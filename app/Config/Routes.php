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
$routes->group('profile', function ($routes) {
	$routes->get('/', 'UserController::profile', ['as' => 'profile']);
	$routes->get('info-profile', 'UserController::info_profile', ['as' => 'info-profile']);
	$routes->put('update-profile/(:any)', 'UserController::update_profile/$1', ['as' => 'update-profile']);
});
$routes->group('stok', function ($routes) {
	$routes->get('/', 'StokController::index', ['as' => 'stok']);
	$routes->get('get-stok', 'StokController::stok', ['as' => 'info-stok']);
	$routes->post('get-stok', 'StokController::stok', ['as' => 'info-stok']);
});

// Owner 
$routes->group('', ['filter' => 'role:owner,admin'], function ($routes) {
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

	// User // * Done
	$routes->group('user', function ($routes) {
		$routes->get('/', 'UserController::index', ['as' => 'user']);
		$routes->get('get-user', 'UserController::user', ['as' => 'info-user']);
		$routes->post('block-user/(:any)', 'UserController::block/$1', ['as' => 'block-user']);
		$routes->delete('deleted-user/(:any)', 'UserController::delete/$1', ['as' => 'hapus-user']);
	});

	// Transaksi // * done
	$routes->group('transaksi', function ($routes) {
		$routes->get('info', 'TransaksiController::info_transaksi', ['as' => 'info-trx']);
		$routes->post('info', 'TransaksiController::info_transaksi', ['as' => 'info-trx']);
		$routes->get('report-trx/(:any)/(:any)', 'TransaksiController::report/$1/$2', ['as' => 'report-trx']);
	});

	// Konter // * done
	$routes->group('konter', function ($routes) {
		$routes->get('/', 'KonterController::index', ['as' => 'konter']);
		$routes->get('get-konter', 'KonterController::konter', ['as' => 'info-konter']);
		$routes->get('create-konter', 'KonterController::create', ['as' => 'tambah-konter']);
		$routes->post('store-konter', 'KonterController::store', ['as' => 'simpan-konter']);
		$routes->get('edit-konter/(:any)', 'KonterController::edit/$1', ['as' => 'edit-konter']);
		$routes->put('update-konter/(:any)', 'KonterController::update/$1', ['as' => 'update-konter']);
		$routes->delete('deleted-konter/(:any)', 'KonterController::delete/$1', ['as' => 'hapus-konter']);
	});
});

// Admin 
$routes->group('', ['filter' => 'role:admin'], function ($routes) {
	// User // * Done
	$routes->group('user', function ($routes) {
		$routes->get('create-user', 'UserController::create', ['as' => 'tambah-user']);
		$routes->post('store-user', 'UserController::store', ['as' => 'simpan-user']);
	});
});

// Karyawan
$routes->group('', ['filter' => 'role:karyawan'], function ($routes) {
	// Stok // * Done
	$routes->group('stok', function ($routes) {
		$routes->get('edit-stok', 'StokController::edit', ['as' => 'edit-stok']);
		$routes->post('update-stok', 'StokController::update', ['as' => 'update-stok']);
	});

	// Transaksi // * done
	$routes->group('transaksi', function ($routes) {
		// * REKAP
		$routes->get('rekap', 'TransaksiController::index', ['as' => 'trx-rekap']);
		$routes->get('get-rekap', 'TransaksiController::rekap', ['as' => 'info-trx-rekap']);
		$routes->post('submit-rekap', 'TransaksiController::rekap', ['as' => 'submit-trx-rekap']);

		// * TRX SALDO
		$routes->get('saldo', 'TransaksiController::index', ['as' => 'trx-saldo']);
		$routes->get('get-saldo', 'TransaksiController::saldo', ['as' => 'info-trx-saldo']);
		$routes->post('submit-saldo', 'TransaksiController::saldo', ['as' => 'submit-trx-saldo']);
		$routes->get('create-saldo', 'TransaksiController::saldo_create', ['as' => 'tambah-trx-saldo']);
		$routes->post('store-saldo', 'TransaksiController::saldo_store', ['as' => 'simpan-trx-saldo']);
		$routes->get('edit-saldo/(:any)', 'TransaksiController::saldo_edit/$1', ['as' => 'edit-trx-saldo']);
		$routes->put('update-saldo/(:any)', 'TransaksiController::saldo_update/$1', ['as' => 'update-trx-saldo']);
		$routes->delete('deleted-saldo/(:any)', 'TransaksiController::saldo_delete/$1', ['as' => 'hapus-trx-saldo']);

		// * TRX RESELLER
		$routes->get('reseller', 'TransaksiController::index', ['as' => 'trx-reseller']);
		$routes->get('get-reseller', 'TransaksiController::reseller', ['as' => 'info-trx-reseller']);
		$routes->post('submit-reseller', 'TransaksiController::reseller', ['as' => 'submit-trx-reseller']);
		$routes->get('create-reseller', 'TransaksiController::reseller_create', ['as' => 'tambah-trx-reseller']);
		$routes->post('store-reseller', 'TransaksiController::reseller_store', ['as' => 'simpan-trx-reseller']);
		$routes->delete('deleted-reseller/(:any)', 'TransaksiController::reseller_delete/$1', ['as' => 'hapus-trx-reseller']);

		// * TRX ACC
		$routes->get('acc', 'TransaksiController::index', ['as' => 'trx-acc']);
		$routes->get('get-acc', 'TransaksiController::acc', ['as' => 'info-trx-acc']);
		$routes->post('submit-acc', 'TransaksiController::acc', ['as' => 'submit-trx-acc']);
		$routes->get('create-acc', 'TransaksiController::acc_create', ['as' => 'tambah-trx-acc']);
		$routes->post('store-acc', 'TransaksiController::acc_store', ['as' => 'simpan-trx-acc']);
		$routes->get('edit-acc/(:any)', 'TransaksiController::acc_edit/$1', ['as' => 'edit-trx-acc']);
		$routes->put('update-acc/(:any)', 'TransaksiController::acc_update/$1', ['as' => 'update-trx-acc']);

		// * TRX KARTU
		$routes->get('kartu', 'TransaksiController::index', ['as' => 'trx-kartu']);
		$routes->get('get-kartu', 'TransaksiController::kartu', ['as' => 'info-trx-kartu']);
		$routes->post('submit-kartu', 'TransaksiController::kartu', ['as' => 'submit-trx-kartu']);
		$routes->get('create-kartu', 'TransaksiController::kartu_create', ['as' => 'tambah-trx-kartu']);
		$routes->post('store-kartu', 'TransaksiController::kartu_store', ['as' => 'simpan-trx-kartu']);
		$routes->get('edit-kartu/(:any)', 'TransaksiController::kartu_edit/$1', ['as' => 'edit-trx-kartu']);
		$routes->put('update-kartu/(:any)', 'TransaksiController::kartu_update/$1', ['as' => 'update-trx-kartu']);
	});
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
