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

            $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_NOFB), MCRYPT_RAND);

            if (!isset($_SESSION)) {
                session_name($app['session_name']);
                session_start();
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
