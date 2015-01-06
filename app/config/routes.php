<?php

/**
 * Routing file
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */

use Core\Dispatcher;
use Core\Router;
use Core\View;

Router::get('/', function () {
    return View::make('home.index', null, 'default');
});

Router::get('users/{id}-{name}/edit', function ($id, $name) {
    return Dispatcher::loadController(array(
        'controller'    => 'Users',
        'action'        => 'edit',
        'params'        => array($id, $name),
        'layout'        => 'default',
    ));
});

/*Router::group(['prefix' => 'admin1259'], function () {
    Router::get('users', 'UsersController');
});*/

Router::get('admin1259', 'AdminController');
Router::get('api', 'ApiController');
//Router::get('users', 'UsersController@index');
