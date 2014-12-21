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
    use Core\ErrorHandler;
    use Core\Exceptions\NotFoundHTTPException;
    use Exception;

    /**
     * Dispatcher Class
     */
    class Dispatcher
    {

        /**
         * Router
         */
        private $router;

        private $debug;
        
        /**
         * Construct
         * 
         * @return void
         */
        function __construct() {
            $this->debugHandler();

            try {
                $this->router = new Router;

                $this->loadController();
            } catch (NotFoundHTTPException $e) {
                if ($this->debug) {
                    new ErrorHandler($e);
                } else {
                    Controller::pageNotFound($e->getLayout());
                }
            } catch (Exception $e) {
                Controller::httpStatus(500);

                if ($this->debug) {
                    new ErrorHandler($e);
                }
            }
        }

        /**
         * Load the Controller associated to route
         * 
         * @throws Exception when Controller file or class not found
         * @return boolean
         */
        private function loadController() {
            $controller = ucfirst($this->router->controller) . 'Controller';

            $filename = __DIR__ . '/../app/controllers/' . $controller .  '.php';

            if (file_exists($filename)) {
                require $filename;

                $classController = '\\App\\Controllers\\' . $controller;

                if (class_exists($classController)) {
                    new $classController($this->router->action, $this->router->params);
                } else {
                    throw new NotFoundHTTPException('Controller file found, but class ' . $controller . ' not found.', 1);
                }

                return true;
            } else if ($this->router->controller == null) {
                throw new NotFoundHTTPException('Route ' . $this->router->url['controller'] . ' not found.', 1);
            } else {
                throw new NotFoundHTTPException('Controller ' . $controller . ' not found.', 1);
            }
        }

        private function debugHandler() {
            $app = self::getAppFile();

            $this->debug = $app['debug'];

            if ($this->debug) {
                ini_set('display_error', 1);
                error_reporting('E_ALL');
                ini_set('log_errors', 0);
                if(function_exists('xdebug_disable')) { xdebug_disable(); }
                $this->errorHandler = new ErrorHandler();
            } else {
                ini_set('display_error', 0);
                error_reporting(0);
            }
        }

        static function getAppFile() {
            return require __DIR__ . '/../app/config/app.php';
        }
    }
