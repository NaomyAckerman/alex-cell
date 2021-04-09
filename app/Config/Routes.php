<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('DashboardController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
$routes->setAutoRoute(false);

// Login/out
$routes->get('login', 'AuthController::login', ['as' => 'login']);
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

// Registration
$routes->get('register', 'AuthController::register', ['as' => 'register']);
$routes->post('register', 'AuthController::attemptRegister');

// Activation
$routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
$routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

// Forgot/Resets
$routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
$routes->post('forgot', 'AuthController::attemptForgot');
$routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
$routes->post('reset-password', 'AuthController::attemptReset');






// Global // * Done
$routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);
$routes->group('stok', function ($routes) {
	$routes->get('/', 'StokController::index', ['as' => 'stok']);
	$routes->get('get-stok', 'StokController::stok', ['as' => 'info-stok']);
	$routes->post('get-stok', 'StokController::stok', ['as' => 'info-stok']);
});

// Admin 
$routes->group('', ['filter' => 'role:admin'], function ($routes) {
	// Produk // * Done
	$routes->group('produk', function ($routes) {
		$routes->get('/', 'ProdukController::index', ['as' => 'produk']);
		$routes->get('get-produk', 'ProdukController::produk', ['as' => 'info-produk']);
		$routes->get('create-produk', 'ProdukController::create', ['as' => 'tambah-produk']);
		$routes->post('store-produk', 'ProdukController::store', ['as' => 'simpan-produk']);
		$routes->get('edit-produk/(:any)', 'ProdukController::edit/$1', ['as' => 'edit-produk']);
		$routes->put('update-produk/(:any)', 'ProdukController::update/$1', ['as' => 'update-produk']);
		$routes->delete('deleted-produk/(:any)', 'ProdukController::delete/$1', ['as' => 'hapus-produk']);
	});

	// Konter
	$routes->group('konter', function ($routes) {
		$routes->get('/', 'KonterController::index', ['as' => 'konter']);
		$routes->get('get-konter', 'KonterController::konter', ['as' => 'info-konter']);
		$routes->get('create-konter', 'KonterController::create', ['as' => 'tambah-konter']);
		$routes->post('store-konter', 'KonterController::store', ['as' => 'simpan-konter']);
	});
});

// Karyawan
$routes->group('', ['filter' => 'role:karyawan'], function ($routes) {
	// Stok // * Done
	$routes->group('stok', function ($routes) {
		$routes->get('edit-stok', 'StokController::edit', ['as' => 'edit-stok']);
		$routes->post('update-stok', 'StokController::update', ['as' => 'update-stok']);
	});
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
