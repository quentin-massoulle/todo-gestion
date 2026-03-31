<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupeUser extends Pivot
{   
    use SoftDeletes;
    protected $table = 'groupe_user';
    public $timestamps = true;

    protected $fillable =[
        'user_id', 'groupe_id'
    ];
}
