<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;

// Halaman welcome (opsional)
Route::get('/', function () {
    return view('auth.login');
});

// Halaman login
Route::get('/login', [AuthController::class, 'index'])->name('login');

// Proses login (dummy)
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Dashboard (admin / warga sesuai role)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//pages
Route::get('/arsip', [MenuController::class, 'arsip'])->name('arsip');
Route::get('/jadwal', [MenuController::class, 'jadwal'])->name('jadwal');
Route::get('/peraturan', [MenuController::class, 'peraturan'])->name('peraturan');
Route::get('/kegiatan-sosial', [MenuController::class, 'sosial'])->name('sosial');
Route::get('/data-penduduk', [MenuController::class, 'penduduk'])->name('penduduk');
Route::get('/antrian', [MenuController::class, 'antrian'])->name('antrian');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/jadwal/store', [MenuController::class, 'storeJadwal'])->name('jadwal.store');
Route::post('/antrian/store', [MenuController::class, 'storeAntrian'])->name('antrian.store');

//crud arsip
Route::post('/arsip/store', [MenuController::class, 'storeArsip'])->name('arsip.store');
Route::get('/arsip/delete/{id}', [MenuController::class, 'deleteArsip'])->name('arsip.delete');
Route::post('/arsip/update', [MenuController::class, 'updateArsip'])->name('arsip.update');

//peraturan
Route::get('/peraturan', [MenuController::class, 'peraturan'])->name('peraturan');
Route::post('/peraturan/store', [MenuController::class, 'storePeraturan'])->name('peraturan.store');
Route::post('/peraturan/update', [MenuController::class, 'updatePeraturan'])->name('peraturan.update');
Route::get('/peraturan/delete/{id}', [MenuController::class, 'deletePeraturan'])->name('peraturan.delete');

// Print all peraturan to PDF
Route::get('/peraturan/print-all', [MenuController::class, 'printAllPeraturan'])->name('peraturan.printAll');

// kegiatan sosial
Route::get('/kegiatan-sosial', [MenuController::class, 'sosial'])->name('sosial');
Route::post('/kegiatan-sosial/store', [MenuController::class, 'storeSosial'])->name('sosial.store');
Route::post('/kegiatan-sosial/update', [MenuController::class, 'updateSosial'])->name('sosial.update');
Route::get('/kegiatan-sosial/delete/{id}', [MenuController::class, 'deleteSosial'])->name('sosial.delete');
Route::get('/kegiatan-sosial/print', [MenuController::class, 'printSosial'])->name('sosial.print');
Route::get('/kegiatan-sosial/stats', [MenuController::class, 'sosialStats'])->name('sosial.stats');