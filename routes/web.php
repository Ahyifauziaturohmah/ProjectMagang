<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DetailPengumpulanController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PengumpulanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\TaskController;
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

Route::get('/tambah/task', [TaskController::class, 'create']);
Route::get('/mentor/task', [TaskController::class, 'index'])->name('laman.task');
Route::post('/tambah/task', [TaskController::class, 'store']);

Route::get('/mentor/task/pengumpulan/{id}', [PengumpulanController::class, 'show'])->name('task.pengumpulan');
Route::get('/mentor/task/pengumpulan/task/{task_id}', [PengumpulanController::class, 'byTask'])->name('task.pengumpulan.byTask');


Route::post('/mentor/task/pengumpulan/detail/{id}', [PengumpulanController::class, 'store'])->name('task.detail.pengumpulan.store');
Route::get('/task/pengumpulan/detail/{id}', [PengumpulanController::class, 'create'])->name('task.detail.pengumpulan');

Route::get('/magang/pengumuman', [PengumumanController::class, 'show']);

Route::get('/magang/task', [TaskController::class, 'magang'])->name('task.magang');

Route::get('/magang/task/pengumpulan/{id}', [TaskController::class, 'submit'])->name('task.submit');
Route::post('/magang/task/pengumpulan/{task}', [TaskController::class, 'submitTugas'])->name('task.submit');

Route::get('/login', function () {
    return view('login');
});


// Route::get('/magang/pengumuman', function () {
//     return view('pengumuman_magang');
// });


// Route::get('/tambah/task', function () {
//     return view('form_tambah_task');
// });

// Route::get('/magangdash', function () {
//     return view('magangdash');
// });