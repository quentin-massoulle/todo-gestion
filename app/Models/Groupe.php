<?php

namespace App\Models;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Groupe extends Model
{
    use HasFactory;
    protected $table = 'groupe';
    public $timestamps = false;


    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function tache()
    {
        return $this->hasMany(Task::class);
    }
    
}
