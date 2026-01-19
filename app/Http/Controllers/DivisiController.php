<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Divisi;

class DivisiController extends Controller
{
    // Menampilkan form atur divisi
    public function create()
    {
        $users = User::where('role', 'magang')->get(); // atau sesuaikan filter-nya
        $kelas = Kelas::all(); // ambil semua kelas/divisi

        return view('form_atur_divisi', compact('users', 'kelas'));
    }

    // Menyimpan data yang di-submit
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Divisi::create([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
        ]);
        return redirect()->to('maganglist')->with('success','Divisi berhasil diatur!');
    }
}

