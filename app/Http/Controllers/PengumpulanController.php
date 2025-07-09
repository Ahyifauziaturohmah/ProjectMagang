<?php

namespace App\Http\Controllers;

use App\Models\Pengumpulan;
use App\Models\Task;
use Illuminate\Http\Request;

class PengumpulanController extends Controller
{
    public function index(){
        $data = Pengumpulan::with('user','task')->orderBy('id')->get();
        return view('daftar_pengumpulan')->with('data', $data);
    }
    public function create($id){
        $data = Pengumpulan::with(['user', 'task.kelas'])->findOrFail($id);
        return view('form_evaluasi', compact('data'));
    }
    public function show($id) {
        $pengumpulan = Pengumpulan::findOrFail($id);
        $data = [$pengumpulan];
        return view('daftar_pengumpulan', compact('data'));
    }
    public function submit($task_id) {
        $task = Task::with('pengumpulans')->findOrFail($task_id);
        return view('pengumpulan_magang')->with('task', $task);
    }

    public function byTask($task_id) {
        $data = Pengumpulan::with('user', 'task')
            ->where('task_id', $task_id)
            ->get();

        return view('daftar_pengumpulan', compact('data'));
    }


    public function store(Request $request, $id)
    {
        $request->validate([
            'evaluasi' => 'required|string|max:5000',
        ]);

        $pengumpulan = Pengumpulan::findOrFail($id);
        $pengumpulan->evaluasi = $request->evaluasi;
        $pengumpulan->save();

        return redirect()->route('laman.task', ['id' => $pengumpulan->task_id])
                        ->with('success', 'Evaluasi berhasil disimpan');
    }

    


    
}
