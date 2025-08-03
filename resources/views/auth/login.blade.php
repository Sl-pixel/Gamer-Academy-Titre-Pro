@extends('layout') 

@section('title', 'Connexion') 

@section('content')
    <div class="flex justify-center items-center min-h-[60vh]">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Connexion</h2>
            <!-- Affiche un message d'erreur s'il y en a un dans la session -->
            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-center">{{ session('error') }}</div>
            @endif

            <!-- Formulaire de connexion qui envoie les données à la route 'loginUser' -->
            <form id="loginForm" method="POST" action="{{ route('loginUser') }}" novalidate>
                @csrf <!-- Token CSRF pour la protection contre les attaques CSRF -->

                <!-- Champ pour l'adresse email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        Adresse email
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required autofocus>
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer une adresse email.</p>
                </div>

                <!-- Champ pour le mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        Mot de passe
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <p id="passwordError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer un mot de passe.</p>
                </div>

                <!-- Case à cocher pour "Se souvenir de moi" -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 focus:ring-indigo-400" id="remember">
                    <label class="text-gray-600" for="remember">Se souvenir de moi</label>
                </div>


                <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold py-2 rounded transition">
                    Se connecter
                </button>

                <!-- Lien vers la page d'inscription -->
                <div class="mt-4 text-center">
                    <a href="{{ route('registerForm') }}" class="text-indigo-700 hover:underline">
                        Pas encore inscrit ? Créez votre compte
                    </a>
                </div>
            </form>
            <script>
                // Ajoute un écouteur d'événement sur le formulaire avec l'ID 'loginForm' pour l'événement 'submit'
                document.getElementById('loginForm').addEventListener('submit', function(e) {
                    // Initialise une variable 'valid' pour vérifier si le formulaire est valide
                    let valid = true;

                    // Récupère les éléments du formulaire et les éléments d'erreur associés
                    const email = document.getElementById('email');
                    const password = document.getElementById('password');
                    const emailError = document.getElementById('emailError');
                    const passwordError = document.getElementById('passwordError');

                    // Expression régulière pour valider le format de l'email
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    // Validation du champ email
                    if (!email.value.trim() || !emailPattern.test(email.value)) {
                        // Si le champ email est vide ou si le format est invalide, affiche un message d'erreur approprié
                        emailError.textContent = !email.value.trim() ? 'Veuillez entrer une adresse email.' : 'Veuillez entrer une adresse email valide.';
                        emailError.classList.remove('hidden'); // Affiche le message d'erreur
                        valid = false; // Marque le formulaire comme invalide
                    } else {
                        // Si le champ email est valide, cache le message d'erreur
                        emailError.classList.add('hidden');
                    }

                    // Validation du champ mot de passe
                    if (!password.value.trim() || password.value.length < 4) {
                        // Si le champ mot de passe est vide ou si le mot de passe a moins de 4 caractères, affiche un message d'erreur approprié
                        passwordError.textContent = !password.value.trim() ? 'Veuillez entrer un mot de passe.' : 'Le mot de passe doit contenir au moins 4 caractères.';
                        passwordError.classList.remove('hidden'); // Affiche le message d'erreur
                        valid = false; // Marque le formulaire comme invalide
                    } else {
                        // Si le champ mot de passe est valide, cache le message d'erreur
                        passwordError.classList.add('hidden');
                    }

                    // Si le formulaire n'est pas valide, empêche sa soumission
                    if (!valid) {
                        e.preventDefault();
                    }
                });
            </script>
        </div>
    </div>
@endsection
