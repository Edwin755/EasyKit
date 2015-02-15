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
use Core\Dispatcher;
use Core\Exceptions\NotFoundHTTPException;
use Core\Validation;
use Core\View;
use Core\Session;
use Core\Cookie;
use Core\Email;
use Exception;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;

/**
 * UsersController Class
 *
 * @property mixed Tokens
 * @property mixed Users
 * @property mixed Admin
 */
class UsersController extends AppController
{

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
     * Datas for model
     *
     * @var string $email
     * @var string $username
     * @var string $password
     * @var boolean $remember
     * @var string $firstname
     * @var string $lastname
     * @var string $birth
     * @var string $token
     * @var string $fb_id
     */
    private $email, $username, $password, $remember, $firstname, $lastname, $birth, $token, $fb_id;
    private $helper;

    /**
     * Get the Email
     *
     * @return string
     */
    function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the Password
     *
     * @return string
     */
    function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the Remember value
     *
     * @return string
     */
    function getRemember()
    {
        return $this->remember;
    }

    /**
     * Get the Firstname
     *
     * @return string
     */
    function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the Firstname
     *
     * @return string
     */
    function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the Firstname
     *
     * @return string
     */
    function getBirth()
    {
        return $this->birth;
    }

    /**
     * Get the username
     *
     * @return string
     */
    function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the Email
     *
     * @param string $email
     */
    function setEmail($email) {
        $this->email = $email;
        $this->fields['email'] = $email;
    }

    /**
     * Set the Password
     *
     * @param string $password
     */
    function setPassword($password) {
        if (strlen($password) > 6) {
            $this->password = md5(sha1($password));
            $this->fields['password'] = $this->password;
        } else {
            $this->errors['password'] = 'Password too short.';
        }
    }

    /**
     * Set the Remember value
     *
     * @param string $remember
     */
    function setRemember($remember) {
        $this->remember = $remember;
    }

    /**
     * Set the Firstname
     *
     * @param string $firstname
     */
    function setFirstname($firstname) {
        $this->firstname = $firstname;
        $this->fields['firstname'] = $firstname;
    }

    /**
     * Set the Lastname
     *
     * @param string $lastname
     */
    function setLastname($lastname) {
        $this->lastname = $lastname;
        $this->fields['lastname'] = $lastname;
    }

    /**
     * Set the Birth
     *
     * @param string $birth
     */
    function setBirth($birth) {
        if (Validation::validateDate($birth, 'Y-m-d')) {
            $this->birth = $birth;
            $this->fields['birth'] = $birth;
        } else {
            $this->errors['date'] = 'Wrong date.';
        }
    }

    /**
     * Set the username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get Token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set Token
     *
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get FB ID
     * @return mixed
     */
    public function getFbId()
    {
        return $this->fb_id;
    }

    /**
     * Set FB ID
     *
     * @param mixed $fb_id
     */
    public function setFbId($fb_id)
    {
        $this->fb_id = $fb_id;
    }

    /**
     * Remember me
     *
     * @param object $user
     * @param string $token
     */
    private function rememberMe($user, $token)
    {
        if ($this->getRemember()) {
            Cookie::set('user_username', $user->users_email);
            Cookie::set('user_token', $token);
        }
    }

