<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RekapController;

Route::get('/login', [AuthController::class, 'halaman_login'])->name('halaman_login');
Route::post('/login', [AuthController::class, 'aksi_login'])->name('aksi_login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() { 
    Route::get('/dashboard', [DashboardController::class, 'halaman_dashboard'])->name('halaman_dashboard');

    Route::get('/user', [UserController::class, 'halaman_user'])->name('halaman_user');
    Route::get('/user/tambah-user', [UserController::class, 'tambah_user'])->name('tambah_user');
    Route::post('/user/tambah-user/simpan', [UserController::class, 'simpan_user'])->name('simpan_user');
    Route::get('/user/edit-user/{user}', [UserController::class, 'edit_user'])->name('edit_user');
    Route::post('/user/update-user/{user}', [UserController::class, 'update_user'])->name('update_user');
    Route::delete('/user/hapus-user/{user}', [UserController::class, 'hapus_user'])->name('hapus_user');

    Route::get('/user', [UserController::class, 'halaman_user'])->name('halaman_user');
    Route::get('/user/tambah-user', [UserController::class, 'tambah_user'])->name('tambah_user');
    Route::post('/user/tambah-user/simpan', [UserController::class, 'simpan_user'])->name('simpan_user');
    Route::get('/user/edit-user/{user}', [UserController::class, 'edit_user'])->name('edit_user');
    Route::post('/user/update-user/{user}', [UserController::class, 'update_user'])->name('update_user');
    Route::delete('/user/hapus-user/{user}', [UserController::class, 'hapus_user'])->name('hapus_user');

    Route::get('/area', [AreaParkirController::class, 'halaman_area'])->name('halaman_area');
    Route::get('/area/tambah-area', [AreaParkirController::class, 'tambah_area'])->name('tambah_area');
    Route::post('/area/tambah-area/simpan', [AreaParkirController::class, 'simpan_area'])->name('simpan_area');
    Route::get('/area/edit-area/{area}', [AreaParkirController::class, 'edit_area'])->name('edit_area');
    Route::post('/area/update-area/{area}', [AreaParkirController::class, 'update_area'])->name('update_area');
    Route::delete('/area/hapus-area/{area}', [AreaParkirController::class, 'hapus_area'])->name('hapus_area');

    Route::get('/tarif', [TarifController::class, 'halaman_tarif'])->name('halaman_tarif');
    Route::get('/tarif/tambah-tarif', [TarifController::class, 'tambah_tarif'])->name('tambah_tarif');
    Route::post('/tarif/tambah-tarif/simpan', [TarifController::class, 'simpan_tarif'])->name('simpan_tarif');
    Route::get('/tarif/edit-tarif/{tarif}', [TarifController::class, 'edit_tarif'])->name('edit_tarif');
    Route::post('/tarif/update-tarif/{tarif}', [TarifController::class, 'update_tarif'])->name('update_tarif');
    Route::delete('/tarif/hapus-tarif/{tarif}', [TarifController::class, 'hapus_tarif'])->name('hapus_tarif');

    Route::get('/kendaraan', [KendaraanController::class, 'halaman_kendaraan'])->name('halaman_kendaraan');
    Route::get('/kendaraan/tambah-kendaraan', [KendaraanController::class, 'tambah_kendaraan'])->name('tambah_kendaraan');
    Route::post('/kendaraan/tambah-kendaraan/simpan', [KendaraanController::class, 'simpan_kendaraan'])->name('simpan_kendaraan');
    Route::get('/kendaraan/edit-kendaraan/{kendaraan}', [KendaraanController::class, 'edit_kendaraan'])->name('edit_kendaraan');
    Route::post('/kendaraan/update-kendaraan/{kendaraan}', [KendaraanController::class, 'update_kendaraan'])->name('update_kendaraan');
    Route::delete('/kendaraan/hapus-kendaraan/{kendaraan}', [KendaraanController::class, 'hapus_kendaraan'])->name('hapus_kendaraan');

    Route::get('/log', [LogAktivitasController::class, 'halaman_log'])->name('halaman_log');

    Route::get('/transaksi', [TransaksiController::class, 'halaman_transaksi'])->name('halaman_transaksi');
    Route::post('/transaksi/tambah-transaksi/simpan', [TransaksiController::class, 'simpan_transaksi'])->name('simpan_transaksi');
    Route::patch('/transaksi/update-transaksi/{transaksi}', [TransaksiController::class, 'update_transaksi'])->name('update_transaksi');

    Route::get('/rekap', [RekapController::class, 'halaman_rekap'])->name('halaman_rekap');
    Route::post('/rekap', [RekapController::class, 'cari_rekap'])->name('cari_rekap');
});