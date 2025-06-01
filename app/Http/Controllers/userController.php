<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function index(){
        $data = User::where('role', 'magang')->orderBy('id','desc')->get();
        return view('maganglist')->with('data', $data);
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
