<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjekTask extends Model
{
    protected $table = 'projektask';

    protected $fillable = [
        'nama', 
        'projek_id', 
        'member_id', 
        'createBy'
    ];

    public function submission()
    {
        return $this->hasOne(ProjekTaskSubmission::class, 'task_id'); 
    }
    public function member()
    {
        return $this->belongsTo(ProjekMember::class, 'member_id');
    }

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'projek_id');
    }
}
