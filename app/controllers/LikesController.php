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
         * API Create
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
            } else {
                $this->errors['id'] = 'Empty id.';
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * API Destroy
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
            } else {
                $this->errors['id'] = 'Empty id.';
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * API Get
         *
         * @param null $id
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         * @throws \Exception
         */
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

        /**
         * API User
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function api_user()
        {
            if (!empty($_POST)) {
                if (isset($_POST['token']) && $_POST['token'] != null) {
                    $this->setToken($_POST['token']);
                    $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                    if ($user->valid) {
                        $user_id = $user->user->tokens_users_id;
                    } else {
                        $this->errors = $user->errors;
                    }
                } else {
                    $this->errors['token'] = 'Empty token.';
                }

                if (empty($this->errors)) {
                    $this->loadModel('Likes');
                    $data['likes'] = $this->Likes->select([
                        'conditions'    => [
                            'users_id'     => $user_id
                        ]
                    ]);
                }
            } else {
                $this->errors['post'] = 'No POST received.';
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Create
         *
         * @param null $id
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function create($id = null)
        {
            if (!is_null($id)) {
                $event = current($this->getJSON($this->link('api/events/get/' . $id)));

                if (!empty($event)) {
                    if (isset($_SESSION['user'])) {
                        $return = json_decode($this->postCURL($this->link('api/likes/create/' . $id), ['token' => Session::get('user')->token]));
                        if (!empty($return->errors)) {
                            $this->errors = $return->errors;
                        }
                    } else {
                        $init = false;
                        if (Cookie::get('l') == false) {
                            $init = true;
                            Cookie::set('l', json_encode([$id]));
                        }

                        if (!$init) {
                            $cookie = json_decode(Cookie::get('l'), false);
                            if (!empty($cookie)) {
                                if (!in_array($id, $cookie)) {
                                    $cookie[] = $id;
                                }
                            } else {
                                if (!in_array($id, $cookie)) {
                                    $cookie = [$id];
                                }
                            }
                            Cookie::set('l', json_encode($cookie));
                        }
                    }
                } else {
                    $this->errors['event'] = 'This event doesn\'t exists.';
                }
            } else {
                $this->errors['id'] = 'Empty id.';
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * User likes
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function user()
        {
            if (isset($_SESSION['user'])) {
                $return = json_decode($this->postCURL($this->link('api/likes/user/'), ['token' => Session::get('user')->token]));
                if (empty($return->errors)) {
                    $data['likes'] = current($return);
                } else {
                    $this->errors = $return->errors;
                }
            } else {
                $data['likes'] = json_decode(Cookie::get('l'), true);
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Destroy
         *
         * @param null $id
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function destroy($id = null)
        {
            if (!is_null($id)) {
                if (isset($_SESSION['user'])) {
                    var_dump('if');
                    $return = json_decode($this->postCURL($this->link('api/likes/destroy/' . $id), ['token' => Session::get('user')->token]));
                    if (!empty($return->errors)) {
                        $this->errors = $return->errors;
                    }
                } else {
                    $init = false;
                    if (Cookie::get('l') == false) {
                        $init = true;
                        Cookie::set('l', json_encode([$id]));
                    }

                    if (!$init) {
                        $cookie = json_decode(Cookie::get('l'), false);
                        if (!empty($cookie)) {
                            if (in_array($id, $cookie)) {
                                unset($cookie[$id]);
                            } else {
                                $this->errors['id'] = 'You didn\'t liked this event.';
                            }
                        } else {
                            $this->errors['cookie'] = 'The cookie is empty.';
                        }
                        Cookie::set('l', json_encode($cookie));
                    } else {
                        $this->errors['cookie'] = 'The cookie isn\'t set.';
                    }
                }
            } else {
                $this->errors['id'] = 'Empty id.';
            }


            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
