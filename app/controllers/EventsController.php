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
                    'conditions'    => array(
                        'id'            => $id,
                    )
                )));

                if (!empty($data['event'])) {
                    $data['event']->user = $this->Events->user(array(
                        'conditions'    => array(
                            'id'            => $id
                        )
                    ));

                    unset($data['event']->user->users_password);

                    $data['event']->user->users_media = $this->Users->media(array(
                        'conditions'    => array(
                            'medias_id'            => $data['event']->user->users_medias_id,
                        ),
                    ));

                    $data['event']->events_medias = $this->Events->medias(array(
                        'conditions'     => array(
                            'id'            => $id,
                        ),
                    ));
                }
            } else {
                $nb = 20;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $page = (($page - 1) * $nb);

                $data['events'] = $this->Events->select(array(
                    'order' => 'desc',
                    'limit' => array($page, $page + $nb),
                ));

                foreach ($data['events'] as $event) {
                    $event->user = $this->Events->user(array(
                        'conditions'    => array(
                            'users_id'            => $event->events_users_id,
                        )
                    ));

                    unset($event->user->users_password);

                    $event->user->users_media = $this->Users->media(array(
                        'conditions'    => array(
                            'medias_id'            => $event->user->users_medias_id,
                        ),
                    ));

                    $event->events_medias = $this->Events->medias(array(
                        'conditions'     => array(
                            'id'            => $event->events_id,
                        ),
                    ));
                }
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Admin Index Action
         *
         * @return void
         */
        function admin_index() {
            View::$title = 'Événements';

            $this->loadModel('Events');

            $data['count'] = $this->Events->select(array('count' => true));

            $data['events'] = current($this->getJSON($this->link('api/events')));

            View::make('events.admin_index', $data, 'admin');
        }

        /**
         * Admin show
         *
         * @throws \Exception
         */
        function admin_show($id = null) {
            $this->loadModel('Events');

            trigger_error('hello');

            if ($id != null) {
                $data['event'] = current($this->getJSON($this->link('api/events/get/' . $id)));
                if (!empty($data['event'])) {
                    View::$title = $data['event']->events_name;
                    View::make('events.admin_show', $data, 'admin');
                }
            } else {
                $this->httpStatus(404);
                View::make('errors.404', null, 'admin');
            }
        }
    }