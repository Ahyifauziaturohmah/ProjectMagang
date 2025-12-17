<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projek extends Model
{
    protected $table = 'projek';

    
    protected $fillable = [
        'nama',
        'deskripsi',
        'kelas_id',
        'createBy'
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjekTask::class, 'projek_id', 'id');
    }
        public function anggota()
    {
        return $this->hasMany(ProjekMember::class, 'projek_id', 'id');
    }

public function members()
{
    return $this->hasMany(ProjekMember::class, 'projek_id');
}
}
