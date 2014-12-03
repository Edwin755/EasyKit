<?php
    
    /**
     * UsersController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\View;
    use Core\Session;
    use Core\Cookie;

    /**
     * UsersController Class
     */
    class UsersController extends Core\Controller
    {

        private $errors = array();

        private $email;
        private $password;
        private $firstname;
        private $lastname;

        /**
         * Get the Email
         * 
         * @return string
         */
        function getEmail() {
            return $this->email;
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
         * Set the Email
         * 
         * @return string
         */
        function setEmail($value) {
            $this->email = $value;
        }

        /**
         * Set the Password
         * 
         * @return string
         */
        function setPassword($value) {
            $this->password = $value;
        }

        /**
         * Set the Firstname
         * 
         * @return string
         */
        function setFirstname($value) {
            $this->firstname = $value;
        }

        /**
         * Set the Firstname
         * 
         * @return string
         */
        function setLastname($value) {
            $this->lastname = $value;
        }

        /**
         * Index Action
         * 
         * @return void
         */
        function index() {
            $data = array('Users controller');
            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Register Action
         * 
         * @return void
         */
        function create() {
            $data = 'No POST received.';

            if (!empty($_POST)) {
                $data = array();
                $this->loadModel('Users');

                if (!isset($_POST['email']) || $_POST['email'] == null || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
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

                if (empty($this->errors)) {
                    $this->Users->save(array(
                        'password'  => md5(sha1($this->getPassword())),
                        'email'     => $this->getEmail(),
                        'firstname' => $this->getFirstname(),
                        'lastname'  => $this->getLastname(),
                        ));

                    $data['success'] = true;
                } else {
                    $data['success'] = false;
                }

                $data['errors'] = $this->errors;
            } else {

            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        function generateToken($id) {
            $this->loadModel('Tokens');

            $token = md5(uniqid(mt_rand(), true));

            $this->Tokens->save(array(
                'token'     => $token,
                'device'    => $_SERVER['HTTP_USER_AGENT'],
                'users_id'  => $id,
                ));

            return $token;
        }

        /**
         * Check token Method
         * 
         * @return array / boolean
         */
        function checkToken($token) {
            $this->loadModel('Tokens');
            $user = $this->Tokens->select(array(
                'join'          => array(
                    array(
                        'name'      => 'Users',
                        'direction' => 'right',
                        ),
                    ),
                'conditions'    => array(
                    'token'         => $token,
                    'device'        => $_SERVER['HTTP_USER_AGENT'],
                    ),
                ));

            return !empty($user) ? true : false;
        }

        /**
         * Auth Action
         * 
         * @return void
         */
        function auth($token = null) {
            if (!empty($_POST)) {
                $data = array();

                if (!isset($_POST['email']) || $_POST['email'] == null || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $this->errors['email'] = 'wrong email';
                } else {
                    $this->setEmail($_POST['email']);
                }

                if (!isset($_POST['password']) || $_POST['password'] == null || strlen($_POST['password']) < 6) {
                    $this->errors['password'] = 'wrong password';
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
                                'device'        => $_SERVER['HTTP_USER_AGENT'],
                                ),
                            ));

                        if (count($user->users_tokens) < 1) {
                            $token = $this->generateToken($user->users_id);
                            $data['authed'] = $this->checkToken($token);
                            $data['token'] = $token;
                        } else if (current($user->users_tokens)->tokens_disabled == 0) {
                            $data['authed'] = $this->checkToken(current($user->users_tokens)->tokens_token);
                            $data['token'] = current($user->users_tokens)->tokens_token;
                        } else {
                            $this->errors['token'] = 'token disabled';
                        }

                        
                    } else {
                        $this->errors['credentials'] = 'wrong credentials.';
                    }
                }

                $data['errors'] = $this->errors;
            } else if ($token != null) {
                $data['authed'] = $this->checkToken($token);
                !$data['authed'] ? $this->errors['token'] = 'invalid token.' : '';
                $data['errors'] = $this->errors;
            } else {
                $data = 'Nothing was sent';
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
