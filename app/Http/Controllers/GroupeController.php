<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Groupe;
use Illuminate\Support\Facades\Validator;


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
        $validator = Validator::make(['id'=>$id],
            [
                'id' => 'required|exists:groupe,id', // Règles de validation
            ], 


        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $groupe  = Groupe::find($id);
        $user    = Auth::user();
        $message = $groupe->message;
        $message = $message->sortByDesc('created_at');

        if ($user->groupe->pluck('id')->contains($groupe->id)){
            return view('groupe.GroupeShow',['groupe' => $groupe , 'messages' => $message]);
        } 
        else{
            return back()->withErrors('pas ton groupe')->withInput();
        }
        
    }
}
