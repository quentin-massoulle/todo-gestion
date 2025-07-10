<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Task extends Model
{

    use HasFactory;
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

    public function message()
{
    return $this->hasMany(Message::class, 'tache_id', 'id');
}

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function dependance()
    {
        return $this->belongsToMany(Task::class, 'taches_dependencies', 'tache_id', 'dependency_id');
    }

}

