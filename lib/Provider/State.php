<?php

declare(strict_types = 1);

namespace OCA\TwoFactorEmail\Provider;

use JsonSerializable;
use OCP\IUser;

class State implements JsonSerializable {

	public function __construct(
		private IUser $user,
		private int $state,
		private ?string $authenticationCode = null,
	) {
	}

	public static function verifying(IUser $user, string $authenticationCode): State {
		return new State(
			$user,
			Email::STATE_VERIFYING,
			$authenticationCode
		);
	}

	public static function disabled(IUser $user): State {
		return new State(
			$user,
			Email::STATE_DISABLED
		);
	}

	public function verify(): State {
		return new State(
			$this->user,
			Email::STATE_ENABLED,
			$this->authenticationCode
		);
	}

	public function getUser(): IUser {
		return $this->user;
	}

	public function getState(): int {
		return $this->state;
	}

	public function getVerificationCode(): ?string {
		return $this->authenticationCode;
	}

	public function jsonSerialize(): array {
		if ($this->user->getEMailAddress() === null) {
			return [
				'state' => $this->state,
				'emailAddress' => '',
			];
		}

		return [
			'state' => $this->state,
			'emailAddress' => $this->user->getEMailAddress(),
		];
	}
}
