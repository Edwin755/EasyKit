<?php
    
    /**
     * HomeController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     * 
     * @package App\Controller
     */

    namespace App\Controllers;

    use Core;
    use Core\View;

    /**
    * HomeController Class
    */
    class HomeController extends Core\Controller
    {
        
        /**
         * Index Action
         * 
         * @return void
         */
        public function index() {
            View::make('home.index');
        }

        public function lol() {
            echo 'lol';
        }
    }
