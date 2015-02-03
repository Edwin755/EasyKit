<?php
    
    /**
     * PacksController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\Controller;
    use Core\Exceptions\NotFoundHTTPException;
    use Core\Session;
    use Core\Validation;
    use Core\View;
    use Core\Cookie;
    use HTML;

    /**
     * Class PacksController
     *
     * @property mixed Users
     * @property mixed Token
     * @package App\Controllers
     */
    class PacksController extends Controller
    {

        /**
         * Errors
         *
         * @var array $errors
         */
        private $errors = array();

        /**
         * Datas for model
         *
         * @var string $name
         * @var string $description
         * @var string $end
         * @var int $user
         * @var string $token
         */
        private $name, $description, $end, $user, $token;

        /**
         * Set Name
         *
         * @param $value
         */
        function setName($value) {
            $this->name = $value;
        }

        /**
         * Get Name
         *
         * @return string
         */
        function getName() {
            return $this->name;
        }

        /**
         * Set Description
         *
         * @param string $value
         */
        function setDescription($value) {
            $this->description = $value;
        }

        /**
         * Get Description
         *
         * @return string
         */
        function getDescription() {
            return $this->description;
        }

        /**
         * Set End
         *
         * @param string $value
         */
        function setEnd($value) {
            if (Validation::validateDate($value, 'Y-m-d H:i')) {
                $this->end = $value;
            } else {
                $this->errors['end'] = 'Not a datetime';
            }
        }

        /**
         * Get End
         *
         * @return string
         */
        function getEnd() {
            return $this->end;
        }

        /**
         * Set Token
         *
         * @param $value
         */
        function setToken($value) {
            $this->token = $value;
        }

        /**
         * Get Token
         *
         * @return string
         */
        function getToken() {
            return $this->token;
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
                        throw new NotFoundHTTPException('Non authorized address.');
                    }
                }
            } else if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                throw new NotFoundHTTPException('Non authorized address.');
            }
        }
        
        /**
         * Index API Action
         *
         * @param mixed $id
         * 
         * @return void
         */
        function api_get($id = null) {
            $this->loadModel('Packs');
            $this->loadModel('Steps');

            if ($id != null) {
                $data['pack'] = current($this->Packs->select(array(
                    'conditions'    => array(
                        'id'            => $id
                    ),
                )));

                if (!empty($data['pack'])) {
                    $data['pack']->steps = $this->Steps->select(array(
                        'conditions'    => array(
                            'packs_id'      => $data['pack']->packs_id
                        ),
                    ));

                    $data['pack']->user = current($this->getJSON($this->link('api/users/get/' . $data['pack']->packs_users_id)));

                    $events = $this->Packs->events(array(
                        'conditions'    => array(
                            'id'      => $data['pack']->packs_id,
                        ),
                    ));

                    $data['pack']->timeago = HTML::timeago($data['pack']->packs_created_at);

                    foreach ($events as $event) {
                        $data['pack']->events = current($this->getJSON($this->link('api/events/get/' . $event->events_packs_events_id)));
                    }
                }
            } else {
                $nb = isset($_GET['limit']) && $_GET['limit'] != null ? $_GET['limit'] : 20;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $page = (($page - 1) * $nb);

                $data['packs'] = $this->Packs->select(array(
                    'order' => 'desc',
                    'limit' => array($page, $page + $nb),
                ));

                foreach ($data['packs'] as $pack) {
                    $pack->steps = $this->Steps->pack(array(
                        'conditions'    => array(
                            'packs_id'      => $pack->packs_id,
                        ),
                    ));

                    $pack->user = current($this->getJSON($this->link('api/users/get/' . $pack->packs_users_id)));

                    $events = $this->Packs->events(array(
                        'conditions'    => array(
                            'id'      => $pack->packs_id,
                        ),
                    ));

                    $pack->timeago = HTML::timeago($pack->packs_created_at);

                    foreach ($events as $event) {
                        $pack->events = current($this->getJSON($this->link('api/events/get/' . $event->events_packs_events_id)));
                    }
                }
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * API Create
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function api_create() {
            if (!empty($_POST)) {
                if (!empty($_POST['name'])) {
                    $this->setName($_POST['name']);
                } else {
                    $this->errors['name'] = 'Empty name.';
                }

                if (!empty($_POST['endtime'])) {
                    $this->setEnd($_POST['endtime']);
                } else {
                    $this->errors['endtime'] = 'Empty end time.';
                }

                if (!empty($_POST['token'])) {
                    $this->setToken($_POST['token']);
                } else {
                    $this->errors['token'] = 'Empty token.';
                }

                if (!empty($_POST['description'])) {
                    $this->setDescription($_POST['description']);
                }

                if (empty($this->errors)) {
                    $this->loadModel('Packs');

                    $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));

                    if ($user->valid) {
                        $this->Packs->save(array(
                            'name' => $this->getName(),
                            'description' => $this->getDescription(),
                            'endtime' => $this->getEnd(),
                            'users_id' => $user->user->tokens_users_id,
                        ));
                    } else {
                        $this->errors['user'] = 'User does not exist.';
                    }
                }
            } else {
                $this->errors['POST'] = 'No data received';
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Index
         *
         * @throws NotFoundHTTPException
         */
        function index() {
            View::$title = 'Create your pack';
            View::make('packs.index', null, 'default');
        }

        /**
         * Summary
         *
         * @throws NotFoundHTTPException
         */
        function summary()
        {
            $data = false;
            View::make('packs.summary', $data, 'default');
        }

        /**
         * Admin Index Action
         *
         * @return void
         */
        function admin_index() {
            View::$title = 'Packs';

            $this->loadModel('Packs');

            $data['count'] = $this->Packs->select(array('count' => true));

            View::make('packs.admin_index', $data, 'admin');
        }

        /**
         * Admin Count Action
         *
         * @return void
         */
        function admin_count() {
            $this->loadModel('Packs');

            $data['count'] = $this->Packs->select(array('count' => true));

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
