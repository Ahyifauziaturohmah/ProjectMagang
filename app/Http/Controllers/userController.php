<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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
    public function editPassword()
    {
        // Pastikan nama file blade kamu ada di: resources/views/magang/edit-password.blade.php
        return view('profile_magang');
    }

    /**
     * 2. Fungsi untuk MEMPROSES perubahan password (yang tadi)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ], [
            // Custom pesan error bahasa Indonesia (Opsional)
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.min' => 'Password baru minimal harus 8 karakter.',
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
        }

        // Update ke database
        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
