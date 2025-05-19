<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $groupes = $user->groupe;


        return view('groupe.dashboardGroupe',['groupes' => $groupes]);
    }
}
