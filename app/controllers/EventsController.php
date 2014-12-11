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
     * @property mixed Users
     */
    class EventsController extends Controller {

        /**
         * Index Action
         *
         * @return void
         */
        function api_get($id = null) {
            $this->loadModel('Events');
            $this->loadModel('Users');

            if ($id != null) {
                $data['event'] = current($this->Events->select(array(
                    'join'          => array(
                        array(
                            'name'      => 'Users',
                            'direction' => 'left'
                        ),
                    ),
                    'conditions'    => array(
                        'id'            => $id,
                    )
                )));

                unset($data['event']->users_password);

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

                $data['event']->users_media = $this->Users->media(array(
                    'conditions'    => array(
                        'id'            => $data['event']->users_medias_id,
                    ),
                ));
            } else {
                $nb = 20;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $page = (($page - 1) * $nb);

                $data['events'] = $this->Events->select(array(
                    'join'          => array(
                        array(
                            'name'      => 'Users',
                            'direction' => 'left'
                        ),
                    ),
                    'order' => 'desc',
                    'limit' => array($page, $page + $nb),
                ));

                foreach ($data['events'] as $event) {
                    unset($event->users_password);
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

                    $event->users_media = $this->Users->media(array(
                        'conditions'    => array(
                            'id'            => $event->users_medias_id,
                        ),
                    ));
                }
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }