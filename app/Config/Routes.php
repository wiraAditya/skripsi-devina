<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('menu', "HomeMenuController::index");

$routes->group('payment', function($routes) {
    $routes->get('/', 'PaymentController::index');
    $routes->get('token', 'PaymentController::token');
});
$routes->group('cart', function($routes) {
    $routes->get('/', 'CartController::view');
    $routes->post('add', 'CartController::add');
    $routes->get('update', 'CartController::update');
    $routes->get('remove/(:num)', 'CartController::remove/$1');
    $routes->post('clear', 'CartController::clear');
    $routes->get('payment', 'PaymentController::token');
});

$routes->group('admin',  function($routes) {
    // Admin Dashboard
    $routes->get('/', 'AdminController::index');
    
    // User Management
    $routes->group('users', function($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('create', 'UserController::create');
        $routes->post('store', 'UserController::store');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update/(:num)', 'UserController::update/$1');
        $routes->delete('delete/(:num)', 'UserController::delete/$1');
    });
    $routes->group('kategori', function($routes) {
        $routes->get('/', 'KategoriController::index');
        $routes->get('create', 'KategoriController::create');
        $routes->post('store', 'KategoriController::store');
        $routes->get('edit/(:num)', 'KategoriController::edit/$1');
        $routes->post('update/(:num)', 'KategoriController::update/$1');
        $routes->delete('delete/(:num)', 'KategoriController::delete/$1');
    });
    $routes->group('menu', function($routes) {
        $routes->get('/', 'MenuController::index');
        $routes->get('create', 'MenuController::create');
        $routes->post('store', 'MenuController::store');
        $routes->get('edit/(:num)', 'MenuController::edit/$1');
        $routes->post('update/(:num)', 'MenuController::update/$1');
        $routes->delete('delete/(:num)', 'MenuController::delete/$1');
        $routes->get('toggle-status/(:num)', 'MenuController::toggleStatus/$1');

    });
    // // Content Management
    // $routes->group('content', function($routes) {
    //     $routes->get('pages', 'PageController::index');
    //     $routes->get('posts', 'PostController::index');
    //     // Add more content routes as needed
    // });
    
    // // Settings
    // $routes->group('settings', function($routes) {
    //     $routes->get('/', 'SettingsController::index');
    //     $routes->post('update', 'SettingsController::update');
    // });
    
    // // Any other admin-specific routes
    // $routes->get('profile', 'AdminController::profile');
    // $routes->post('profile/update', 'AdminController::updateProfile');
});

