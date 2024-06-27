<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Page
Route::group(['middleware' => ['auth', 'role:superadministrator|owner']], function () {
	Route::get('/dashboard', 'PageController@pageDashboard');
});
Route::group(['middleware' => ['auth', 'role:superadministrator|owner|karyawan']], function () {
	Route::get('/barang', 'PageController@pageBarang');
	Route::get('/persediaan', 'PageController@pagePersediaan');
	Route::get('/pembelian', 'PageController@pagePembelian');
});
Route::group(['middleware' => ['auth', 'role:superadministrator|owner|karyawan|kasir']], function () {
	Route::get('/penjualan', 'PageController@pagePenjualan');
	Route::get('/penjualan/transaksi', 'PageController@pageTransaksi');
});



// Table

Route::get('/table/barang', 'BarangController@index')->name('tableBarang');
Route::get('/table/persediaan', 'PersediaanController@index')->name('tablePersediaan');
Route::get('/table/pembelian', 'PembelianController@index')->name('tablePembelian');
Route::get('/table/penjualan', 'TransaksiController@index')->name('tablePenjualan');

// Modal

Route::get('/modal','ModalController@modal')->name('modal');

// Crud
Route::match(['post','patch','delete'], '/barang/crud','BarangController@BarangCrud')->name('barang_crud');
Route::match(['post','patch','delete'], '/persediaan/crud','PersediaanController@PersediaanCrud')->name('persediaan_crud');
Route::match(['post','patch','delete'], '/pembelian/crud','PembelianController@PembelianCrud')->name('pembelian_crud');

// Post 
Route::post('/post/transaction', 'TransaksiController@postTransaction');

// Grafik

Route::get('/grafik/laba-rugi','DashboardController@LabaRugi')->name('LabaRugi');
Route::get('/grafik/barang','DashboardController@Barang')->name('Barang');

// Extends Functionn

Route::get('/getBarang', 'BarangController@getBarang');
Route::match(['post','patch','delete'], '/barang/update-stok','BarangController@updateStokBarang')->name('updateStokBarang');
Route::match(['post','patch','delete'], '/persediaan/update-stok','PersediaanController@updateStokPersediaan')->name('updateStokPersediaan');
Route::get('/struk', 'TransaksiController@struk');
