<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('signin', 'Auth::signIn');
$routes->post('signin', 'Auth::signInCheck');
$routes->get('signup', 'Auth::signUp');
$routes->post('signup', 'Auth::signUpCreate');
$routes->get('forgot', 'Auth::forgot');
$routes->post('forgot', 'Auth::forgotCheck');
$routes->get('reset/(:hash)', 'Auth::reset/$1');
$routes->post('reset/(:hash)', 'Auth::resetCheck/$1');
$routes->get('signout', 'Auth::signOut');
// $routes->post('/lgn', 'Auth::attempt_login');
// $routes->get('/lgt', 'Auth::logout');
// $routes->addRedirect('/', '/dsb');
// $routes->get('/jenis-biaya', 'JenisBiaya::index', ['filter' => 'login']);
// $routes->get('/jenis-biaya/all', 'JenisBiaya::all', ['filter' => 'login']);
// $routes->get('/jenis-biaya/(:num)', 'JenisBiaya::detail/$1', ['filter' => 'login']);
// $routes->put('/jenis-biaya/(:num)', 'JenisBiaya::edit/$1', ['filter' => 'login']);
// $routes->post('/jenis-biaya/add', 'JenisBiaya::add', ['filter' => 'login']);
// $routes->delete('/jenis-biaya/(:num)', 'JenisBiaya::delete/$1', ['filter' => 'login']);
// $routes->get('/tahun-pelajaran', 'TahunPelajaran::index', ['filter' => 'login']);
// $routes->get('/tahun-pelajaran/all', 'TahunPelajaran::all', ['filter' => 'login']);
// $routes->get('/tahun-pelajaran/(:num)', 'TahunPelajaran::detail/$1', ['filter' => 'login']);
// $routes->put('/tahun-pelajaran/(:num)', 'TahunPelajaran::edit/$1', ['filter' => 'login']);
// $routes->post('/tahun-pelajaran/add', 'TahunPelajaran::add', ['filter' => 'login']);
// $routes->delete('/tahun-pelajaran/(:num)', 'TahunPelajaran::delete/$1', ['filter' => 'login']);
// $routes->get('/siswa', 'Siswa::index', ['filter' => 'login']);
// $routes->get('/siswa/all', 'Siswa::all', ['filter' => 'login']);
// $routes->post('/siswa/import', 'Siswa::import', ['filter' => 'login']);
// $routes->get('/siswa/search', 'Siswa::searchSiswa', ['filter' => 'login']);
// $routes->get('/siswa/kelas', 'Siswa::kelas', ['filter' => 'login']);
// $routes->get('/siswa/(:num)', 'Siswa::detail/$1', ['filter' => 'login']);
// $routes->put('/siswa/(:num)', 'Siswa::edit/$1', ['filter' => 'login']);
// $routes->post('/siswa/add', 'Siswa::add', ['filter' => 'login']);
// $routes->post('/siswa/import', 'Siswa::import', ['filter' => 'login']);
// $routes->delete('/siswa/(:num)', 'Siswa::delete/$1', ['filter' => 'login']);
// $routes->get('/bayaran', 'Bayaran::index', ['filter' => 'login']);
// $routes->get('/bayaran/detail', 'Bayaran::detail', ['filter' => 'login']);
// $routes->put('/bayaran/edit', 'Bayaran::edit', ['filter' => 'login']);
// $routes->get('/bayaran/get-bayaran', 'Bayaran::getBayaran', ['filter' => 'login']);
// $routes->post('/bayaran/generate', 'Bayaran::generate', ['filter' => 'login']);
// $routes->delete('/bayaran', 'Bayaran::delete', ['filter' => 'login']);
// $routes->get('/transaksi', 'Transaksi::index', ['filter' => 'login']);
// $routes->put('/transaksi', 'Transaksi::edit', ['filter' => 'login']);
// $routes->get('/laporan', 'Laporan::index', ['filter' => 'login']);
// $routes->get('/laporan/export', 'Laporan::export', ['filter' => 'login']);
// $routes->get('/laporan/get-bayaran', 'Laporan::getBayaran', ['filter' => 'login']);
// $routes->get('/kartu', 'Kartu::index', ['filter' => 'login']);
// $routes->get('/kartu/print', 'Kartu::print', ['filter' => 'login']);

// $routes->get('/users', 'Users::index', ['filter' => 'login']);
// $routes->patch('/users/(:num)', 'Users::edit/$1', ['filter' => 'login']);
// $routes->post('/users', 'Users::add', ['filter' => 'login']);
// $routes->delete('/users/(:num)', 'Users::delete/$1', ['filter' => 'login']);
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
