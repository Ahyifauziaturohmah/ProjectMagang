<?php

namespace App\Http\Controllers;

use App\Models\Projek;
use App\Models\ProjekTask; // Pastikan nama modelnya benar
use App\Models\ProjekTaskSubmission;
use Illuminate\Http\Request;

class ProjekTaskController extends Controller
{
    public function create($id) 
    {
        $projek = Projek::with('anggota.user')->findOrFail($id);
        
        return view('form-task-projek_mentor', compact('projek'));
    }
    public function store(Request $request, $id)
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

            return redirect()->to('/mentor/detail/team/projek/' . $id)
                 ->with('success', 'Semua task berhasil disimpan!');
        } catch (\Exception $e) {
            dd("GAGAL SIMPAN! Pesan Error: " . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $task = \App\Models\ProjekTask::findOrFail($id);
        $projek = \App\Models\Projek::with('anggota.user')->findOrFail($task->projek_id);
        return view('form-task-projek_mentor', compact('task', 'projek'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'member_id' => 'required'
        ]);

        $task = \App\Models\ProjekTask::findOrFail($id);
        $task->update([
            'nama' => $request->nama,
            'member_id' => $request->member_id,
        ]);

        return redirect('/mentor/detail/team/projek/' . $task->projek_id)->with('success', 'Task berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $task = \App\Models\ProjekTask::findOrFail($id);
        $task->delete();
        return back()->with('success', 'Task berhasil dihapus!');
    }
    public function updateTaskStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:submitted,approved,revisi'
        ]);

        $task = \App\Models\ProjekTask::with(['member.user.contact', 'projek'])->findOrFail($id);

        \App\Models\ProjekTaskSubmission::updateOrCreate(
            ['task_id' => $id],
            [
                'member_id' => $task->member_id,
                'status'    => $request->status,
            ]
        );

        $userMagang = $task->member->user;
        $nomorWa = $userMagang->contact?->kontak;

        if ($nomorWa) {
            $namaProjek = $task->projek->nama ?? 'Projek Tim';
            
            if ($request->status == 'approved') {
                $pesan = "*TASK DISETUJUI (APPROVED)*\n\n" .
                        "Halo *{$userMagang->name}*,\n" .
                        "Ada kabar baik! Task kamu telah disetujui oleh mentor.\n\n" .
                        "*Projek:* {$namaProjek}\n" .
                        "*Task:* {$task->nama}\n\n" .
                        "Mantap! Silakan lanjut ke task berikutnya ya.";
            } elseif ($request->status == 'revisi') {
                $pesan = "*PERLU REVISI*\n\n" .
                        "Halo *{$userMagang->name}*,\n" .
                        "Task kamu di projek *{$namaProjek}* perlu diperbaiki.\n\n" .
                        "*Task:* {$task->nama}\n" ;
            }

            if (isset($pesan)) {
                \App\Helpers\WhatsappHelper::send($nomorWa, $pesan);
            }
        }

        return back()->with('success', 'Status berhasil diperbarui');
    }
    public function quickUpdate(Request $request, $id)
    {
        $task = \App\Models\ProjekTask::findOrFail($id);
        
        $submission = \App\Models\ProjekTaskSubmission::where('task_id', $id)->first();
        
        if($submission) {
            $submission->update(['status' => $request->status]);
        } else {
            \App\Models\ProjekTaskSubmission::create([
                'task_id' => $id,
                'member_id' => $task->member_id,
                'status' => $request->status,
                'url' => null
            ]);
        }

        if ($request->status == 'approved') {
            $userMagang = $task->member->user;
            if ($userMagang->contact?->kontak) {
                $pesan = "✅ *TASK APPROVED*\n\n" .
                        "Halo *{$userMagang->name}*,\n" .
                        "Task *{$task->nama}* di projek tim telah disetujui oleh mentor!";
                
                \App\Helpers\WhatsappHelper::send($userMagang->contact->kontak, $pesan);
            }
        }

        return back();
    }

    public function updateUrl(Request $request, $id)
    {
        $task = \App\Models\ProjekTask::with('projek')->findOrFail($id);
        
        $submission = \App\Models\ProjekTaskSubmission::updateOrCreate(
            ['task_id' => $id],
            [
                'member_id' => $task->member_id,
                'url' => $request->url,
                'status' => 'submitted'
            ]
        );

        $mentor = \App\Models\User::where('role', 'mentor')->with('contact')->first();
        if ($mentor && $mentor->contact?->kontak) {
            $namaProjek = $task->projek->nama ?? 'Projek Tidak Diketahui';
            
            $pesan = "*UPDATE TASK PROJEK*\n\n" .
                    "Halo Coach, ada update link tugas baru!\n\n" .
                    "*Projek:* {$namaProjek}\n" .
                    "*Task:* {$task->nama}\n" .
                    "*Oleh:* " . auth()->user()->name . "\n" .
                    "*Link:* {$request->url}\n\n" .
                    "Silakan dicek ya Coach!";
            
            \App\Helpers\WhatsappHelper::send($mentor->contact->kontak, $pesan);
        }

        return back()->with('success', 'URL berhasil disimpan!');
    }
}
