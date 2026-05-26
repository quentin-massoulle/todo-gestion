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
        $groupesQuery = Groupe::query();
        $usersQuery = User::query();

        if ($date_debut) {
            $tachesQuery->where('date_fin', '>=', $date_debut);
            $groupesQuery->whereDate('created_at', '>=', $date_debut);
            $usersQuery->whereDate('created_at', '>=', $date_debut);
        }

        if ($date_fin) {
            $tachesQuery->where('date_fin', '<=', $date_fin);
            $groupesQuery->whereDate('created_at', '<=', $date_fin);
            $usersQuery->whereDate('created_at', '<=', $date_fin);
        }

        $totalUsers   = $usersQuery->count();
        $totalGroupes = $groupesQuery->count();
        $filteredTaches = $tachesQuery->get();
        $totalTaches  = $filteredTaches->count();
        $terminees    = $filteredTaches->where('etat', 'termine')->count();
        $enCours      = $filteredTaches->where('etat', 'en_cours')->count();
        $enRetard     = $filteredTaches->where('date_fin', '<', now())->where('etat', '!=', 'termine')->count();

        $completion = $totalTaches > 0 ? round(($terminees / $totalTaches) * 100) : 0;

        $recentUsers = $usersQuery->latest()->take(5)->get();
        
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
    public function users(Request $request)
    {
        $users = User::where('is_admin', false)->latest()->get();
        return view('axe.users', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }

        foreach ($user->groupe as $groupe) {
            $groupe->users()->detach($user->id);
        }

        foreach ($user->tache as $tache) {
            if ($tache->groupe_id != null) {
                $tache->update(['user_id' => null]);
            }else{
                $tache->delete();
            }
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
