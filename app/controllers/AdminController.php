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

        protected $layout = 'admin';

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

        function defaultAction() {
            throw new Core\Exceptions\NotFoundHTTPException('Page not found', 1, 'admin');
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
            $this->loadController('Home', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Events Action
         */
        function events() {
            $this->loadController('Events', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Users Action
         */
        function users() {
            $this->loadController('Users', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Apis Action
         */
        function api() {
            $this->loadController('Api', 'admin_', func_get_args(), $this->layout);
        }
    }
