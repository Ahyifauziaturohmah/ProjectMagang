<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $data = Task::with('kelas')->orderBy('id')->get();
        return view('daftar_task')->with('data', $data);
    }
    public function create(){
        return view('form_tambah_task');
    }
    public function show($id) {
        $task = Task::with('pengumpulan')->findOrFail($id);
        return view('daftar_pengumpulan', compact('task'));
    }
    

    public function store(Request $request){
        $data = [
            'judul'=>$request->judul,
            'deskripsi'=>$request->deskripsi,
            'tenggat'=>$request->tenggat,
            'kelas_id'=>$request->kelas_id,

        ];
        Task::create($data);
        return redirect()->to('mentor/task')->with('success','Pengumuman Berhasil Ditambahkan');
    }
}
