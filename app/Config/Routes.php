<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/user', 'User::index');
$routes->get('/user/add', 'User::add');
$routes->post('/user/add', 'User::store');
