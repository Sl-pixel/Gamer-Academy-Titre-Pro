@extends('layout') 

@section('title', 'Inscription')

@section('content') 
    <div class="flex justify-center items-center min-h-[60vh]">
   
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">

            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Créer un compte</h2>


            <!-- Affiche les erreurs de validation sous chaque champ concerné -->
            <!-- Formulaire d'inscription qui envoie les données à la route 'registerUser' -->
            <form id="registerForm" method="POST" action="{{ route('registerUser') }}" novalidate>
                @csrf <!-- Token CSRF pour la protection contre les attaques CSRF -->

                <!-- Champ pour le pseudo -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Pseudo</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p id="nameError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer un pseudo.</p>
                </div>

                <!-- Champ pour l'adresse email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Adresse email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer une adresse email.</p>
                </div>

                <!-- Champ pour le mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Mot de passe</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p id="passwordError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer un mot de passe.</p>
                </div>

                <!-- Bouton de soumission du formulaire -->

                <p id="registerError" class="text-red-500 text-sm mb-2 hidden">Veuillez remplir tous les champs.</p>
                <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold py-2 rounded transition">
                    S'inscrire
                </button>

                <!-- Lien vers la page de connexion -->
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-indigo-700 hover:underline">
                        Déjà inscrit ? Se connecter
                    </a>
                </div>
            </form>
            <script>
                    // Ajoute un écouteur d'événement au formulaire qui écoute l'événement 'submit'
                document.getElementById('registerForm').addEventListener('submit', function(e) {
                    // Initialise une variable pour suivre la validité du formulaire
                    let valid = true;

                    // Obtient les références aux champs du formulaire et à leurs éléments de message d'erreur correspondants
                    const name = document.getElementById('name');
                    const email = document.getElementById('email');
                    const password = document.getElementById('password');
                    const nameError = document.getElementById('nameError');
                    const emailError = document.getElementById('emailError');
                    const passwordError = document.getElementById('passwordError');

                    // Valide le champ 'name'
                    if (!name.value.trim()) {
                        // Si le champ du nom est vide, affiche le message d'erreur et marque le formulaire comme invalide
                        nameError.classList.remove('hidden');
                        valid = false;
                    } else {
                        // Si le champ du nom n'est pas vide, cache le message d'erreur
                        nameError.classList.add('hidden');
                    }

                    // Valide le champ 'email' en utilisant une expression régulière pour vérifier un format d'email valide
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!email.value.trim() || !emailPattern.test(email.value)) {
                        // Si le champ email est vide ou le format de l'email est invalide, affiche le message d'erreur approprié et marque le formulaire comme invalide
                        emailError.textContent = !email.value.trim() ? 'Veuillez entrer une adresse email.' : 'Veuillez entrer une adresse email valide.';
                        emailError.classList.remove('hidden');
                        valid = false;
                    } else {
                        // Si le champ email est valide, cache le message d'erreur
                        emailError.classList.add('hidden');
                    }

                    // Valide le champ 'password'
                    if (!password.value.trim() || password.value.length < 4) {
                        // Si le champ mot de passe est vide ou la longueur du mot de passe est inférieure à 4 caractères, affiche le message d'erreur approprié et marque le formulaire comme invalide
                        passwordError.textContent = !password.value.trim() ? 'Veuillez entrer un mot de passe.' : 'Le mot de passe doit contenir au moins 4 caractères.';
                        passwordError.classList.remove('hidden');
                        valid = false;
                    } else {
                        // Si le champ mot de passe est valide, cache le message d'erreur
                        passwordError.classList.add('hidden');
                    }

                    // Si le formulaire n'est pas valide, empêche la soumission du formulaire
                    if (!valid) {
                        e.preventDefault();
                    }
                });
s            </script>
        </div>
    </div>
@endsection