    /**
     * Constructor
     *
     * @return void
     */
    function constructor()
    {
        if (isset($_SESSION['admin']) && $this->getPrefix() == 'admin') {
            $admin = Session::get('admin');
            if (!$this->getJSON($this->link('admin1259/is_admin/' . $admin->admin_username . '/' . $admin->admin_password))->admin) {
                if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                    throw new NotFoundHTTPException('Non authorized address.');
                }
            }
        }
    }

    /**
     * Index Action
     *
     * @return void
     */
    function api_get($id = null)
    {
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
            $nb = isset($_GET['limit']) && $_GET['limit'] != null ? $_GET['limit'] : 20;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $page = (($page - 1) * $nb);

            $data['users'] = $this->Users->select(array(
                'order' => 'desc',
                'orderby'   => 'id',
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
    function api_create()
    {
        if (!empty($_POST)) {
            $data = array();
            $this->loadModel('Users');

            if (!isset($_POST['email']) || $_POST['email'] == null || !Validation::validateEmail($_POST['email'])) {
                $this->errors['email'] = 'Email not valid.';
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

            if (!isset($_POST['password']) || $_POST['password'] == null) {
                $this->errors['password'] = 'Empty password.';
            } else {
                $this->setPassword($_POST['password']);
            }

            if (!isset($_POST['tc']) || is_null($_POST['tc']) || !$_POST['tc']) {
                $this->errors['tc'] = 'Please accept the Terms & Conditions.';
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

            if (isset($_POST['fb_id'])) {
                $this->setFbId($_POST['fb_id']);
            }

            if (empty($this->errors)) {
                /*$this->Users->save(array(
                    'email'     => $this->getEmail(),
                    'password'  => $this->getPassword(),
                    'firstname' => $this->getFirstname(),
                    'lastname'  => $this->getLastname(),
                    'birth'     => $this->getBirth(),
                    'fb_id'     => $this->getFbid(),
                ));*/

                $message = 'Welcome to Easykit, please login';
                Session::setFlash('success', $message);

                $mail = new Email($this->getEmail(),['hello@easykit.ovh' => 'Easykit'], 'Welcome on Easykit', '<h1>Welcome on Easykit</h1>', 'Welcome on Easykit');
                if (!$mail->send()) {
                    $this->errors['send'] = 'Could not send the message';
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
     * Register Action
     *
     * @return void
     */
    function api_edit($id = null)
    {
        if ($id != null) {
            if (!empty($_POST)) {
                $data = array();

                if (isset($_POST['password']) && $_POST['password'] != null) {
                    $this->setPassword($_POST['password']);
                }

                if (isset($_POST['firstname']) && $_POST['firstname'] != null) {
                    $this->setFirstname($_POST['firstname']);
                }

                if (isset($_POST['lastname']) && $_POST['lastname'] != null) {
                    $this->setLastname($_POST['lastname']);
                }

                if (isset($_POST['birth']) && $_POST['birth'] != null) {
                    $this->setBirth($_POST['birth']);
                }

                if (isset($_POST['token']) && $_POST['token'] != null) {
                    $this->setToken($_POST['token']);
                } else {
                    $this->errors['token'] = 'No token given.';
                }

                if (empty($this->errors)) {
                    $this->loadModel('Users');
                    $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                    if ($user->valid) {
                        $user_id = $user->user->tokens_users_id;
                    } else {
                        $this->errors['token'] = $user->errors;
                    }

                    $user_model = $this->Users->select([
                        'conditions'    => [
                            'id'            => $id
                        ]
                    ]);

                    if (count($user_model) != 1) {
                        $this->errors['user'] = 'This user doesn\'t exists.';
                    } else if (empty($this->errors)) {
                        if (current($user_model)->users_id != $user_id) {
                            $this->errors['user'] = 'You\'re not allowed to edit this user.';
                        }
                    }

                    if (empty($this->errors)) {
                        $this->fields['id'] = $id;
                        $this->Users->save($this->fields);

                        $data['user'] = $id;
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
     * API Generate Token
     *
     * @param $id
     *
     * @return string
     *
     * @throws \Exception
     */
    function api_generateToken($id)
    {
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
     * @return array|boolean
     */
    function api_checkToken($token = null, $address = null)
    {
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
    function api_auth($token = null)
    {
        if (!empty($_POST)) {
            $data = array();

            if (!isset($_POST['email']) || $_POST['email'] == null || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = 'Empty email.';
            } else {
                $this->setEmail($_POST['email']);
            }

            if (!isset($_POST['password']) || $_POST['password'] == null) {
                $this->errors['password'] = 'Empty password.';
            } else {
                $this->setPassword($_POST['password']);
            }

            if (isset($_POST['remember']) && $_POST['remember'] != null) {
                $this->setRemember($_POST['remember']);
            }

            unset($_POST);

            $this->loadModel('Users');

            if (empty($this->errors)) {
                $user = $this->Users->select(array(
                    'conditions'    => array(
                        'email'         => $this->getEmail(),
                        'password'      => $this->getPassword(),
                    ),
                ));

                if (count($user) == 1) {
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
                        $data['user'] = $user;
                        $data['token'] = $token;
                        $this->rememberMe($user, $token);
                    } else if (current($user->users_tokens)->tokens_disabled == 0) {
                        $request = $this->getJSON($this->link('api/users/checkToken/' . current($user->users_tokens)->tokens_token . '/' . $_SERVER['REMOTE_ADDR']));
                        $data['authed'] = $request->valid;
                        if (!empty($request->errors)) {
                            $this->errors = $request->errors;
                        }
                        $data['user'] = $user;
                        $data['token'] = current($user->users_tokens)->tokens_token;
                        $this->rememberMe($user, $data['token']);
                    } else {
                        $this->errors['token'] = 'Token disabled.';
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

        $data['success'] = !empty($this->errors) ? false : true;
        $data['errors'] = $this->errors;

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
    function api_tokens($id = null)
    {
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

        $data['success'] = !empty($this->errors) ? false : true;
        $data['errors'] = $this->errors;

        View::make('api.index', json_encode($data), false, 'application/json');
    }

    /**
     * Sign in
     *
     * @throws NotFoundHTTPException
     */
    function signin()
    {
        $data = [];

        if (!empty($_POST) && !isset($_SESSION['user'])) {
            $return = json_decode($this->postCURL($this->link('api/users/auth'), $_POST), false);

            $data = $return;

            if ($return->success == true) {
                $data->user->token = $return->token;
                $data->user->users_media = current($this->getJSON($this->link('api/medias/get') . '/' . $return->user->users_medias_id));
                Session::set('user', $data->user);
            }
        }

        View::make('api.index', json_encode($data), false, 'application/json');
    }

    /**
     * Register
     *
     * @throws NotFoundHTTPException
     */
    function register()
    {
        View::$title = 'Register';
        $data = $_POST;
        if (Session::get('user') == false) {
            $helper = $this->initFb();

            try {
                if (Session::get('fb_token') != false) {
                    $session = new FacebookSession(Session::get('fb_token'));
                } else {
                    $session = $helper->getSessionFromRedirect();
                }
            } catch(FacebookRequestException $e) {
                throw new Exception($e->getMessage());
            }

            if (isset($session)) {
                try {
                    Session::set('fb_token', $session->getToken());
                    $request = new FacebookRequest($session, 'GET', '/me');
                    $profile = $request->execute()->getGraphObject('Facebook\GraphUser');
                    if($profile->getEmail() === null){
                        throw new Exception('Email missing.');
                    }
                    $post = [
                        'email'     => $profile->getEmail(),
                        'password'  => $profile->getId(),
                        'fb_id'     => $profile->getId(),
                        'firstname' => $profile->getFirstname(),
                        'lastname'  => $profile->getLastname(),
                        'tc'        => true
                    ];
                    $return = json_decode($this->postCURL($this->link('api/users/create'), $post), false);
                    if ($return->success) {
                        $return = json_decode($this->postCURL($this->link('users/signin'), $post), false);

                        if ($return->success) {
                            Session::set('user', $return->user);
                            $this->redirect('/');
                        } else {
                            $loginUrl = $this->generateFbLink();
                            $data['login'] = $loginUrl;
                            $this->errors = $return->errors;
                            Session::destroy('fb_token');
                        }
                    } else {
                        $return = json_decode($this->postCURL($this->link('users/signin'), $post), false);

                        if ($return->success) {
                            Session::set('user', $return->user);
                            $this->redirect('/');
                        } else {
                            $loginUrl = $this->generateFbLink();
                            $data['login'] = $loginUrl;
                            $this->errors = $return->errors;
                            Session::destroy('fb_token');
                        }
                    }
                } catch (Exception $e) {
                    Session::destroy('fb_token');
                    $loginUrl = $this->generateFbLink(true);
                    $data['login'] = $loginUrl;
                }
            } else {
                $loginUrl = $this->generateFbLink();
                $data['login'] = $loginUrl;
            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('users.register', $data, 'default');
        } else {
            $this->redirect('/');
        }
    }

    /**
     *
     */
    function logout()
    {

    }

    /**
     * Admin Index Action
     *
     * @return void
     */
    function admin_index()
    {
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
    function admin_create($id = null)
    {
        View::$title = 'Ajout d\'un utilisateur';

        View::make('users.admin_create', null, 'admin');
    }

    /**
     * Admin Count Action
     *
     * @return void
     */
    function admin_count()
    {
        $this->loadModel('Users');

        $data['count'] = $this->Users->select(array('count' => true));

        View::make('api.index', json_encode($data), false, 'application/json');
    }

    /**
     * Admin Create
     *
     * @return void
     */
    function admin_signin()
    {
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
                        'password'      => $this->getPassword(),
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
    function admin_logout()
    {
        Session::destroy('admin');
        Cookie::destroy('admin_username');
        Cookie::destroy('admin_security');
        $this->redirect('admin1259/users/signin');
    }
}
