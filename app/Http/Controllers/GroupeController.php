<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Groupe;


use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groupes = $user->groupe;


        return view('groupe.dashboardGroupe',['groupes' => $groupes]);
    }

    public function show($id)
    {
        $groupe = Groupe::find($id);
        return view('groupe.GroupeShow',['groupe' => $groupe]);
    }
}
