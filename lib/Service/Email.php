<?php

declare(strict_types=1);

namespace OCA\TwoFactorEmail\Service;

use OCP\IL10N;
use OCP\ILogger;
use OCP\IUser;
use OCP\Mail\IMailer;
use OCP\Util;

class Email {

	/** @var IMailer */
	private $mailer;

	/** @var IL10N */
	private $l10n;

	/** @var ILogger */
	private $logger;

	public function __construct(IMailer $mailer,
								IL10N $l10n,
								ILogger $logger) {
		$this->mailer = $mailer;
		$this->l10n = $l10n;
		$this->logger = $logger;
	}

	/**
	 * @param IUser $user
	 * @param string $authenticationCode
	 */
	public function send(IUser $user, string $authenticationCode) {
		$this->logger->debug("sending email message to $identifier, authentication code: $authenticationCode");

		$template = $this->mailer->createEMailTemplate('twofactor_email.send');
		$template->setSubject($this->l10n->t('Nextcloud Two-Factor Authentication'));
		$template->addHeader();
		$template->addHeading($this->l10n->t('Your account %s is protected by two-factor authentication.', [$user->getDisplayName()]));
		$template->addBodyText($this->l10n->t('Your code to continue your login is: %s', [$authenticationCode]));
		$template->addFooter();

		$message = $this->mailer->createMessage();
		$message->setTo([ $user->getEMailAddress() => $user->getDisplayName() ]);
		$message->useTemplate($template);

		$this->mailer->send($message);
	}
}
