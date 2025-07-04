<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
   protected $table = 'messages';

     public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }


    
}
