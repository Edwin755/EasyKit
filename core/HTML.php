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
         * Link method
         *
         * @param string $link
         *
         * @return string Constructed URL
         */
        static function link($link)
        {
            $link = !empty($link) ? '/' . trim($link, '/') : '';
            $script_name = trim(dirname(dirname($_SERVER['SCRIPT_NAME']))) != '/' ? '/' . trim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') : '';
            return $_SERVER['REQUEST_SCHEME'] . '://' . trim($_SERVER['SERVER_NAME'], '/') . $script_name . $link;
        }

        static function getCurrentURL() {
            return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }
    }
