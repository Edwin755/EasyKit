<?php
    
    /**
     * ApiController
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
     * ApiController Class
     */
    class ApiController extends Controller
    {
        
        /**
         * Index Action
         * 
         * @return void
         */
        function index() {
            $data = array('Welcome in EasyKit API!');
            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Default Action throw 404
         * 
         * @return void
         */
        function defaultAction() {
            $this->httpStatus(404);
            $data = array(
                'error' => 'Invalid URL parameter(s)',
                );
            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Users Action
         *
         * @return void
         */
        function users() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = trim($args[0], '/');
                array_shift($args);
                $params = $args;
            } else {
                $action = null;
                $params = array();
            }

            $action = $action != null ? $action : 'get';

            require 'UsersController.php';
            new UsersController('api_' . $action, $params);
        }

        /**
         * Events Action
         *
         * @return void
         */
        function events() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = trim($args[0], '/');
                array_shift($args);
                $params = $args;
            } else {
                $action = null;
                $params = array();
            }

            $action = $action != null ? $action : 'get';

            require 'EventsController.php';
            new EventsController('api_' . $action, $params);
        }

        /**
         * Packs Action
         *
         * @return void
         */
        function packs() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = trim($args[0], '/');
                array_shift($args);
                $params = $args;
            } else {
                $action = null;
                $params = array();
            }

            $action = $action != null ? $action : 'get';

            require 'PacksController.php';
            new PacksController('api_' . $action, $params);
        }

        /**
         * Admin index Action
         *
         * @return void
         */
        function admin_index() {
            View::$title = 'Accès API';
            $data['token'] = md5(uniqid(mt_rand(), true));
            View::make('api.admin_index', $data, 'admin');
        }
    }
