<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Models\Groupe;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Méthode pour enregistrer un message.
     * Peut être lié à une tâche (tache_id) ou à un groupe (groupe_id).
     */
    public function store(Request $request)
    {   
        // Si la requête contient un identifiant de tâche
        if ($request->tache) {

            // Validation des données d’entrée
            $validator = Validator::make($request->all(), [
                'tache'  => 'required|exists:taches,id',
                'message' => 'required|string',
            ], [
                'tache.required' => __('validator.task.id.required'),
                'tache.exists'   => __('validator.task.id.exists'),
                'message.required'=> __('validator.message.required'),
                'message.string'  => __('validator.message.string'),
            ]);

            // Retourne une erreur si la validation échoue
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Vérifie que l’utilisateur est bien authentifié
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => __('validator.access_denied'),
                ], 401);
            }

            // Création du message lié à une tâche
            $message = new Message();
            $message->user_id    = $user->id;
            $message->tache_id   = $request->tache;
            $message->contenu    = $request->message;
            $message->save();

            // Retourne une réponse JSON avec le message créé
            return response()->json([
                'success' => true,
                'message' => 'Message envoyé',
                'data'    => [
                    'contenu'  => $message->contenu,
                    'user'     => $user->name,
                    'created'  => $message->created_at->diffForHumans(),
                ]
            ]);
        } 
        // Sinon, on vérifie si un groupe est précisé
        else {
            if ($request->groupe) {

                // Validation des données pour le groupe
                $validator = Validator::make($request->all(), [
                    'groupe'  => 'required|exists:groupe,id',
                    'message' => 'required|string',
                ], [
                    'groupe.required' => __('validator.groupe.id.required'),
                    'groupe.exists'   => __('validator.groupe.id.exists'),
                    'message.required'=> __('validator.message.required'),
                    'message.string'  => __('validator.message.string'),
                ]);

                // En cas d’erreur de validation
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors'  => $validator->errors(),
                    ], 422);
                }

                // Vérifie que l’utilisateur est bien connecté
                $user = Auth::user();
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => __('validator.access_denied'),
                    ], 401);
                }

                // Création du message lié à un groupe
                $message = new Message();
                $message->user_id    = $user->id;
                $message->groupe_id  = $request->groupe;
                $message->contenu    = $request->message;
                $message->save();
                
                // Réponse JSON
                return response()->json([
                    'success' => true,
                    'message' => 'Message envoyé',
                    'data'    => [
                        'contenu'  => $message->contenu,
                        'user'     => $user->name,
                        'created'  => $message->created_at->diffForHumans(),
                    ]
                ]);
            }
        }
    }

    /**
     * Méthode pour récupérer les messages d’une tâche ou d’un groupe.
     */
    public function get(Request $request)
    {
        // Si on veut les messages d’une tâche
        if($request->tache) {
            // Validation du paramètre "tache"
            $validator = Validator::make($request->all(), [
                'tache'  => 'required|exists:taches,id',
            ], [
                'tache.required' => __('validator.task.id.required'),
                'tache.exists'   => __('validator.task.id.exists'),
            ]);

            // Si la validation échoue
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Récupération des messages liés à la tâche
            $tacheId = $request->tache;
            $tache   = Task::find($tacheId);
            $messages = $tache->message()->orderBy('created_at', 'desc')->get();
        }
        // Sinon, récupération des messages d’un groupe
        else {
            $validator = Validator::make($request->all(), [
                'groupe'  => 'required|exists:groupe,id',
            ], [
                'groupe.required' => __('validator.groupe.id.required'),
                'groupe.exists'   => __('validator.groupe.id.exists'),
            ]);

            // Validation échouée
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Récupération des messages du groupe
            $groupeId = $request->groupe;
            $groupe   = Groupe::find($groupeId);
            $messages = $groupe->message()->orderBy('created_at', 'desc')->get();
        }

        // Formatage des messages pour la réponse JSON
        $data = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'contenu' => $message->contenu,
                'created_at_human' => $message->created_at->diffForHumans(),
                'user_id' => $message->user_id,
                'user' => [
                    'prenom' => $message->user->prenom ?? 'Utilisateur',
                ]
            ];
        });

        // Réponse finale
        return response()->json([
            'success' => true,
            'message' => 'Message envoyé',
            'data'    => $data,
        ]);
    }
}
