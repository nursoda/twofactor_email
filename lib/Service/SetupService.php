<?php

declare(strict_types=1);

namespace OCA\TwoFactorEmail\Service;

use Exception;
use OCA\TwoFactorEmail\Exception\TransmissionException;
use OCA\TwoFactorEmail\Exception\VerificationException;
use OCA\TwoFactorEmail\Provider\Email as EmailProvider;
use OCA\TwoFactorEmail\Provider\State;
use OCA\TwoFactorEmail\Service\Email as EmailService;
use OCP\Authentication\TwoFactorAuth\IRegistry;
use OCP\IUser;
use OCP\Security\ISecureRandom;

class SetupService {

	public function __construct(
		private StateStorage $stateStorage,
		private EmailService $emailService,
		private EmailProvider $emailProvider,
		private ISecureRandom $random,
		private IRegistry $providerRegistry,
	) {
	}

	public function getState(IUser $user): State {
		return $this->stateStorage->get($user);
	}

	/**
	 * Send out confirmation message and save current authentication code in user settings
	 */
	public function startSetup(IUser $user): State {
		$authenticationCode = $this->random->generate(6, ISecureRandom::CHAR_DIGITS);

		try {
			$this->emailService->send($user, $authenticationCode);
		} catch (Exception $ex) {
			throw new TransmissionException('Could not send verification code', 0, $ex);
		}

		return $this->stateStorage->persist(
			State::verifying($user, $authenticationCode)
		);
	}

	public function finishSetup(IUser $user, string $authenticationCode): State {
		$state = $this->stateStorage->get($user);

		if (is_null($state->getVerificationCode())) {
			throw new VerificationException('no verification code set');
		}

		if ($state->getVerificationCode() !== $authenticationCode) {
			throw new VerificationException('verification code mismatch');
		}

		$this->providerRegistry->enableProviderFor($this->emailProvider, $user);

		return $this->stateStorage->persist(
			$state->verify()
		);
	}

	public function disable(IUser $user): State {
		$this->providerRegistry->enableProviderFor($this->emailProvider, $user);
		$this->providerRegistry->disableProviderFor($this->emailProvider, $user);

		return $this->stateStorage->persist(
			State::disabled($user)
		);
	}
}
