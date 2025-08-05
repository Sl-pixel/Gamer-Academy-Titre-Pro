<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamerAcademy</title>
    <link rel="shortcut icon" href="{{ asset('images/logoGamerAcademy.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('js/admin-create.js') }}">
    <link rel="stylesheet" href="{{ asset('js/auth.js') }}">
    <link rel="stylesheet" href="{{ asset('js/register.js') }}">
    <link rel="stylesheet" href="{{ asset('js/caroussel.js') }}">
</head>
<body>
    <header class="navbar">
        <div class="container navbar-container">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logoGamerAcademy.png') }}" alt="logo du site" class="navbar-logo">
            </a>
            <nav>
                <ul class="navbar-nav">
                    <li><a href="{{ url('/') }}" class="navbar-link">Accueil</a></li>
                    <li><a href="{{ url('/contact') }}" class="navbar-link">Contactez-nous</a></li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li><a href="{{ route('adminDashboard') }}" class="navbar-link">Dashboard Admin</a></li>
                        @endif
                        @if(auth()->user()->isCoach())
                            <li><a href="{{ route('coachDashboard', auth()->user()->id) }}" class="navbar-link">Interface coach</a></li>
                        @endif
                        @if(auth()->user()->isStudent())
                            <li><a href="{{ route('studentDashboard', auth()->user()->id) }}" class="navbar-link">Mon Espace Élève</a></li>
                        @endif
                        <li><a href="{{ route('logout') }}" class="navbar-link logout">Déconnexion</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="navbar-link">Connexion</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>
    <main class="container main-content">
        @yield('content')
    </main>
    <footer class="footer">
        <div class="container footer-container">
            <div>
                <h2 class="footer-title">Contact</h2>
                <ul class="footer-list">
                    <li><a href="{{ url('/contact') }}" class="footer-link">Contactez-nous</a></li>
                    <li><a href="{{ url('/discord') }}" class="footer-link">Discord</a></li>
                </ul>
            </div>
            <div>
                <h2 class="footer-title">Jeux</h2>
                <ul class="footer-list">
                    <li><a href="{{ url('/games/valorant') }}" class="footer-link">Valorant</a></li>
                    <li><a href="{{ url('/games/cs2') }}" class="footer-link">CS2</a></li>
                    
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>