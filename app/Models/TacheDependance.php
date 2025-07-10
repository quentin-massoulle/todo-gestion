<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TacheDependance extends Model
{
    protected $table = 'tache_dependance';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'dependance_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function dependance()
    {
        return $this->belongsTo(Task::class, 'dependance_id');
    }
}
