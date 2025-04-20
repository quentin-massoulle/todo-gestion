<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'taches';

    protected $fillable = [
        'user_id', 'titre', 'description', 'est_termine', 'rappel_active'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Rappels(){
        return this->hasMany(Rappel::class);
    }


}

