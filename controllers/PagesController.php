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

namespace li3_nzedb\controllers;

use lithium\data\Connections;
use lithium\security\Auth;
use li3_nzedb\models\Sites;

/**
 * This controller is used for serving static pages by name, which are located in the `/views/pages`
 * folder.
 *
 * A Lithium application's default routing provides for automatically routing and rendering
 * static pages using this controller. The default route (`/`) will render the `home` template, as
 * specified in the `view()` action.
 *
 * Additionally, any other static templates in `/views/pages` can be called by name in the URL. For
 * example, browsing to `/pages/about` will render `/views/pages/about.html.php`, if it exists.
 *
 * Templates can be nested within directories as well, which will automatically be accounted for.
 * For example, browsing to `/pages/about/company` will render
 * `/views/pages/about/company.html.php`.
 */
class PagesController extends \lithium\action\Controller
{
	protected $_render = array();

	public function view() {
		$options = array();
		$path = func_get_args();

		$config = Connections::config();
		if (!$path || $path === array('home') || !$config) {
			if (!$config || !$this->_checkSite()) {
				$this->_render['layout'] = 'setup';
				$path = array('setup');
			} else {
				$theme = Sites::find('first', array('conditions' => array('setting' => 'style')));
				$this->_render['layout'] = strtolower($theme->data('value'));
				$path = array('home');
			}
			$options['compiler'] = array('fallback' => true);
		}
		$user = Auth::check('default', $this->request);
		$link1 = $user ? 'out' : 'in';
		$link2 = $user ? 'profile' : 'join';
		$label2 = $user ? 'Profile' : 'Register';

		$this->set(compact('user', 'link1', 'link2', 'label2'));
		$options['template'] = join('/', $path);
		return $this->render($options);
	}

	protected function _checkSite()
	{
		try {
			$result = Sites::first(array('conditions' => array('id' => '1')));
		} catch (Exception $ex) {
			return false;
		}
		return $result;
	}
}

?>