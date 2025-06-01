<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function storeGroupe(Request $resquest){
        $user=Auth::user();
        $message = new Message();
        $message->user_id=$user->id;
        $message->groupe_id = $resquest->groupe;
        $message->contenu = $resquest->message;
        $message->save();
    }
}
