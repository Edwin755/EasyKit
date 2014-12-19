<?php

    /**
     * ErrorHandler of the framework
     *
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     *
     * @package Core
     */

    namespace Core;

    use App\Controllers;
    use Exception;

    class ErrorHandler
    {

        private $errno;
        private $errstr;
        private $errfile;
        private $errline;
        private $errcontext;
        private $errbacktrace;
        private $errlines;

        /**
         * Set up the ErrorHandler
         *
         * @return void
         */
        function __construct() {
            set_error_handler(array($this, 'customErrorHandler'));
            register_shutdown_function(array($this, 'customFatalHandler'));
        }

        /**
         * Set Error number
         *
         * @param string $value
         */
        function setErrNo($value) {
            $this->errno = $value;
        }

        /**
         * Set Error Message
         *
         * @param string $value
         */
        function setErrStr($value) {
            $this->errstr = $value;
        }

        /**
         * Set Error file
         *
         * @param string $value
         */
        function setErrFile($value) {
            $this->errfile = $value;
        }

        /**
         * Set Error line
         *
         * @param string $value
         */
        function setErrLine($value) {
            $this->errline = $value;
        }

        /**
         * Set Error context
         *
         * @param string $value
         */
        function setErrContext($value) {
            $this->errcontext = $value;
        }

        /**
         * Set Error backtrace
         *
         * @param string $value
         */
        function setErrBacktrace($value) {
            $this->errbacktrace = $value;
        }

        /**
         * Set Error backtrace
         *
         * @param string $value
         */
        function setErrLines($value) {
            $this->errlines = $value;
        }

        /**
         * Get Error number
         *
         * @return string
         */
        function getErrNo() {
            return $this->errno;
        }

        /**
         * Get Error message
         *
         * @return string
         */
        function getErrStr() {
            return $this->errstr;
        }

        /**
         * Get Error file
         *
         * @return string
         */
        function getErrFile() {
            return $this->errno;
        }

        /**
         * Get Error line
         *
         * @return string
         */
        function getErrLine() {
            return $this->errline;
        }

        /**
         * Get Error context
         *
         * @return string
         */
        function getErrContext() {
            return $this->errcontext;
        }

        /**
         * Get Error context
         *
         * @return string
         */
        function getErrBacktrace() {
            return $this->errbacktrace;
        }

        /**
         * Get Error context
         *
         * @return string
         */
        function getErrLines() {
            return $this->errlines;
        }

        /**
         * Custom Error Handler
         */
        function customErrorHandler($errno, $errstr, $errfile, $errline, $errcontext = null) {
            $this->setErrNo($errno);
            $this->setErrStr($errstr);
            $this->setErrFile($errfile);
            $this->setErrLine($errline);
            $this->setErrContext($errcontext);
            $this->setErrBacktrace(debug_backtrace());
            $handle = file($errfile);

            $lines = '';
            for ($i = $errline - 7; $i <= $errline + 2; $i++) {
                $lines .= $handle[$i];
            }

            $this->setErrLines($lines);

            $this->displayErrorPage();

            die();
        }

        /**
         * Custom Fatal Handler
         */
        function customFatalHandler() {
            $error = error_get_last();

            if (!empty($error)) {
                $this->customErrorHandler($error['type'], $error['message'], $error['file'], $error['line']);
            }
        }

        /**
         *
         */
        function displayErrorPage() {
            $data['errno'] = $this->getErrNo();
            $data['errstr'] = $this->getErrStr();
            $data['errfile'] = $this->getErrFile();
            $data['errline'] = $this->getErrLine();
            $data['errcontext'] = $this->getErrContext();
            $data['errbacktrace'] = $this->getErrBacktrace();
            $data['errlines'] = $this->getErrLines();

            //extract($data);

            require __DIR__ . '/../core/HTML.php';

            require __DIR__ . '/../core/ErrorHandling/index.php';
        }
    }