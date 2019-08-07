<?php

declare(strict_types=1);

namespace OCA\TwoFactorEmail\Provider;

use OCA\TwoFactorEmail\EmailMask;
use OCA\TwoFactorEmail\AppInfo\Application;
use OCA\TwoFactorEmail\Service\Email as EmailService;
use OCA\TwoFactorEmail\Service\StateStorage;
use OCA\TwoFactorEmail\Settings\PersonalSettings;

use OCP\Authentication\TwoFactorAuth\IPersonalProviderSettings;
use OCP\Authentication\TwoFactorAuth\IProvider;
use OCP\Authentication\TwoFactorAuth\IProvidesIcons;
use OCP\Authentication\TwoFactorAuth\IProvidesPersonalSettings;
use OCP\IL10N;
use OCP\ISession;
use OCP\IUser;
use OCP\Security\ISecureRandom;
use OCP\Template;

class Email implements IProvider, IProvidesIcons, IProvidesPersonalSettings {

	const STATE_DISABLED = 0;
	const STATE_VERIFYING = 1;
	const STATE_ENABLED = 2;

	/** @var EmailService */
	var $emailService;

	/** @var StateStorage */
	protected $stateStorage;

	/** @var ISession */
	protected $session;

	/** @var ISecureRandom */
	protected $secureRandom;

	/** @var IL10N */
	protected $l10n;

	public function __construct(EmailService $emailService,
								StateStorage $stateStorage,
								ISession $session,
								ISecureRandom $secureRandom,
								IL10N $l10n) {
		$this->emailService = $emailService;
		$this->stateStorage = $stateStorage;
		$this->session = $session;
		$this->secureRandom = $secureRandom;
		$this->l10n = $l10n;
	}

	private function getSessionKey() {
		return "twofactor_email_secret";
	}

	/**
	 * Get unique identifier of this 2FA provider
	 */
	public function getId(): string {
		return 'email';
	}

	/**
	 * Get the display name for selecting the 2FA provider
	 */
	public function getDisplayName(): string {
		return $this->l10n->t('Email verification');
	}

	/**
	 * Get the description for selecting the 2FA provider
	 */
	public function getDescription(): string {
		return $this->l10n->t('Verificate via Email');
	}

	private function getSecret(): string {
		if ($this->session->exists($this->getSessionKey())) {
			return $this->session->get($this->getSessionKey());
		}

		$secret = $this->secureRandom->generate(6, ISecureRandom::CHAR_DIGITS);
		$this->session->set($this->getSessionKey(), $secret);

		return $secret;
	}

	/**
	 * Get the template for rending the 2FA provider view
	 */
	public function getTemplate(IUser $user): Template {
		$secret = $this->getSecret();

		try {
			$this->emailService->send($user, $secret);
		} catch (Exception $ex) {
			return new Template('twofactor_email', 'error');
		}

		$tmpl = new Template('twofactor_email', 'challenge');
		$tmpl->assign('emailAddress', EmailMask::maskEmail($user->getEMailAddress()));
		return $tmpl;
	}

	/**
	 * Verify the given challenge
	 */
	public function verifyChallenge(IUser $user, string $challenge): bool {
		$valid = $this->session->exists($this->getSessionKey())
			&& $this->session->get($this->getSessionKey()) === $challenge;

		if ($valid) {
			$this->session->remove($this->getSessionKey());
		}

		return $valid;
	}

	/**
	 * Decides whether 2FA is enabled for the given user
	 */
	public function isTwoFactorAuthEnabledForUser(IUser $user): bool {
		return $this->stateStorage->get($user)->getState() === self::STATE_ENABLED;
	}

	public function getPersonalSettings(IUser $user): IPersonalProviderSettings {
		return new PersonalSettings($this->gatewayName);
	}

	public function getLightIcon(): String {
		return image_path(Application::APP_NAME, 'app.svg');
	}

	public function getDarkIcon(): String {
		return image_path(Application::APP_NAME, 'app-dark.svg');
	}
}
