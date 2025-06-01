<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman'; // default plural dari Laravel

    protected $fillable = ['judul', 'isi', 'kelas_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
