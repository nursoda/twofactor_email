<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) 2018, Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\TwoFactorEmail\Service;

use OCP\IL10N;
use OCP\IUser;
use OCP\Mail\IMailer;

class Mailer {

	/** @var IMailer */
	private $mailer;

	/** @var IL10N */
	private $l;

	public function __construct(IMailer $mailer, IL10N $l) {
		$this->mailer = $mailer;
		$this->l = $l;
	}

	public function sendCode(IUser $user, string $email, string $code) {
		$template = $this->mailer->createEMailTemplate('2faEmail.sendCode');
		$template->setSubject($this->l->t('Second factor e-mail code'));
		$template->addHeader();
		$template->addHeading($this->l->t('Your account is protected by second factor authentication.'));
		$template->addBodyText($this->l->t('Your code to continue your login is: %s', [$code]));
		$template->addFooter();

		$message = $this->mailer->createMessage();
		$message->setTo([$email]);
		$message->useTemplate($template);

		$this->mailer->send($message);
	}

	public function sendValidation(IUser $user, string $email, string $code) {
		$template = $this->mailer->createEMailTemplate('2faEmail.validate');
		$template->setSubject($this->l->t('You second factor e-mail validation'));
		$template->addHeader();
		$template->addHeading($this->l->t('Your account is almost protected by e-mail second factor authentication.'));
		$template->addBodyText($this->l->t('Your code to validate your e-mail address is: %s', [$code]));
		$template->addFooter();

		$message = $this->mailer->createMessage();
		$message->setTo([$email]);
		$message->useTemplate($template);

		$this->mailer->send($message);
	}
}
