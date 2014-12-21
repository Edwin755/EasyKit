<?php

    /**
     * Parse URL to routes
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    /**
     * Router Class
     */
    class Router
    {

        /**
         * URL
         */
        public $url;

        /**
         * Controller
         */
        public $controller;

        /**
         * Action
         */
        public $action;

        /**
         * Params
         */
        public $params;
        
        /**
         * Construct
         * 
         * @return boolean
         */
        function __construct() {
            $this->parse();

            if ($this->matchRoutes()) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Parse the URL
         * 
         * @return void
         */
        function parse() {
            $url = isset($_SERVER['PATH_INFO']) ? trim(substr($_SERVER['PATH_INFO'], 1), '/') : '';

            $query = explode('/', $url);

            $this->url['controller'] = isset($query[0]) ? $query[0] : '/';

            $this->url['action'] = isset($query[1]) ? $query[1] : '';

            $this->params = array_slice($query, 2);
        }

        /**
         * Match the route associated to URL
         * 
         * @return boolean
         */
        function matchRoutes() {
            $routes = require __DIR__ . '/../app/config/routes.php';

            $query = $this->url['controller'] . '/';
            $query .= !empty($this->url['action']) ? $this->url['action'] . '/' : '';

            foreach ($routes as $url => $route) {
                $multiple = explode('/', $url);

                if ($url == $query) {
                    $route = explode('.', $route);

                    $this->controller = $route[0];
                    $this->action = isset($route[1]) ? $route[1] : 'index';

                    return true;
                } else if ($multiple[0] == $this->url['controller'] && $multiple[1] == '*') {
                    $route = explode('.', $route);

                    $this->controller = $route[0];
                    $this->action = !empty($this->url['action']) ? $this->url['action'] : 'index';

                    return true;
                }
            }

            return false;
        }
    }
