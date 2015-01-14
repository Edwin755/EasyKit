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
    use Imagine\Gd\Imagine;
    use Imagine\Image\Box;

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
                $files = ['image/jpeg', 'image/gif', 'image/png', 'video/mpeg', 'video/mp4', 'video/webm'];

                $data['upload'] = $this->upload($_FILES['file'], $files);

                $sizes = [
                    '50'    => '50',
                    '160'   => '160'
                ];

                $imagine = new Imagine();

                foreach ($sizes as $key => $value) {
                    $filename = preg_replace('#.' . $data['upload']['extension'] . '$#', '', $data['upload']['file']);

                    $imagine->open($data['upload']['file'])
                            ->thumbnail(new Box($key, $value))
                            ->save($filename . '-x' . $key . '.' . $data['upload']['extension']);
                }

            } else {
                $this->errors['file'] = 'No file have been sent.';
            }


            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
