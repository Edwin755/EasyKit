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
            try {
                if (!$this->router = new Router) {
                    new Controller('404');
                    throw new \Exception("Error Processing Request", 1);
                }

                $this->debugHandler();
                $this->loadController();
            } catch (\Exception $e) {
                if (self::getAppFile()['debug']) {
                    die($e->getMessage());
                } else {
                    die();
                }
            }
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
                new Controller(404);
                throw new \Exception('Route matches but there is no Controller.', 1);
            }
        }

        private function debugHandler() {
            $app = self::getAppFile();

            if ($app['debug']) {
                ini_set('display_error', 'On');
                error_reporting(E_ALL | E_STRICT);
            } else {
                ini_set('display_error', 'Off');
                error_reporting(0);
            }
        }

        static function getAppFile() {
            return require __DIR__ . '/../app/config/app.php';
        }
    }
