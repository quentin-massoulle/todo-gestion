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
        if($request->Groupe)
        {
            $task->groupe_id = $request->groupe ;
            $task->save();
            return redirect()->route('groupe.show',['id' => $request->groupe])->with('success', 'Tâche créée avec succès.');
        }
        return redirect()->route('user.tasks')->with('success', 'Tâche créée avec succès.');
    }

    public function viewsTasks()
    {
        $groupe = request('groupe');
        if (isset($groupe)){
            $tasks = Task::where("groupe_id",$groupe)->get()->groupBy('etat');
        }
        else{
            $user = Auth::user();
            $tasks = Task::where('user_id', auth()->id())->get()->groupBy('etat');
        }
        return view('task.taskDashboard', ['tasks' => $tasks , 'groupe'=> $groupe]);
    }

    public function showTask($id)
    {   
        $user = Auth::user();
        if($id!=0)
        {
             $validator = Validator::make(['id'=>$id],
            [
                'id' => 'required|exists:taches,id',
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
            if ($task->groupe)
            {
                $validator = Validator::make(['userId' => $user->id , 'groupe_id' => $task->groupe->id], [
                    'userId' => 'exists:groupe_user,user_id',
                    'groupe_id' => 'exists:groupe,id'
                ], [
                    'groupe_id.exists' => __('validator.groupe.id.exists'),
                ]);
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
            }
            else {
                $validator = Validator::make(['user_id' => $task->user_id], [
                'user_id' => 'in:' . $user->id
            ], [
                'user_id.in' => __('validator.task.id.UserExiste'),
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            }
            
        }
        else{
            $task = null;
        }
        $groupe = $task->groupe_id ?? null;
        if (isset($groupe))
        {
            if(!$user->groupe->contains('id',$groupe))
            {
                $groupe==null;
            }   
        }
        else{
            $groupe=null;
        }
        $messages = $task->message ?? null;
        if (!isset($messages)){
            $messages = null;
        }
        return view('task.taskShow',['task' => $task, 'groupe' => $groupe, 'messages' => $messages]);
    }

    public function updateEtat(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'etat' => 'required|in:nouveau,planifie,en_cours,termine',
        ]);

        $task->etat = $validated['etat'];
        $task->save();

        return response()->json(['success' => true]);
    }

}
