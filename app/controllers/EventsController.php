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
         * Datas for model
         *
         * @var string $name
         * @var string $description
         * @var string $starttime
         * @var string $endtime
         * @var int $user
         */
        private $name, $description, $starttime, $endtime, $user;

        /**
         * Errors
         *
         * @var array $errors
         */
        private $errors = [];

        /**
         * Get Name
         *
         * @return mixed
         */
        private function getName() {
            return $this->name;
        }

        /**
         * Set Name
         *
         * @param mixed $name
         */
        private function setName($name) {
            $this->name = $name;
        }

        /**
         * Get Description
         *
         * @return mixed
         */
        private function getDescription() {
            return $this->description;
        }

        /**
         * Set Description
         *
         * @param mixed $description
         */
        private function setDescription($description) {
            $this->description = $description;
        }

        /**
         * Get Start time
         *
         * @return mixed
         */
        private function getStarttime() {
            return $this->starttime;
        }

        /**
         * Set Start time
         *
         * @param mixed $starttime
         */
        private function setStarttime($starttime) {
            $this->starttime = $starttime;
        }

        /**
         * Get End time
         *
         * @return mixed
         */
        private function getEndtime() {
            return $this->endtime;
        }

        /**
         * Set End time
         *
         * @param mixed $endtime
         */
        private function setEndtime($endtime) {
            $this->endtime = $endtime;
        }

        /**
         * Get User ID
         *
         * @return mixed
         */
        private function getUser()
        {
            return $this->user;
        }

        /**
         * Set User ID
         *
         * @param mixed $user
         */
        private function setUser($user)
        {
            $this->user = $user;
        }

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

                    foreach ($data['event']->events_medias as $media) {
                        $mediafile = current($this->getJSON($this->link('api/medias/get/' . $media->medias_id)));
                        $media->medias_file = $mediafile->medias_file;
                        $media->medias_thumb50 = $mediafile->medias_thumb50;
                        $media->medias_thumb160 = $mediafile->medias_thumb160;
                    }
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
                        $mediafile = current($this->getJSON($this->link('api/medias/get/' . $media->medias_id)));
                        $media->medias_file = $mediafile->medias_file;
                        $media->medias_thumb50 = $mediafile->medias_thumb50;
                        $media->medias_thumb160 = $mediafile->medias_thumb160;
                    }
                }
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * API Create
         */
        function api_create() {
            if (!empty($_POST)) {

            }
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
         * @throws NotFoundHTTPException
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
         * Admin create
         *
         * @throws NotFoundHTTPException
         */
        function admin_create() {
            View::$title = 'Création d\'un événement';
            View::make('events.admin_create', null, 'admin');
        }

        /**
         * Admin Store
         */
        function admin_store() {
            if (!empty($_POST)) {

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