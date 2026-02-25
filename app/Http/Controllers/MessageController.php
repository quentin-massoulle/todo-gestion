<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Models\Groupe;
use App\Models\Tache;
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
    try {
        // 1. Déterminer si on cherche par tâche ou par groupe
        if ($request->has('tache')) {
            $model = Tache::find($request->tache);
            if (!$model) return response()->json(['success' => false, 'message' => 'Tâche introuvable'], 404);
        } elseif ($request->has('groupe')) {
            $model = Groupe::find($request->groupe);
            if (!$model) return response()->json(['success' => false, 'message' => 'Groupe introuvable'], 404);
        } else {
            return response()->json(['success' => false, 'message' => 'Paramètre manquant'], 422);
        }

        // 2. Récupérer les messages (Attention au nom de la relation : messages ou message ?)
        // On utilise 'with' pour charger les utilisateurs et éviter de faire 100 requêtes SQL
        $messages = $model->message() // Remplace par messages() si tu as une erreur sur cette ligne
                          ->with('user') 
                          ->orderBy('created_at', 'desc') // 'asc' pour que le nouveau soit en bas
                          ->get();

        // 3. Formatage sécurisé
        $data = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'contenu' => $message->contenu,
                // On vérifie que created_at existe pour éviter le crash
                'created_at_human' => $message->created_at ? $message->created_at->diffForHumans() : 'Date inconnue',
                'user_id' => $message->user_id,
                'user' => [
                    'prenom' => $message->user->prenom ?? 'Utilisateur',
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);

    } catch (\Exception $e) {
        // Cette ligne va t'afficher l'erreur exacte dans l'onglet Network de ton navigateur
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}
