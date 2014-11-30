<?php
    
    /**
     * ApiController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\View;
    use Core\Cookie;

    /**
     * ApiController Class
     */
    class ApiController extends Core\Controller
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
                $action = $args[0];
                array_shift($args);
                $params = $args;
            } else {
                $action = null;
                $params = array();
            }

            require 'UsersController.php';
            new UsersController($action, $params);
        }
    }
