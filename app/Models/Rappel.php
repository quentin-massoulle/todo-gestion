<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rappel extends Model
{
   
    protected $table = 'rappels';

    protected $fillable = [
        'tache_id', 'frequence', 'frequence',
    ];


}
