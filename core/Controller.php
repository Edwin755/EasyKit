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
         * Construct
         * 
         * @param string $action
         * @param array $params
         * 
         * @return boolean
         */
        function __construct($action, $params = null) {
            new Session();
            Cookie::init();

            $this->actions = get_class_methods($this);

            if (in_array($action, $this->actions)) {
                $this->httpStatus(200);
                call_user_func_array(array($this, $action), $params);
            } else {
                foreach ($this->actions as $actions) {
                    if ($actions == 'defaultAction') {
                        call_user_func_array(array($this, $actions), $params);
                        return true;
                    }
                }

                $this->pageNotFound();
            }

            if (!View::getRendered()) {
                $this->pageNotFound();
            }
            
            return true;
        }

        /**
         * Launch the 404 page
         * 
         * @return boolean
         */
        public function pageNotFound() {
            $this->httpStatus(404);

            View::make('errors.404', '', 'default');
            return true;
        }

        /**
         * Launch the header status for each status code
         * 
         * @param int $code
         * 
         * @return boolean
         */
        private function httpStatus($code) {
            switch ($code) {
                case 404:
                    header('HTTP/1.1 404 Not Found');
                    break;

                case 200:
                    header('HTTP/1.1 200 OK');
                    break;
                
                default:
                    throw new Exception("Unknown http status", 1);
                    return false;
                    break;
            }

            return true;
        }

        /**
         * Load model
         * 
         * @param string $model Name of the model and name of the file
         */
        protected function loadModel($model) {
            if(!isset($this->$model)){
                $file = __DIR__ . '/../app/models/' . ucfirst($model) . '.php';
                require_once($file);
                $class = '\\App\\Models\\' . $model;
                $this->$model = new $class();
            }
        }
    }
