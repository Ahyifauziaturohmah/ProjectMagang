<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjekTaskSubmission extends Model
{
    use HasFactory;

    protected $table = 'projek_task_submissions'; 

    protected $fillable = [
        'task_id',
        'member_id', 
        'status',
        'url',
    ];

    public function projekTask()
    {
        return $this->belongsTo(ProjekTask::class, 'task_id');
    }
}
