<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_nzedb\controllers;

class HelloWorldController extends \lithium\action\Controller {

	public function index() {
		return $this->render(array('layout' => false));
	}

	public function toString() {
		return "Hello World";
	}

	public function toSson() {
		return $this->render(array('json' => 'Hello World'));
	}
}

?>