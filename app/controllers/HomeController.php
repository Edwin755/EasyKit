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

            View::make('home.index', null, 'default');
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
