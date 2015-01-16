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
    use HTML;
    use Imagine\Gd\Imagine;
    use Imagine\Image\ImageInterface;
    use Imagine\Image\Box;

    /**
     * Class MediasController
     *
     * @property Medias
     */
    class MediasController extends Controller
    {

        private $errors = array();

        /**
         * Get
         *
         * @param null $id
         * @throws Core\Exceptions\NotFoundHTTPException
         * @throws \Exception
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

                $file = pathinfo(realpath(__DIR__ . '/../../public/uploads/' . $data['media']->medias_type . '/' . $data['media']->medias_file));
                $filename = $file['filename'];
                $extension = $file['extension'];
                $baselink = HTML::link('/uploads/' . $data['media']->medias_type . '/' . $filename);

                $data['media']->medias_file = $baselink . '.' . $extension;
                $data['media']->medias_thumb50 = $baselink . '-x50.' . $extension;
                $data['media']->medias_thumb160 = $baselink . '-x160.' . $extension;
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        /**
         * Send
         *
         * @param null $mode
         * @throws Core\Exceptions\NotFoundHTTPException
         * @throws \Exception
         */
        function api_send($mode = null) {
            if (!empty($_FILES)) {
                $files = ['image/jpeg', 'image/gif', 'image/png', 'video/mpeg', 'video/mp4', 'video/webm'];
                $images = ['image/jpeg', 'image/gif', 'image/png'];

                $data['upload'] = $this->upload($_FILES, $files);

                $this->loadModel('Medias');

                $i = 0;

                foreach ($_FILES as $file) {
                    if ($data['upload'][$i]['success']) {
                        if (in_array($file['type'], $images)) {
                            $sizes = [
                                '50'    => '50',
                                '160'   => '160'
                            ];

                            $imagine = new Imagine();

                            if ($mode == 'outbound') {
                                $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                            } elseif ($mode == 'inset') {
                                $mode = ImageInterface::THUMBNAIL_INSET;
                            } else {
                                $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                            }

                            foreach ($sizes as $key => $value) {
                                $filename = preg_replace('#.' . $data['upload'][$i]['extension'] . '$#', '', $data['upload'][$i]['file']);

                                $imagine->open($data['upload'][$i]['file'])
                                    ->thumbnail(new Box($key, $value), $mode)
                                    ->save($filename . '-x' . $key . '.' . $data['upload'][$i]['extension']);
                            }
                        }

                        $this->Medias->save([
                            'file'  => $data['upload'][$i]['filename'] . '.' . $data['upload'][$i]['extension'],
                            'type'  => $file['type'],
                        ]);

                        $data['upload'][$i]['medias_id'] = $this->Medias->lastInsertId;
                    }

                    $i++;
                }
            } else {
                $this->errors['file'] = 'No file have been sent.';
            }

            $data['errors'] = $this->errors;
            $data['success'] = !empty($this->errors) ? false : true;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        function api_destroy($id = null) {
            $this->loadModel('Medias');

            if ($id != null) {
                $media = $this->Medias->select([
                    'conditions'    => [
                        'id'            => $id
                    ]
                ]);

                if (count($media) == 1) {
                    $media = current($media);
                    $file = pathinfo($media->medias_file);
                    $directory = __DIR__ . '/../../public/uploads/' . $media->medias_type . '/' . $file['filename'];

                    $files = [
                        $directory . '.' . $file['extension'],
                        $directory . '-x50.' . $file['extension'],
                        $directory . '-x160.' . $file['extension'],
                    ];

                    foreach ($files as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }

                    $this->Medias->delete($id);
                    $data['success'] = true;
                } else {
                    $data['success'] = false;
                    $this->errors['media'] = 'The media doesn\'t exists.';
                }
            } else {
                $data['success'] = false;
                $this->errors['id'] = 'No id have been sent.';
            }

            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }



