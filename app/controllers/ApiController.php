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
    use Core\Form;
    use Core\Cookie;

    /**
     * HomeController Class
     */
    class ApiController extends Core\Controller
    {
        
        /**
         * Index Action
         * 
         * @return void
         */
        function index() {
            $data = array('api' => 'index');

            $this->loadModel('Post');

            $data['posts'] = $this->Post->select();

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Sample
         * 
         * @return void
         */
        function getHello() {

        }

        function defaultAction() {
            View::make('api.index', json_encode(array('error' => 'URL Parsing error, please check URL parameters.')), false, 'application/json');
        }

        /**
         * Another sample
         * 
         * @return void
         */
        function hello($param1, $param2) {
            $data = array(
                'param1' => $param1,
                'param2' => $param2
                );

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
