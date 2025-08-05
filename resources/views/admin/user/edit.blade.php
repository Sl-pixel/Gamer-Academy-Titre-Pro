@extends('layout')

@section('title', 'Modifier le profil')

@section('content')
<!-- Section principale où le contenu de la page sera inséré -->
<div class="flex justify-center items-center min-h-[70vh] bg-gray-50 py-10">
    <!-- Conteneur principal de la fenêtre -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-md p-8">

        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-8">Modifier le profil de {{ $user->name }}</h2>
        <!-- Titre de la page -->

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Conteneur flex qui passe en ligne sur les écrans moyens et plus grands -->

            <!-- Section pour la photo et le rôle de l'utilisateur -->
            <div class="md:w-1/3 flex flex-col items-center border-r border-gray-200 pr-4">
                <!-- Affiche la photo de profil de l'utilisateur -->
                <!-- Si l'utilisateur n'a pas de photo de profil, une image par défaut est utilisée -->
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('/images/default-avatar-profile.jpg') }}"
                    alt="Photo de {{ $user->name }}"
                    class="rounded-full h-32 w-32 object-cover mb-4 shadow-md">

                <p class="text-sm text-gray-600 mb-1">Rôle actuel :</p>
                <!-- Texte indiquant le rôle actuel -->
                <span class="text-md font-semibold text-indigo-600">{{ $user->role }}</span>
                <!-- Affiche le rôle actuel de l'utilisateur -->

                <!-- Formulaire pour changer le rôle de l'utilisateur -->
                <form action="{{ route('user.updateRoleOnly', $user->id) }}" method="POST" class="mt-4 w-full text-center">
                    @csrf
                    <!-- Token CSRF pour sécuriser le formulaire -->
                    @method('PUT')
                    <!-- Utilise la méthode PUT pour la mise à jour -->
                    <select name="role" onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <!-- Menu déroulant pour sélectionner le rôle -->
                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Étudiant</option>
                        <option value="coach" {{ $user->role == 'coach' ? 'selected' : '' }}>Coach</option>
                    </select>
                    <!-- Soumet le formulaire dès que la sélection change -->
                </form>

                <!-- Bouton pour revenir à la page précédente -->
                <button onclick="window.history.back()"
                    class="mt-6 px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600">
                    Retour
                </button>
            </div>

            <!-- Formulaire principal pour modifier les informations de l'utilisateur -->
            <div class="md:w-2/3">
                <form method="POST" action="{{ route('updateUser', $user->id) }}" class="space-y-6">
                    @csrf
                    <!-- Token CSRF pour sécuriser le formulaire -->
                    @method('PUT')
                    <!-- Utilise la méthode PUT pour la mise à jour -->

                    <!-- Champ pour le nom de l'utilisateur -->
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-medium mb-1">Nom</label>
                        <input type="text" name="name" id="name" placeholder="Laisser vide pour ne pas changer"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ pour l'email de l'utilisateur -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" id="email" placeholder="Laisser vide pour ne pas changer"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ pour le Discord de l'utilisateur -->
                    <div>
                        <label for="discord" class="block text-gray-700 text-sm font-medium mb-1">Discord</label>
                        <input type="text" name="discord" id="discord" placeholder="Laisser vide pour ne pas changer"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @error('discord')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ pour le mot de passe -->
                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" placeholder="Laisser vide pour ne pas changer"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton pour enregistrer les modifications -->
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg">
                        Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection