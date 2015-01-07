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
         * URL
         */
        static public $url;

        /**
         * Controller
         */
        static public $controller;

        /**
         * Action
         */
        static public $action;

        /**
         * Params
         */
        static public $params;

        /**
         * Do
         */
        static private $do;

        /**
         * Closure
         */
        static public $closure;

        /**
         * Resource
         */
        private static $defaultContext = array(
            'index'     => true,
            'create'    => true,
            'store'     => true,
            'show'      => true,
            'edit'      => true,
            'update'    => true,
            'destroy'   => true,
        );

        /**
         * Arguments
         */
        private static $args;

        /**
         * Parent Do
         */
        private static $parentDo;

        /**
         * Construct
         * 
         * @return boolean
         */
        function __construct() {
            require_once __DIR__ . '/../app/config/routes.php';
        }

        public static function isClosure($value = null) {
            if ($value == null) {
                return self::$closure;
            } else {
                self::$closure = $value;

                return true;
            }
        }

        /**
         * @param null $key
         *
         * @return mixed
         */
        public static function getUrl($key = null) {
            if ($key == null) {
                return self::$url;
            } else {
                return self::$url[$key];
            }
        }

        /**
         * @param $value
         */
        public static function setController($value) {
            static::$controller = $value;
        }

        /**
         * @return mixed
         */
        public static function getController() {
            return static::$controller;
        }

        /**
         * @param $value
         */
        public static function setAction($value) {
            self::$action = $value;
        }

        /**
         * @return mixed
         */
        public static function getAction() {
            return self::$action;
        }

        /**
         * @return mixed
         */
        public static function getParams() {
            return self::$url['params'];
        }

        /**
         * Parse the URL
         * 
         * @return void
         */
        static private function parse() {
            $url = isset($_SERVER['PATH_INFO']) ? trim(substr($_SERVER['PATH_INFO'], 1), '/') : '';

            $query = explode('/', $url);

            self::$url['controller'] = isset($query[0]) ? $query[0] : '/';

            self::$url['action'] = isset($query[1]) ? $query[1] : '';

            self::$url['params'] = array_slice($query, 2);

        }

        public function where($vars) {
            $valid = true;
            foreach ($vars as $var => $regex) {
                if (!preg_match('#^' . $regex . '$#', self::$args[$var])) {
                    self::setController(self::$parentDo);
                    self::setAction(self::getUrl('action'));
                    $valid = false;
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
        static public function get($url, $do, $context = array()) {
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
                self::$args = array();
                foreach ($matches[1] as $match) {
                    preg_match("#(.*)\{$match\}(.*)#", $url, $beforeafter);
                    if(preg_match("#{$beforeafter[1]}([a-zA-Z0-9]*)#", $query, $result)) {
                        $url = str_replace('{' . $match . '}', $result[1],$beforeafter[0]);
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
                    } else {
                        $do();
                    }
                } else {
                    self::isClosure(false);
                    $do = explode('@', $do);

                    self::setController($do[0]);
                    self::setAction(isset($do[1]) ? $do[1] : 'index');
                }
            } else if (preg_match("#^{$url}#", $query) && !preg_match('#@#', $do)) {
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

            return new Router;
        }

        /**
         * @param $url
         * @param $do
         * @param array $context
         */
        static public function resource($url, $do, $context = array()) {
            self::$parentDo = $do;
            self::parse();

            if (isset($context['only'])) {
                foreach(self::$defaultContext as $k => $v) {
                    $context['only'][$k] = false;
                }

                foreach ($context['only'] as $k => $v) {
                    $context['only'][$v] = true;
                }

                $context = array_merge(self::$defaultContext, $context['only']);
            } else if (isset($context['exclude'])) {
                foreach(self::$defaultContext as $k => $v) {
                    $context['exclude'][$k] = true;
                }

                foreach ($context['exclude'] as $k => $v) {
                    $context['exclude'][$v] = false;
                }

                $context = array_merge(self::$defaultContext, $context['exclude']);
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
                                'controller'    => str_replace('Controller', '', $do),
                                'action'        => 'update',
                                'params'        => array($id),
                                'layout'        => false,
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
                            return Dispatcher::loadController(array(
                                'controller'    => str_replace('Controller', '', $do),
                                'action'        => 'destroy',
                                'params'        => array($id),
                                'layout'        => false,
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
                        if ($context['show']) {
                            Router::get($url . '/{id}', function ($id) use ($do) {
                                return Dispatcher::loadController(array(
                                    'controller'    => str_replace('Controller', '', $do),
                                    'action'        => 'show',
                                    'params'        => array($id),
                                    'layout'        => false,
                                ));
                            })->where(['id' => '([0-9]*)']);
                        }
                    }
                }
            }

            if (self::getAction() == null) {
                throw new NotFoundHTTPException('Route definition banned this URL.', 1);
            }
        }
    }
