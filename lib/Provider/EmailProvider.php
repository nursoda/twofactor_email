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

namespace OCA\TwoFactorEmail\Provider;

use OCA\TwoFactorEmail\AppInfo\Application;
use OCA\TwoFactorEmail\Service\Totp;
use OCP\Authentication\TwoFactorAuth\IProvider;
use OCP\IL10N;
use OCP\IUser;
use OCP\Template;

class EmailProvider implements IProvider {

	/** @var IL10N */
	private $l;

	/** @var Totp */
	private $totp;

	public function __construct(IL10N $l, Totp $totp) {
		$this->l = $l;
		$this->totp = $totp;
	}

	public function getId(): string {
		return 'email';
	}

	public function getDisplayName(): string {
		return $this->l->t('E-mail');
	}

	public function getDescription(): string {
		return $this->l->t('Get token via e-mail');
	}

	public function getTemplate(IUser $user): Template {
		$this->totp->sendCode($user);
		return new Template(Application::APPNAME, 'challenge');
	}

	public function verifyChallenge(IUser $user, string $challenge): bool {
		return $this->totp->validateSecret($user, $challenge);
	}

	public function isTwoFactorAuthEnabledForUser(IUser $user): bool {
		// For now it is just always enabled
		return true;
		return $this->totp->hasSecret($user);
	}

}
