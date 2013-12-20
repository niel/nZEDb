<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, nZEDb (http://nzedb.com)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_nzedb\controllers;

use lithium\security\Auth;
use li3_nzedb\models\Users;

class UsersController extends \lithium\action\Controller {

    public function index() {
        $users = Users::all();
        return compact('users');
    }

    public function add() {
        $user = Users::create($this->request->data);

        if (($this->request->data) && $user->save()) {
            return $this->redirect('Users::index');
        }
        return compact('user');
    }
}

?>