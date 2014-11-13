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
         * Make the view including datas
         * 
         * @param $view string
         * @param $data void
         * 
         * @return void
         */
        static function make($view, $layout, $data = null) {
            $view = explode('.', $view);

            $filename = __DIR__ . '/../app/views/' . $view[0];

            $view = array_slice($view, 1);

            foreach ($view as $v) {
                $filename .= '/' . $v;
            }

            $filename .= '.php';

            if (file_exists($filename)) {
                require $filename;
            } else {
                new Controller('404');
            }
        }
    }
