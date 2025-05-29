<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\peminjamController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\kaunitController;
use App\Http\Controllers\AuthController;

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
//SECTION - PEMINJAM ------------------------------------------------------------------------------
// Rute untuk peminjam (akses tanpa login)

Route::get('peminjam_beranda', 'peminjamController@peminjam_beranda');
Route::get('/', 'peminjamController@peminjam_beranda');
Route::get('peminjaman_perlengkapan', 'peminjamController@peminjaman_perlengkapan');

//peminjaman ruang / kapel
Route::get('peminjaman_kapel', 'peminjamController@peminjaman_kapel');
Route::get('/peminjaman_kapel/peminjaman_kapel_formadd/{id_ruang}', 'peminjamController@peminjaman_kapel_formadd');
Route::post('/peminjaman_kapel/save_peminjaman_kapel', 'peminjamController@save_peminjaman_kapel');
Route::get('/peminjaman_kapel/detail_peminjaman_kapel/{id_ruang}', 'peminjamController@detail_peminjaman_kapel');

//peminjaman perlengkapan 
Route::get('peminjaman_perlengkapan', 'peminjamController@peminjaman_perlengkapan');
Route::post('/peminjaman_perlengkapan/kirimKeFormPeminjaman', 'peminjamController@kirimKeFormPeminjaman');
Route::get('/peminjaman_perlengkapan/peminjaman_perlengkapan_formadd', 'peminjamController@peminjaman_perlengkapan_formadd');
Route::post('/peminjaman_perlengkapan/save_peminjaman_perlengkapan', 'peminjamController@save_peminjaman_perlengkapan');
Route::get('/peminjaman_perlengkapan/detail_peminjaman_perlengkapan/{id_peminjaman_pkp}', 'peminjamController@detail_peminjaman_perlengkapan');


Route::get('peminjam_daftar_riwayat_peminjaman', 'peminjamController@peminjam_daftar_riwayat_peminjaman');

//SECTION - LOGIN ----------------------------------------------------------------------------------
// Rute untuk otentikasi (login, registrasi, reset password)
Route::get('login', 'AuthController@showLoginForm')->name('login');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->name('logout');
Route::get('register', 'AuthController@showRegistrationForm')->name('register');
Route::post('register', 'AuthController@register');
Route::get('reset-password/{token}', 'AuthController@showResetForm');
Route::post('reset-password', 'AuthController@reset');
Route::get('forgot-password', 'AuthController@showLinkRequestForm');
Route::post('forgot-password', 'AuthController@sendResetLinkEmail');

// Ubah Password
Route::get('ubah_password', 'AuthController@ubah_password');
Route::post('update_password', 'AuthController@update_password');



