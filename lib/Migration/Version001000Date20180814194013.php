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

namespace OCA\TwoFactorEmail\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version001000Date20180814194013 extends SimpleMigrationStep {


	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 * @since 13.0.0
	 */
	public function changeSchema(IOutput $output, \Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		$table = $schema->createTable('twofactor_email_secrets');
		$table->addColumn('id', 'bigint', [
			'autoincrement' => true,
			'notnull' => true,
			'length' => 11,
			'unsigned' => true,
		]);
		$table->addColumn('user_id', 'string', [
			'notnull' => true,
			'length' => 64,
		]);
		$table->addColumn('secret', 'blob', [
			'notnull' => true,
		]);
		$table->addColumn('state', 'smallint', [
			'length' => 4,
			'notnull' => true,
		]);

		$table->setPrimaryKey(['id']);
		$table->addIndex(['user_id'], 'twofactor_email_secrets_uid');

		return $schema;
	}
}
