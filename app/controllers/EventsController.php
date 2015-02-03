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
    class EventsController extends Controller
    {

        /**
         * Datas for model
         *
         * @var string $name
         * @var string $description
         * @var string $starttime
         * @var string $endtime
         * @var int $user
         * @var string $token
         */
        private $name, $description, $starttime, $endtime, $user, $token;

        /**
         * Errors
         *
         * @var array $errors
         */
        private $errors = [];

        /**
         * Fields
         *
         * @var array $fields
         */
        private $fields = [];

        /**
         * Get Name
         *
         * @return mixed
         */
        private function getName()
        {
            return $this->name;
        }

        /**
         * Set Name
         *
         * @param mixed $name
         */
        private function setName($name)
        {
            $this->name = $name;
            $this->fields['name'] = $this->name;
        }

        /**
         * Get Description
         *
         * @return mixed
         */
        private function getDescription()
        {
            return $this->description;
        }

        /**
         * Set Description
         *
         * @param mixed $description
         */
        private function setDescription($description)
        {
            $this->description = $description;
            $this->fields['description'] = $this->description;
        }

        /**
         * Get Start time
         *
         * @return mixed
         */
        private function getStarttime()
        {
            return $this->starttime;
        }

        /**
         * Set Start time
         *
         * @param mixed $starttime
         */
        private function setStarttime($starttime)
        {
            if (Validation::validateDate($starttime, 'Y-m-d H:i')) {
                $this->starttime = $starttime;
                $this->fields['starttime'] = $this->starttime;
            } else {
                $this->errors['starttime'] = 'Not a datetime.';
            }
        }

        /**
         * Get End time
         *
         * @return mixed
         */
        private function getEndtime()
        {
            return $this->endtime;
        }

        /**
         * Set End time
         *
         * @param mixed $endtime
         */
        private function setEndtime($endtime)
        {
            if (Validation::validateDate($endtime, 'Y-m-d H:i')) {
                $this->endtime = $endtime;
                $this->fields['endtime'] = $this->endtime;
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
         * Get Token
         *
         * @return mixed
         */
        private function getToken()
        {
            return $this->token;
        }

        /**
         * Set Token
         *
         * @param $token
         */
        private function setToken($token)
        {
            $this->token = $token;
        }

        /**
         * Constructor
         *
         * @return void
         */
        function constructor()
        {
            if (isset($_SESSION['admin'])) {
                $admin = Session::get('admin');
                if (!$this->getJSON($this->link('admin1259/is_admin/' . $admin->admin_username . '/' . $admin->admin_password))->admin) {
                    if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                        throw new NotFoundHTTPException('Non authorized address.');
                    }
                }
            } else if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                throw new NotFoundHTTPException('Non authorized address.');
            }
        }

        /**
         * Index Action
         *
         * @return void
         */
        function api_get($id = null)
        {
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
        function api_create()
        {
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

                if (isset($_POST['token']) && $_POST['token'] != null) {
                    $this->setToken($_POST['token']);
                    $token = true;
                } else {
                    $this->setUser(1);
                    $token = false;
                }

                if (empty($this->errors)) {
                    $this->loadModel('Events');
                    $this->loadModel('Users');
                    if ($token) {
                        $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                        if ($user->valid) {
                            $user_id = $user->user->tokens_users_id;
                        } else {
                            $this->errors['user'] = $user->errors;
                        }
                    } else {
                        $user_id = $this->getUser();
                    }

                    if (empty($this->errors)) {
                        $this->Events->save([
                            'name'          => $this->getName(),
                            'description'   => $this->getDescription(),
                            'starttime'     => $this->getStarttime(),
                            'endtime'       => $this->getEndtime(),
                            'users_id'      => $user_id
                        ]);

                        $data['event'] = $this->Events->lastInsertId;
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
         * API Edit
         *
         * @param null $id
         * @throws NotFoundHTTPException
         * @throws \Exception
         */
        function api_edit($id = null) {
            if ($id != null) {
                if (!empty($_POST)) {
                    if (isset($_POST['name']) && $_POST['name'] != null) {
                        $this->setName($_POST['name']);
                    }

                    if (isset($_POST['description']) && $_POST['description'] != null) {
                        $this->setDescription($_POST['description']);
                    }

                    if (isset($_POST['starttime']) && $_POST['starttime'] != null) {
                        $this->setStarttime($_POST['starttime']);
                    }

                    if (isset($_POST['endtime']) && $_POST['endtime'] != null) {
                        $this->setEndtime($_POST['endtime']);
                    }

                    if (isset($_POST['token']) && $_POST['token'] != null) {
                        $this->setToken($_POST['token']);
                    } else {
                        $this->errors['token'] = 'No token given.';
                    }

                    if (empty($this->errors)) {
                        $this->loadModel('Events');
                        $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                        if ($user->valid) {
                            $user_id = $user->user->tokens_users_id;
                        } else {
                            $this->errors['user'] = $user->errors;
                        }

                        $event = $this->Events->select([
                            'conditions'    => [
                                'id'            => $id
                            ]
                        ]);

                        if (current($event)->events_users_id != 1 && current($event)->events_users_id != $user_id) {
                            $this->errors['user'] = 'You\'re not the owner of this event.';
                        } else {
                            $this->fields['users_id'] = $user_id;
                        }

                        if (empty($this->errors) && count($event) == 1) {
                            $this->fields['id'] = $id;
                            $this->Events->save($this->fields);

                            $data['event'] = $id;
                        } else {
                            $this->errors['event'] = 'This event doesn\'t exists.';
                        }
                    }
                } else {
                    $this->errors['POST'] = 'No POST received.';
                }
            } else {
                $this->errors['id'] = 'No id given.';
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
        function admin_index()
        {
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
        function admin_show($id = null)
        {
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
        function admin_create()
        {
            View::$title = 'Création d\'un événement';
            View::make('events.admin_create', null, 'admin');
        }

        /**
         * Admin store
         */
        function admin_store() {
            if (!empty($_POST)) {
                $return = json_decode($this->postCURL($this->link('api/events/create'), $_POST), false);
                if (empty($return->errors)) {
                    $this->redirect('admin1259/events/edit/' . $return->event);
                } else {
                    Session::setFlash('danger', 'L\'événement n\'a pas pu être créé.');
                    $this->redirect('admin1259/events/create');
                }
            }
        }

        /**
         * Admin Count Action
         *
         * @return void
         */
        function admin_count()
        {
            $this->loadModel('Events');

            $data['count'] = $this->Events->select(array('count' => true));

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Delete an event
         *
         * @param int $id
         * @throws NotFoundHTTPException
         * @throws \Exception
         */
        function admin_delete($id = null)
        {
            if ($id != null) {
                $this->loadModel('Events');
                $this->Events->delete($id);
            } else {
                $this->errors['id'] = 'No id given.';
            }

            $data['success'] = empty($this->errors) ? true : false;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }