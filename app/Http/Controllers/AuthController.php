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
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mdp' => 'required|min:6|confirmed',
            ], 
            [
            'nom.required' => __('validator.nom.required'),
            'prenom.required' => __('validator.prenom.required'),
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

        $user = new User([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->mdp),
        ]);
        
        $user->save();
        
        Auth::login($user); 
        
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return back();
    }

    public function login(Request $request, $role = 'user')
    {

        $validator = Validator::make($request->all(), 
        [
            'email' => 'required|exists:users,email', 
            'mdp' => 'required', 
        ], 
        [
            'email.required' => __('validator.email.required'),
            'email.exists' => __('validator.email.exists'), 
            'mdp.required' => __('validator.mdp.required'),  
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->mdp,
        ];
        if (Auth::attempt($credentials)) {
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.dashboard');
        }
        return back()->withErrors(['connexion' => __('validator.login.failed')])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('./');
    }
}