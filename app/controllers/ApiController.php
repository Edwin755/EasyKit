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
            $this->loadController('Users', 'api_', func_get_args(), false, 'get');
        }

        /**
         * Events Action
         *
         * @return void
         */
        function events() {
            $this->loadController('Events', 'api_', func_get_args(), false, 'get');
        }

        /**
         * Packs Action
         *
         * @return void
         */
        function packs() {
            $this->loadController('Packs', 'api_', func_get_args(), false, 'get');
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
