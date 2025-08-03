@extends('layout') 

@section('title', 'Créer un utilisateur') 

@section('content')
<div class="flex justify-center items-center min-h-[70vh] py-10">
    <!-- Conteneur principal de la fenêtre -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-md p-8">

        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-8">Créer un Administrateur</h2>
        <!-- Titre -->

        <!-- Affiche un message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-center">
            <!-- Conteneur pour centrer le formulaire -->
            <div class="w-full md:w-2/3">
                <!-- Formulaire pour créer un administrateur, qui envoie les données à la route 'createAdmin' -->
                <form method="POST" action="{{ route('createAdmin') }}" class="space-y-6" id="admin-create-form" novalidate>
                    @csrf <!-- Token CSRF pour la protection contre les attaques CSRF -->

                    <!-- Champ pour le pseudo -->
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-medium mb-1">Pseudo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('name') border-red-500 @enderror">
                        <p class="text-red-500 text-xs mt-1 hidden" id="name-error"></p>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ pour l'email -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('email') border-red-500 @enderror">
                        <p class="text-red-500 text-xs mt-1 hidden" id="email-error"></p>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ pour le mot de passe -->
                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Mot de passe</label>
                        <input type="password" name="password" id="password" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('password') border-red-500 @enderror">
                        <p class="text-red-500 text-xs mt-1 hidden" id="password-error"></p>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition shadow-sm">
                        Créer L'Administrateur
                    </button>
                </form>

                <!-- Bouton pour revenir en arrière -->
                <div class="mt-6 flex justify-start space-x-4">
                    <button onclick="goBack()" class="px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600 transition duration-300">
                        Retour
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script JavaScript pour revenir en arrière dans l'historique du navigateur et valider le formulaire -->
<script>
    function goBack() {
        window.history.back();
    }

// Écoute l'événement 'DOMContentLoaded' qui se déclenche lorsque le DOM est complètement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Récupère les éléments du formulaire et des messages d'erreur
    const form = document.getElementById('admin-create-form');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const nameError = document.getElementById('name-error');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    // Ajoute un écouteur d'événement pour la soumission du formulaire
    form.addEventListener('submit', function(e) {
        let valid = true; // Variable pour suivre la validité du formulaire

        // Cache tous les messages d'erreur au début de la validation
        nameError.classList.add('hidden');
        emailError.classList.add('hidden');
        passwordError.classList.add('hidden');

        // Validation du champ 'name' (pseudo)
        if (!name.value.trim()) {
            nameError.textContent = 'Le pseudo est requis.';
            nameError.classList.remove('hidden');
            valid = false;
        } else if (name.value.length < 3) {
            nameError.textContent = 'Le pseudo doit contenir au moins 3 caractères.';
            nameError.classList.remove('hidden');
            valid = false;
        }

        // Validation du champ 'email'
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expression régulière pour valider l'email
        if (!email.value.trim()) {
            emailError.textContent = 'L\'email est requis.';
            emailError.classList.remove('hidden');
            valid = false;
        } else if (!emailPattern.test(email.value)) {
            emailError.textContent = 'Le format de l\'email est invalide.';
            emailError.classList.remove('hidden');
            valid = false;
        }

        // Validation du champ 'password' (mot de passe)
        if (!password.value) {
            passwordError.textContent = 'Le mot de passe est requis.';
            passwordError.classList.remove('hidden');
            valid = false;
        } else if (password.value.length < 4) {
            passwordError.textContent = 'Le mot de passe doit contenir au moins 4 caractères.';
            passwordError.classList.remove('hidden');
            valid = false;
        }

        // Si le formulaire n'est pas valide, empêche sa soumission
        if (!valid) {
            e.preventDefault(); // Empêche l'envoi du formulaire
        }
    });
});

</script>
@endsection
