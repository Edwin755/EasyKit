<?php
    
    /**
     * UsersController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\Controller;
    use Core\Validation;
    use Core\View;
    use Core\Session;
    use Core\Cookie;
    use HTML;

    /**
     * UsersController Class
     *
     * @property mixed Tokens
     * @property mixed Users
     * @property mixed Admin
     */
    class UsersController extends Controller
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
         * @var string $email
         * @var string $username
         * @var string $password
         * @var boolean $remember
         * @var string $firstname
         * @var string $lastname
         * @var string $birth
         */
        private $email, $username, $password, $remember, $firstname, $lastname, $birth;

        /**
         * Get the Email
         *
         * @return string
         */
        function getEmail() {
            return $this->email;
        }

        /**
         * Get the Username
         *
         * @return string
         */
        function getUsername() {
            return $this->username;
        }

        /**
         * Get the Password
         *
         * @return string
         */
        function getPassword() {
            return $this->password;
        }

        /**
         * Get the Remember value
         *
         * @return string
         */
        function getRemember() {
            return $this->remember;
        }

        /**
         * Get the Firstname
         *
         * @return string
         */
        function getFirstname() {
            return $this->firstname;
        }

        /**
         * Get the Firstname
         *
         * @return string
         */
        function getLastname() {
            return $this->lastname;
        }

        /**
         * Get the Firstname
         *
         * @return string
         */
        function getBirth() {
            return $this->birth;
        }

        /**
         * Set the Email
         *
         * @param string $value
         *
         * @return string
         */
        function setEmail($value) {
            $this->email = $value;
        }

        /**
         * Set the Username
         *
         * @param string $value
         *
         * @return string
         */
        function setUsername($value) {
            $this->username = $value;
        }

        /**
         * Set the Password
         *
         * @param string $value
         *
         * @return string
         */
        function setPassword($value) {
            $this->password = $value;
        }

        /**
         * Set the Remember value
         *
         * @param string $value
         *
         * @return string
         */
        function setRemember($value) {
            $this->remember = $value;
        }

        /**
         * Set the Firstname
         *
         * @param string $value
         *
         * @return string
         */
        function setFirstname($value) {
            $this->firstname = $value;
        }

        /**
         * Set the Firstname
         *
         * @param string $value
         *
         * @return string
         */
        function setLastname($value) {
            $this->lastname = $value;
        }

        /**
         * Set the Birth
         *
         * @param string $value
         *
         * @return string
         */
        function setBirth($value) {
            if (Validation::validateDate($value, 'Y-m-d')) {
                $this->birth = $value;
            } else {
                $this->errors['date'] = 'Wrong date.';
            }
        }

        /**
         * Index Action
         *
         * @return void
         */
        function api_get($id = null) {
            $this->loadModel('Users');

            if ($id != null) {
                $data['user'] = current($this->Users->select(array(
                    'conditions'    => array(
                        'id'            => $id
                    ),
                )));

                unset($data['user']->users_password);

                $data['user']->users_media = current($this->getJSON($this->link('api/medias/get/' . $data['user']->users_medias_id)));
            } else {
                $nb = 20;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $page = (($page - 1) * $nb);

                $data['users'] = $this->Users->select(array(
                    'order' => 'desc',
                    'limit' => array($page, $page + $nb),
                ));

                foreach ($data['users'] as $user) {
                    unset($user->users_password);
                    $user->users_media = current($this->getJSON($this->link('api/medias/get/' . $user->users_medias_id)));
                }
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Register Action
         *
         * @return void
         */
        function api_create() {
            if (!empty($_POST)) {
                $data = array();
                $this->loadModel('Users');

                if (!isset($_POST['email']) || $_POST['email'] == null || !Validation::validateEmail($_POST['email'])) {
                    $this->errors['email'] = 'Wrong email';
                } else {
                    $user = $this->Users->select(array(
                        'conditions'    => array(
                            'email'         => $_POST['email']
                            )
                        ));

                    if (count($user) < 1) {
                        $this->setEmail($_POST['email']);
                    } else {
                        $this->errors['email'] = 'Email address already exists.';
                    }
                }

                if (!isset($_POST['password']) || $_POST['password'] == null || strlen($_POST['password']) < 6) {
                    $this->errors['password'] = 'Wrong password';
                } else {
                    $this->setPassword($_POST['password']);
                }

                if (isset($_POST['firstname'])) {
                    $this->setFirstname($_POST['firstname']);
                }

                if (isset($_POST['lastname'])) {
                    $this->setLastname($_POST['lastname']);
                }

                if (isset($_POST['birth'])) {
                    $this->setBirth($_POST['birth']);
                }

                if (empty($this->errors)) {
                    $this->Users->save(array(
                        'password'  => md5(sha1($this->getPassword())),
                        'email'     => $this->getEmail(),
                        'firstname' => $this->getFirstname(),
                        'lastname'  => $this->getLastname(),
                        'birth'     => $this->getBirth(),
                        ));

                    $data['success'] = true;
                } else {
                    $data['success'] = false;
                }
            } else {
                $data['success'] = false;

                $this->errors['POST'] = 'No POST received.';
            }

            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * API Generate Token
         *
         * @param $id
         *
         * @return string
         *
         * @throws \Exception
         */
        function api_generateToken($id) {
            $this->loadModel('Tokens');

            $token = md5(uniqid(mt_rand(), true));

            $this->Tokens->save(array(
                'token'     => $token,
                'device'    => $_SERVER['REMOTE_ADDR'],
                'users_id'  => $id,
                ));

            return $token;
        }

        /**
         * Check token Method
         *
         * @param string $token
         *
         * @return array / boolean
         */
        function api_checkToken($token = null, $address = null) {
            $this->loadModel('Tokens');

            if ($token != null && $address != null) {
                $user = $this->Tokens->select([
                    'conditions'    => [
                        'token'         => $token,
                        'device'        => $address,
                    ],
                ]);

                if (count($user) != 1) {
                    $this->errors['user'] = 'No user.';
                } else {
                    $data['user'] = current($user);
                }
            } else {
                $this->errors['token'] = 'No token sent.';
            }

            $data['errors'] = $this->errors;

            $data['valid'] = empty($this->errors) ? true : false;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Auth Action
         *
         * @param string $token
         *
         * @return void
         */
        function api_auth($token = null) {
            if (!empty($_POST)) {
                $data = array();

                if (!isset($_POST['email']) || $_POST['email'] == null || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $this->errors['email'] = 'Wrong email';
                } else {
                    $this->setEmail($_POST['email']);
                }

                if (!isset($_POST['password']) || $_POST['password'] == null || strlen($_POST['password']) < 6) {
                    $this->errors['password'] = 'Wrong password';
                } else {
                    $this->setPassword($_POST['password']);
                }

                unset($_POST);

                $this->loadModel('Users');

                if (empty($this->errors)) {
                    $user = $this->Users->select(array(
                        'conditions'    => array(
                            'email'         => $this->getEmail(),
                            'password'      => md5(sha1($this->getPassword())),
                            ),
                        ));

                    if (count($user) > 0) {
                        $user = current($user);

                        $this->loadModel('Tokens');
                        $user->users_tokens = $this->Tokens->select(array(
                            'conditions'    => array(
                                'users_id'      => $user->users_id,
                                'device'        => $_SERVER['REMOTE_ADDR'],
                                ),
                            ));

                        if (count($user->users_tokens) < 1) {
                            $token = $this->api_generateToken($user->users_id);
                            $request = $this->getJSON($this->link('api/users/checkToken/' . $token . '/' . $_SERVER['REMOTE_ADDR']));
                            $data['authed'] = $request->valid;
                            if (!empty($request->errors)) {
                                $this->errors = $request->errors;
                            }
                            $data['token'] = $token;
                        } else if (current($user->users_tokens)->tokens_disabled == 0) {
                            $request = $this->getJSON($this->link('api/users/checkToken/' . current($user->users_tokens)->tokens_token . '/' . $_SERVER['REMOTE_ADDR']));
                            $data['authed'] = $request->valid;
                            if (!empty($request->errors)) {
                                $this->errors = $request->errors;
                            }
                            $data['token'] = current($user->users_tokens)->tokens_token;
                        } else {
                            $this->errors['token'] = 'Token disabled';
                        }


                    } else {
                        $this->errors['credentials'] = 'Wrong credentials.';
                    }
                }

                $data['errors'] = $this->errors;
            } else if ($token != null) {
                $data['authed'] = $this->getJSON($this->link('api/users/checkToken/' . $token . '/' . $_SERVER['REMOTE_ADDR']))->valid;
                !$data['authed'] ? $this->errors['token'] = 'Invalid token.' : true;
                $data['errors'] = $this->errors;
            } else {
                $data = 'Nothing was sent';
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * API Tokens
         *
         * @param null $id
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         * @throws \Exception
         */
        function api_tokens($id = null) {
            if ($id != null) {
                $this->loadModel('Users');
                $this->loadModel('Tokens');

                $user = $this->Users->select([
                    'conditions'    => [
                        'id'            => $id,
                    ],
                ]);

                if (count($user) == 1) {
                    $data['tokens'] = $this->Tokens->select([
                        'conditions'    => [
                            'users_id'      => $id,
                        ]
                    ]);
                } else {
                    $this->errors['id'] = 'No user with this id';
                }
            } else {
                $this->errors['id'] = 'No id sent';
            }

            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Admin Index Action
         *
         * @return void
         */
        function admin_index() {
            View::$title = 'Liste des utilisateurs';
            $this->loadModel('Users');

            $data['users'] = current($this->getJSON($this->link('api/users/')));

            $data['count'] = $this->Users->select(array('count' => true));

            View::make('users.admin_index', $data, 'admin');
        }

        /**
         * Admin Create
         *
         * @return void
         */
        function admin_create($id = null) {
            View::$title = 'Ajout d\'un utilisateur';

            View::make('users.admin_create', null, 'admin');
        }

        /**
         * Admin Count Action
         *
         * @return void
         */
        function admin_count() {
            $this->loadModel('Users');

            $data['count'] = $this->Users->select(array('count' => true));

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Admin Create
         *
         * @return void
         */
        function admin_signin() {
            View::$title = 'Dashboard';

            if (!empty($_POST)) {
                if (!isset($_POST['username']) || $_POST['username'] == null) {
                    $this->errors['username'] = 'wrong username';
                } else {
                    $this->setUsername($_POST['username']);
                }

                if (!isset($_POST['password']) || $_POST['password'] == null) {
                    $this->errors['password'] = 'wrong password';
                } else {
                    $this->setPassword($_POST['password']);
                }

                if (!isset($_POST['remember']) || $_POST['remember'] == null) {
                    $this->errors['remember'] = 'wrong remember value';
                } else {
                    $this->setRemember($_POST['remember']);
                }

                unset($_POST);

                $this->loadModel('Admin');

                if (empty($this->errors)) {
                    $admin = $this->Admin->select(array(
                        'conditions'    => array(
                            'username'      => $this->getUsername(),
                            'password'      => md5(sha1($this->getPassword())),
                        ),
                    ));

                    if (count($admin) == 1) {
                        Session::set('admin', current($admin));

                        if ($this->getRemember()) {
                            Cookie::set('admin_username', current($admin)->admin_username);
                            Cookie::set('admin_security', md5($_SERVER['HTTP_USER_AGENT'] . current($admin)->admin_username));
                        }

                        $message = 'Bienvenue, ' . current($admin)->admin_username . '.';
                        Session::setFlash('success', $message);

                        $this->redirect('admin1259');
                    } else {
                        $message = 'Nom d\'utilisateur ou mot de passe incorrect.';
                        Session::setFlash('danger', $message);
                        $this->redirect('admin1259');
                    }
                } else {
                    $message = 'Nom d\'utilisateur ou mot de passe incorrect.';
                    Session::setFlash('danger', $message);
                    $this->redirect('admin1259');
                }
            } else if (Cookie::get('admin_username') !== false && Cookie::get('admin_security') !== false) {
                $this->loadModel('Admin');

                $admin = $this->Admin->select(array(
                    'conditions'    => array(
                        'username'      => Cookie::get('admin_username'),
                    ),
                ));

                if (count($admin) == 1 && Cookie::get('admin_security') == md5($_SERVER['HTTP_USER_AGENT'] . Cookie::get('admin_username'))) {
                    Session::set('admin', current($admin));

                    $this->redirect('admin1259');
                } else {
                    Cookie::destroy('admin_security');
                    Cookie::destroy('admin_username');
                }
            } else if (Session::get('admin') !== false) {
                $this->redirect('admin1259');
            }

            View::make('users.admin_signin', null, 'admin_signin');
        }

        /**
         * Log out the current admin
         *
         * @return void
         */
        function admin_logout() {
            Session::destroy('admin');
            Cookie::destroy('admin_username');
            Cookie::destroy('admin_security');
            $this->redirect('admin1259/users/signin');
        }
    }
