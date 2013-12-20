<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, nZEDb (http://nzedb.com)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_nzedb\models;

use lithium\core\Libraries;
use lithium\data\entity\Document;
use lithium\security\Auth;
use lithium\security\Password;
use lithium\storage\Cache;
use lithium\util\Inflector;
use lithium\util\Validator;
use \Exception;
use \MongoId;

class Users extends \lithium\data\Model
{
	/**
	 * @var string The name of the id field used by tables ('_id' for MongoDb, 'id' for most others).
	 */
	protected $_id;
	protected $_meta = array(
/*		'locked' => true,*/
		'connection' => 'default',
/*		'source' => 'li3_nzedb.users'*/
	);
	protected $_schema;
	public $url_field = array('firstName', 'lastName');
	public $url_separator = '-';
	public $search_schema = array(
		'nick_name' => array(
			'weight' => 1
		),
		'first_name' => array(
			'weight' => 1
		),
		'last_name' => array(
			'weight' => 1
		),
		'email' => array(
			'weight' => 1
		)
	);
	// These are user roles for the entire system.
/*	protected $_user_roles = array(
		'administrator' => 'Administrator',
		'content_editor' => 'Content Editor',
		'registered_user' => 'Registered User'
	);*/
	public $validates = array(
		'username' => array(
			array('notEmpty', 'message' => 'User name cannot be empty.')
		),
/*		'firstName' => array(
			array('notEmpty', 'message' => 'First name cannot be empty.')
		),*/
		'email' => array(
			array('notEmpty', 'message' => 'E-mail cannot be empty.'),
			array('email', 'message' => 'E-mail is not valid.'),
		// array('uniqueEmail', 'message' => 'Sorry, this e-mail address is already registered.'),
		),
		'password' => array(
			array('notEmpty', 'message' => 'Password cannot be empty.'),
			array('notEmptyHash', 'message' => 'Password cannot be empty.'),
			array('moreThanFive', 'message' => 'Password must be at least 6 characters long.')
		),
/*		'profilePicture' => array(
			array('notTooLarge', 'message' => 'Profile picture cannot be larger than 250px in either dimension.'),
			array('invalidFileType', 'message' => 'Profile picture must be a jpg, png, or gif image.')
		)*/
	);

	public static function __init()
	{
/*		$libConfig = Libraries::get('li3b_users_pdo');
		if (strtolower($libConfig['connection']['type']) != 'database') {
			throw new Exception("Invalid configuration.");
		}
		$this->_adapter = strtolower($libConfig['connection']['adapter']);
		switch ($this->_adapter)
		{
			case 'mongodb':
				$this->_id = '_id';
				$type = 'id';
				break;
			case 'mysql':
			case 'pgsql':
			default:
				$this->_id = 'id';
				$type = 'integer';
		}
		$id = $this->_id;
		$this->_schema = array(
			$id => array('type' => $type),
			'nickname' => array('type' => 'string'),
			'firstName' => array('type' => 'string'),
			'lastName' => array('type' => 'string'),
			'profilePicture' => array('type' => 'string'),
			'url' => array('type' => 'string'),
			'email' => array('type' => 'string'),
			'password' => array('type' => 'string'),
			'role' => array('type' => 'string'),
			'active' => array('type' => 'boolean'),
			'lastLoginIp' => array('type' => 'string'),
			'lastLoginTime' => array('type' => 'date'),
			'created' => array('type' => 'date')
		);

		/*
		 * Some special validation rules
		 * /
		Validator::add('uniqueEmail', function($value)
			{
				$current_user = Auth::check('li3b_user');
				if (!empty($current_user)) {
					$user = User::find('first', array('fields' => array($id), 'conditions' => array('email' => $value, $id => array('$ne' => new MongoId($current_user[$id])))));
				} else {
					$user = User::find('first', array('fields' => array($id), 'conditions' => array('email' => $value)));
				}
				if (!empty($user)) {
					return false;
				}
				return true;
			}
		);

		Validator::add('notEmptyHash', function($value)
			{
				if ($value == Password::hash('')) {
					return false;
				}
				return true;
			}
		);

		Validator::add('moreThanFive', function($value)
			{
				if (strlen($value) < 5) {
					return false;
				}
				return true;
			}
		);

		Validator::add('notTooLarge', function($value)
			{
				if ($value == 'TOO_LARGE.jpg') {
					return false;
				}
				return true;
			}
		);

		Validator::add('invalidFileType', function($value)
			{
				if ($value == 'INVALID_FILE_TYPE.jpg') {
					return false;
				}
				return true;
			}
		);
 */

		//parent::__init();

		/*
		 * If told to ues a specific connection, do so.
		 * Otherwise, use the default li3b_users_pdo connection.
		 * Also note: This must be called AFTER parent::__init()
		 *
		 * This is useful if the main application wants everything to use the
		 * same database...Be it local or on something like MongoLab or wherever.
		 *
		 * In fact, when gluing together libraries, one may choose
		 * all libraries that use the same database and kinda go
		 * with each other. That way it'll end up looking like a single
		 * cohesive application from the database's point of view.
		 * Of course then it's difficult to avoid conflicts in MongoDB
		 * collection names. In this case, this model is prefixing the
		 * library name to the collection in order to ensure there are
		 * no conflicts.
		 * /
		$libConfig = Libraries::get('li3b_users_pdo');
		$connection = isset($libConfig['useConnection']) ? $libConfig['useConnection'] : 'li3b_users_pdo';
		static::meta('connection', $connection); */
	}

	/**
	 * Get the user roles.
	 *
	 * @return Array
	 */
	public static function userRoles()
	{
		$class = __CLASS__;
		return $class::_object()->_user_roles;
	}

	/**
	 * Uses the connection object to determine what type of new date should be
	 * returned (MongoDate or DateTime).
	 *
	 * @param object $connection	Connection object.
	 */
	public function newDate($intiialise = null)
	{
		switch ($this->_adapter)
		{
			case 'mongodb':
				return new \MongoDate($initialise);
				break;

			case 'mysql':
			case 'pgsql':
			default:
				return new \DateTime($initialise);
				break;
		}
	}
}
?>