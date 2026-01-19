<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class userController extends Controller
{
    public function index(){
        $data = User::with(['divisi.kelas']) 
                ->where('role', 'magang')
                ->get();

    return view('maganglist', compact('data'));
    }
    
    public function create(){
        return view('formmaganglist');
    }
    public function store(Request $request){
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'magang'
            ]);

            $user->contact()->create([
                'kontak' => $request->kontak, 
            ]);
        });
        return redirect()->to('maganglist')->with('success','Data Berhasil Ditambahkan');
    }
    public function editPassword()
    {
        return view('profile_magang');
    }

    public function edit($id)
    {
        $magang = \App\Models\User::findOrFail($id);
        
        $datakelas = \App\Models\Kelas::all(); 

        return view('formmaganglist', compact('magang', 'datakelas'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($request, $user) {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            $user->contact()->updateOrCreate(
                ['user_id' => $user->id],
                ['kontak'  => $request->kontak]
            );
        });

        return redirect('/maganglist')->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if($user->contact) {
            $user->contact()->delete();
        }
        
        $user->delete();

        return redirect()->back()->with('success', 'Data anak magang berhasil dihapus');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.min' => 'Password baru minimal harus 8 karakter.',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    public function contact() {
        return $this->hasOne(UserContact::class, 'user_id');
    }
}
