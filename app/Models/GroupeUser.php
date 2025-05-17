<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupeUser extends Model
{
    protected $table = 'groupe_user';
    public $timestamps = false;


    protected $fillable =[
        'user_id', 'groupe_id'
    ];
}
