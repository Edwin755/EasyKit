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

    /**
     * AdminController Class
     *
     * @property mixed Admin
     */
    class AdminController extends Controller
    {

        protected $layout = 'admin';

        /**
         * Constructor
         *
         * @return void
         */
        function constructor() {
            if (isset($_SESSION['admin'])) {
                if (!$this->isAdmin()) {
                    $this->redirect('admin1259/users/signin');
                }
            } else if ($this->link('admin1259/users/signin') != $this->getCurrentURL()) {
                $this->redirect('admin1259/users/signin');
            }
        }

        /**
         * isAdmin
         *
         * @return boolean
         */
        function isAdmin() {
            $this->loadModel('Admin');

            $user = $this->Admin->select(array(
                'conditions'    => array(
                    'id'            => Session::get('admin')->admin_id
                )
            ));
            $user = current($user);

            if ($user->admin_username == Session::get('admin')->admin_username && $user->admin_password == Session::get('admin')->admin_password) {
                return true;
            } else {
                unset($_SESSION['admin']);
                return false;
            }
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

            View::make('api.index', json_encode($data), false);
        }
    }
