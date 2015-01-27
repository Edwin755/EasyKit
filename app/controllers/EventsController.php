<?php

    /**
     * Created by PhpStorm.
     * User: H3yden
     * Date: 10/12/2014
     * Time: 11:36
     */

    namespace App\Controllers;

    use App\Models\Admin;
    use Core;
    use Core\Controller;
    use Core\Session;
    use Core\Validation;
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
            if (Validation::validateDate($starttime)) {
                $this->starttime = $starttime;
            } else {
                $this->errors['starttime'] = 'Not a datetime.';
            }
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
            if (Validation::validateDate($endtime)) {
                $this->endtime = $endtime;
            } else {
                $this->errors['endtime'] = 'Not a datetime.';
            }
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
         * Constructor
         *
         * @return void
         */
        function constructor() {
            if (isset($_SESSION['admin'])) {
                $admin = Session::get('admin');
                if (!$this->getJSON($this->link('admin1259/is_admin/' . $admin->admin_username . '/' . $admin->admin_password))->admin) {
                    if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                        $this->redirect('admin1259/users/signin');
                    }
                }
            }
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
                $nb = isset($_GET['limit']) && $_GET['limit'] != null ? $_GET['limit'] : 20;
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
                if (isset($_POST['name']) && $_POST['name'] != null) {
                    $this->setName($_POST['name']);
                } else {
                    $this->errors['name'] = 'Wrong name.';
                }

                if (isset($_POST['description']) && $_POST['description'] != null) {
                    $this->setDescription($_POST['description']);
                }

                if (isset($_POST['starttime']) && $_POST['starttime'] != null) {
                    $this->setStarttime($_POST['starttime']);
                } else {
                    $this->errors['starttime'] = 'Wrong start time.';
                }

                if (isset($_POST['endtime']) && $_POST['endtime'] != null) {
                    $this->setEndtime($_POST['endtime']);
                } else {
                    $this->errors['endtime'] = 'Wrong endtime.';
                }

                if (isset($_POST['user']) && $_POST['user'] != null) {
                    $this->setUser($_POST['user']);
                } else {
                    $this->errors['user'] = 'Wrong user.';
                }

                if (empty($this->errors)) {
                    $this->loadModel('Events');
                    $this->loadModel('Users');
                    $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getUser() . '/' . $_SERVER['REMOTE_ADDR']));

                    if ($user->valid) {
                        $this->Events->save([
                            'name'          => $this->getName(),
                            'description'   => $this->getDescription(),
                            'starttime'     => $this->getStarttime(),
                            'endtime'       => $this->getEndtime(),
                            'users_id'      => $user->user->tokens_users_id
                        ]);
                    } else {
                        $this->errors['user'] = 'User does not exist.';
                    }
                }
            } else {
                $this->errors['POST'] = 'No POST received.';
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

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