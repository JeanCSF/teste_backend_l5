<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::docs');
$routes->group('api', function (RouteCollection $routes) {
    $routes->post('login', 'Api::login');
    $routes->get('logout', 'Api::logout');

    $routes->post('clientes', 'Api::listar');
    $routes->post('produtos', 'Api::listar');
    $routes->post('pedidos', 'Api::listar');

    $routes->post('create/cliente', 'Api::create');
    $routes->post('create/produto', 'Api::create');
    $routes->post('create/pedido', 'Api::create');

    $routes->post('read/cliente', 'Api::read');
    $routes->post('read/produto', 'Api::read');
    $routes->post('read/pedido', 'Api::read');

    $routes->post('update/cliente', 'Api::update');
    $routes->post('update/produto', 'Api::update');
    $routes->post('update/pedido', 'Api::update');

    $routes->delete('delete/cliente/(:num)', 'Api::delete/$1');
    $routes->delete('delete/produto/(:num)', 'Api::delete/$1');
    $routes->delete('delete/pedido/(:num)', 'Api::delete/$1');
});
