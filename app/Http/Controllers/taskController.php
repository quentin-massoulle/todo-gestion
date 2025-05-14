<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class taskController extends Controller
{
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),
            [
                'titre' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'date_fin'=> 'nullable|date'
            ], 
            [
                'titre.required' => __('validator.titre.required'),
                'description.required' => __('validator.titre.required'),
                'date_fin.date' => __('validator.date.date')
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();

        $task = new Task();
        $task->user_id = $user->id;
        $task->titre = $request->titre;
        $task->description = $request->description;
        $task->date_fin = $request->date; 

        $task->save();
        

        return redirect()->route('user.dashboard')->with('success', 'Tâche créée avec succès.');
    }
}
