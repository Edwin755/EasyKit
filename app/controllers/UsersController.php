<?php
    
    /**
     * UsersController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\View;
    use Core\Cookie;

    /**
     * UsersController Class
     */
    class UsersController extends Core\Controller
    {

        /**
         * Index Action
         * 
         * @return void
         */
        function index() {
            $data = array('Users controller');
            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Auth Action
         * 
         * @return void
         */
        function auth() {
            $data = array('Auth action');
            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
