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

	// Konter // ! belum
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
	// Transaksi // * done
	$routes->group('transaksi', function ($routes) {
		// * Rekap done
		$routes->get('rekap', 'TransaksiController::index', ['as' => 'transaksi-rekap']);
		$routes->post('rekap', 'TransaksiController::index', ['as' => 'trx-rekap']);
		// * Kartu done
		$routes->get('kartu', 'TransaksiController::kartu', ['as' => 'transaksi-kartu']);
		$routes->post('kartu', 'TransaksiController::kartu', ['as' => 'transaksi-kartu']);
		$routes->post('kartu-store', 'TransaksiController::kartu_store', ['as' => 'transaksi-kartu-store']);
		$routes->get('kartu/(:any)', 'TransaksiController::kartu_edit/$1', ['as' => 'transaksi-kartu-edit']);
		$routes->put('kartu-update/(:any)', 'TransaksiController::kartu_update/$1', ['as' => 'transaksi-kartu-update']);
		// * Acc done
		$routes->get('acc', 'TransaksiController::acc', ['as' => 'transaksi-acc']);
		$routes->post('acc', 'TransaksiController::acc', ['as' => 'transaksi-acc']);
		$routes->post('acc-store', 'TransaksiController::acc_store', ['as' => 'transaksi-acc-store']);
		$routes->get('acc/(:any)', 'TransaksiController::acc_edit/$1', ['as' => 'transaksi-acc-edit']);
		$routes->put('acc-update/(:any)', 'TransaksiController::acc_update/$1', ['as' => 'transaksi-acc-update']);
		// * Reseller done 
		$routes->get('reseller', 'TransaksiController::reseller', ['as' => 'transaksi-reseller']);
		$routes->post('reseller', 'TransaksiController::reseller', ['as' => 'transaksi-reseller']);
		$routes->post('reseller-store', 'TransaksiController::reseller_store', ['as' => 'transaksi-reseller-store']);
		$routes->delete('reseller-deleted/(:any)', 'TransaksiController::reseller_delete/$1', ['as' => 'transaksi-reseller-hapus']);
		// * Saldo
		$routes->get('saldo', 'TransaksiController::saldo', ['as' => 'transaksi-saldo']);
		$routes->post('saldo', 'TransaksiController::saldo', ['as' => 'transaksi-saldo']);
		$routes->post('saldo-store', 'TransaksiController::saldo_store', ['as' => 'trx-saldo-store']);
		$routes->get('saldo/(:any)', 'TransaksiController::saldo_edit/$1', ['as' => 'trx-saldo-edit']);
		$routes->put('saldo-update/(:any)', 'TransaksiController::saldo_update/$1', ['as' => 'trx-saldo-update']);
		$routes->delete('saldo-delete/(:any)', 'TransaksiController::saldo_delete/$1', ['as' => 'trx-saldo-delete']);
	});
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
