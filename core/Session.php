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
         * @return boolean
         */
        function __construct() {
            $app = Dispatcher::getAppFile();

            if (!isset($_SESSION)) {
                session_name($app['session_name']);
                session_start();
                return true;
            } else {
                return false;
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
         * @param string $key
         * 
         * @return boolean|string|array|int|object
         */
        static function get($key) {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            } else {
                return false;
            }
        }
    }
