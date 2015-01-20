<?php

    /**
     * View
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    use Core\Exceptions\NotFoundHTTPException;

    /**
     * Class View
     *
     * @package Core
     */
    class View
    {

        /**
         * Current Page
         *
         * @var string $current
         * @var string $title
         * @var string $folders
         */
        static public $current, $title, $folders;

        /**
         * Set the folders
         *
         * @param $folders
         */
        private function setFolders($folders)
        {
            self::$folders = $folders;
        }

        /**
         * Get the folders
         *
         * @return string
         */
        private static function getFolders()
        {
            return self::$folders;
        }

        /**
         * Make the view including datas
         *
         * @param string $view
         * @param array $data
         * @param string|boolean $layout But boolean by default
         * @param string $content_type
         *
         * @return bool
         *
         * @throws NotFoundHTTPException
         */
        static function make($view, $data = array(), $layout = false, $content_type = 'text/html') {
            header('Content-type: ' . $content_type);
            $viewname = $view;
            $view = explode('.', $view);

            self::setFolders(str_replace('.', '/', $viewname));

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

                    $layout_file = __DIR__ . '/../app/views/layouts/' . $layout . '.php';

                    if (file_exists($layout_file)) {
                        require $layout_file;
                    } else {
                        throw new NotFoundHTTPException('Layout ' . $layout . ' not found.');
                    }
                } else {
                    require $filename;
                }

                return true;
            } else {
                throw new NotFoundHTTPException('View ' . $viewname . ' not found.');
            }
        }
    }
