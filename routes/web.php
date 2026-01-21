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
    // Route untuk Edit (Menampilkan Form)
Route::get('/magang/edit/{id}', [userController::class, 'edit'])->name('magang.edit');

// Route untuk Proses Update (Action Form)
Route::put('/magang/update/{id}', [userController::class, 'update'])->name('magang.update');

// Route untuk Hapus
Route::delete('/magang/delete/{id}', [userController::class, 'destroy'])->name('magang.destroy');

    // Pengumuman Management
    Route::get('/form/pengumuman', [PengumumanController::class, 'create']);
    Route::get('/mentor/pengumuman', [PengumumanController::class, 'index']);
    Route::post('/form/pengumuman', [PengumumanController::class, 'store']);
    Route::get('/mentor/pengumuman/tambah', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::get('/mentor/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');

    // Eksekusi Data
    Route::post('/mentor/pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/mentor/pengumuman/{id}/update', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/mentor/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

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
    Route::get('/mentor/edit/team/projek/{id}', [ProjekController::class, 'edit']);
    Route::put('/mentor/update/team/projek/{id}', [ProjekController::class, 'update']);
    Route::delete('/mentor/delete/team/projek/{id}', [ProjekController::class, 'destroy']);
    Route::get('/mentor/detail/team/projek/{id}',[ProjekController::class, 'detail_projek']);

    Route::get('/mentor/team/projek/{id}/add-task', [ProjekTaskController::class, 'create'])->name('mentor.projek.task.create');
    Route::post('/mentor/team/projek/{id}/add-task', [ProjekTaskController::class, 'store'])->name('mentor.projek.task.store');
    Route::get('/mentor/task/{id}/edit', [ProjekTaskController::class, 'edit'])->name('mentor.task.edit');
    Route::put('/mentor/task/{id}', [ProjekTaskController::class, 'update'])->name('mentor.task.update');
    Route::delete('/mentor/task/{id}', [ProjekTaskController::class, 'destroy'])->name('mentor.task.destroy');
    Route::patch('/mentor/task/{id}/status', [ProjekTaskController::class, 'updateTaskStatus']) ->name('mentor.task.updateStatus');
    Route::patch('/mentor/task/update/{id}', [ProjekTaskController::class, 'updateTaskStatus'])->name('task.update.status');

    Route::get('/mentor/team/role/create/{id}', [ProjekMemberController::class, 'create'])->name('mentor.team.role.create');
    Route::post('/mentor/team/role/store/{id}', [ProjekMemberController::class, 'store'])->name('mentor.team.role.store');
    Route::delete('/mentor/member/{id}', [ProjekMemberController::class, 'destroy'])->name('mentor.member.destroy');
 

});

Route::middleware(['auth', 'magang'])->group(function () {
    Route::get('/magangdash', [AdminController::class, 'magang']);
    //Route::get('/magang/password',[userController::class])
    Route::get('/magang/password', [userController::class, 'editPassword'])->name('magang.password.edit');
    Route::patch('/magang/password', [userController::class, 'updatePassword'])->name('magang.password.update');

    Route::get('/magang/pengumuman', [PengumumanController::class, 'show']);

    Route::get('/magang/task', [TaskController::class, 'magang'])->name('task.magang');

    Route::get('/magang/task/pengumpulan/{id}', [TaskController::class, 'submit'])->name('task.submit');
    Route::post('/magang/task/pengumpulan/{task}', [TaskController::class, 'submitTugas'])->name('task.submit.store');

    Route::get('/magang/team/projek', [ProjekController::class, 'index_magang']);
    
    Route::get('/magang/detail/team/projek/{id}',[ProjekController::class, 'detail_projek_magang']);
    Route::post('/update-task-status/{id}', [ProjekTaskController::class, 'quickUpdate'])->name('task.quickUpdate');

    Route::patch('/magang/projek-task/{id}/url', [ProjekTaskController::class, 'updateUrl'])->name('magang.projek-task.updateUrl');
});

Route::get('/admin', [AdminController::class, 'index']);


Route::get('/login', function () {
    return view('login');
});
