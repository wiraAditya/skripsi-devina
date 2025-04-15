<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('menu', "Home::menu");
$routes->get('cart', "Home::cart");
$routes->get('payment', "Home::payment");

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

