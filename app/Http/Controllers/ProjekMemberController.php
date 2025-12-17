<?php

namespace App\Http\Controllers;

use App\Models\ProjekMember;
use App\Models\User;
use Illuminate\Http\Request;

class ProjekMemberController extends Controller
{
    
    public function create()
    {
        $users = User::where('role', 'magang')->get();
        return view('form-role-team_mentor', compact('users'));
    }

    public function store(Request $request)
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

}
