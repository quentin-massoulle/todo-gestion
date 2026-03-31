<?php

namespace App\Models;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groupe extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'groupe';
    public $timestamps = true;


    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'groupe_user')
                    ->using(GroupeUser::class) 
                    ->withTimestamps()         
                    ->withPivot('deleted_at'); 
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function tache()
    {
        return $this->hasMany(Tache::class);
    }
    
}
