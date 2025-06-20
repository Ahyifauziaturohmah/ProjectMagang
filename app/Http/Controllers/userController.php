<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function index(){
        $data = User::with(['divisi.kelas']) // eager load divisi dan kelas-nya
                ->where('role', 'magang')
                ->get();

    return view('maganglist', compact('data'));
    }
    
    public function create(){
        return view('formmaganglist');
    }
    public function store(Request $request){
        $data = [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,

        ];
        User::create($data);
        return redirect()->to('maganglist')->with('success','Data Berhasil Ditambahkan');
    }
}
