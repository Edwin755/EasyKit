<?php

    /**
     * Dispatcher of the framework
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     * 
     * @package Core
     */

    namespace Core;

    use App\Controllers;

    /**
     * Dispatcher Class
     */
    class Dispatcher
    {

        /**
         * Router
         */
        private $router;
        
        /**
         * Construct
         * 
         * @return void
         */
        function __construct() {
            if (!$this->router = new Router) {
                new Controller('404');
            }

            $this->loadController();
        }

        /**
         * Load the Controller associated to route
         * 
         * @return boolean
         */
        private function loadController() {
            $controller = ucfirst($this->router->controller) . 'Controller';

            $filename = __DIR__ . '/../app/controllers/' . $controller .  '.php';

            if (file_exists($filename)) {
                require $filename;

                $classController = '\\App\\Controllers\\' . $controller;

                new $classController($this->router->action, $this->router->params);

                return true;
            } else {
                $controller = new Controller('404');

                return false;
            }
        }
    }
