<!DOCTYPE html>
<html lang="fr">
<head>
    @yield('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('js')
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('style')
    
</head>
<body>
    @if (session('success'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 5000)" 
            x-show="show"
            x-transition
            class="fixed top-4 left-4 bg-green-100 border border-green-400 text-green-700 text-sm px-4 py-2 rounded shadow-md z-50"
        >
            <div class="flex items-center justify-between space-x-2">
                <div>
                    <strong class="font-semibold">Succès :</strong>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-green-700 hover:text-green-900">
                    &times;
                </button>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 7000)" 
            x-show="show"
            x-transition
            class="fixed top-4 left-4 bg-red-100 border border-red-400 text-red-700 text-sm px-4 py-2 rounded shadow-md z-50 w-80"
        >
            <div class="flex items-start justify-between space-x-2">
                <div>
                    <strong class="font-semibold">Erreur{{ $errors->count() > 1 ? 's' : '' }} :</strong>
                    <ul class="mt-1 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="text-red-700 hover:text-red-900 text-xl leading-none">
                    &times;
                </button>
            </div>
        </div>
    @endif

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
                <a href="{{ route('user.tasks')}}">{{ __('layout.taches')}}</a>
                <a href="{{ route('user.groupes')}}">{{ __('layout.groupe')}}</a>
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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
