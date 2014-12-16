<?php
    
    /**
     * AdminController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\Controller;
    use Core\Session;
    use Core\View;
    use Core\Cookie;

    /**
     * AdminController Class
     *
     * @property mixed Admin
     */
    class AdminController extends Controller
    {

        /**
         * Constructor
         *
         * @return void
         */
        function constructor() {
            if (isset($_SESSION['admin'])) {
                if (!$this->isAdmin()) {
                    $this->redirect('admin1259/users/signin');
                }
            } else if ($this->link('admin1259/users/signin') != $this->getCurrentURL()) {
                $this->redirect('admin1259/users/signin');
            }
        }

        /**
         * isAdmin
         *
         * @return boolean
         */
        function isAdmin() {
            $this->loadModel('Admin');

            $user = $this->Admin->select(array(
                'conditions'    => array(
                    'id'            => Session::get('admin')->admin_id
                )
            ));
            $user = current($user);

            if ($user->admin_username == Session::get('admin')->admin_username && $user->admin_password == Session::get('admin')->admin_password) {
                return true;
            } else {
                unset($_SESSION['admin']);
                return false;
            }
        }

        /**
         * Index Action
         */
        function index() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = $args[0];
                array_shift($args);
                $params = $args;
            } else {
                $action = 'index';
                $params = array();
            }

            $action = $action != null ? $action : 'index';

            require 'HomeController.php';
            new HomeController('admin_' . $action, $params);
        }

        /**
         * Events Action
         */
        function events() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = $args[0];
                array_shift($args);
                $params = $args;
            } else {
                $action = 'index';
                $params = array();
            }

            $action = $action != null ? $action : 'index';

            require 'EventsController.php';
            new EventsController('admin_' . $action, $params);
        }

        /**
         * Users Action
         */
        function users() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = $args[0];
                array_shift($args);
                $params = $args;
            } else {
                $action = 'index';
                $params = array();
            }

            $action = $action != null ? $action : 'index';

            require 'UsersController.php';
            new UsersController('admin_' . $action, $params);
        }

        /**
         * Apis Action
         */
        function api() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = $args[0];
                array_shift($args);
                $params = $args;
            } else {
                $action = 'index';
                $params = array();
            }

            $action = $action != null ? $action : 'index';

            require 'ApiController.php';
            new ApiController('admin_' . $action, $params);
        }
    }
