<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = 'users_contacts'; 

    // 2. Daftarkan kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'kontak', 
    ];

    // 3. Relasi balik ke User (Optional tapi bagus buat ada)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
