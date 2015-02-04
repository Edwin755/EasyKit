<?php
    
    /**
     * HomeController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\Controller;
    use Core\Exceptions\NotFoundHTTPException;
    use Core\Session;
    use Core\View;
    use Core\Cookie;

    /**
     * HomeController Class
     */
    class HomeController extends Controller
    {

        /**
         * Index
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function index() {
            View::$title = 'Accueil';

            View::make('home.index', null, 'home');
        }

        /**
         * Constructor
         *
         * @return void
         */
        function constructor() {
            if (isset($_SESSION['admin']) && $this->getPrefix() == 'admin') {
                $admin = Session::get('admin');
                if (!$this->getJSON($this->link('admin1259/is_admin/' . $admin->admin_username . '/' . $admin->admin_password))->admin) {
                    if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                        throw new NotFoundHTTPException('Non authorized address.');
                    }
                }
            } else if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                throw new NotFoundHTTPException('Non authorized address.');
            }
        }

        /**
         * Admin Index
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function admin_index() {
            View::$current = 'dash';
            View::$title = 'Dashboard';

            View::make('home.admin_index', null, 'admin');
        }
    }
