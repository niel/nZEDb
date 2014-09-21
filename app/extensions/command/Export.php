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
 * @copyright 2014 nZEDb
 */
namespace app\extensions\command;

use \Exception;
use \lithium\console\command\Help;

class Export extends \app\extensions\console\Command
{
	/**
	 * Constructor.
	 *
	 * @param array $config
	 */
	public function __construct(array $config = [])
	{
		$defaults = [
			'request' => null,
			'response' => array(),
			'classes' => $this->_classes
		];
		parent::__construct($config + $defaults);
	}

	public function run($command = null)
	{
		if (!$command || !$this->request->args()) {
			return $this->_help($command);
		}

		if (!$command) {
			return $this->_help($command);
		}

		if ($this->_execute($command)) {
			return true;
		}

		$this->error("{$command} could not be created.");
		return false;
	}

	/**
	 * Invokes the `Help` command.
	 *
	 * The invoked Help command will take over request and response objects of
	 * the originally invoked command. Thus the response of the Help command
	 * becomes the response of the original one.
	 *
	 * @return boolean
	 */
	protected function _help()
	{
		$help = new Help(array(
							 'request'  => $this->request,
							 'response' => $this->response,
							 'classes'  => $this->_classes
						 ));
		return $help->run(get_class($this));
	}

	/**
	 * Class initializer. Parses template and sets up params that need to be filled.
	 *
	 * @return void
	 */
	protected function _init()
	{
		parent::_init();
	}
}
