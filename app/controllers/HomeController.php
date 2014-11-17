<?php
    
    /**
     * HomeController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\View;
    use Core\Form;

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
        function index() {
            $data = array('lol' => 'lol');

            $this->loadModel('Post');

            $data['posts'] = $this->Post->select();

            View::make('home.index', 'default', $data);
        }
    }
