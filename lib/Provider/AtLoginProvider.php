<?php
declare(strict_types = 1);

namespace OCA\TwoFactorEmail\Provider;

use OCP\Authentication\TwoFactorAuth\ILoginSetupProvider;
use OCP\Template;
use OCP\IUser;
use OCA\TwoFactorEmail\Service\Email as EmailService;
use OCP\IConfig as OCCONFIG;
use OCP\Authentication\TwoFactorAuth\IRegistry;
use OC\Template as OCTemplate;

class AtLoginProvider extends OCTemplate implements ILoginSetupProvider {

    /** @var IUser */
    private $myUser;

    /** @var EmailService */
    private $EmailService;

    /** @var OCCONFIG */
    private $occonfig;

    /** @var IRegistry */
    private $registry;

    /** @var Email */
    private $provider;

    private $mySecret;

	public function __construct(IUser $myUser, $mySecret, EmailService $EmailService, OCCONFIG $occonfig, IRegistry $registry, Email $provider) {
		$this->myUser = $myUser;
		$this->mySecret = $mySecret;
		$this->EmailService = $EmailService;
		$this->occonfig = $occonfig;
		$this->registry = $registry;
		$this->provider = $provider;
	}

	public function setEnabledActivity() {
        // With OCP\IConfig i can get all configured value in config/config.php so i can know if twofactor is forced
        // And it's not in database
		$state2fa = $this->occonfig->getSystemValue('twofactor_enforced');

        //If true, i set plugin " enabled " in databse for the user
        //In database is : oc_twofactor_providers , and set enabled to 1 , 0 is disable
        //For futur, if needed, disableProviderFor exist :)
		if ($state2fa) {
			$this->registry->enableProviderFor($this->provider, $this->myUser);
		}
	}

	public function getBody(): Template {
        //The code is from Email.php, getTemplate
        //Just call when loginSetup is called for first time
		try {
			$this->EmailService->send($this->myUser, $this->mySecret);
		} catch (\Exception $ex) {
			return new Template('twofactor_email', 'error');
		}
		$this->setEnabledActivity();
		$tmpl = new Template('twofactor_email', 'challenge_forFirstConfig');
		$tmpl->assign('emailAddress', $this->myUser->getEmailAddress());
		return $tmpl;
	}
}
