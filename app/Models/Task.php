<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'taches';
    protected $fillable = ['titre', 'description', 'etat', 'date_fin', 'rappel_active', 'user_id'];

    const ETATS = [
        'nouveau',
        'planifie',
        'en_cours',
        'termine',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Rappels(){
        return $this->hasMany(Rappel::class);
    }


}

