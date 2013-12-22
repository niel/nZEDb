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

namespace li3_nzedb\models;

class Sites extends \lithium\data\Model
{
	protected $_meta = array('source' => 'site');

	static public function setting($setting)
	{
		$result = self::find(array(
			'fields' => array('setting', 'value'),
			'conditions' => array(
				'setting' => array('=' => $setting)
			)
		));
		return $result->data('value');
	}
}

?>