<?php

declare(strict_types = 1);

namespace OCA\TwoFactorEmail\Provider;

use OCA\TwoFactorEmail\EmailMask;

use OCP\IUser;

use JsonSerializable;

class State implements JsonSerializable {

	/** @var IUser */
	private $user;

	/** @var int */
	private $state;

	/** @var string|null */
	private $authenticationCode;

	public function __construct(IUser $user,
								int $state,
								string $authenticationCode = null) {
		$this->user = $user;
		$this->state = $state;
		$this->authenticationCode = $authenticationCode;
	}

	public static function verifying(IUser $user,
									 string $authenticationCode): State {
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

	/**
	 * @return IUser
	 */
	public function getUser(): IUser {
		return $this->user;
	}

	/**
	 * @return int
	 */
	public function getState(): int {
		return $this->state;
	}

	/**
	 * @return null|string
	 */
	public function getVerificationCode() {
		return $this->authenticationCode;
	}

	public function jsonSerialize() {
		return [
			'state' => $this->state,
			'emailAddress' => EmailMask::maskEmail($this->user->getEMailAddress()),
		];
	}

}
