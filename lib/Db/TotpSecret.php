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

namespace OCA\TwoFactorEmail\Db;

use OCP\AppFramework\Db\Entity;

/**
 * @method void setUserId(string $uid)
 * @method string getUserId()
 * @method void setSecret(string $secret)
 * @method string getSecret()
 * @method void setState(int $state)
 * @method int getState()
 */
class TotpSecret extends Entity {
	/** @var string */
	protected $userId;

	/** @var string */
	protected $secret;

	/** @var int */
	protected $state;

	public function __construct() {
		$this->addType('userId', 'string');
		$this->addType('secret', 'string');
		$this->addType('state', 'int');
	}
}
