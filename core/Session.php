<?php

    /**
     * Session
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    /**
     * Session Class
     */
    class Session
    {

        /**
         * Construct
         * Secure the session by mcrypt
         * 
         * @return void
         */
        function __construct() {
            $app = Dispatcher::getAppFile();

            if (!isset($_SESSION)) {
                session_start();
                session_name($app['session_name']);

                $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_NOFB), MCRYPT_RAND);
                self::set('secure', mcrypt_encrypt(MCRYPT_3DES, $app['secure_key'], $_SERVER['HTTP_USER_AGENT'], MCRYPT_MODE_NOFB, $iv));
            } else {
                if (mcrypt_decrypt(MCRYPT_3DES, $app['secure_key'], self::get('secure'), MCRYPT_MODE_NOFB, $iv) == $_SERVER['HTTP_USER_AGENT']) {
                    return true;
                } else {
                    session_destroy();
                    unset($_SESSION);
                }
            }
        }

        /**
         * Set a value to the session
         * 
         * @param string $key
         * @param void $value
         * 
         * @return void
         */
        static function set($key, $value) {
            $_SESSION[$key] = $value;
        }

        /**
         * Get a value from the session
         * 
         * @param string key
         * 
         * @return void
         */
        static function get($key) {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        }
    }
