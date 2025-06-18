<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Groupe;
use Illuminate\Support\Facades\Validator;


class GroupeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groupes = $user->groupe;


        return view('groupe.dashboardGroupe',['groupes' => $groupes]);
    }

    public function show(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:groupe,id',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $date_depart = $request->input('date_depart');
        $date_fin = $request->input('date_fin');
    
        $groupe = Groupe::find($id);
        $user = Auth::user();
    
        // Vérifie si l'utilisateur appartient bien au groupe
        if (!$user->groupe->pluck('id')->contains($groupe->id)) {
            return back()->withErrors('pas ton groupe')->withInput();
        }
    
        // Récupération des messages
        $messages = $groupe->message()->orderByDesc('created_at')->get();
    
        // Filtrage des tâches
        $tachesQuery = $groupe->tache(); // <== Ceci retourne un QueryBuilder, pas une Collection
    
        if ($date_depart) {
            $tachesQuery->where('date_fin', '>=', $date_depart);
        }

        if ($date_fin) {
            $tachesQuery->where('date_fin', '<=', $date_fin);
        }
    
        $taches = $tachesQuery->get();
    
        return view('groupe.GroupeShow', [
            'groupe' => $groupe,
            'tache' => $taches,
            'messages' => $messages,
            'date_depart' => $date_depart,
            'date_fin' => $date_fin,
            'periode' => $date_depart && $date_fin,
        ]);
    }    
}
