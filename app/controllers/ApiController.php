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

            View::make('api.index', json_encode($data));
        }

        function getHello() {
            //$this->pageNotFound();
        }

        function hello($param) {
            $data = array('params' => $param);

            $this->loadModel('Post');

            $data['posts'] = $this->Post->select();

            View::make('api.index', json_encode($data));
        }
    }
