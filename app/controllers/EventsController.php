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
    use Core\Exceptions\NotFoundHTTPException;
    use HTML;

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

            if ($id != null) {
                $data['event'] = current($this->Events->select(array(
                    'conditions'    => array(
                        'id'            => $id,
                    )
                )));

                if (!empty($data['event'])) {
                    $data['event']->user = current($this->getJSON($this->link('api/users/get/' . $data['event']->events_users_id)));

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
                    $event->user = current($this->getJSON($this->link('api/users/get/' . $event->events_users_id)));

                    $event->events_medias = $this->Events->medias(array(
                        'conditions'     => array(
                            'id'            => $event->events_id,
                        ),
                    ));

                    foreach ($event->events_medias as $media) {
                        $media->medias_file = HTML::link('uploads/' . $media->medias_file);
                    }
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

            if ($id != null) {
                $data['event'] = current($this->getJSON($this->link('api/events/get/' . $id)));
                if (!empty($data['event'])) {
                    View::$title = $data['event']->events_name;
                    View::make('events.admin_show', $data, 'admin');
                } else {
                    throw new NotFoundHTTPException('This event doesn\'t exists.', 1, 'admin');
                }
            } else {
                throw new NotFoundHTTPException('You haven\'t specified any id.', 1, 'admin');
            }
        }

        /**
         * Admin Count Action
         *
         * @return void
         */
        function admin_count() {
            $this->loadModel('Events');

            $data['count'] = $this->Events->select(array('count' => true));

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }