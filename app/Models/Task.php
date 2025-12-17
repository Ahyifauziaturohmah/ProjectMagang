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
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function divisi() {
        return $this->belongsTo(Divisi::class);
    }
    public function projek()
{
    return $this->belongsTo(Projek::class, 'projek_id');
}
}
