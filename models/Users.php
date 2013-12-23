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

class Users extends \lithium\data\Model
{
	protected $_schema = array(
		'id' => ['type' => 'id'],
		'username' => ['type' => 'string'],
		'email' => ['type' => 'string'],
		'role' => ['type' => 'integer'],
		'host' => ['type' => 'string'],
		'grabs' => ['type' => 'string'],
		'rsstoken' => ['type' => 'string'],
		'createddate' => ['type' => 'date'],
		'resetguid' => ['type' => 'string'],
		'lastlogin' => ['type' => 'date'],
		'apiaccess' => ['type' => 'date'],
		'invites' => ['type' => 'integer'],
		'invitedby' => ['type' => 'integer'],
		'movieview' => ['type' => 'integer'],
		'musicview' => ['type' => 'integer'],
		'consoleview' => ['type' => 'integer'],
		'bookview' => ['type' => 'integer'],
		'saburl' => ['type' => 'string'],
		'sabapikey' => ['type' => 'string'],
		'sabapikeytype' => ['type' => 'boolean'],
		'sabpriority' => ['type' => 'boolean'],
		'userseed' => ['type' => 'string']
	);

	/**
	 * Test if the user has the admin role.
	 *
	 * @param array|false $user The result of an Auth::check().
	 * @return boolean True if the user has the admin role.
	 */
	static public function isAdmin(array $user = null)
	{
		if (is_array($user)) {
			return ($user['role'] == 2);
		}
		return $user;
	}

	/**
	 * Test if the user's account has been disabled.
	 *
	 * @param array $user The result of a valid Auth::check(). i.e. no false allowed.
	 */
	static public function isDisabled(array $user)
	{
		if (is_array($user)) {
			return ($user['role'] === 3);
		}
		return $user;
	}
}

?>