<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class taskController extends Controller
{
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), 
        [
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date'=> 'nullable|date'
        ], 
        [
            'titre.required' => __('validator.name.required'),
            'email.required' => __('validator.email.required'),
            'email.email' => __('validator.email.email'),
            'email.unique'=>__('validator.email.unique'),
            'mdp.required' => __('validator.required'),
            'mdp.min' => __('validator.mdp.min'),
            'mdp.confirmed' => __('validator.mdp.confirmed'),
        ]
    );
    }
}
