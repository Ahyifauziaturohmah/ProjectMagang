<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas'];

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class);
    }
    public function divisi()
    {
        return $this->hasMany(Divisi::class);
    }

}
