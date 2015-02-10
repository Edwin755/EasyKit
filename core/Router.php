<?php

/**
 * Parse URL to routes
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */

namespace Core;

use Core\Exceptions\NotFoundHTTPException;

/**
 * Router Class
 */
class Router
{

    /**
     * URL Parameters
     *
     * @var string $url
     * @var string $controller
     * @var string $action
     * @var array $params
     */
    static public $url, $controller, $action, $params;

    /**
     * Do
     *
     * @var mixed $do
     */
    static private $do;

    /**
     * Closure
     *
     * @var boolean $closure
     */
    static public $closure;

    /**
     * Resource
     *
     * @var array $defaultContext
     */
    private static $defaultContext = array(
        'index' => true,
        'create' => true,
        'store' => true,
        'show' => true,
        'edit' => true,
        'update' => true,
        'destroy' => true,
    );

    /**
     * Arguments
     *
     * @var array $args
     */
    private static $args;

    /**
     * Parent Do
     *
     * @var mixed $parentDo
     */
    private static $parentDo;

    /**
     * Resource
     *
     * @var boolean $resource
     */
    private static $resource = false;

    /**
     * Construct
     *
     * @return boolean
     */
    function __construct()
    {
        require_once __DIR__ . '/../app/config/routes.php';
    }

    /**
     * isClosure
     *
     * @param null $value
     * @return bool
     */
    public static function isClosure($value = null)
    {
        if ($value == null) {
            return self::$closure;
        } else {
            self::$closure = $value;

            return true;
        }
    }

    /**
     * Get URL
     *
     * @param null $key
     *
     * @return mixed
     */
    public static function getUrl($key = null)
    {
        if ($key == null) {
            return self::$url;
        } else {
            return self::$url[$key];
        }
    }

    /**
     * Set Controller
     *
     * @param $value
     */
    public static function setController($value)
    {
        static::$controller = $value;
    }

    /**
     * Get Controller
     *
     * @return mixed
     */
    public static function getController()
    {
        return static::$controller;
    }

    /**
     * Set Action
     *
     * @param $value
     */
    public static function setAction($value)
    {
        self::$action = $value;
    }

    /**
     * Get Action
     *
     * @return mixed
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * Get Params
     *
     * @return mixed
     */
    public static function getParams()
    {
        return self::$url['params'];
    }

    /**
     * Parse the URL
     *
     * @return void
     */
    static private function parse()
    {
        $url = isset($_SERVER['PATH_INFO']) ? trim(substr($_SERVER['PATH_INFO'], 1), '/') : '';

        $query = explode('/', $url);

        self::$url['controller'] = isset($query[0]) ? $query[0] : '/';

        self::$url['action'] = isset($query[1]) ? $query[1] : '';

        self::$url['params'] = array_slice($query, 2);

    }

    /**
     * Condition for URL
     *
     * @param $vars
     */
    public function where($vars)
    {
        $valid = true;
        foreach ($vars as $var => $regex) {
            if (is_array(self::$args)) {
                if (!preg_match('#^' . $regex . '$#', self::$args[$var][0])) {
                    self::setController(self::$parentDo);
                    self::setAction(self::getUrl('action'));
                    $valid = false;
                }
            } else {
                if (!preg_match('#^' . $regex . '$#', self::$args[$var])) {
                    self::setController(self::$parentDo);
                    self::setAction(self::getUrl('action'));
                    $valid = false;
                }
            }
        }

        if ($valid) {
            call_user_func_array(self::$do, self::$args);
        }
    }

    /**
     * Get the URL and do what has to be done
     *
     * @param $url string
     * @param $do string|object
     */
    static public function get($url, $do, $context = array())
    {
        self::parse();
        self::$do = $do;
        $query = self::getUrl('controller');
        $query .= self::getUrl('action') != '' ? '/' . self::getUrl('action') : '';
        foreach (self::getParams() as $param) {
            $query .= '/' . $param;
        }

        $query = $query == '' ? '/' : $query;

        if (preg_match('#{[a-z]*}#', $url)) {
            preg_match_all('#{([a-z]*)}#', $url, $matches);
            self::$args = [];
            foreach ($matches[1] as $match) {
                preg_match("#(.*)\{$match\}(.*)#", $url, $beforeafter);
                if (preg_match("#{$beforeafter[1]}([a-zA-Z0-9]*)#", $query, $result)) {
                    $url = str_replace('{' . $match . '}', $result[1], $beforeafter[0]);
                }
                preg_match("#$beforeafter[1]([a-zA-Z0-9]*)$beforeafter[2]#", $url, self::$args[$match]);
            }
        } else {
            self::$args = [];
        }

        if ($url == $query) {
            if (is_object($do)) {
                self::isClosure(true);

                if (!empty(self::$args)) {
                    foreach (self::$args as $key => $value) {
                        self::$args[$key] = $value[1];
                    }
                    if (!self::$resource) {
                        call_user_func_array($do, self::$args);
                    }
                } else {
                    $do();
                }
            } else {
                self::isClosure(false);
                $do = explode('@', $do);

                self::setController($do[0]);
                self::setAction(isset($do[1]) ? $do[1] : 'index');
            }
        } else if (!is_object($do)) {
            if (preg_match("#^{$url}#", $query) && !preg_match('#@#', $do)) {
                $valid = true;

                if (!empty($context)) {
                    if (isset($context['only'])) {
                        $valid = false;

                        foreach ($context['only'] as $only) {
                            if ($only == self::getUrl('action')) {
                                $valid = true;
                            }
                        }
                    } else if (isset($context['exclude'])) {
                        $valid = true;

                        foreach ($context['exclude'] as $exclude) {
                            if ($exclude == self::getUrl('action')) {
                                $valid = false;
                            }
                        }
                    }
                }

                if ($valid == true) {
                    self::setController($do);
                    self::setAction(self::getUrl('action') != null ? self::getUrl('action') : 'index');
                }
            }
        }

        return new Router;
    }

