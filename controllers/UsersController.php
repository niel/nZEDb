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
 * @author niel
 * @copyright 2013 nZEDb
 */

namespace li3_nzedb\controllers;

use lithium\security\Auth;
use li3_flash_message\extensions\storage\FlashMessage;
use li3_nzedb\models\Users;

class UsersController extends \lithium\action\Controller
{
	/**
	 * Allows admins to create an account manually.
	 */
	public function add()
	{
		return;
		$this->_render['layout'] = 'admin';
		$user = Users::create($this->request->data);

		if (($this->request->data) && $user->save()) {
			return $this->redirect('Users::index');
		}
		return compact('user');
	}

	/**
	 * Facility for users that have forgotten their usernames to have a reminder
	 * sent to their registered email address.
	 */
	public function amnesia()
	{
		$this->_render['layout'] = 'login';
		if ($this->request->data) {
			$user = Users::find('first', ['conditions' => ['email' => ['=' => $this->request->data['email']]]]);
			if (!$user) {
				FlashMessage::write('Unable to find your account, please check your spelling.');
				return;
			}

			// TODO add mail sending code.
			FlashMessage::write('Email with your user name, sent to your address.');
			return $this->redirect('/');
		}
	}

	/**
	 * Displays a list of all usernames.
	 */
	public function index()
	{
		$this->_render['layout'] = 'admin';
		$user = Auth::check('default', $this->request);
		if (!Users::isAdmin($user)) {
			FlashMessage::write('Only admins can view the user list');
			return $this->redirect('/');
		}
		$users = Users::all();
		return compact('users');
	}

	/**
	 * Log in to the site with username/password, saving the user's details into
	 * the session for easier retrieval.
	 */
	public function login()
	{
		$this->_render['layout'] = 'login';

		$request = $this->request;
		if ($request->data) {
			$user = Auth::check('default', $this->request);
			if ($user) {
				if (Users::isDisabled($user)) {
					FlashMessage::write('Your account has been disabled');
					return $this->redirect('/logout');
				} else {
					return $this->redirect('/');
				}
			} else {
				FlashMessage::write('Username/Password do not match!');
				return;
			}
		}
	}

	/**
	 * Log out of the site by clearing the user from the session.
	 *
	 * @return Redirect Sends user back to the home page.
	 */
	public function logout()
	{
		Auth::clear('default');
		return $this->redirect('/');
	}

	public function read()
	{
	}

	/**
	 * Allow a new user to register an account.
	 *
	 * TODO create page and logic for proper singup. Once confirmation (if
	 * enabled) is done redirect to profile.
	 */
	public function register()
	{
		$this->_render['layout'] = 'login';
		$this->dummy();
	}

	/**
	 * Send email to allow password reset.
	 */
	public function reset()
	{
	}

	public function test()
	{
		$this->_render['layout'] = 'login';
		$user = array();
		$request = $this->request->data;
		if (!empty($request)) {
			$this->set(['test' => true, 'user' => $user, 'used' => '']);
		} else {
			$this->set(['test' => false, 'user' => $user, 'used' => '']);
		}
	}
}

?>