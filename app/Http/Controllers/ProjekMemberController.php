<?php

namespace App\Http\Controllers;

use App\Models\Projek;
use App\Models\ProjekMember;
use App\Models\User;
use Illuminate\Http\Request;

class ProjekMemberController extends Controller
{
    
    public function create($id)
    {
        
        $projek = Projek::findOrFail($id);
        $users = \App\Models\User::where('role', 'magang')->get();
        return view('form-role-team_mentor', compact('projek', 'users'));
    }

    public function store(Request $request, $id)
    {
        
        // dd($request->all());
        // 1. Validasi data array members
        $request->validate([
            'members' => 'required|array',
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.role' => 'required|in:leader,UI/UX,front-end,back-end,fullstack',
        ]);

        // Ambil data projek sekali saja di luar loop untuk efisiensi
        $projek = \App\Models\Projek::findOrFail($id);

        foreach ($request->members as $item) {
            // 2. Simpan atau Update data anggota ke database
            $member = \App\Models\ProjekMember::updateOrCreate(
                [
                    'projek_id' => $id,
                    'user_id'   => $item['user_id']
                ],
                [
                    'role' => $item['role']
                ]
            );

            // 3. Ambil data User beserta kontaknya untuk kirim WA
            $user = \App\Models\User::with('contact')->find($item['user_id']);

            if ($user && $user->contact?->kontak) {
                $nomorTarget = $user->contact->kontak;
                
                $pesan = "*UNDANGAN PROJEK BARU*\n\n" .
                        "Halo *{$user->name}*,\n" .
                        "Kamu telah ditunjuk untuk bergabung dalam projek tim:\n\n" .
                        "*Projek:* {$projek->nama}\n" .
                        "*Role:* {$item['role']}\n\n" .
                        "Silakan koordinasi dengan anggota tim lainnya di dashboard. Semangat!";

                // Kirim notifikasi per orang
                \App\Helpers\WhatsappHelper::send($nomorTarget, $pesan);
            }
        }
        

        return redirect('/mentor/detail/team/projek/'.$id)
            ->with('success', 'Semua anggota dan role berhasil simpan');
    }

    public function setRole(Request $request)
    {
        $request->validate([
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.role' => 'required'
        ]);

        foreach ($request->members as $member) {
            ProjekMember::updateOrCreate(
                ['user_id' => $member['user_id']],
                ['role' => $member['role']]
            );
        }

        return back()->with('success', 'Role berhasil disimpan');
    }

    public function destroy($id)
    {
        $member = \App\Models\ProjekMember::findOrFail($id);
        $projekId = $member->projek_id;
        $member->delete();
        return redirect('/mentor/detail/team/projek/' . $projekId)->with('success', 'Anggota tim berhasil dihapus!');
    }

}
