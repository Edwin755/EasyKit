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
         * IV for MCrypt
         */
        static public $iv;

        /**
         * Cookies
         */
        static public $cookies;
        
        /**
         * Create first Cookie values
         */
        static function init() {
            self::$app = Dispatcher::getAppFile();
            self::$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_NOFB), MCRYPT_RAND);

            if (isset($_COOKIE[self::$app['cookie_name']])) {
                $values = json_decode($_COOKIE[self::$app['cookie_name']]);
            }

            if (!Cookie::checkValidity()) {
                foreach ($_COOKIE as $key => $value) {
                    Cookie::destroy($key);
                }
            }

            if (!isset($_COOKIE[self::$app['cookie_name'] . '_security'])) {
                Cookie::set('security', mcrypt_encrypt(MCRYPT_3DES, self::$app['secure_key'], $_SERVER['HTTP_USER_AGENT'], MCRYPT_MODE_NOFB, self::$iv));
            }
        }

        /**
         * Create cookie with name, value, and timeout
         * 
         * @param string $name Name of the cookie
         * @param string $value Value of the cookie
         * @param int $time Optional timeout instead of default timeout
         */
        static function set($name, $value, $time = null, $path = '/') {
            setcookie(self::$app['cookie_name'] . '_' . $name, $value, time() + ($time != null ? $time : self::$app['cookie_time']), $path);
        }

        /**
         * Get value of given cookie
         * 
         * @param string $name
         * 
         * @return string
         */
        static function get($name) {
            if (isset($_COOKIE[self::$app['cookie_name'] . '_' . $name])) {
                return $_COOKIE[self::$app['cookie_name'] . '_' . $name];
            }
        }

        /**
         * Check Validity of the cookies
         * 
         * @return boolean
         */
        static function checkValidity() {
            if (mcrypt_decrypt(MCRYPT_3DES, self::$app['secure_key'], Cookie::get('security'), MCRYPT_MODE_NOFB, self::$iv) == $_SERVER['HTTP_USER_AGENT']) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Destroy given cookie
         * 
         * @param string $name
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
