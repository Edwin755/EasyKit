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

            if ($id != null) {
                $data['event'] = current($this->Events->select(array(
                    'fields'        => array(
                        'events.events_name',
                        'events.events_description',
                        'events.events_starttime',
                        'events.events_endtime',
                        'events.events_geox',
                        'events.events_geoy',
                        'events.events_created_at',
                        'users.users_email',
                        'users.users_firstname',
                        'users.users_lastname',
                    ),
                    'join'          => array(
                        array(
                            'name'      => 'Users',
                            'direction' => 'left'
                        ),
                    ),
                    'conditions'    => array(
                        'id'            => $id,
                    ),
                    'limit'         => 20
                )));

                $data['event']->events_medias = $this->Events->medias(array(
                    'fields'        => array(
                        'events_medias.events_medias_name',
                        'events_medias.events_medias_description',
                        'medias.medias_file',
                        'medias.medias_type',
                    ),
                    'join'          => array(
                        array(
                            'name'      => 'Users',
                            'direction' => 'left'
                        )
                    ),
                    'conditions'     => array(
                        'id'            => $id,
                    ),
                ));
            } else {
                $data['events'] = $this->Events->select(array(
                    'fields'        => array(
                        'events.events_name',
                        'events.events_description',
                        'events.events_starttime',
                        'events.events_endtime',
                        'events.events_geox',
                        'events.events_geoy',
                        'events.events_created_at',
                        'users.users_email',
                        'users.users_firstname',
                        'users.users_lastname',
                    ),
                    'join'          => array(
                        array(
                            'name'      => 'Users',
                            'direction' => 'left'
                        ),
                    ),
                    'limit' => 20
                ));

                foreach ($data['events'] as $event) {
                    $event->events_medias = $this->Events->medias(array(
                        'fields'        => array(
                            'events_medias.events_medias_name',
                            'events_medias.events_medias_description',
                            'medias.medias_file',
                            'medias.medias_type',
                        ),
                        'join'          => array(
                            array(
                                'name'      => 'Users',
                                'direction' => 'left'
                            )
                        ),
                        'conditions'     => array(
                            'id'            => $event->events_id
                        ),
                    ));
                }
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }