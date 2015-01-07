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

Router::get('admin1259', 'AdminController');
Router::get('api', 'ApiController');

Router::resource('users', 'UsersController', [
    'only'  => [
        'index',
        'edit'
    ]
]);
