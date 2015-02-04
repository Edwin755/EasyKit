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
         * @access public
         * @return void
         * @static
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

        /**
         * Return the current URL
         *
         * @return string
         */
        static function getCurrentURL() {
            self::init();
            
            return self::$request_scheme . '://' . $_SERVER['SERVER_NAME'] . self::$server_port . $_SERVER['REQUEST_URI'];
        }

        /**
         * Return the amount of time ago
         *
         * @example just now, 13 minutes ago, Yesterday at 21:05
         *
         * @param $date
         */
        static function timeago($date) {
            $datetime = new DateTime($date);
            $interval = $datetime->diff(new DateTime('now'));

            $date = strtotime($date);

            if ($interval->m > 1) {
                return date('F j Y', $date);
            } else if ($interval->m < 2 && $interval->d > 2) {
                return date('F j', $date) . ' at ' . date('H:i', $date);
            } else if ($interval->m < 2 && $interval->d == 2) {
                return 'Yesterday at ' . date('H:i', $date);
            } else if ($interval->m < 2 && $interval->d < 2 && $interval->h > 1) {
                return $interval->h . ' hours';
            } else if ($interval->m < 2 && $interval->d < 2 && $interval->h < 2 && $interval->i > 1) {
                return $interval->i . ' mins';
            } else {
                return 'Just now';
            }
        }

        /**
         * Summary for text
         *
         * @param $str
         * @param int $n
         * @param string $end_char
         *
         * @return mixed|string
         */
        static function summary($str, $n = 500, $end_char = ' ...')
        {
            if (strlen($str) < $n)
            {
                return $str;
            }

            $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

            if (strlen($str) <= $n)
            {
                return $str;
            }

            $out = "";
            foreach (explode(' ', trim($str)) as $val)
            {
                $out .= $val.' ';

                if (strlen($out) >= $n)
                {
                    $out = trim($out);
                    return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
                }
            }
        }
    }
