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

namespace OCA\TwoFactorEmail\Settings;

use OCA\TwoFactorEmail\AppInfo\Application;
use OCA\TwoFactorEmail\Provider\State;
use OCP\Authentication\TwoFactorAuth\IPersonalProviderSettings;
use OCP\IInitialStateService;
use OCP\Template;

class PersonalSettings implements IPersonalProviderSettings {

	/** @var IInitialStateService */
	private $initialStateService;
	/** @var State */
	private $state;
	/** @var bool */
	private $available;

	public function __construct(IInitialStateService $initialStateService,
								State $state,
								bool $available) {
		$this->initialStateService = $initialStateService;
		$this->state = $state;
		$this->available = $available;
	}

	/**
	 * @return Template
	 *
	 * @since 15.0.0
	 */
	public function getBody(): Template {
		$this->initialStateService->provideInitialState(Application::APP_NAME, 'available', $this->available);
		$this->initialStateService->provideInitialState(Application::APP_NAME, 'state', $this->state);
		return new Template('twofactor_email', 'personal_settings');
	}
}
