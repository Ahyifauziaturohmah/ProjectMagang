<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DetailPengumpulanController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PengumpulanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProjekController;
use App\Http\Controllers\ProjekMemberController;
use App\Http\Controllers\ProjekTaskController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


// Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index']);
    Route::post('/', [SesiController::class, 'login']);
// });
Route::get('/logout', [SesiController::class, 'logout']);
Route::get('send-wa', function () {
    $response = Http::withHeaders(['Authorization'=> 'WQEnJep54zBGDTNdEQLQ',
    ])->post('https://api.fonnte.com/send', [
        'target' => '083128467450',
        'message' => 'ini notif ',
    ]);
    dd(json_decode($response,true));
});


Route::middleware(['auth', 'mentor'])->group(function () {
    Route::get('/mentordash', [AdminController::class, 'mentor']);
    
    // User Management
    Route::get('/formmaganglist', [userController::class, 'create']);
    Route::get('/maganglist', [userController::class, 'index']);
    Route::post('/formmaganglist', [userController::class, 'store']);

    // Pengumuman Management
    Route::get('/form/pengumuman', [PengumumanController::class, 'create']);
    Route::get('/mentor/pengumuman', [PengumumanController::class, 'index']);
    Route::post('/form/pengumuman', [PengumumanController::class, 'store']);

    // Divisi Management
    Route::get('/form/divisi', [DivisiController::class, 'create']);
    Route::post('/form/divisi', [DivisiController::class, 'store'])->name('atur.divisi.store');

    // Task Management (Daftar Tugas)
    Route::get('/tambah/task', [TaskController::class, 'create'])->name('task.create'); 
    Route::post('/tambah/task', [TaskController::class, 'store'])->name('task.store');
    Route::get('/mentor/task', [TaskController::class, 'index'])->name('task.index'); 

    // Fungsionalitas Edit & Hapus Tugas 
    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');


    // Pengumpulan Task (untuk Mentor)
    Route::get('/mentor/task/pengumpulan/{id}', [PengumpulanController::class, 'show'])->name('task.pengumpulan');
    Route::get('/mentor/task/pengumpulan/task/{task_id}', [PengumpulanController::class, 'byTask'])->name('task.pengumpulan.byTask');
    Route::post('/mentor/task/pengumpulan/detail/{id}', [PengumpulanController::class, 'store'])->name('task.detail.pengumpulan.store');
    Route::get('/task/pengumpulan/detail/{id}', [PengumpulanController::class, 'create'])->name('task.detail.pengumpulan');

    //projek
    Route::get('/mentor/team/projek', [ProjekController::class, 'index']);
    Route::get('/mentor/form/team/projek', [ProjekController::class, 'create']);
    Route::post('/mentor/team/projek',[ProjekController::class, 'store'])->name('projek.store');
    Route::get('/mentor/detail/team/projek/{id}',[ProjekController::class, 'detail_projek']);
    Route::get('/mentor/team/role/{projek}',[ProjekMemberController::class, 'create'])->name('mentor.team.role.create');
    Route::get('/mentor/team/projek/{id}/add-task', [ProjekController::class, 'create_task_projek'])->name('mentor.projek.task.create');
    Route::post('/mentor/team/projek/{id}/add-task', [ProjekController::class, 'store_task_projek'])->name('mentor.projek.task.store');
    Route::get('/mentor/team/role/create/{id}', [ProjekController::class, 'create_role'])->name('mentor.team.role.create');
    Route::post('/mentor/team/role/store/{id}', [ProjekController::class, 'store_role'])->name('mentor.team.role.store');
    Route::patch('/mentor/task/{id}/status', [ProjekController::class, 'updateTaskStatus']) ->name('mentor.task.updateStatus');
    Route::patch('/mentor/task/update/{id}', [ProjekController::class, 'updateTaskStatus'])->name('task.update');
 

});

Route::middleware(['auth', 'magang'])->group(function () {
    Route::get('/magangdash', [AdminController::class, 'magang']);
    //Route::get('/magang/password',[userController::class])
    Route::get('/magang/password', [userController::class, 'editPassword'])->name('magang.password.edit');
    Route::patch('/magang/password', [userController::class, 'updatePassword'])->name('magang.password.update');

    Route::get('/magang/pengumuman', [PengumumanController::class, 'show']);

    Route::get('/magang/task', [TaskController::class, 'magang'])->name('task.magang');

    Route::get('/magang/task/pengumpulan/{id}', [TaskController::class, 'submit'])->name('task.submit');
    Route::post('/magang/task/pengumpulan/{task}', [TaskController::class, 'submitTugas'])->name('task.submit');

    Route::get('/magang/team/projek', [ProjekController::class, 'index_magang']);
    
    Route::get('/magang/detail/team/projek/{id}',[ProjekController::class, 'detail_projek_magang']);
    Route::post('/update-task-status/{id}', [ProjekController::class, 'quickUpdate'])->name('task.quickUpdate');

    Route::patch('/magang/projek-task/{id}/url', [ProjekTaskController::class, 'updateUrl'])->name('magang.projek-task.updateUrl');
});

Route::get('/admin', [AdminController::class, 'index']);


Route::get('/login', function () {
    return view('login');
});
