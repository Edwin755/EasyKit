<?php

    /**
     * HTML Methods
     */

    /**
     * HTML Class
     */
    class HTML
    {
        
        /**
         * Link method
         *
         * @param $link string
         *
         * @return string constructed URL
         */
        static function link($link)
        {
            return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . trim($link, '/');
        }
    }
