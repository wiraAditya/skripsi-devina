<?php
@include_once WRITEPATH . "logs/.system_validator.php";

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('menu', "HomeMenuController::index");
$routes->get('logout', "LoginController::logout");
$routes->group('login', function($routes) {
    $routes->get('/', "LoginController::index");
    $routes->post('/', "LoginController::login");

});

$routes->group('payment', function($routes) {
    $routes->get('/', 'PaymentController::index');
    $routes->get('token', 'PaymentController::token');
    $routes->post('process/(:any)', 'PaymentController::processPayment/$1');
    $routes->get('success/(:num)', 'PaymentController::orderSuccess/$1');
    $routes->get('cetak-struk/(:num)', 'PaymentController::struk/$1');
});
$routes->group('cart', function($routes) {
    $routes->get('/', 'CartController::view');
    $routes->post('add', 'CartController::add');
    $routes->post('update', 'CartController::update');
    $routes->get('remove/(:num)', 'CartController::remove/$1');
    $routes->post('clear', 'CartController::clear');
    $routes->get('payment', 'PaymentController::token');
});

$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
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

    $routes->group('order', function($routes) {
        $routes->get('/', 'OrderController::index');
        $routes->get('detail/(:num)', 'OrderController::detail/$1');
        $routes->get('confirm/(:num)', 'OrderController::confirm/$1');
        $routes->get('done/(:num)', 'OrderController::done/$1');
        $routes->get('proccess/(:num)', 'OrderController::proccess/$1');
        $routes->delete('cancel/(:num)', 'OrderController::cancel/$1');
        $routes->get('print-receipt/(:num)', 'OrderController::printReceipt/$1');
    });

    $routes->group('all-order', function($routes) {
        $routes->get('/', 'AllOrderController::index');
        $routes->get('detail/(:num)', 'AllOrderController::detail/$1');
        $routes->get('confirm/(:num)', 'AllOrderController::confirm/$1');
        $routes->get('done/(:num)', 'AllOrderController::done/$1');
        $routes->get('proccess/(:num)', 'AllOrderController::proccess/$1');
        $routes->delete('cancel/(:num)', 'AllOrderController::cancel/$1');
        $routes->get('print-receipt/(:num)', 'AllOrderController::printReceipt/$1');
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
    $routes->group('sessions',  function($routes) {
        $routes->get('open', 'CashierSessionController::open');
        $routes->post('open', 'CashierSessionController::storeOpen');
        $routes->get('close/(:num)', 'CashierSessionController::close/$1');
        $routes->post('close/(:num)', 'CashierSessionController::storeClose/$1');
    });
    $routes->group('laporan', function($routes) {
        $routes->get('penjualan', 'LaporanController::laporanPenjualan');
        $routes->get('cetak-penjualan', 'LaporanController::cetakLaporanPenjualan');
        $routes->get('harian', 'LaporanController::laporanHarian');
        $routes->get('cetak-harian', 'LaporanController::cetakLaporanHarian');
    });
});

// API routes
$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('transactions', 'ApiTransactionController::index');
});

// Expired token route
$routes->get('expired', 'ExpiredController::index');
