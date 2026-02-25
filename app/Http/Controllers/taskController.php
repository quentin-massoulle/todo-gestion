<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Tache;
use App\Models\TacheDependance;
use DateTime;

class taskController extends Controller
{
    /**
     * Crée ou met à jour une tâche.
     * Si 'TaskId' est présent → mise à jour d'une tâche existante.
     * Sinon → création d'une nouvelle tâche.
     */
    public function store(Request $request)
    {
        //  Validation des données reçues depuis le formulaire
        $validator = Validator::make($request->all(),
            [
                'TaskId' => 'nullable|exists:taches,id',
                'titre' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'date_fin'=> 'nullable|date',
                'date_debut' => 'nullable|date',
                'groupe' => 'nullable|exists:groupe,id',
                'dependance' => 'nullable|array',
                'dependance.*' => 'exists:taches,id',
            ], 
            [
                'TaskId.exists' => __('validator.task.id.exists'),
                'titre.required' => __('validator.titre.required'),
                'description.required' => __('validator.description.required'),
                'date_fin.date' => __('validator.date.date'),
                'date_debut.date' => __('validator.date.date'),
                'groupe.exists' => __('validator.groupe.id.exists'),
                'dependance.array' => __('validator.dependance.array'),
                'dependance.*.exists' => __('validator.dependance.id.exists'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->TaskId){
            $task = Tache::where('id', $request->TaskId)->first();

        }
        else {
            $user = Auth::user();
            $task = new Tache();
            $task->user_id = $user->id;
            $task->etat = 'nouveau';   
        }

        $task->titre = $request->titre;
        $task->description = $request->description;
        $task->date_debut = $request->date_debut ?? now();          
        $task->date_fin = $request->date_fin ?? now()->addMonth();  
        $task->save();

        //sycronise les dependances avec le tableau recu
        if ($request->dependance) {
            $dependanceIds = array_unique($request->dependance);
            $task->dependance()->sync($dependanceIds);
        } else {
            $task->dependance()->sync([]);
        }

        if ($request->TaskId){
            return redirect()->route('user.tasks')->with('success', 'Tâche modifiée avec succès.');
        }

        if($request->groupe)
        {
            $task->groupe_id = $request->groupe ;
            $task->save();
            return redirect()->route('groupe.show',['id' => $request->groupe])
                ->with('success', 'Tâche créée avec succès.');
        }

        return redirect()->route('user.tasks')->with('success', 'Tâche créée avec succès.');
    }

    /**
     * Affiche les tâches regroupées par état (nouveau, en cours, terminé…).
     * Si un groupe est précisé → affiche les tâches du groupe.
     * Sinon → affiche les tâches de l’utilisateur connecté.
     */
    public function viewsTasks()
    {
        $groupe = request('groupe');

        if (isset($groupe)){
            $tasks = Tache::where("groupe_id",$groupe)->get()->groupBy('etat');
        }
        else{
            $user = Auth::user();
            $tasks = Tache::where('user_id', $user->id)->get()->groupBy('etat');
        }

        return view('task.taskDashboard', ['tasks' => $tasks , 'groupe'=> $groupe]);
    }

    /**
     * Affiche les détails d'une tâche spécifique.
     * Permet aussi de gérer l’accès selon le groupe ou le propriétaire.
     */
  public function showTask($id)
{   
    $user = Auth::user();
    $task = null;
    $groupe = null;
    $listeTache = collect(); 

    if ($id != 0) {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:taches,id',
        ], [
            'id.required' => __('validator.task.id.required'),
            'id.exists' => __('validator.task.id.exists'),
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $task = Tache::with('dependance')->find($id);

        if ($task->groupe_id) {
            $validator = Validator::make(
                ['userId' => $user->id, 'groupe_id' => $task->groupe_id],
                [
                    'userId' => 'exists:groupe_user,user_id',
                    'groupe_id' => 'exists:groupe,id'
                ],
                ['groupe_id.exists' => __('validator.groupe.id.exists')]
            );

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $groupe = $task->groupe;
            $listeTache = $groupe->tache; 
        } else {
            $validator = Validator::make(['user_id' => $task->user_id], [
                'user_id' => 'in:' . $user->id
            ], [
                'user_id.in' => __('validator.task.id.UserExiste'),
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $listeTache = $user->tache->where('groupe_id', null); 
        }
    } else {
        $task = new Tache();
        $task->user_id = $user->id;
        $task->titre = 'Nouvelle tâche';
        $task->description = 'Nouvelle tâche';
        $task->etat = 'nouveau';
        $task->date_debut = now();
        $task->date_fin = now()->addDays(1);
         
        $groupIdFromUrl = request()->query('groupe');
        if ($groupIdFromUrl) {
            $groupe = $user->groupe()->find($groupIdFromUrl);
            $listeTache = $groupe ? $groupe->tache : $user->tache;
        } else {
            $listeTache = $user->tache;
        }
    }

    $messages = ($task) ? $task->message()->orderByDesc('created_at')->get() : collect();

    return view('task.taskShow', [
        'task' => $task, 
        'groupe' => $groupe, 
        'messages' => $messages, 
        'listeTache' => $listeTache
    ]);
   
    }

    /**
     * Met à jour l'état d'une tâche (AJAX).
     * États possibles : nouveau, planifie, en_cours, termine.
     */
    public function updateEtat(Request $request, $id)
    {
        $task = Tache::findOrFail($id);

        $validated = $request->validate([
            'etat' => 'required|in:nouveau,planifie,en_cours,termine',
        ]);
        $task->etat = $validated['etat'];
        $task->save();

        return response()->json(['success' => true]);
    }

    /**
     * Met à jour les dates de début et de fin d'une tâche.
     */
    public function updateDates(Request $request, $id)
    {
        $task = Tache::findOrFail($id);

        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $start = new DateTime($validated['start']);
        $start->modify('+1 day');
        $task->date_debut = $start->format('Y-m-d'); 

        $end = new DateTime($validated['end']);
        $end->modify('+1 day');
        $task->date_fin = $end->format('Y-m-d'); 

        $task->save();

        return response()->json(['success' => true]);
    }
}
