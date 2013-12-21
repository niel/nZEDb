<?php
/**
 * Copyright (C) 2013 nZEDb
 *
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
 * not, see <http://www.gnu.org/licenses/>.
 */
namespace li3_nzedb\controllers;

use lithium\security\Auth;

class SessionsController extends \lithium\action\Controller
{
	public function add()
	{
		$auth = Auth::check('default', $this->request);
		if ($this->request->data && $auth) {
			return $this->redirect('/');
		}
	}

	public function delete()
	{
		Auth::clear('default');
		return $this->redirect('/');
	}
}
?>