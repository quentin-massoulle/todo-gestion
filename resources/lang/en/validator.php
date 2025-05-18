<?php

return 
[
    'name.required' => 'The name is required.',
    'email.required' => 'The email address is required.',
    'email.email' => 'Please enter a valid email address.',
    'email.unique' => 'This email is already in use.',
    'email.exists' => 'No account exists with this email.',
    
    'mdp.required' => 'The password is required.',
    'mdp.min' => 'The password must be at least 6 characters.',
    'mdp.confirmed' => 'Passwords do not match.',
    
    'access_denied' => 'Access denied.',
    
    'titre.required' => 'The title is required.',
    'titre.string' => 'The title must be a string.',
    'titre.max' => 'The title may not be greater than 255 characters.',
    
    'description.required' => 'The description is required.',
    'description.string' => 'The description must be a string.',
    'description.max' => 'The description may not be greater than 255 characters.',
    
    'date_fin.required' => 'The end date is required.',
    'date_fin.date' => 'The end date must be a valid date.',
    
    'rappel_active.boolean' => 'The reminder must be true or false.',
    'task' => [
        'id'=>[
            'exists' => 'The task must exist.',
            'required' => 'The task ID is required.',
            'UserExiste' => "You are not the owner of this task.",
        ]
    ],

    'login' => 
        [
        'failed' => 'Incorrect email address or password.',
        ]
];