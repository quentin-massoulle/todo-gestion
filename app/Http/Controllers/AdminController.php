<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tache;
use App\Models\Groupe;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $tachesQuery = Tache::query();

        if ($date_debut) {
            $tachesQuery->where('date_fin', '>=', $date_debut);
        }

        if ($date_fin) {
            $tachesQuery->where('date_fin', '<=', $date_fin);
        }

        $totalUsers   = User::count();
        $totalGroupes = Groupe::count();

        // Stats calculées sur les tâches filtrées
        $filteredTaches = $tachesQuery->get();
        $totalTaches  = $filteredTaches->count();
        $terminees    = $filteredTaches->where('etat', 'termine')->count();
        $enCours      = $filteredTaches->where('etat', 'en_cours')->count();
        $enRetard     = $filteredTaches->where('date_fin', '<', now())->where('etat', '!=', 'termine')->count();

        $completion = $totalTaches > 0 ? round(($terminees / $totalTaches) * 100) : 0;

        $recentUsers = User::latest()->take(5)->get();
        
        // Re-execute query for recent tasks to include limits and relations
        $recentTaches = (clone $tachesQuery)->with('user')->latest()->take(5)->get();

        return view('dashboard.dashboardAdmin', compact(
            'totalUsers',
            'totalTaches',
            'totalGroupes',
            'terminees',
            'enCours',
            'enRetard',
            'completion',
            'recentUsers',
            'recentTaches',
            'date_debut',
            'date_fin'
        ));
    }
}
