<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) 2018, Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\TwoFactorEmail\Service;

use Base32\Base32;
use OCA\TwoFactorEmail\Db\TotpSecret;
use OCA\TwoFactorEmail\Db\TotpSecretMapper;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\IConfig;
use OCP\IUser;
use OCP\Security\ICrypto;
use Otp\GoogleAuthenticator;
use Otp\Otp;

class Totp {

	const STATE_DISABLED = 0;
	const STATE_CREATED = 1;
	const STATE_ENABLED = 2;

	const PERIOD = 600; //10 minutes to enter to code

	/** @var TotpSecretMapper */
	private $secretMapper;

	/** @var ICrypto */
	private $crypto;

	/** @var Mailer */
	private $mailer;

	/** @var IConfig */
	private $config;

	public function __construct(TotpSecretMapper $secretMapper,
								ICrypto $crypto,
								Mailer $mailer,
								IConfig $config) {
		$this->secretMapper = $secretMapper;
		$this->crypto = $crypto;
		$this->mailer = $mailer;
		$this->config = $config;
	}

	public function hasSecret(IUser $user) {
		try {
			$secret = $this->secretMapper->getSecret($user);
			return self::STATE_ENABLED === (int)$secret->getState();
		} catch (DoesNotExistException $ex) {
			return false;
		}
	}

	/**
	 * TODO: enable should only create the secret
	 * Test e-mail should then be send to validate the e-mail address
	 * Next steps is add a listner so we can act on e-mail changed etc
	 */
	public function createSecret(IUser $user): string {
		try {
			// Delete existing one
			$oldSecret = $this->secretMapper->getSecret($user);
			$this->secretMapper->delete($oldSecret);
		} catch (DoesNotExistException $ex) {
			// Ignore
		}

		// Create new one
		$secret = GoogleAuthenticator::generateRandom();

		$dbSecret = new TotpSecret();
		$dbSecret->setUserId($user->getUID());
		$dbSecret->setSecret($this->crypto->encrypt($secret));
		$dbSecret->setState(self::STATE_CREATED);

		$this->secretMapper->insert($dbSecret);

		$email = $this->getEmail($user);
		$this->mailer->sendValidation($user, $email, $this->getCode($user));

		return $secret;
	}

	public function deleteSecret(IUser $user) {
		try {
			$dbSecret = $this->secretMapper->getSecret($user);
			$this->secretMapper->delete($dbSecret);
		} catch (DoesNotExistException $ex) {
			// Ignore
		}
	}

	private function getCode(IUser $user): string {
		try {
			$dbSecret = $this->secretMapper->getSecret($user);
		} catch (DoesNotExistException $ex) {
			throw new NoTotpSecretFoundException();
		}

		$secret = $this->crypto->decrypt($dbSecret->getSecret());
		$otp = new Otp();
		$otp->setPeriod(self::PERIOD);

		return $otp->totp(Base32::decode($secret));
	}

	public function sendCode(IUser $user) {
		$code = $this->getCode($user);
		$email = $this->getEmail($user);
		$this->mailer->sendCode($user, $email, $code);
	}

	public function validateSecret(IUser $user, $key): bool {
		try {
			$dbSecret = $this->secretMapper->getSecret($user);
		} catch (DoesNotExistException $ex) {
			throw new NoTotpSecretFoundException();
		}

		$secret = $this->crypto->decrypt($dbSecret->getSecret());

		$otp = new Otp();
		$otp->setPeriod(self::PERIOD);
		return $otp->checkTotp(Base32::decode($secret), $key, 0);
	}

	public function validateEmail(IUser $user, string $key): bool {
		try {
			$dbSecret = $this->secretMapper->getSecret($user);
		} catch (DoesNotExistException $ex) {
			throw new NoTotpSecretFoundException();
		}

		$secret = $this->crypto->decrypt($dbSecret->getSecret());

		$otp = new Otp();
		$otp->setPeriod(self::PERIOD);
		if ($otp->checkTotp(Base32::decode($secret), $key, 0)) {
			$dbSecret->setState(self::STATE_ENABLED);
			$this->secretMapper->update($dbSecret);
			return true;
		} else {
			return false;
		}
	}

	private function getEmail(IUser $user): string {
		$email = $this->config->getUserValue($user->getUID(), 'settings', 'email', '');
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new \Exception('invalid email');
		}

		return $email;
	}

}
