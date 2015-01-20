<?php
    /**
     * Created by PhpStorm.
     * User: Heyden
     * Date: 20/12/2014
     * Time: 02:08
     */

    namespace Core\Exceptions;

    use Exception;

    /**
     * Class NotFoundHTTPException
     *
     * Launched when Controller or View not found
     *
     * @package Core
     */
    class NotFoundHTTPException extends Exception {

        /**
         * Layout
         *
         * @var string
         */
        protected $layout;

        /**
         * Define a layout to use for 404
         *
         * @param string $message
         * @param int $code
         * @param string $layout
         * @param Exception $previous
         */
        public function __construct($message = '', $code = 0, $layout = 'default', Exception $previous = null) {
            $this->layout = $layout;
            parent::__construct($message, $code, $previous);
        }

        /**
         * Get Layout
         *
         * @return string
         */
        public function getLayout() {
            return $this->layout;
        }
    }