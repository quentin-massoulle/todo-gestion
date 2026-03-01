<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rappel extends Model
{
   
    protected $table = 'rappels';

    protected $casts = [
        'date_rappel' => 'date',
    ];

    protected $fillable = [
        'tache_id', 'frequence', 'date_rappel',
    ];


}
