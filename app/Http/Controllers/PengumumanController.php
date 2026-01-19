<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsappHelper;
use App\Models\Kelas;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index(){
        
        $data = Pengumuman::with('kelas')->orderBy('id','desc')->get();
        return view('mentor_pengumuman')->with('data', $data);
    }
    
    public function show(){
        $user = Auth::user();
        $kelasId = Auth::user()->divisi->kelas_id ?? null;

        $data = Pengumuman::where('kelas_id', $kelasId)->with('kelas')->get();
        return view('pengumuman_magang')->with('data', $data);
    }

    public function create() {
        $datakelas = Kelas::all(); 
        return view('form_pengumuman', compact('datakelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kelas_id' => 'required',
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kelas_id' => $request->kelas_id,
        ];

        $pengumuman = Pengumuman::create($data);

        $penerima = User::whereHas('divisi', function($query) use ($request) {
            $query->where('kelas_id', $request->kelas_id);
        })->with('contact')->get(); 

        foreach ($penerima as $user) {
            $nomorWa = $user->contact?->kontak; 
            
            if ($nomorWa) {
                $pesan = "*PENGUMUMAN BARU*\n\n" .
                        "Halo *{$user->name}*,\n" .
                        "Ada pengumuman baru: *{$request->judul}*\n\n" .
                        "Silakan cek di web.";

                WhatsappHelper::send($nomorWa, $pesan);
            }
        }

        return redirect()->to('mentor/pengumuman')->with('success', 'Pengumuman Berhasil Ditambahkan');
    }

    public function edit($id) {
        $pengumuman = Pengumuman::findOrFail($id);
        $datakelas = Kelas::all(); 
        return view('form_pengumuman', compact('pengumuman', 'datakelas')); 
    }

    public function update(Request $request, $id) {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required', 
            'kelas_id' => 'required'
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update([
            'judul' => $request->judul,
            'isi' => $request->isi, 
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect('/mentor/pengumuman')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy($id) {
        Pengumuman::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}
