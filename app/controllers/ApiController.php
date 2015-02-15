<?php

/**
 * ApiController
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

/**
 * ApiController Class
 */
class ApiController extends AppController
{

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
        } else if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
            throw new NotFoundHTTPException('Non authorized address.');
        }
    }

    /**
     * Index Action
     *
     * @return void
     */
    function index()
    {
        $data = array('Welcome in EasyKit API!');
        View::make('api.index', json_encode($data), false, 'application/json');
    }

    /**
     * Default Action throw 404
     *
     * @return void
     */
    function defaultAction()
    {
        $this->httpStatus(404);
        $data = array(
            'error' => 'Invalid URL parameter(s)',
        );
        View::make('api.index', json_encode($data), false, 'application/json');
    }

    /**
     * Users Action
     *
     * @return void
     */
    function users()
    {
        $this->useController('Users', 'api_', func_get_args(), false, 'get');
    }

    /**
     * Events Action
     *
     * @return void
     */
    function events()
    {
        $this->useController('Events', 'api_', func_get_args(), false, 'get');
    }

    /**
     * Packs Action
     *
     * @return void
     */
    function packs()
    {
        $this->useController('Packs', 'api_', func_get_args(), false, 'get');
    }

    /**
     * Packs Action
     *
     * @return void
     */
    function steps()
    {
        $this->useController('Steps', 'api_', func_get_args(), false, 'get');
    }

    /**
     * Medias Action
     *
     * @return void
     */
    function medias()
    {
        $this->useController('Medias', 'api_', func_get_args(), false, 'get');
    }

    /**
     * Likes Action
     *
     * @return void
     */
    function likes()
    {
        $this->useController('Likes', 'api_', func_get_args(), false, 'get');
    }

    /**
     * Admin index Action
     *
     * @return void
     */
    function admin_index()
    {
        View::$title = 'Accès API';
        $data['token'] = md5(uniqid(mt_rand(), true));
        View::make('api.admin_index', $data, 'admin');
    }
}
