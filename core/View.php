<?php

    /**
     * View
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    /**
     * View Class
     */
    class View
    {

        /**
         * Rendered
         */
        static private $rendered;

        /**
         * Current Page
         */
        static public $current;

        /**
         * Current Page
         */
        static public $title;

        /**
         * 
         */
        static function getRendered() {
            return self::$rendered;
        }
     
        /**
         * Make the view including datas
         * 
         * @param string $view
         * @param array $data
         * @param string|boolean $layout But boolean by default
         * @param string $content_type
         * 
         * @return boolean
         */
        static function make($view, $data = array(), $layout = false, $content_type = 'text/html') {
            if (!self::$rendered) {
                header('Content-type: ' . $content_type);
                $view = explode('.', $view);

                if (is_array($data)) {
                    extract($data);
                }

                $filename = __DIR__ . '/../app/views/' . $view[0];

                $view = array_slice($view, 1);

                foreach ($view as $v) {
                    $filename .= '/' . $v;
                }

                $filename .= '.php';

                if (file_exists($filename)) {
                    if ($layout !== false) {
                        require_once 'HTML.php';
                        
                        ob_start();
                        require $filename;
                        $content_for_layout = ob_get_clean();

                        require __DIR__ . '/../app/views/layouts/' . $layout . '.php';
                    } else {
                        require $filename;
                    }

                    self::$rendered = true;
                    return true;
                } else {
                    self::$rendered = true;
                    throw new NotFoundHTTPException('View not found');
                }
            } else {
                return false;
            }
        }
    }
