<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
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

        //  Si la validation échoue → retour avec erreurs
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //  Si une tâche existe déjà (mise à jour)
        if ($request->TaskId){
            $task = Task::where('id', $request->TaskId)->first();
        }
        //  Sinon, création d'une nouvelle tâche
        else {
            $user = Auth::user();
            $task = new Task();
            $task->user_id = $user->id;
        }

        //  Remplissage des champs principaux
        $task->titre = $request->titre;
        $task->description = $request->description;
        $task->date_debut = $request->date_debut ?? now();          // Date de début = maintenant si non précisée
        $task->date_fin = $request->date_fin ?? now()->addMonth();  // Date de fin = dans 1 mois par défaut
        $task->etat = 'nouveau';                                    // État initial de la tâche
        $task->save();

        //  Gestion des dépendances (relations entre tâches)
        if ($request->dependance) {
            $dependanceIds = array_unique($request->dependance);
            $task->dependance()->sync($dependanceIds);
        } else {
            $task->dependance()->sync([]);
        }

        //  Redirections selon le contexte
        if ($request->TaskId){
            // Cas d’une modification
            return redirect()->route('user.tasks')->with('success', 'Tâche modifiée avec succès.');
        }

        // Cas d’une création dans un groupe
        if($request->groupe)
        {
            $task->groupe_id = $request->groupe ;
            $task->save();
            return redirect()->route('groupe.show',['id' => $request->groupe])
                ->with('success', 'Tâche créée avec succès.');
        }

        // Cas d’une création personnelle
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

        //  Si un groupe est précisé, on affiche ses tâches
        if (isset($groupe)){
            $tasks = Task::where("groupe_id",$groupe)->get()->groupBy('etat');
        }
        // Sinon, on affiche les tâches de l'utilisateur connecté
        else{
            $user = Auth::user();
            $tasks = Task::where('user_id', $user->id)->get()->groupBy('etat');
        }

        // Vue du tableau de bord des tâches
        return view('task.taskDashboard', ['tasks' => $tasks , 'groupe'=> $groupe]);
    }

    /**
     * Affiche les détails d'une tâche spécifique.
     * Permet aussi de gérer l’accès selon le groupe ou le propriétaire.
     */
    public function showTask($id)
    {   
        $user = Auth::user();

        // Si un ID de tâche est précisé
        if($id != 0)
        {
            // Validation de l'existence de la tâche
            $validator = Validator::make(['id'=>$id],
            [
                'id' => 'required|exists:taches,id',
            ], 
            [
                'id.required' => __('validator.task.id.required'),
                'id.exists' => __('validator.task.id.exists'),
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $task = Task::where('id', $id)->first();

            // Si la tâche appartient à un groupe
            if ($task->groupe)
            {
                // Vérifie que l’utilisateur fait partie du groupe
                $validator = Validator::make(
                    ['userId' => $user->id , 'groupe_id' => $task->groupe->id],
                    [
                        'userId' => 'exists:groupe_user,user_id',
                        'groupe_id' => 'exists:groupe,id'
                    ],
                    [
                        'groupe_id.exists' => __('validator.groupe.id.exists'),
                    ]
                );
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                // Liste des tâches du groupe
                $listeTache = $task->groupe->tache;
            }
            // Sinon, vérifie que l’utilisateur est bien le propriétaire
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
        // Cas où aucune tâche spécifique n’est demandée
        else{
            $task = null;
            $listeTache = $user->tache;
        }

        // Gestion du groupe lié
        $groupe = $task->groupe_id ?? null;
        if (isset($groupe))
        {
            // Vérifie que l’utilisateur appartient bien au groupe
            if(!$user->groupe->contains('id',$groupe))
            {     
                $groupe = null;
            }   
            else {
                $groupe = $user->groupe->where('id', $groupe)->first();
                $listeTache = $groupe->tache;
            }
        }
        else{
            $groupe = null;
            $listeTache = $user->tasks;
        }

        //  Récupération des messages liés à la tâche
        if ($task != null) {
            $messages = $task->message()->orderByDesc('created_at')->get();
            if (!isset($messages)){
                $messages = null;
            }
        }
        else {
            $messages = null;
        }

        // Vue détaillée de la tâche
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
        $task = Task::findOrFail($id);

        // Validation du champ 'etat'
        $validated = $request->validate([
            'etat' => 'required|in:nouveau,planifie,en_cours,termine',
        ]);

        // Mise à jour et sauvegarde
        $task->etat = $validated['etat'];
        $task->save();

        return response()->json(['success' => true]);
    }

    /**
     * Met à jour les dates de début et de fin d'une tâche.
     * Utilisée notamment pour le glisser-déposer dans un calendrier (ex: FullCalendar).
     */
    public function updateDates(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Validation des dates
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        // Conversion et ajustement des dates (+1 jour pour correction de fuseau)
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
