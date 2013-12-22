<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
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

		$this->set(['user' => Auth::check('default', $this->request)]);
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