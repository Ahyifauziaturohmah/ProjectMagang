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


    public function edit($id) {
        $projek = Projek::findOrFail($id);
        $kelas = Kelas::all();
        return view('form-team_mentor', compact('projek', 'kelas'));
    }

        public function update(Request $request, $id) {
            $request->validate([
                'nama' => 'required',
                'deskripsi' => 'required',
                'kelas_id' => 'required'
            ]);

            $projek = Projek::findOrFail($id);
            $projek->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'kelas_id' => $request->kelas_id,
            ]);

            // Cukup satu baris ini saja, yang lain dihapus
            return redirect('/mentor/team/projek')->with('success', 'Projek berhasil diperbarui!');
        }

    public function destroy($id) {
        Projek::findOrFail($id)->delete();
        return redirect('/mentor/team/projek')->with('success', 'Projek berhasil dihapus!');
    }

    public function detail_projek($id)
    {
        $projek = Projek::with(['kelas', 'anggota.user', 'tasks'])->findOrFail($id);

        return view('detail-team_mentor', compact('projek'));
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
}
