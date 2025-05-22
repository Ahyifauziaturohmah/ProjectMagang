<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index']);
    Route::post('/', [SesiController::class, 'login']);
// });


Route::get('/admin', [AdminController::class, 'index']);
Route::get('/mentordash', [AdminController::class, 'mentor']);
Route::get('/magangdash', [AdminController::class, 'magang']);
Route::get('/logout', [SesiController::class, 'logout']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/maganglist', function () {
    return view('maganglist');
});

Route::get('/formmaganglist', function () {
    return view('formmaganglist');
});
// Route::get('/mentordash', function () {
//     return view('mentordash');
// });

// Route::get('/magangdash', function () {
//     return view('magangdash');
// });