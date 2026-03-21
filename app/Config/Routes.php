<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('allusers','UserController::index');
$routes->get('user', 'UserController::getUser');     
$routes->post('user','UserController::createUser');
$routes->put('user/updateuser', 'UserController::updateUser');
$routes->delete('user', 'UserController::deleteUser'); 