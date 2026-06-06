<?php

declare(strict_types=1);

namespace OCA\TwoFactorEmail\Service;

use OCP\Defaults;
use OCP\IL10N;
use OCP\IUser;
use OCP\Mail\IMailer;
use Psr\Log\LoggerInterface;

class Email {

	public function __construct(
		private IMailer $mailer,
		private IL10N $l10n,
		private LoggerInterface $logger,
		private Defaults $themingDefaults,
	) {
	}

	public function send(IUser $user, string $authenticationCode): void {
		$email = $user->getEMailAddress();
		assert($email !== null);
		$this->logger->debug('Sending email message to ' . $email . ', code: ' . $authenticationCode);

		$template = $this->mailer->createEMailTemplate('twofactor_email.send');
		$user_at_cloud = $user->getDisplayName() . ' @ ' . $this->themingDefaults->getName();
		$template->setSubject($this->l10n->t('Login attempt for %s', [$user_at_cloud]));
		$template->addHeader();
		$template->addHeading($this->l10n->t('Your two-factor authentication code is: %s', [$authenticationCode]));
		$template->addBodyText($this->l10n->t('If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!', [$this->themingDefaults->getName()]));
		$template->addFooter();

		$message = $this->mailer->createMessage();
		$message->setTo([ $email => $user->getDisplayName() ]);
		$message->useTemplate($template);

		$this->mailer->send($message);
	}
}
