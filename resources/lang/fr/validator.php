<?php

return [
    'name.required' => 'Le nom est obligatoire.',
    'email.required' => 'L\'adresse e-mail est obligatoire.',
    'email.email' => 'Veuillez entrer une adresse e-mail valide.',
    'email.unique' => 'Cet e-mail est déjà utilisé.',
    'email.exists' => 'Aucun compte n\'existe avec cet e-mail.',
    
    'mdp.required' => 'Le mot de passe est obligatoire.',
    'mdp.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
    'mdp.confirmed' => 'Les mots de passe ne correspondent pas.',
    
    'access_denied' => 'Connexion rejetée.',
    
    'titre.required' => 'Le titre est requis.',
    'titre.string' => 'Le titre doit être une chaîne de caractères.',
    'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
    
    'description.required' => 'La description est requise.',
    'description.string' => 'La description doit être une chaîne de caractères.',
    'description.max' => 'La description ne peut pas dépasser 255 caractères.',
    
    'date_fin.required' => 'La date de fin est requise.',
    'date_fin.date' => 'La date de fin doit être une date valide.',
    
    'rappel_active.boolean' => 'Le rappel doit être vrai ou faux.',
    
    'task' => [
        'id'=>[
            'exists' => "La tâche doit exister.",
            'required' => "L'identifiant de la tâche est obligatoire.",
            'UserExiste' => "Vous n'êtes pas propriétaire de cette tâche.",
        ]
    ],
    'login' => 
        [
        'failed' => 'Adresse e-mail ou mot de passe incorrect.',
        ]
];