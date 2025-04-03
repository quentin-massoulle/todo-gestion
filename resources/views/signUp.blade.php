<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('login.signUp')}}</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>{{__('login.signUp')}}</h2>
        <form method="post">
            @csrf
            <div class=inputDiv>
                <h4>{{__('login.name')}}</h4>
                <input type="text" placeholder="{{__('login.namePlaceholder')}}"required name='name'>
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class=inputDiv>
                <h4>{{__('login.email')}}</h4>
                <input type="email" placeholder="{{__('login.emailPlaceholder')}}"required name='email'>
            </div>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class=inputDiv>
                <h4>{{__('login.mdp')}}</h4>
                <input type="password" placeholder="{{__('login.mdpPlaceholder')}}"required name='mdp'>
            </div>
            @error('mdp')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class=inputDiv>
                <h4>{{__('login.mdpConfirme')}}</h4>
                <input type="password" placeholder="{{__('login.mdpPlaceholder')}}"required name='mdp_confirmation'>
            </div>
            @error('mdp')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit">{{__('login.signUp')}}</button>
        </form>
        <a href="login" class="register-link">{{__('layout.connexion')}}</a>
    </div>
</body>