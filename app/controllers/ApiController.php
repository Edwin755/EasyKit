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

        /**
         * Default Action
         * 
         * 404 Page Not Found
         */
        function defaultAction() {
            $this->httpStatus(404);
            View::make('api.index', json_encode(array('error' => 'URL Parsing error, please check URL parameters.')), false, 'application/json');
        }

        /**
         * Another sample
         * 
         * @return void
         */
        function hello($param1 = null, $param2 = null) {
            $data = array(
                'param1' => $param1,
                'param2' => $param2,
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD']
                );

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        function post() {
            $this->loadModel('Post');

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $data['posts'] = $this->Post->select();
                    break;

                case 'POST':
                    $data['id'] = $this->Post->save(array(
                        'name'      => $_POST['name'],
                        'content'   => $_POST['content']
                        ));
                    $data = $this->Post->select(array(
                        'conditions'    => array(
                            'id'       => $data['id']
                            )
                        ));
                    break;
                
                default:
                    # code...
                    break;
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
