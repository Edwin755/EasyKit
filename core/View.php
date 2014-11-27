<?php

    /**
     * View
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    use Core\Form as Form;

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
         * 
         */
        static function getRendered() {
            return self::$rendered;
        }
     
        /**
         * Make the view including datas
         * 
         * @param string $view
         * @param string $layout But boolean by default
         * @param array $data
         * 
         * @return void
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
//                         HTML::init();

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
                    new Controller('404');

                    self::$rendered = true;
                    return false;
                }
            }
        }
    }
