<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function storeGroupe(Request $request)
{
    $validator = Validator::make($request->all(), [
        'groupe'  => 'required|exists:taches,id',
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

}
