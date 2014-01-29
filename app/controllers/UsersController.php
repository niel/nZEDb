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

namespace app\controllers;

use lithium\security\Auth;
use lithium\util\Validator;
use li3_flash_message\extensions\storage\FlashMessage;
use li3_mailer\action\Mailer;
use \li3_mailer\net\mail\transport\adapter\Debug;
//use \li3_mailer\net\mail\transport\adapter\Mailgun;
use \li3_mailer\net\mail\transport\adapter\Simple;
//use \li3_mailer\net\mail\transport\adapter\Swift;
use li3_mailer\net\mail\Message;
use app\models\Settings;
use app\models\Users;

/**
 * The Users controller allows creating, viewing, or modifying users; either by
 * the user themselves, or by the site's administrator(s).
 */
class UsersController extends \lithium\action\Controller
{
	public function _init()
	{
		parent::_init();
		$self = $this;

		Validator::add('emailInUse',
			function($value)
			{
				$result = Users::find('first', ['conditions' => ['email' => ['=' => $value]]]);
				return !count($result) > 0;
			}
		);

		Validator::add('usernameTaken',
			function($value)
			{
				return !(count(Users::findByUsername($value)) > 0);
			}
		);

		Validator::add('matchesPassword',
			function($value) use (&$self)
			{
				return $value == $self->request->get('data:password');
			}
		);
	}

	/**
	 * Allows admins to create an account manually.
	 */
	public function add()
	{
/*
		$this->_render['layout'] = 'admin';
		$user = Users::create($this->request->data);

		if (($this->request->data) && $user->save()) {
			return $this->redirect('Users::index');
		}
		return compact('user');
 */
	}

	/**
	 * Facility for users that have forgotten their usernames to have a reminder
	 * sent to their registered email address.
	 */
	public function amnesia()
	{
		if ($this->request->data) {
			$user = Users::find('first', ['conditions' => ['email' => ['=' => $this->request->data['email']]]]);
			if (!$user) {
				FlashMessage::write('Unable to find your account, please check your spelling.');
				return;
			}

			// TODO add mail sending code.
			$result = $this->_sendForgottenUsernameMailer($user);

			if ($result) {
				FlashMessage::write("An email has been sent to the given address.");
			} else {
				FlashMessage::write("An error occured while trying to send your reminder!<br/> Please inform the site admin.");
			}
			$this->set(['user' => $user]);
			$this->set(['debug' => $result]);
			return $this->redirect('/');
		}
	}

	/**
	 * Action to accept confirmation code sent out in email during registration.
	 *
	 * @param type $param code from email link
	 */
	public function confirm($param)
	{
		$this->_render['template'] = 'confirm';  //Just to make it complain if not finished before testing.
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
		//$this->_render['layout'] = 'login';
		$this->set(['member' => ['label' => 'Register', 'link' => '/users/register']]);

		$user = null;
		$this->set(['user' => $user]);
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
	 * TODO create page and logic for proper signup. Once confirmation (if
	 * enabled) is done, redirect to profile.
	 */
	public function register()
	{
		$status = Settings::get('registerstatus');
		if ($status != Settings::REGISTER_STATUS_OPEN) {
			FlashMessage::write('Registration is currently closed, please check back later.');
			$this->redirect('/');
		}

		$this->set(['log' => 'in']);
		$user = Users::create($this->request->data);
		if ($this->request->data) {
			$user->set(['role' => Users::STATUS_DISABLED]);

			$result = $user->save();
			if($result) {
				// TODO create/send mail with confirmation code.
				FlashMessage::write('Your account has been set up. Please check your email for a confirmation link.');
				$this->redirect('/');
			}
			FlashMessage::write('Please correct the errors below.');
		}
		$this->set(compact('user'));
	}

	/**
	 * Send email to allow password reset.
	 */
	public function reset()
	{
		$this->_render['layout'] = 'login';
		$nopass = true;
		if ($this->request->data) {
			$user = Users::find('first', ['conditions' => ['username' => ['=' => $this->request->data['username']]]]);
			if (!$user) {
				FlashMessage::write('Unable to find your account, please check your username is correct.');
				return;
			}

			// TODO add mail sending code.
			FlashMessage::write('Email with reset link, sent to your address.');
			return $this->redirect('/');
		}
		return compact('nopass');
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

	/**
	 * Sends message to a user specified in the params
	 *
	 * @param array $params Array of body, email, and subject for the message.
	 * @return boolean True on success.
	 */
	protected function _sendmail(array $params)
	{
		if (!is_array($params['body'])) {
			$params['body'] = [$params['body']];
		}
		$msg = Mailer::message([
			'type' => 'text',
			'baseURL' => 'nZEDb',												// replace with site domain.
			'body' => ['text/plain' => $params['body']],
			'from' => 'nZEDb',													// replace with field from sites table.
			'subject' => $params['subject'],
			'to' => $params['email'],
		]);
		$msg->ensureStandardCompliance();

		$transport = new Debug();

		return $transport->deliver($msg);
	}

	protected function _sendForgottenUsernameMailer($user, array $params = array())
	{
		$defaults = ['delivery' => 'default'];
		$params += $defaults;
		return Mailer::deliver('amnesia', [
				'data'		=> ['resource' => $user],
				'delivery'	=> $params['delivery'],
				'from'		=> Settings::get('email'),
				'layout'	=> false,
				'subject'	=> 'Your user name @ *add domain name here* reminder',
				'to'		=> $user->email,
				'types'		=> ['text'],
			]);
	}

}



class MailerSimple extends Mailer
{
	/**
	 * @var object Message object;
	 */
	protected $_message;

	public function __construct(array $params = array())
	{
		$defaults = [
			[
				'baseURL'	=> Settings::get('domain'),
				'from'		=> Settings::get('domain'),
				'type'		=> 'text',
			]
		];
		$this->_messages += $params + $defaults;
	}
}

?>