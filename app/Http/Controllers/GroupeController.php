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
    public function index()
    {
        $user = Auth::user();
        $groupes = $user->groupe;
        $users = User::where('id', '!=', $user->id)->get();

        return view('groupe.dashboardGroupe',['groupes' => $groupes , 'users'=> $users ,'groupeActif' => false , 'userGroupe' => null]);
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
    
       
        if (!$user->groupe->pluck('id')->contains($groupe->id)) {
            return back()->withErrors('pas ton groupe')->withInput();
        }
    
    
        $messages = $groupe->message()->orderByDesc('created_at')->get();
    

        $tachesQuery = $groupe->tache(); 
    
        if ($date_depart) {
            $tachesQuery->where('date_fin', '>=', $date_depart);
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
            'date_depart' => $date_depart,
            'date_fin' => $date_fin,
            'periode' => $date_depart && $date_fin,
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
            GroupeUser::where('groupe_id', $groupe->id)->delete();
        } else {
            $groupe = new Groupe;
            $groupe->nom =  $inputValue;
            $groupe->proprietaire_id = $user->id;
            $groupe->save();
        }
       
        $groupeUser = new GroupeUser;
        $groupeUser->groupe_id =  $groupe->id;
        $groupeUser->user_id = $user->id;
        $groupeUser->save();
        
        foreach($selectValues as $value)
        {
            $groupeUser = new GroupeUser;
            $groupeUser->groupe_id =  $groupe->id;
            $groupeUser->user_id = $value;
            $groupeUser->save();
        }

         return redirect()->route('user.groupes')->with('success', 'action reussie');
    }


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
    
        return view('gantt', [
            'groupe' => $groupe,
            'taches' => $taches,
        ]);
    }
}
