<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function storeGroupe(Request $request){
        $validator = Validator::make($request->all(),
            [
                'groupe' => 'required|exists:taches,id',
                'message'=> 'required|string'
            ], 
            [
                'groupe.required' =>  __('validator.groupe.id.required'),
                'groupe.exists' =>   __('validator.groupe.id.exists'),
                'message.required' =>  __('validator.message.required'),
                'message.exists' =>   __('validator.message.string'),
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user=Auth::user();
        if ($user) {
            $message = new Message();
            $message->user_id=$user->id;
            $message->groupe_id = $request->groupe;
            $message->contenu = $request->message;
            $message->save();
        }
        else {
            return back()->withErrors(__('validator.access_denied'));
        }
        return back()->with('success', 'Opération réussie.');

        
    }
}
