<?php

    /**
     * HTML Methods
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    /**
     * HTML Class
     */
    class HTML
    {

        /**
         * server_port
         * 
         * @var mixed
         * @access private
         * @static
         */
        private static $server_port;
        

        /**
         * request_scheme
         * 
         * @var mixed
         * @access private
         * @static
         */
        private static $request_scheme;
        
        /**
         * init function.
         * 
         * @access static
         * @return void
         */
        static function init(){
            if (!isset($_SERVER['REQUEST_SCHEME'])) {
                self::$request_scheme = 'http';
            } else {
                self::$request_scheme = $_SERVER['REQUEST_SCHEME'];
            }
            
            if ($_SERVER['SERVER_PORT'] == 80) {
                self::$server_port = '';
            } else {
                self::$server_port = ':' . $_SERVER['SERVER_PORT'];
            }
        }
        
        /**
         * Link method
         *
         * @param string $link
         *
         * @return string Constructed URL
         */
        static function link($link) {
            self::init();
            
            $link = !empty($link) ? '/' . trim($link, '/') : '';
            $script_name = trim(dirname(dirname($_SERVER['SCRIPT_NAME']))) != '/' ? '/' . trim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') : '';
            
            return self::$request_scheme . '://' . trim($_SERVER['SERVER_NAME'], '/') . self::$server_port . $script_name . $link;
        }

        static function getCurrentURL() {
            self::init();
            
            return self::$request_scheme . '://' . $_SERVER['SERVER_NAME'] . self::$server_port . $_SERVER['REQUEST_URI'];
        }
    }
