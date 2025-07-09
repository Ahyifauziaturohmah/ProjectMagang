<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pengumuman;
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

    public function create(){
        return view('form_pengumuman');
    }
    public function store(Request $request){
        $data = [
            'judul'=>$request->judul,
            'isi'=>$request->isi,
            'kelas_id'=>$request->kelas_id,

        ];
        Pengumuman::create($data);
        return redirect()->to('mentor/pengumuman')->with('success','Pengumuman Berhasil Ditambahkan');
    }
}
