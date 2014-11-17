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
            return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . trim($link, '/');
        }
    }
