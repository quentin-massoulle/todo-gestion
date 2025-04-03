<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Se connecter</h2>
        <form>
            <div class=inputDiv>
                <h4>{{__('login.email')}}</h4>
                <input type="text" placeholder="{{__('login.emailPaceholder')}}"required>
            </div>
            
            <div class=inputDiv>
                <h4>{{__('login.mdp')}}</h4>
                <input type="password" placeholder="{{__('login.mdpPaceholder')}}"required>
            </div>
            <button type="submit">{{__('layout.connexion')}}</button>
        </form>
        <a href="#" class="register-link">Créer un compte</a>
    </div>
</body>