    /**
     * Resource
     *
     * @param string $url
     * @param mixed $do
     * @param array $context
     * @param null $prefix
     *
     * @throws NotFoundHTTPException
     */
    static public function resource($url, $do, $context = array(), $prefix = null)
    {
        self::$parentDo = $do;
        self::$resource = true;
        self::parse();

        if (self::getUrl('controller') == $url) {
            if (isset($context['only'])) {
                foreach (self::$defaultContext as $k => $v) {
                    $context['only'][$k] = false;
                }

                foreach ($context['only'] as $k => $v) {
                    $context['only'][$v] = true;
                }

                $context = array_merge(self::$defaultContext, $context['only']);
            } else if (isset($context['exclude'])) {
                foreach (self::$defaultContext as $k => $v) {
                    $context['exclude'][$k] = true;
                }

                foreach ($context['exclude'] as $k => $v) {
                    $context['exclude'][$v] = false;
                }

                $context = array_merge(self::$defaultContext, $context['exclude']);
            } else {
                $context = self::$defaultContext;
            }

            if (!empty($_POST)) {
                if (self::getUrl('action') == 'store') {
                    if ($context['store']) {
                        Router::get($url . '/' . self::getUrl('action'), $do . '@store');
                    }
                } else {
                    if ($context['update']) {
                        Router::get($url . '/{id}', function ($id) use ($do) {
                            return Dispatcher::loadController(array(
                                'controller' => str_replace('Controller', '', $do),
                                'action' => 'update',
                                'params' => array($id),
                                'layout' => false,
                            ));
                        })->where(['id' => '([0-9]*)']);
                    }
                }
            } else {
                if (in_array('edit', self::getParams())) {
                    if ($context['edit']) {
                        Router::get($url . '/{id}/edit', function ($id) use ($do) {
                            return Dispatcher::loadController(array(
                                'controller' => str_replace('Controller', '', $do),
                                'action' => 'edit',
                                'params' => array($id),
                                'layout' => false,
                            ));
                        })->where(['id' => '([0-9]*)']);
                    }
                } else if (in_array('destroy', self::getParams())) {
                    if ($context['destroy']) {
                        Router::get($url . '/{id}/destroy', function ($id) use ($do) {
                            var_dump(true);
                            return Dispatcher::loadController(array(
                                'controller' => str_replace('Controller', '', $do),
                                'action' => $prefix . 'destroy',
                                'params' => array($id),
                                'layout' => false,
                            ));
                        })->where(['id' => '([0-9]*)']);
                    }
                } else if (in_array('create', self::getUrl())) {
                    if ($context['create']) {
                        Router::get($url . '/create', $do . '@create');
                    }
                } else {
                    if ((self::getUrl('action') == 'index' || self::getUrl('action') == '')) {
                        if ($context['index']) {
                            $url = $url . (self::getUrl('action') == '' ? '' : '/' . self::getUrl('action'));
                            Router::get($url, $do . '@index');
                        }
                    } else {
                        if ($context['show'] && self::getUrl('action') != 'store' && self::getUrl('action') != 'update') {
                            Router::get($url . '/{id}', function ($id) use ($do) {
                                return Dispatcher::loadController(array(
                                    'controller' => str_replace('Controller', '', $do),
                                    'action' => 'show',
                                    'params' => array($id),
                                    'layout' => false,
                                ));
                            })->where(['id' => '([0-9]*)']);
                        }
                    }
                }
            }

            if (self::getAction() == null) {
                throw new NotFoundHTTPException('Route definition banned this URL or wrong context (POST/GET).', 1);
            }
        }
    }
}
