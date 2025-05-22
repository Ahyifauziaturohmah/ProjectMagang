<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index(){
        return view('login');
    }
    function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ],[
            'email.required'=>'Email Harus Diisi',
            'password.required'=>'Password Harus Diisi',
        ]);
        $infologin =[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(Auth::attempt($infologin)){
            if (Auth::user()->role == 'mentor'){
                return redirect('/mentordash');
            }else if (Auth::user()->role == 'magang'){
                return redirect('/magangdash');
            }
        }else {
            return redirect('')->withErrors('Username atau Password yang dimasukan tidak sesuai')->withInput();
        }
    }
    function logout()
    {
        Auth::logout();
        return redirect('');
    }

}
