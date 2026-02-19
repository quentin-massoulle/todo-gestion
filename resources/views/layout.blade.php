<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TodoGestion')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('style')
</head>
<body>
    @if (session('success') || $errors->any())@endif

    <nav>
        <div class="logo">
            <a href="/" class="flex items-center gap-3">
                <i class="fas fa-wallet fa-3x"></i>
                <h1 class="text-2xl font-bold">TodoGestion</h1>
            </a>
        </div>

        <div class="menu-toggle" id="mobile-menu">
            <i class="fas fa-bars"></i>
        </div>

        <div class="nav-links" id="nav-links">
            @auth
                <a href="{{ route('user.tasks') }}">{{ __('layout.taches') }}</a>
                <a href="{{ route('user.groupes') }}">{{ __('layout.groupe') }}</a>
                <a href="{{ route('user.profile') }}">{{ __('layout.profil') }}</a>
                <div class='bnt-log'>
                    <a href="/logOut">{{ __('layout.deconnexion') }}</a>
                </div>
            @else
                <a href="/">{{ __('layout.Accueil') }}</a>
                <a href="#">{{ __('layout.ÀPropos') }}</a>
                <div class="bnt-log">
                    <a href="./login">{{ __('layout.connexion') }}</a>
                </div>
            @endauth
        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} TodoGestion. Tous droits réservés.</p>
    </footer>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Script pour le menu mobile
        document.getElementById('mobile-menu').addEventListener('click', () => {
            document.getElementById('nav-links').classList.toggle('active');
        });
    </script>
    @yield('script')
</body>
</html>