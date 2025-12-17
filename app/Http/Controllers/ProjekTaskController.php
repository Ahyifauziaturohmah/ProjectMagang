<?php

namespace App\Http\Controllers;

use App\Models\ProjekTask; // Pastikan nama modelnya benar
use App\Models\ProjekTaskSubmission;
use Illuminate\Http\Request;

class ProjekTaskController extends Controller
{
    public function updateUrl(Request $request, $id)
{
    $task = ProjekTask::findOrFail($id);
    $currentMemberId = auth()->user()->member->id ?? null;

    if ($task->member_id !== $currentMemberId) {
        return back()->with('error', 'Anda tidak diizinkan mengubah tugas anggota tim lain!');
    }
    
    ProjekTaskSubmission::updateOrCreate(
        ['task_id' => $id],
        [
            'member_id' => $task->member_id,
            'url'       => $request->url,
            'status'    => 'submitted'
        ]
    );

    return back();
}
}
