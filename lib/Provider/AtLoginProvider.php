<?php

declare(strict_types = 1);

namespace OCA\TwoFactorEmail\Provider;

use OCA\TwoFactorEmail\Service\Email as EmailService;
use OCA\TwoFactorEmail\Service\StateStorage;
use OCP\Authentication\TwoFactorAuth\ILoginSetupProvider;
use OCP\Authentication\TwoFactorAuth\IRegistry;
use OCP\IConfig as OCCONFIG;
use OCP\IUser;
use OCP\Template;

class AtLoginProvider implements ILoginSetupProvider {
	/** @var IUser */
	private $myUser;

	/** @var EmailService */
	private $emailService;

	/** @var OCCONFIG */
	private $occonfig;

	/** @var IRegistry */
	private $registry;

	/** @var Email */
	private $provider;

	private $mySecret;
	private $stateStorage;

	public function __construct(IUser $myUser, $mySecret, EmailService $EmailService, OCCONFIG $occonfig, IRegistry $registry, Email $provider, StateStorage $stateStorage) {
		$this->myUser = $myUser;
		$this->mySecret = $mySecret;
		$this->emailService = $EmailService;
		$this->occonfig = $occonfig;
		$this->registry = $registry;
		$this->provider = $provider;
		$this->stateStorage = $stateStorage;
	}

	private function setEnabledActivity() {
		$isEnforced = $this->occonfig->getSystemValue('twofactor_enforced');
		if ($isEnforced) {
			$this->registry->enableProviderFor($this->provider, $this->myUser);
		}
	}

	public function getBody(): Template {
		if ($this->myUser->getEMailAddress() === null) {
			return new Template('twofactor_email', 'error_email_empty');
		}
		try {
			$this->emailService->send($this->myUser, $this->mySecret);
		} catch (\Exception $ex) {
			return new Template('twofactor_email', 'error');
		}
		$this->setEnabledActivity();
		$this->stateStorage->persist(
			State::verifying($this->myUser, $this->mySecret)
		);
		$tmpl = new Template('twofactor_email', 'challenge_forFirstConfig');
		$tmpl->assign('emailAddress', $this->myUser->getEmailAddress());
		return $tmpl;
	}
}
