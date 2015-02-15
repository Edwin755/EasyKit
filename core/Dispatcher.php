<?php

/**
 * Dispatcher of the framework
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */

namespace Core;

use App\Controllers;
use Core\Exceptions\NotFoundHTTPException;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Dispatcher Class
 *
 * @package Core
 */
class Dispatcher
{

    /**
     * Router
     *
     * @var object $router
     */
    private static $router;

    /**
     * Loaded
     *
     * @var boolean $loaded
     */
    private static $loaded = false;

    /**
     * Debug
     *
     * @var boolean $debug
     */
    private $debug;

    /**
     * App file
     *
     * @var array
     */
    private static $appfile;

    /**
     * Construct
     *
     * @return void
     */
    function __construct()
    {
        $this->debugHandler();

        require __DIR__ . '/../app/controllers/AppController.php';

        try {
            self::$router = new Router;

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

            $log = new Logger('exception');
            $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/exception.log', Logger::WARNING));
            $log->addWarning('[l.' . $e->getLine() . '] ' . $e->getMessage());
        }
    }

    /**
     * Load the Controller associated to route
     *
     * @throws Exception when Controller file or class not found
     * @return boolean
     */
    static public function loadController($req = array())
    {
        if (!empty($req)) {
            $controller = ucfirst($req['controller']) . 'Controller';
            $action = $req['action'];
            $params = $req['params'];
            $layout = $req['layout'];
        } else {
            $controller = self::$router->getController();
            $action = self::$router->getAction();
            $params = self::$router->getParams();
            $layout = null;
        }

        $filename = __DIR__ . '/../app/controllers/' . $controller . '.php';

        if (file_exists($filename)) {
            if (!self::$loaded) {
                require $filename;

                $classController = '\\App\\Controllers\\' . $controller;

                if (class_exists($classController)) {
                    new $classController($action, $params, $layout);
                    self::$loaded = true;
                } else {
                    throw new NotFoundHTTPException('Controller file found, but class ' . $controller . ' not found.', 1);
                }
            }

            return true;
        } else if (self::$router->getController() == null) {
            if (!Router::isClosure()) {
                throw new NotFoundHTTPException('Route ' . self::$router->getUrl('controller') . ' not found.', 1);
            } else {
                return false;
            }
        } else {
            throw new NotFoundHTTPException('Controller ' . $controller . ' not found.', 1);
        }
    }

    /**
     * Debug Handler
     */
    private function debugHandler()
    {
        $app = self::getAppFile();

        $this->debug = $app['debug'];

        if ($this->debug) {
            ini_set('display_error', 1);
            error_reporting('E_ALL');
            ini_set('log_errors', 0);
            if (function_exists('xdebug_disable')) {
                xdebug_disable();
            }
            $this->errorHandler = new ErrorHandler();
        } else {
            ini_set('display_error', 0);
            error_reporting(0);
        }
    }

    /**
     * Get the App File
     *
     * @return array
     */
    static function getAppFile()
    {
        if (empty(self::$appfile)) {
            self::$appfile = require __DIR__ . '/../app/config/app.php';
        }
        return self::$appfile;
    }
}
