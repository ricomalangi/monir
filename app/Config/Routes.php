<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/dashboard/total_power', 'Dashboard::getTotalPower');
$routes->post('/dashboard/update-harga', 'Dashboard::updateHarga');

$routes->get('/user', 'User::index');
$routes->get('/user/add', 'User::add');
$routes->post('/user/add', 'User::store');
$routes->get('/user/(:segment)/edit', 'User::edit/$1');
$routes->post('/user/update', 'User::update');

$routes->get('/relay', 'Relay::index');
$routes->get('/relay/add', 'Relay::add');
$routes->post('/relay/add', 'Relay::store');
$routes->get('/relay/(:segment)/edit', 'Relay::edit/$1');
$routes->post('/relay/update', 'Relay::update');
$routes->post('/relay/update-status', 'Relay::updateStatus');

$routes->post('/harga-air', 'Kamar::hargaAir');

$routes->get('/json/harga-air', 'Kamar::jsonHargaAir');
$routes->get('/api/pzem-data', 'Recievedata::index');
$routes->get('/api/total-bayar', 'Recievedata::totalHarga');
$routes->get('/api/relay/(:segment)', 'Recievedata::relay/$1');

$routes->post('voice-command/process', 'VoiceCommand::process');
$routes->get('voice-command', function () {
    return view('voice_command');
});
