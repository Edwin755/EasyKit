<?php

    /**
     * Cookie file
     */

    namespace Core;

    /**
     * Cookie class
     */
    class Cookie
    {

        /**
         * Array App file
         */
        static public $app;

        /**
         * Cookies
         */
        static public $cookies;

        static private $iv;
        
        /**
         * Create first Cookie values
         */
        static function init() {
            self::$app = Dispatcher::getAppFile();
        }

        /**
         * Create cookie with name, value, and timeout
         * 
         * @param string $name Name of the cookie
         * @param string $value Value of the cookie
         * @param int $time Optional timeout instead of default timeout
         * @param string $path Optional path to save the cookie
         */
        static function set($name, $value, $time = null, $path = '/') {
            setcookie(self::$app['cookie_name'] . '_' . $name, $value, time() + ($time != null ? $time : self::$app['cookie_time']), $path);
        }

        /**
         * Get value of given cookie
         * 
         * @param string $name
         * 
         * @return string|boolean
         */
        static function get($name) {
            if (isset($_COOKIE[self::$app['cookie_name'] . '_' . $name])) {
                $value = $_COOKIE[self::$app['cookie_name'] . '_' . $name];
                return $value;
            } else {
                return false;
            }
        }

        /**
         * Destroy given cookie
         * 
         * @param string $name
         * @param string $path Destroy the cookie in the path
         * 
         * @return boolean
         */
        static function destroy($name, $path = '/') {
            $name = str_replace(self::$app['cookie_name'] . '_', '', $name);
            if (isset($_COOKIE[self::$app['cookie_name'] . '_' . $name])) {
                setcookie(self::$app['cookie_name'] . '_' . $name, '', 10, $path);
                return true;
            } else {
                return false;
            }
        }
    }
