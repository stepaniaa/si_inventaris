<?php

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
    return view('welcome');
});

//User - Peminjam ------------------------------------------------------------------------------------------
Route::get('home_user', 'PageController@home_user');
Route::get('peminjam_home', 'PageController@peminjam_home');

//Staff LPKKSK  ------------------------------------------------------------------------------------------
Route::get('staff_home', 'PageController@staff_home');
Route::get('staff_daftar_kategori', 'PageController@staff_daftar_kategori');
Route::get('staff_daftar_ruang', 'PageController@staff_daftar_ruang');
Route::get('staff_daftar_barang', 'PageController@staff_daftar_barang');
Route::get('staff_pengadaan', 'PageController@staff_pengadaan');
Route::get('staff_perbaikan', 'PageController@staff_perbaikan');
Route::get('staff_penghapusan', 'PageController@staff_penghapusan');
Route::get('staff_daftar_peminjaman', 'PageController@staff_daftar_peminjaman');
Route::get('staff_pengajuan_peminjaman', 'PageController@staff_pengajuan_peminjaman');