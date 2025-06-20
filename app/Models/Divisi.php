<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'divisi'; // good!

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nama_divisi', // pastikan ini juga diisi kalau kamu simpan nama divisinya
    ];

    // Setiap divisi dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Setiap divisi dimiliki oleh satu kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

