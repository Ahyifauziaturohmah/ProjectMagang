<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsappHelper;
use App\Models\Kelas;
use App\Models\Pengumpulan;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(){
        $data = Task::with('kelas')->orderBy('id')->get();
        return view('daftar_task')->with('data', $data);
    }
    public function create(){
        $item = null;
        $kelas = Kelas::all();
        return view('form_tambah_task', compact('item', 'kelas'));
    }
    public function show($id) {
        $task = Task::with('pengumpulan')->findOrFail($id);
        return view('daftar_pengumpulan', compact('task'));
    }
    public function submit($id) {
        $task = \App\Models\Task::findOrFail($id);
        return view('pengumpulan_magang', compact('task'));

        // $data = Task::with('pengumpulan')->findOrFail($id);
        // return view('pengumpulan_magang')->with('data', $data);
    }

    public function magang(){
        $user = Auth::user();
        $kelasId = Auth::user()->divisi->kelas_id ?? null;
        $data = Task::where('kelas_id', $kelasId)->with('kelas')->get();
        return view('list_task_magang')->with('data', $data);
    }
    
    public function store(Request $request)
    {
        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tenggat' => $request->tenggat,
            'kelas_id' => $request->kelas_id,
        ];
        
        $task = Task::create($data);

        $penerima = User::whereHas('divisi', function($query) use ($request) {
            $query->where('kelas_id', $request->kelas_id);
        })->with('contact')->get();

        foreach ($penerima as $user) {
            $nomorWa = $user->contact?->kontak;
            if ($nomorWa) {
                $pesan = "*TUGAS BARU*\n\n" .
                         "Halo *{$user->name}*,\n" .
                         "Ada tugas baru yang harus dikerjakan:\n\n" .
                         "*{$request->judul}*\n" .
                         "Tenggat: " . date('d M Y, H:i', strtotime($request->tenggat)) . "\n\n" .
                         "Semangat mengerjakannya!";
                
                WhatsappHelper::send($nomorWa, $pesan);
            }
        }

        return redirect()->route('task.index')->with('success', 'Tugas Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $item = Task::findOrFail($id);
        $kelas = Kelas::all();

        return view('form_tambah_task', compact('item', 'kelas'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tenggat' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $item = Task::findOrFail($id);

        $item->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tenggat' => $request->tenggat,
            'kelas_id' => $request->kelas_id,
        ]);
        
        return redirect()->route('task.index')->with('success', 'Tugas berhasil diperbarui!');
    }

   
    public function destroy($id)
    {
        $item = Task::findOrFail($id);
        
        $item->delete();

        return redirect()->route('task.index')->with('success', 'Tugas berhasil dihapus!');
    }


    public function submitTugas(Request $request, Task $task)
    {
        $request->validate([
            'tautan' => 'required|string|max:2048',
        ]);

        $user = Auth::user();
        $tautan = $request->input('tautan');

        $existing = Pengumpulan::updateOrCreate(
            ['user_id' => $user->id, 'task_id' => $task->id],
            ['tautan' => $tautan, 'evaluasi' => '']
        );

        $mentor = User::where('role', 'mentor')->with('contact')->first();

        if ($mentor && $mentor->contact?->kontak) {
            $pesan = "*PENGUMPULAN TUGAS*\n\n" .
                    "Halo Coach *{$mentor->name}*,\n" .
                    "Ada tugas baru yang dikumpulkan oleh anak magang.\n\n" .
                    "Nama: *{$user->name}*\n" .
                    "Tugas: *{$task->judul}*\n" .
                    "Link: {$tautan}\n\n" .
                    "Silakan dicek di dashboard mentor.";

            WhatsappHelper::send($mentor->contact->kontak, $pesan);
        }

        return redirect()->route('task.magang')->with('success', 'Tugas berhasil dikumpulkan!');
    }

    
}
