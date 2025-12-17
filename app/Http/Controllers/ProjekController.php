<?php

namespace App\Http\Controllers;

use App\Models\Projek;
use App\Models\Kelas;
use App\Models\ProjekMember;
use App\Models\ProjekTask;
use App\Models\User;
use Illuminate\Http\Request;

class ProjekController extends Controller
{
    function index (){
        $projek = Projek::latest()->get();
        return view('team-projek_mentor', compact('projek'));
    }
    function create (){
        $kelas = Kelas::all();
        return view('form-team_mentor', [
            'kelas' => $kelas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required',
        'deskripsi' => 'required',
        'kelas_id' => 'required'
    ]);

    Projek::create([
        'nama' => $request->nama,
        'deskripsi' => $request->deskripsi,
        'kelas_id' => $request->kelas_id,
        'createBy' => auth()->id(),
    ]);

    return redirect('/mentor/team/projek')
        ->with('success', 'Projek berhasil ditambahkan');
    }

  
    public function create_task_projek($id) 
    {
        $projek = Projek::with('anggota.user')->findOrFail($id);
        
        return view('form-task-projek_mentor', compact('projek'));
    }

    public function store_task_projek(Request $request, $id)
    {
       
        if (!$id) {
            return "Error: Projek ID tidak ditemukan di URL";
        }

        try {
            foreach ($request->tasks as $taskData) {
                $task = new \App\Models\ProjekTask();
                $task->nama = $taskData['nama'];
                $task->projek_id = $id; 
                $task->member_id = $taskData['member_id'];
                $task->createBy = auth()->id();
                
                $task->save();
            }

            return redirect('/mentor/detail/team/projek/'.$id)
                ->with('success', 'Data berhasil masuk!');

        } catch (\Exception $e) {
            dd("GAGAL SIMPAN! Pesan Error: " . $e->getMessage());
        }
    }

    public function detail_projek($id)
    {
        $projek = Projek::with(['kelas', 'anggota.user', 'tasks'])->findOrFail($id);

        return view('detail-team_mentor', compact('projek'));
    }

    public function create_task($id) 
    {
        $projek = Projek::findOrFail($id);
        return view('form-task-projek_mentor', compact('projek'));
    }

    public function create_role($id)
    {
        
        $projek = Projek::findOrFail($id);
        $users = \App\Models\User::where('role', 'magang')->get();
        return view('form-role-team_mentor', compact('projek', 'users'));
    }

    public function store_role(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:leader,UI/UX,front-end,back-end,fullstack',
        ], [
            'role.in' => 'Role yang dipilih tidak valid. Pilih dari daftar yang tersedia.'
        ]);

        \App\Models\ProjekMember::create([
            'projek_id' => $id,
            'user_id' => $request->user_id,
            'role' => $request->role,
        ]);

        return redirect('/mentor/detail/team/projek/'.$id)
            ->with('success', 'Anggota dan Role berhasil ditambahkan.');
    }

    public function updateTaskStatus(Request $request, $id)
    {
        $request->validate([
        'status' => 'required|in:submitted,approved,revisi'
    ]);

    $task = \App\Models\ProjekTask::findOrFail($id);

    \App\Models\ProjekTaskSubmission::updateOrCreate(
        ['task_id' => $id],
        [
            'member_id' => $task->member_id,
            'status'    => $request->status,
        ]
    );

    return back()->with('success', 'Status berhasil diperbarui!');
    }

    function index_magang (){
        $projek = Projek::whereHas('members', function($query) {
        $query->where('user_id', auth()->id());
    })->get();
        return view('team-projek_magang', compact('projek'));
    }

    function detail_projek_magang ($id){
        $projek = Projek::with(['kelas', 'anggota.user', 'tasks'])->findOrFail($id);
        return view('detail-team_magang', compact('projek'));
    }

    public function quickUpdate(Request $request, $id)
    {
        $task = \App\Models\ProjekTask::findOrFail($id);
        $memberId = $task->member_id;
        $newStatus = $request->status;

        \App\Models\ProjekTaskSubmission::updateOrCreate(
            ['task_id' => $id],
            [
                'member_id' => $memberId,
                'status'    => $newStatus,
                'url'       => $task->submission->url ?? null 
            ]
        );

        return back()->with('success', 'Status diperbarui!');
    }
}
