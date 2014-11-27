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
            if(!isset($_SERVER['REQUEST_SCHEME'])){
                $_SERVER['REQUEST_SCHEME'] = 'http';
            }
            
            if($_SERVER['SERVER_PORT'] == 80){
                $port = '';
            }else{
                $port = ':' . $_SERVER['SERVER_PORT'];
            }
            
            
            return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $port . dirname(dirname($_SERVER['SCRIPT_NAME'])) . '/' . trim($link, '/');
        }

        static function getCurrentURL() {
            
            if(!isset($_SERVER['REQUEST_SCHEME'])){
                $_SERVER['REQUEST_SCHEME'] = 'http';
            }
            
            if($_SERVER['SERVER_PORT'] == 80){
                $port = '';
            }else{
                $port = ':' . $_SERVER['SERVER_PORT'];
            }
            
            return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
        }
    }
