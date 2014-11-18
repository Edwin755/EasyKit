<?php

    /**
     * Cookie file
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    /**
     * Cookie class
     */
    class Cookie
    {

        private $values;
        
        /**
         * Construct
         *
         * @return void
         */
        function __construct() {
            if (isset($_COOKIE)) {
                $app = Dispatcher::getAppFile();

                setcookie($app['cookie_name'], $this->values, time() + $app['cookie_time']);
            } else {

            }
        }

        static function cookie_destroy() {

        }
    }
