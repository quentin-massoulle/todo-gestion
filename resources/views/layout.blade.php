<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('style')

</head>
<body>
    <header>
        <nav>
            <div class=logo>
                <i class="fas fa-wallet fa-3x"></i>
                <h1 class="text-2xl font-bold">TodoGestion</h1>
            </div>
            <div class="nav-links">
                <a href="/">{{__('layout.Accueil')}}</a>
                <a href="#">{{__('layout.ÀPropos')}}</a>
            </div>
            @if (Auth::check())
                <div class='bnt-log'>
                    <a href="/logOut">{{ __('layout.deconnexion') }}</a>   
                </div >
            @else
                <div class="bnt-log">
                    <a href="./login">{{ __('layout.connexion') }}</a>
                </div>
            @endif

        </nav>
    </header>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="content">
        @yield('content')
    </div>
    <footer>
        <p>&copy; {{ date('Y') }} Mon Site Web. Tous droits réservés.</p>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
