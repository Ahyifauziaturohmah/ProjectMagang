<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index']);
    Route::post('/', [SesiController::class, 'login']);
// });


Route::get('/admin', [AdminController::class, 'index']);
Route::get('/mentordash', [AdminController::class, 'mentor']);
Route::get('/magangdash', [AdminController::class, 'magang']);
Route::get('/logout', [SesiController::class, 'logout']);
Route::get('/formmaganglist', [userController::class, 'create']);
Route::get('/maganglist', [userController::class, 'index']);
Route::post('/formmaganglist', [userController::class, 'store']);

Route::get('/form/pengumuman', [PengumumanController::class, 'create']);
Route::get('/mentor/pengumuman', [PengumumanController::class, 'index']);
Route::post('/form/pengumuman', [PengumumanController::class, 'store']);

Route::get('/form/divisi', [DivisiController::class, 'create']);
Route::post('/form/divisi', [DivisiController::class, 'store'])->name('atur.divisi.store');


Route::get('/login', function () {
    return view('login');
});

// Route::get('/form/Divisi', [])
// Route::get('/form/divisi', function () {
//     return view('form_atur_divisi');
// });

// Route::get('/form/pengumuman', function () {
//     return view('form_pengumuman');
// });
// Route::get('/mentordash', function () {
//     return view('mentordash');
// });

// Route::get('/magangdash', function () {
//     return view('magangdash');
// });