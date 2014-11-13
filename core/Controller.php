<?php

    /**
     * Principal Controller
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    /**
    * Controller Class
    */
    class Controller
    {
        /**
         * Action
         */
        private $actions;

        /**
         * Rendered
         */
        private $rendered;

        /**
         * Construct
         * 
         * @param $action string
         * @param $params array
         * 
         * @return boolean
         */
        function __construct($action, $params = null) {
            if ($this->rendered) {
                return false;
            } else {
                $this->actions = get_class_methods($this);

                if (in_array($action, $this->actions)) {
                    call_user_func(array($this, $action), $params);
                } else {
                    $this->pageNotFound();
                    var_dump('construct controller');
                }

                $this->rendered = true;
                return true;
            }
        }

        /**
         * Launch the 404 page
         * 
         * @return boolean
         */
        function pageNotFound() {
            $this->httpStatus(404);

            View::make('errors.404');
            return true;
        }

        /**
         * Launch the header status for each status code
         * 
         * @param $code int
         * 
         * @return boolean
         */
        function httpStatus($code) {
            header("HTTP/1.0 404 Not Found");

            return true;
        }
    }
