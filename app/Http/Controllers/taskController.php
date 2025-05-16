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
                'TaskId' => 'nullable|exists:taches,id',
                'titre' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'date_fin'=> 'nullable|date'
            ], 
            [
                'TaskId.exists' => __('validator.task.id.exists'),
                'titre.required' => __('validator.titre.required'),
                'description.required' => __('validator.description.required'),
                'date_fin.date' => __('validator.date.date')
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request->TaskId){
            $task=Task::where('id', $request->TaskId)->first();
        }
        else {
            $user = Auth::user();
            $task = new Task();
            $task->user_id = $user->id;
        }
        $task->titre = $request->titre;
        $task->description = $request->description;
        $task->date_fin = $request->date_fin; 

        $task->save();
        if ($request->TaskId){
            return redirect()->route('user.tasks')->with('success', 'Tâche modifier avec succès.');
        }
        return redirect()->route('user.tasks')->with('success', 'Tâche créée avec succès.');
    }

    public function viewsTasks()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->get();
        return view('task.taskDashboard', ['tasks' => $tasks]);
    }

    public function showTask($id)
    {
        $validator = Validator::make(['id'=>$id],
            [
                'id' => 'required|exists:taches,id', // Règles de validation
            ], 
            [
    
                'id.required' => __('validator.task.id.required'),
                'id.exists' => __('validator.task.id.exists'),
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $task=Task::where('id', $id)->first();
        $user = Auth::user();
        $validator = Validator::make(['user_id' => $task->user_id], [
            'user_id' => 'in:' . $user->id
        ], [
            'user_id.in' => __('validator.task.id.UserExiste'),
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        return view('task.taskShow',['task' => $task]);
    }
}
