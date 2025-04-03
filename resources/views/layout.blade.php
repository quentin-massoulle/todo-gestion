<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('style')

</head>
<body>
    <header>
        <nav>
            <div class="logo"></div>
            <div class="nav-links">
                <a href="/">{{__('layout.Accueil')}}</a>
                <a href="#">{{__('layout.ÀPropos')}}</a>
            </div>
            <div class="login-button">
                <a href="./login">{{__('layout.connexion')}}</a>
            </div>
        </nav>
    </header>
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
