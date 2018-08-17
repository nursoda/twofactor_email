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

use OCP\AppFramework\Db\QBMapper;
use OCP\IDBConnection;
use OCP\IUser;

class TotpSecretMapper extends QBMapper {

	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'twofactor_email', TotpSecret::class);
	}


	public function getSecret(IUser $user): TotpSecret {
		$qb = $this->db->getQueryBuilder();

		$qb->select('id', 'user_id', 'secret', 'state')
			->from('twofactor_totp_secrets')
			->where($qb->expr()->eq('user_id', $qb->createNamedParameter($user->getUID())));

		$row = $this->findOneQuery($qb);

		return TotpSecret::fromRow($row);
	}
}
