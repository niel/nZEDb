<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, nZEDb (http://nzedb.com)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_nzedb\models;

class Sites extends \lithium\data\Model
{
	protected $_meta = array('source' => 'site');

	static public function get($setting)
	{
		$setting = self::find('first', array('conditions' => array('setting' => array('=' => $setting))));
		$setting = $setting == true ? $setting->data()['value'] : null;
		return $setting;
	}
}

?>
