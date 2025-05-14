<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('js')
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('style')

</head>
<body>
    <header>
        <nav>
            <div class=logo>
                <a href="">
                    <i class="fas fa-wallet fa-3x"></i>
                    <h1 class="text-2xl font-bold">TodoGestion</h1>
                </a>
            </div>
                <!-- Menu hamburger -->
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
            <div class="nav-links" id="nav-links">
                <a href="/">{{ __('layout.taches')}}</a>
                <a href="/">{{ __('layout.groupe')}}</a>
                <a href="/">{{__('layout.profil')}}</a>
                @if (Auth::check())
                <div class='bnt-log'>
                    <a href="/logOut">{{ __('layout.deconnexion') }}</a>
                </div >
                @else
                <div class="bnt-log">
                    <a href="./login">{{ __('layout.connexion') }}</a>
                </div>
                @endif
            </div>
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.getElementById('nav-links');

        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
    @yield('script')
</body>
</html>
