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

Router::get('/', 'HomeController', [
    'only'  => [
        'index'
    ]
]);

Router::get('admin1259', 'AdminController');

Router::get('api', 'ApiController');

Router::resource('packs', 'PacksController');

Router::resource('users', 'UsersController');

Router::resource('events', 'EventsController');
