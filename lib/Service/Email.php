<?php

declare(strict_types=1);

namespace OCA\TwoFactorEmail\Service;

use OCP\IL10N;
use OCP\ILogger;
use OCP\IUser;
use OCP\Mail\IMailer;
use OCP\Defaults;

class Email {

	/** @var IMailer */
	private $mailer;

	/** @var IL10N */
	private $l10n;

	/** @var ILogger */
	private $logger;

	/** @var Defaults */
	private $themingDefaults;

	public function __construct(IMailer $mailer,
								IL10N $l10n,
								ILogger $logger,
								Defaults $themingDefaults) {
		$this->mailer = $mailer;
		$this->l10n = $l10n;
		$this->logger = $logger;
		$this->themingDefaults = $themingDefaults;
	}

	/**
	 * @param IUser $user
	 * @param string $authenticationCode
	 */
	public function send(IUser $user, string $authenticationCode): void {
		$this->logger->debug('sending email message to ' . $user->getEMailAddress() . ', authentication code: $authenticationCode');

		$template = $this->mailer->createEMailTemplate('twofactor_email.send');
		$template->setSubject($this->l10n->t('Login with Two-Factor Email on %s', [$this->themingDefaults->getName()]));
		$template->addHeader();
		$template->addHeading($this->l10n->t('Login attempt for account %s', [$user->getDisplayName()]));
		$template->addBodyText($this->l10n->t('If you just tried to login, you need to enter this access code because your account is protected by Two-Factor Email: %s', [$authenticationCode]));
		$template->addFooter();

		$message = $this->mailer->createMessage();
		$message->setTo([ $user->getEMailAddress() => $user->getDisplayName() ]);
		$message->useTemplate($template);

		$this->mailer->send($message);
	}
}
