<?php

namespace App\Http\Controllers;

use App\Models\User ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'email' => 'required|exists:users,email',  // Vérifie que l'email existe dans la table 'users'
            'mdp' => 'required',  // Vérifie que le mot de passe est requis
        ], 
        [
            'email.required' => __('validator.email.required'),
            'email.exists' => __('validator.email.exists'),  // Message personnalisé si l'email n'existe pas dans la base
            'mdp.required' => __('validator.mdp.required'),  // Message personnalisé si le mot de passe est requis
        ]
        );
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Tentative de connexion avec les informations fournies
        $credentials = [
            'email' => $request->email,
            'password' => $request->mdp,
        ];
    
        // Vérifie si les informations sont valides et si l'utilisateur existe
        if (Auth::attempt($credentials)) {
            // Si la connexion réussit, redirige l'utilisateur vers la page souhaitée (par exemple, le tableau de bord)
            return redirect()->route('user.dashboard');
        }
    
        // Si la tentative échoue, renvoie un message d'erreur
        return back()->withErrors(['email' => __('validator.login.failed')])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Déconnecte l'utilisateur

        $request->session()->invalidate(); // Invalide la session

        $request->session()->regenerateToken(); // Regénère le token CSRF

        return redirect('./'); // Redirige où tu veux (ex: page d'accueil)
    }
}