<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tache;
use App\Models\Groupe;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers   = User::count();
        $totalTaches  = Tache::count();
        $totalGroupes = Groupe::count();
        $terminees    = Tache::where('etat', 'termine')->count();
        $enCours      = Tache::where('etat', 'en_cours')->count();
        $enRetard     = Tache::where('date_fin', '<', now())->where('etat', '!=', 'termine')->count();

        $completion = $totalTaches > 0 ? round(($terminees / $totalTaches) * 100) : 0;

        $recentUsers = User::latest()->take(5)->get();
        $recentTaches = Tache::with('user')->latest()->take(5)->get();

        return view('dashboard.dashboardAdmin', compact(
            'totalUsers',
            'totalTaches',
            'totalGroupes',
            'terminees',
            'enCours',
            'enRetard',
            'completion',
            'recentUsers',
            'recentTaches'
        ));
    }
}
