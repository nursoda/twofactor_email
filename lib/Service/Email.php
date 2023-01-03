<?php

declare(strict_types=1);

namespace OCA\TwoFactorEmail\Service;

use OCP\Defaults;
use OCP\IL10N;
use OCP\ILogger;
use OCP\IUser;
use OCP\Mail\IMailer;

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
		$this->logger->debug('sending email message to ' . $user->getEMailAddress() . ', code: $authenticationCode');

		$template = $this->mailer->createEMailTemplate('twofactor_email.send');
		$user_at_cloud = $user->getDisplayName() . " @ " . $this->themingDefaults->getName();
		$template->setSubject($this->l10n->t('Login attempt for %s', [$user_at_cloud]));
		$template->addHeader();
		$template->addHeading($this->l10n->t('Your two-factor authentication code is: %s', [$authenticationCode]));
		$template->addBodyText($this->l10n->t('If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!', [$this->themingDefaults->getName()]));
		$template->addFooter();

		$message = $this->mailer->createMessage();
		$message->setTo([ $user->getEMailAddress() => $user->getDisplayName() ]);
		$message->useTemplate($template);

		$this->mailer->send($message);
	}
}
