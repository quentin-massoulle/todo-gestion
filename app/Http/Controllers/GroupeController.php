<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Groupe;
use App\Models\GroupeUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class GroupeController extends Controller
{

    /**
     * permet au utilisateur d'acceder au dahborn de ses groupe 
     */
    public function indexAdmin(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $groupes = Groupe::all();
        if ($date_debut && $date_fin) {
            $groupes = $groupes->whereBetween('created_at', [$date_debut, $date_fin]);
        }
        return view('axe.groupe-show', ['groupes' => $groupes , 'date_debut' => $date_debut , 'date_fin' => $date_fin]);
    }

    /**
     * permet au utilisateur d'acceder au dahborn de ses groupe 
     */
    public function index()
    {
        $user = Auth::user();
        $groupes = $user->groupe;
        $users = User::where('id', '!=', $user->id)->get();

        return view('groupe.dashboardGroupe',['groupes' => $groupes , 'users'=> $users ,'groupeActif' => false , 'userGroupe' => null]);
    }

    /**
     * permet de redirigier l'utilisateur vert le groupe selectionner si il en fait partie 
     */
    public function show(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:groupe,id',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
    
        $groupe = Groupe::find($id);
        $user = Auth::user();
    
       
        if (!$user->groupe->pluck('id')->contains($groupe->id)) {
            return back()->withErrors('pas ton groupe')->withInput();
        }
    
    
        $messages = $groupe->message()->orderBy('created_at', 'asc')->get();
    

        $tachesQuery = $groupe->tache(); 
    
        if ($date_debut) {
            $tachesQuery->where('date_fin', '>=', $date_debut);
        }

        if ($date_fin) {
            $tachesQuery->where('date_fin', '<=', $date_fin);
        }
        $users = User::where('id', '!=', $user->id)->get();
        $taches = $tachesQuery->get();
    
        return view('groupe.GroupeShow', [
            'userGroupe' => $groupe->user,
            'groupeActif' => true,
            'users' => $users,
            'groupe' => $groupe,
            'tache' => $taches,
            'messages' => $messages,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'periode' => $date_debut && $date_fin,
        ]);
    }

    public function store(Request $request)
    {
        $idGroupe = $request->input('idGroupe');
        $user = Auth::user();
        $inputValue = $request->input('NameGroupe');
        $selectValues = $request->input('SelectGroupe');
        if ($idGroupe) {
            $validator = Validator::make($request->all(), [
                'idGroupe' => 'required|exists:groupe,id',
                'NameGroupe' => 'required|string|max:255',
                'SelectGroupe' => 'required|array',
                'SelectGroupe.*' => 'exists:users,id',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'NameGroupe' => 'required|string|max:255',
                'SelectGroupe' => 'required|array',
                'SelectGroupe.*' => 'exists:users,id',
            ]);
        }
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($idGroupe) {
            $groupe = Groupe::find($idGroupe);
            if (!$groupe || !$user->groupe->pluck('id')->contains($groupe->id)) {
                return back()->withErrors('pas ton groupe')->withInput();
            }
            $groupe->nom = $inputValue;
            $groupe->save();
        } else {
            $groupe = new Groupe;
            $groupe->nom = $inputValue;
            $groupe->proprietaire_id = $user->id;
            $groupe->save();
        }

        // Ensure the owner is always in the group and members are unique
        $memberIds = is_array($selectValues) ? array_unique($selectValues) : [];
        
        // Remove owner from selected members if they were somehow included
        $filteredMemberIds = array_diff($memberIds, [$user->id]);
        
        // Final list: owner + filtered selected members
        $syncData = array_merge([$user->id], array_values($filteredMemberIds));

        $groupe->users()->sync($syncData);

         return redirect()->route('user.groupes')->with('success', 'action reussie');
    }

    /**
     * supprime le groupe selectionner 
     */
    public function delete($id)
    {

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:groupe,id',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $groupe = Groupe::find($id);

        if (!$groupe) {
            return back()->withErrors('pas ton groupe')->withInput();
        }
        $groupe->delete();

        GroupeUser::where('groupe_id', $groupe->id)->delete();

        return redirect()->route('user.groupes')->with('success', 'Groupe supprimé avec succès');
    }

    public function gantt($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:groupe,id',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $groupe = Groupe::find($id);
        $user = Auth::user();
    
        if (!$user->groupe->pluck('id')->contains($groupe->id)) {
            return back()->withErrors('pas ton groupe')->withInput();
        }
    
        $taches = $groupe->tache()->get();
        foreach ($taches as $task) {
            $task->dependencies = $task->dependance->pluck('id')->implode(',');
            $task->dependencies = preg_replace('/\s+/', '', $task->dependencies);
        }
        return view('gantt', [
            'groupe' => $groupe,
            'taches' => $taches,
        ]);
    }
}
