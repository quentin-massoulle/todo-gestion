<?php

namespace App\Http\Controllers;

use App\Models\User ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class login extends Controller
{
    public function signUp(Request $request)
    {
        // Validation des données avec des messages personnalisés
        $validator = Validator::make($request->all(), 
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mdp' => 'required|min:6|confirmed',
            ], 
            [
            'name.required' => __('validator.name.required'), // Message personnalisé
            'email.required' => __('validator.email.required'),
            'email.email' => __('validator.email.email'),
            'email.unique'=>__('validator.email.unique'),
            'mdp.required' => __('validator.required'),
            'mdp.min' => __('validator.mdp.min'),
            'mdp.confirmed' => __('validator.mdp.confirmed'),
            ]
        );
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // Vérifier si la validation échoue
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->mdp),  // Utilise Hash::make pour sécuriser le mot de passe
        ]);
        
        // Sauvegarde de l'utilisateur dans la base de données
        $user->save();
        
        // Connexion de l'utilisateur après l'inscription
        Auth::login($user);  // Cette ligne permet de connecter l'utilisateur immédiatement
        
        // Vérifier si l'utilisateur est connecté
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return back();
    }
}