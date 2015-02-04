<?php

    /**
     * LikesController file
     *
     * Created by worker
     */

    namespace App\Controllers;
    
    use Core;
    use Core\Controller;
    use Core\Validation;
    use Core\View;
    use Core\Session;
    use Core\Cookie;

    /**
     * Class LikesController
     *
     * @property mixed Likes
     */
    class LikesController extends Controller
    {

        /**
         * Errors
         *
         * @var array $errors
         */
        private $errors = [];

        /**
         * Data for model
         *
         * @var string token
         */
        private $token;

        /**
         * Get Token
         *
         * @return string
         */
        public function getToken()
        {
            return $this->token;
        }

        /**
         * Set Token
         *
         * @param string $token
         */
        public function setToken($token)
        {
            $this->token = $token;
        }

        /**
         * Create
         *
         * @param null $id
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function api_create($id = null)
        {
            if (!is_null($id)) {
                $event = current($this->getJSON($this->link('api/events/get/' . $id)));

                if (!empty($_POST)) {
                    if (isset($_POST['token']) && $_POST['token'] != null) {
                        $this->setToken($_POST['token']);
                        $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                        if ($user->valid) {
                            $user_id = $user->user->tokens_users_id;
                        } else {
                            $this->errors['user'] = $user->errors;
                        }
                    } else {
                        $this->errors['token'] = 'Empty token.';
                    }

                    if (!is_null($event) && empty($this->errors)) {
                        $this->loadModel('Likes');
                        $like = $this->Likes->select([
                            'conditions'    => [
                                'users_id'  => $user_id,
                                'events_id' => $id
                            ]
                        ]);

                        if (empty($like)) {
                            $this->Likes->save([
                                'users_id'  => $user_id,
                                'events_id' => $id
                            ]);
                        } else {
                            $this->errors['like'] = 'This like already exists.';
                        }
                    } else {
                        $this->errors['event'] = 'This event doesn\'t exists.';
                    }
                } else {
                    $this->errors['post'] = 'No POST received.';
                }
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Destroy
         *
         * @param null $id
         * @throws Core\Exceptions\NotFoundHTTPException
         * @throws \Exception
         */
        function api_destroy($id = null)
        {
            if (!is_null($id)) {
                $event = current($this->getJSON($this->link('api/events/get/' . $id)));

                if (!empty($_POST)) {
                    if (isset($_POST['token']) && $_POST['token'] != null) {
                        $this->setToken($_POST['token']);
                        $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                        if ($user->valid) {
                            $user_id = $user->user->tokens_users_id;
                        } else {
                            $this->errors['user'] = $user->errors;
                        }
                    } else {
                        $this->errors['token'] = 'Empty token.';
                    }

                    if (!is_null($event) && empty($this->errors)) {
                        $this->loadModel('Likes');

                        $this->Likes->delete([
                            'users_id'  => $user_id,
                            'events_id' => $id
                        ]);
                    } else {
                        $this->errors['event'] = 'This event doesn\'t exists.';
                    }
                } else {
                    $this->errors['post'] = 'No POST received.';
                }
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        function api_get($id = null)
        {
            $data = [];

            if (!is_null($id)) {
                $this->loadModel('Likes');
                $data['count'] = $this->Likes->select([
                    'count'         => true,
                    'conditions'    => [
                        'events_id'     => $id
                    ]
                ]);
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
