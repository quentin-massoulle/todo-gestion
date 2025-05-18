<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('layout.connexion')}}</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>{{__('layout.connexion')}}</h2>
        @error('connexion')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <form method="post">
            @csrf
            <div class=inputDiv>
                <h4>{{__('login.email')}}</h4>
                <input type="email" placeholder="{{__('login.emailPlaceholder')}}" required name='email'>
            </div>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class=inputDiv>
                <h4>{{__('login.mdp')}}</h4>
                <input type="password" placeholder="{{__('login.mdpPlaceholder')}}" required name='mdp'>
            </div>
            @error('mdp')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit">{{__('layout.connexion')}}</button>
        </form>
        <a href="signUp" class="register-link">{{__('login.signUp')}}</a>
    </div>
</body>