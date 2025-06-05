<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Models\Groupe;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function storeGroupe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'groupe'  => 'required|exists:groupe,id',
            'message' => 'required|string',
        ], [
            'groupe.required' => __('validator.groupe.id.required'),
            'groupe.exists'   => __('validator.groupe.id.exists'),
            'message.required'=> __('validator.message.required'),
            'message.string'  => __('validator.message.string'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('validator.access_denied'),
            ], 401);
        }

        $message = new Message();
        $message->user_id    = $user->id;
        $message->groupe_id  = $request->groupe;
        $message->contenu    = $request->message;
        $message->save();
        
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

    public function getGroupe(Request $request){
        $validator = Validator::make($request->all(), [
            'groupe'  => 'required|exists:groupe,id',
        ], [
            'groupe.required' => __('validator.groupe.id.required'),
            'groupe.exists'   => __('validator.groupe.id.exists'),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $groupeId = $request->groupe;
        $groupe   = Groupe::find($groupeId);
        $messages = $groupe->message()->orderBy('created_at', 'desc')->get();


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

        return response()->json([
            'success' => true,
            'message' => 'Message envoyé',
            'data'    => $data,
        ]);
    }

}
