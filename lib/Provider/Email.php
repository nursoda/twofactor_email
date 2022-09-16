<?php

declare(strict_types=1);

namespace OCA\TwoFactorEmail\Provider;

use OCA\TwoFactorEmail\AppInfo\Application;
use OCA\TwoFactorEmail\Service\Email as EmailService;
use OCA\TwoFactorEmail\Service\StateStorage;
use OCA\TwoFactorEmail\Settings\PersonalSettings;

use OCP\Authentication\TwoFactorAuth\IPersonalProviderSettings;
use OCP\Authentication\TwoFactorAuth\IProvider;
use OCP\Authentication\TwoFactorAuth\IProvidesIcons;
use OCP\Authentication\TwoFactorAuth\IProvidesPersonalSettings;
use OCP\IInitialStateService;
use OCP\IL10N;
use OCP\ISession;
use OCP\IURLGenerator;
use OCP\IUser;
use OCP\Security\ISecureRandom;
use OCP\Template;
use OCP\IConfig as OCCONFIG;
use OCP\Authentication\TwoFactorAuth\IRegistry;

class Email implements IProvider, IProvidesIcons, IProvidesPersonalSettings {
	public const STATE_DISABLED = 0;
	public const STATE_VERIFYING = 1;
	public const STATE_ENABLED = 2;

	/** @var EmailService */
	public $emailService;

	/** @var StateStorage */
	protected $stateStorage;

	/** @var ISession */
	protected $session;

	/** @var ISecureRandom */
	protected $secureRandom;

	/** @var IL10N */
	protected $l10n;

	/** @var IInitialStateService */
	private $initialStateService;

	/** @var IURLGenerator */
	private $urlGenerator;

	/** @var OCCONFIG */
	private $occonfig;

	/** @var IRegistry */
	private $registry;

	public function __construct(EmailService $emailService,
								StateStorage $stateStorage,
								ISession $session,
								ISecureRandom $secureRandom,
								IL10N $l10n,
								IInitialStateService $initialStateService,
								IURLGenerator $urlGenerator,
								OCCONFIG $occonfig,
								IRegistry $registry) {
		$this->emailService = $emailService;
		$this->stateStorage = $stateStorage;
		$this->session = $session;
		$this->secureRandom = $secureRandom;
		$this->l10n = $l10n;
		$this->initialStateService = $initialStateService;
		$this->urlGenerator = $urlGenerator;
		$this->occonfig = $occonfig;
		$this->registry = $registry;
	}

	private function getSessionKey(): string {
		return 'twofactor_email_secret';
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
		return $this->l10n->t('Email');
	}

	/**
	 * Get the description for selecting the 2FA provider
	 */
	public function getDescription(): string {
		return $this->l10n->t('Send a code to your email address');
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
		} catch (\Exception $ex) {
			return new Template('twofactor_email', 'error');
		}

		$tmpl = new Template('twofactor_email', 'challenge');
		$tmpl->assign('emailAddress', $user->getEMailAddress());
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
		return new PersonalSettings($this->initialStateService, $this->stateStorage->get($user), $user->getEMailAddress() !== null);
	}

	public function getLightIcon(): String {
		return $this->urlGenerator->imagePath(Application::APP_NAME, 'app-light.svg');
	}

	public function getDarkIcon(): String {
		return $this->urlGenerator->imagePath(Application::APP_NAME, 'app-dark.svg');
	}

	public function getLoginSetup(IUser $user): ILoginSetupProvider {
		return new AtLoginProvider($user, $this->getSecret(), $this->emailService, $this->occonfig, $this->registry, $this);
	}
}
