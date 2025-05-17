<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $table = 'groupe';
    public $timestamps = false;


    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return belongToMany(User::class);
    }

    public function task()
    {
        return $this->user->task;
    }
}
