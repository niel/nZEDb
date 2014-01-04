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
	const ROLE_ADMIN		= 2;
	const STATUS_BANNED		= -2;
	const STATUS_DISABLED	= 3;
	const STATUS_GUEST		= 0;
	const STATUS_REGISTERED	= 1;

	public $validates = [
		'email' => [
			['notEmpty', 'message' => 'email is empty'],
			['email', 'message' => 'email is not valid'],
			['emailInUse', 'message' => 'This address is already in use.']
		],
		'password' => [
			['notEmpty', 'message' => 'Please supply a password.', 'required' => true]
		],
		'passcopy' => [
			['matchesPassword', 'message' => 'Passwords did not match!']
		],
		'username' => [
			['notEmpty', 'message' => 'Please supply a username.', 'required' => true],
			['usernameTaken', 'message' => 'Sorry that name is already in use.']
		],
	];

	/**
	 * Test if the user has the admin role.
	 *
	 * @param array|false $user The result of an Auth::check().
	 * @return boolean True if the user has the admin role.
	 */
	static public function isAdmin(array $user = null)
	{
		if (!empty($user)) {
			return ((integer) $user['role'] === self::ROLE_ADMIN);
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
		if (!empty($user)) {
			return ((integer) $user['role'] === STATUS_DISABLED);
		}
		return $user;
	}
}

?>