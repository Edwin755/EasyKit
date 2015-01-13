<?php

    /**
     * MediasController file
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
     * Class MediasController
     *
     * @property  Medias
     */
    class MediasController extends Controller
    {

        private $errors = array();

        /**
		 * Get
		 */
        function api_get($id = null) {
            $this->loadModel('Medias');

            if ($id == null) {
                $nb = 20;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $page = (($page - 1) * $nb);

                $data['medias'] = $this->Medias->select([
                    'order'         => 'desc',
                    'limit'         => array($page, $page + $nb)
                ]);
            } else {
                $data['media'] = current($this->Medias->select([
                    'conditions'    => [
                        'id'            => $id
                    ]
                ]));
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Send
         */
        function api_send() {
            if (!empty($_FILES)) {
                $data['file'] = $_FILES;
            } else {
                $this->errors['file'] = 'No file was sent.';
            }


            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