//NEW SECTION - STAFF --------------------------------------------------------------------------------
Route::group(['middleware' => ['auth', 'role:staff|kaunit']], function () {

    Route::get('/staff_beranda', 'staffController@staff_beranda');
    Route::group(['middleware' => ['cekbagian:staff_keuangan_dan_pengadaan']], function () {
    //Kelola Data Kategori 
    Route::get('/staff_daftar_kategori', 'staffController@staff_daftar_kategori');
    Route::get('/staff_daftar_kategori/s_kategori_formadd', 'staffController@s_kategori_formadd');
    Route::post('/staff_daftar_kategori/save_kategori', 'staffController@save_kategori');
    Route::get('/staff_daftar_kategori/s_kategori_formedit/{id_kategori}', 'staffController@s_kategori_formedit');
    Route::put('/staff_daftar_kategori/update_kategori/{id_kategori}', 'staffController@update_kategori');
    Route::get('/staff_daftar_kategori/delete_kategori/{id_kategori}', 'staffController@delete_kategori');

    //Kelola Data Kapel / Ruang 
    Route::get('staff_daftar_ruang', 'staffController@staff_daftar_ruang');
    Route::get('/staff_daftar_ruang/s_ruang_formadd', 'staffController@s_ruang_formadd');
    Route::post('/staff_daftar_ruang/save_ruang', 'staffController@save_ruang');
    Route::get('/staff_daftar_ruang/s_ruang_formedit/{id_ruang}', 'staffController@s_ruang_formedit');
    Route::put('/staff_daftar_ruang/update_ruang/{id_ruang}', 'staffController@update_ruang');
    Route::get('/staff_daftar_ruang/delete_ruang/{id_ruang}', 'staffController@delete_ruang');

    //Kelola Data Perlengkapan
    Route::get('staff_daftar_perlengkapan', 'staffController@staff_daftar_perlengkapan');
    Route::get('/staff_daftar_perlengkapan/search', 'staffController@search');
    Route::get('/staff_daftar_perlengkapan/s_perlengkapan_formadd', 'staffController@s_perlengkapan_formadd');
    Route::post('/staff_daftar_perlengkapan/save_perlengkapan', 'staffController@save_perlengkapan');
    Route::get('/staff_daftar_perlengkapan/s_perlengkapan_formedit/{id_perlengkapan}', 'staffController@s_perlengkapan_formedit');
    Route::put('/staff_daftar_perlengkapan/update_perlengkapan/{id_perlengkapan}', 'staffController@update_perlengkapan');
    Route::get('/staff_daftar_perlengkapan/delete_perlengkapan/{id_perlengkapan}', 'staffController@delete_perlengkapan');

    //Kelola Data Usulan Pengadaan 
    Route::get('staff_usulan_pengadaan', 'staffController@staff_usulan_pengadaan');
    Route::get('/staff_usulan_pengadaan/staff_pengadaan_formadd', 'staffController@staff_pengadaan_formadd');
    Route::post('/staff_usulan_pengadaan/save_pengadaan', 'staffController@save_pengadaan');
    Route::get('/staff_usulan_pengadaan/staff_pengadaan_formedit/{id_usulan_pengadaan}', 'staffController@staff_pengadaan_formedit');
    Route::put('/staff_usulan_pengadaan/update_pengadaan/{id_usulan_pengadaan}', 'staffController@update_pengadaan');
    Route::delete('/staff_usulan_pengadaan/delete_pengadaan/{id_usulan_pengadaan}', 'staffController@delete_pengadaan');

    //Kelola Data Usulan Perbaikan
    Route::get('staff_usulan_perbaikan', 'staffController@staff_usulan_perbaikan');
    Route::get('/staff_usulan_perbaikan/staff_perbaikan_formadd', 'staffController@staff_perbaikan_formadd');
    Route::post('/staff_usulan_perbaikan/save_perbaikan', 'staffController@save_perbaikan');
    Route::get('/staff_usulan_perbaikan/staff_perbaikan_formedit/{id_usulan_perbaikan}', 'staffController@staff_perbaikan_formedit');
    Route::put('/staff_usulan_perbaikan/update_perbaikan/{id_usulan_perbaikan}', 'staffController@update_perbaikan');
    Route::delete('/staff_usulan_perbaikan/delete_perbaikan/{id_usulan_perbaikan}', 'staffController@delete_perbaikan');

    //Kelola Data Usulan Penghapusanj
    Route::get('staff_usulan_penghapusan', 'staffController@staff_usulan_penghapusan');
    Route::get('/staff_usulan_penghapusan/staff_penghapusan_formadd', 'staffController@staff_penghapusan_formadd');
    Route::post('/staff_usulan_penghapusan/save_penghapusan', 'staffController@save_penghapusan');
    Route::get('/staff_usulan_penghapusan/staff_penghapusan_formedit/{id_usulan_penghapusan}', 'staffController@staff_pengadaanpenghapusan_formedit');
    Route::put('/staff_usulan_penghapusan/update_penghapusan/{id_usulan_penghapusan}', 'staffController@update_penghapusan');
    Route::get('/staff_usulan_penghapusan/delete_penghapusan/{id_usulan_penghapusan}', 'staffController@delete_penghapusan');
      });

    //Approval Peminjaman 
    Route::get('staff_peminjaman_kapel', 'staffController@staff_peminjaman_kapel');
    Route::get('/staff_peminjaman_kapel/form_validasi_peminjaman_kapel/{peminjaman}', 'staffController@form_validasi_peminjaman_kapel');
    Route::put('/staff_peminjaman_kapel/save_validasi_peminjaman_kapel/{peminjaman}', 'staffController@save_validasi_peminjaman_kapel');

    //Approval Perlengkapan
    Route::get('staff_peminjaman_perlengkapan', 'staffController@staff_peminjaman_perlengkapan');
    Route::get('/staff_peminjaman_perlengkapan/form_validasi_peminjaman_perlengkapan/{peminjaman}', 'staffController@form_validasi_peminjaman_perlengkapan');
    Route::put('/staff_peminjaman_perlengkapan/save_validasi_peminjaman_perlengkapan/{peminjaman}', 'staffController@save_validasi_peminjaman_perlengkapan');

    //Pengembalian Ruang 
    Route::get('staff_pengembalian_kapel', 'staffController@staff_pengembalian_kapel');
    Route::get('/staff_pengembalian_kapel/form_pengembalian_kapel/{id_peminjaman_kapel}', 'staffController@form_pengembalian_kapel');
    Route::put('/staff_pengembalian_kapel/save_pengembalian_kapel/{peminjaman}', 'staffController@save_pengembalian_kapel');
    Route::put('/staff_pengembalian_kapel/update_status_pengembalian_kapel/{id_sesi_kapel}', 'staffController@update_status_pengembalian_kapel');
    Route::patch('/batalkan_sesi_kapel/{id_sesi_kapel}', 'staffController@batalkan_sesi_kapel');



    //Pengembalian Perlengkapan
    Route::get('staff_pengembalian_pkp', 'staffController@staff_pengembalian_pkp');
    //Route::put('/sesi_pkp/{id_sesi_pkp}/status', 'staffController@ubah_status_sesi');

// Tampilkan form pengembalian untuk peminjaman tertentu
Route::get('/staff_pengembalian_pkp/form_pengembalian_pkp/{id_peminjaman_pk}', 'staffController@form_pengembalian_pkp');

// Proses update status pengembalian per sesi
Route::put('/staff_pengembalian_pkp/update_status_pengembalian_pkp/{id_sesi_pkp}', 'staffController@update_status_pengembalian_pkp');
Route::patch('/batalkan_sesi_pkp/{id_sesi_pkp}', 'staffController@batalkan_sesi_pkp');


});



