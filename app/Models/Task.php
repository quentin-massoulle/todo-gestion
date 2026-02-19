<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Task extends Model
{

    protected $casts = [
    'date_debut' => 'datetime', 
    'date_fin' => 'datetime',
    ];

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

    /// calcule le pourcentage de temps écoulé entre la date de début et la date de fin
    public function getCouleurTempsAttribute()
    {
        $debut = $this->date_debut; 
        $fin = $this->date_fin;
        $maintenant = Carbon::now();
        if ($maintenant > $fin) {
            return "bg-rose-100 text-rose-900";
        }
        if ($maintenant < $debut) {
            return "bg-emerald-100 text-emerald-900";
        }
        else {
            $diff1 = $debut->diffInDays($fin);
            $diff2 = $debut->diffInDays($maintenant);
            $pourcentage = ($diff2 / $diff1) * 100;
            if ($pourcentage > 90) {
                return "bg-rose-100 text-rose-900";
            }
            if ($pourcentage > 70) {
                return "bg-orange-100 text-orange-900";
            }
            if ($pourcentage > 50) {
                return "bg-amber-100 text-amber-900";
            }
            return "bg-emerald-100 text-emerald-900";
        }
    }
}

