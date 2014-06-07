<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program (see LICENSE.txt in the base directory.  If
 * not, see:
 *
 * @link <http://www.gnu.org/licenses/>.
 * @author Niel Archer
 * @copyright 2013 nZEDb
 */

namespace app\models;

class Settings extends \lithium\data\Model
{
	const REGISTER_STATUS_API_ONLY = 3;
	const REGISTER_STATUS_CLOSED = 2;
	const REGISTER_STATUS_INVITE = 1;
	const REGISTER_STATUS_OPEN = 0;

	protected $_meta = ['key' => ['section', 'subsection', 'name']];

	static public function get($setting)
	{
		$setting = self::find('first', ['conditions' => ['setting' => ['=' => $setting]]]);
		return $setting === false ?: $setting->data()['value'];
	}

	static public function asArray()
	{
		$result = self::find('all', ['fields' => ['setting', 'value'], 'order' => ['setting']]);
		foreach ($result->data() as $setting => $value) {
			$settings[$setting] = $value;
		}
		return $settings;
	}
}

?>
