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
         * Create
         *
         * @param null $id
         *
         * @throws Core\Exceptions\NotFoundHTTPException
         */
        function create($id = null)
        {
            if (!is_null($id)) {

            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }

        function destroy($id = null)
        {
            if (!is_null($id)) {

            }

            $data['success'] = !empty($this->errors) ? false : true;
            $data['errors'] = $this->errors;

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
