<?php
    
    /**
     * AdminController
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Controllers;

    use Core;
    use Core\Controller;
    use Core\Exceptions\NotFoundHTTPException;
    use Core\Session;
    use Core\View;
    use Core\Cookie;
    use Ifsnop\Mysqldump as IMysqldump;
    use \Exception;
    use Monolog\Handler\StreamHandler;
    use Monolog\Logger;

    /**
     * AdminController Class
     *
     * @package App\Controllers
     * @property mixed Admin
     */
    class AdminController extends Controller
    {

        /**
         * Layout
         *
         * @var string $layout
         */
        protected $layout = 'admin';

        /**
         * Constructor
         *
         * @return void
         */
        function constructor() {
            if (!preg_match('#^' . $this->link('admin1259/is_admin/') . '#', $this->getCurrentURL())) {
                if (isset($_SESSION['admin'])) {
                    $admin = Session::get('admin');
                    if (!$this->getJSON($this->link('admin1259/is_admin/' . $admin->admin_username . '/' . $admin->admin_password))->admin) {
                        $this->redirect('admin1259/users/signin');
                    }

                    $log = new Logger('admin');
                    $log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/admin.log', Logger::INFO));
                    $log->addInfo('User "' . $admin->admin_username . '" access page : ' . $this->getCurrentURL());
                } else if ($this->link('admin1259/users/signin') != $this->getCurrentURL()) {
                    $this->redirect('admin1259/users/signin');
                }
            }


        }

        /**
         * isAdmin
         *
         * @return boolean
         */
        function is_admin($username, $password) {
            $this->loadModel('Admin');

            $user = $this->Admin->select(array(
                'conditions'    => array(
                    'username'            => $username,
                    'password'            => $password,
                )
            ));

            if (count($user) == 1) {
                $data['admin'] = true;
            } else {
                $data['admin'] = false;
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Index Action
         */
        function index() {
            $this->useController('Home', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Events Action
         */
        function events() {
            $this->useController('Events', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Events Action
         */
        function packs() {
            $this->useController('Packs', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Users Action
         */
        function users() {
            $this->useController('Users', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Apis Action
         */
        function api() {
            $this->useController('Api', 'admin_', func_get_args(), $this->layout);
        }

        /**
         * Dump
         *
         * @throws NotFoundHTTPException
         */
        function dump() {
            $database = require __DIR__ . '/../config/database.php';
            $database = $database['connections'][$database['default']];

            if (isset($_POST)) {
                if (isset($_POST['datas']) && $_POST['datas'] == true) {
                    $datas = false;
                } else {
                    $datas = true;
                }
            } else {
                $datas = true;
            }

            try {
                $dump = new IMysqldump\Mysqldump($database['database'], $database['username'], $database['password'], $database['host'], 'mysql', array('no-data' => $datas));
                $filename = date('Y-m-d') . '-' . $database['database'] . '.sql';
                $dump->start(__DIR__ . '/../../dumps/' . $filename);
                $data['status'] = 'success';
                $data['message'] = 'Export terminé. <ul><li>Emplacement: <strong>' . realpath(__DIR__ . '/../../dumps/' . $filename) . '</strong></li></ul>';
            } catch (Exception $e) {
                $data['status'] = 'danger';
                $data['message'] = $e->getMessage();
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
