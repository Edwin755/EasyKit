<?php
    
    /**
     * AdminController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\View;
    use Core\Cookie;

    /**
     * AdminController Class
     */
    class AdminController extends Core\Controller
    {

        /**
         * Index Action
         */
        function index() {
            $args = func_get_args();

            if (!empty($args)) {
                $action = $args[0];
                array_shift($args);
                $params = $args;
            } else {
                $action = 'index';
                $params = array();
            }

            require 'HomeController.php';
            new HomeController('admin_' . $action, $params);
        }

    }
