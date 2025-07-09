<?php

namespace App\Http\Controllers;

use App\Models\Pengumpulan;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function submit($id) {
        $data = Task::with('pengumpulan')->findOrFail($id);
        return view('pengumpulan_magang')->with('data', $data);
    }

    public function magang(){
        $user = Auth::user();
        $kelasId = Auth::user()->divisi->kelas_id ?? null;
        $data = Task::where('kelas_id', $kelasId)->with('kelas')->get();
        return view('list_task_magang')->with('data', $data);
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

    public function submitTugas(Request $request, Task $task)
{
    $request->validate([
        'tautan' => 'required|string|max:2048',
    ]);

    $tautan = $request->input('tautan');

    $existing = Pengumpulan::where('user_id', Auth::id())
                           ->where('task_id', $task->id)
                           ->first();

    if ($existing) {
        $existing->update([
            'tautan' => $tautan,
        ]);
    } else {
        Pengumpulan::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'tautan' => $tautan,
            'evaluasi' => '',
        ]);
    }

    return redirect()->route('task.magang')->with('success', 'Tugas berhasil dikumpulkan!');
}


}