//NEW SECTION - KEPALA UNIT ---------------------------------------------------------------------------
Route::group(['middleware' => ['auth', 'role:kaunit']], function () {
    //Route::get('kaunit_daftar_kapel', 'KaunitController@kaunit_daftar_kapel');
     Route::get('kaunit_beranda', 'kaunitController@kaunit_beranda');
    Route::get('kaunit_daftar_kapel', 'kaunitController@kaunit_daftar_kapel');
    Route::get('kaunit_daftar_perlengkapan', 'kaunitController@kaunit_daftar_perlengkapan');
    Route::get('kaunit_daftar_user', 'kaunitController@kaunit_daftar_user');
    // Kelola Approval Usulan Pengadaan
    Route::get('kaunit_usulan_pengadaan', 'kaunitController@kaunit_usulan_pengadaan');
    Route::get('/kaunit_usulan_pengadaan/form_validasi_pengadaan/{pengadaan}', 'kaunitController@form_validasi_pengadaan');
    Route::put('/kaunit_usulan_pengadaan/save_validasi_pengadaan/{pengadaan}', 'KaunitController@save_validasi_pengadaan');

    // Kelola  Approval Usulan Perbaikan
    Route::get('kaunit_usulan_perbaikan', 'kaunitController@kaunit_usulan_perbaikan');
    Route::get('/kaunit_usulan_perbaikan/form_validasi_perbaikan/{perbaikan}', 'kaunitController@form_validasi_perbaikan');
    Route::put('/kaunit_usulan_perbaikan/save_validasi_perbaikan/{perbaikan}', 'KaunitController@save_validasi_perbaikan');

    // Kelola untuk Approval Usulan Penghapusan
    Route::get('kaunit_usulan_penghapusan', 'kaunitController@kaunit_usulan_penghapusan');
    Route::get('/kaunit_usulan_penghapusan/form_validasi_penghapusan/{penghapusan}', 'kaunitController@form_validasi_penghapusan');
    Route::put('/kaunit_usulan_penghapusan/save_validasi_penghapusan/{penghapusan}', 'KaunitController@save_validasi_penghapusan');
    
    Route::get('/kaunit/create_user', 'KaunitController@createUserForm');
    Route::post('/kaunit/create_user', 'KaunitController@storeUser');
      Route::get('/kaunit_daftar_user/delete_user/{id}', 'kaunitController@delete_user');

});


