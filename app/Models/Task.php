<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task'; 

    protected $fillable = ['judul', 'deskripsi','tenggat', 'kelas_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class);
    }
}
