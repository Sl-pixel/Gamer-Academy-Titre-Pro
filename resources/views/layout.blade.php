<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamerAcademy</title>
    <link rel="shortcut icon" href="{{ asset('images/logoGamerAcademy.png') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head> 
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">
    <header class="bg-white shadow mb-6">
        <div class="container mx-auto flex items-center justify-between py-4 px-6">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logoGamerAcademy.png') }}" alt="logo du site" class="h-12">
            </a>
            <nav id="nav-menu" class="md:flex md:items-center">
                <ul class="flex flex-col md:flex-row items-center gap-6">
                    <li>
                        <a href="{{ url('/') }}" class="font-semibold text-gray-700 hover:text-indigo-700">Accueil</a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="font-semibold text-gray-700 hover:text-indigo-700">Contactez-nous</a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li><a href="{{ route('adminDashboard') }}" class="font-semibold text-gray-700 hover:text-indigo-700">Dashboard Admin</a></li>
                        @endif
                        @if(auth()->user()->isCoach())
                            <li><a href="{{ route('coachDashboard', auth()->user()->id) }}" class="font-semibold text-gray-700 hover:text-indigo-700">Interface coach</a></li>
                        @endif
                        @if(auth()->user()->isStudent())
                            <li><a href="{{ route('studentDashboard', auth()->user()->id) }}" class="font-semibold text-gray-700 hover:text-indigo-700">Mon Espace Élève</a></li>
                        @endif
                        <li>
                            <a href="{{ route('logout') }}" class="font-semibold text-red-600 hover:text-red-800">Déconnexion</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="font-semibold text-indigo-700 hover:text-indigo-900">Connexion</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>
    <main class="flex-1 container mx-auto px-4">
        @yield('content')
    </main>
    <footer class="bg-white border-t mt-8 py-8">
        <div class="container mx-auto flex flex-col md:flex-row justify-between gap-8 px-4">
            <div>
                <h2 class="text-lg font-bold mb-2 text-indigo-700">Contact</h2>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-indigo-700">Contactez-nous</a>
                    </li>
                    <li>
                        <a href="{{ url('/discord') }}" class="text-gray-700 hover:text-indigo-700">Discord</a>
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="text-lg font-bold mb-2 text-indigo-700">Jeux</h2>
                <ul class="space-y-1">
                    <li><a href="{{ url('/valo') }}" class="text-gray-700 hover:text-indigo-700">Valorant</a></li>
                    <li><a href="{{ url('/cs2') }}" class="text-gray-700 hover:text-indigo-700">CS2</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
