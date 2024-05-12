<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/user', 'User::index');
$routes->get('/user/add', 'User::add');
$routes->post('/user/add', 'User::store');
$routes->get('/user/(:segment)/edit', 'User::edit/$1');
$routes->post('/user/update', 'User::update');

$routes->get('/kamar', 'Kamar::index');
$routes->get('/kamar/add', 'Kamar::add');
$routes->post('/kamar/add', 'Kamar::store');
$routes->get('/kamar/(:segment)/edit', 'Kamar::edit/$1');
$routes->post('/kamar/update', 'Kamar::update');
$routes->post('/harga-air', 'Kamar::hargaAir');