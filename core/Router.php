<?php

    /**
     * Parse URL to routes
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

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
         * Closure
         */
        static public $closure;

        /**
         * Resource
         */
        private static $resource = false;

        /**
         * Construct
         * 
         * @return boolean
         */
        function __construct() {
            require __DIR__ . '/../app/config/routes.php';
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
        function getParams() {
            return self::$params;
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

            self::$params = array_slice($query, 2);
        }

        /**
         *
         *
         * @param $url string
         * @param $do string|object
         */
        static public function get($url, $do, $context = array()) {
            self::parse();
            $query = self::getUrl('controller');
            $query .= self::getUrl('action') != '' ? '/' . self::getUrl('action') : '';
            foreach (self::$params as $param) {
                $query .= '/' . $param;
            }

            $query = $query == '' ? '/' : $query;

            if (preg_match('#{[a-z]*}#', $url)) {
                preg_match_all('#{([a-z]*)}#', $url, $matches);
                $args = array();
                foreach ($matches[1] as $match) {
                    preg_match("#(.*)\{$match\}(.*)#", $url, $beforeafter);
                    if(preg_match("#{$beforeafter[1]}([a-zA-Z0-9]*)#", $query, $result)) {
                        $url = str_replace('{' . $match . '}', $result[1],$beforeafter[0]);
                    }
                    preg_match("#$beforeafter[1]([a-zA-Z0-9]*)$beforeafter[2]#", $url, $args[$match]);
                }
            } else {
                $args = [];
            }

            if ($url == $query) {
                if (is_object($do)) {
                    self::isClosure(true);

                    if (!empty($args)) {
                        foreach ($args as $key => $value) {
                            $args[$key] = $value[1];
                        }
                        call_user_func_array($do, $args);
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
        }

        static public function resource($url, $do) {
            self::$resource = true;
        }
    }
