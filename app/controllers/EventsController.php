<?php

    /**
     * Created by PhpStorm.
     * User: H3yden
     * Date: 10/12/2014
     * Time: 11:36
     */

    namespace App\Controllers;

    use Core;
    use Core\Controller;
    use Core\View;
    use Core\Cookie;

    /**
     * Events Controller
     *
     * @property mixed Events
     */
    class EventsController extends Controller {

        /**
         * Index Action
         *
         * @return void
         */
        function api_get($id = null) {
            $this->loadModel('Events');
            var_dump($this->Events->medias());

            if ($id != null) {
                $data['event'] = $this->Events->select(array(
                    'join'          => array(
                        array(
                            'name'      => 'Events_medias',
                            'direction' => 'left'
                        )
                    ),
                    'conditions'    => array(
                        'id'            => $id,
                    ),
                ));
            } else {
                $data['events'] = $this->Events->select(array(
                    'join'          => array(
                        array(
                            'name'      => 'Events_medias',
                            'direction' => 'left'
                        )
                    ),
                    'order'     => 'desc',
                    'limit'     => '0,20'
                ));
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }