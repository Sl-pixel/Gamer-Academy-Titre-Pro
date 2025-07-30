@extends('layout')
@section('title', 'Dashboard')
@section('content')

<div class="flex justify-center items-center min-h-[70vh] bg-50 py-10">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-8">Modifier le profil utilisateur</h2>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Colonne photo + rôle -->
            <div class="md:w-1/3 flex flex-col items-center border-r border-gray-200 pr-4">
                <img src="{{ $user->profile_picture }}" alt="Photo de {{ $user->name }}"
                    class="rounded-full h-32 w-32 object-cover mb-4 shadow-md">

                <p class="text-sm text-gray-600 mb-1">Rôle actuel :</p>
                <span class="text-md font-semibold text-indigo-600 capitalize">{{ $user->role }}</span>

                <!-- Formulaire changement de rôle -->
                <form action="{{ route('user.updateRoleOnly', $user->id) }}" method="POST" id="roleForm" class="mt-4 w-full text-center">
                    @csrf
                    @method('PUT')

                    <select name="role"
                        onchange="document.getElementById('submitRoleBtn').click()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Étudiant</option>
                        <option value="coach" {{ $user->role == 'coach' ? 'selected' : '' }}>Coach</option>
                    </select>
                    <button type="submit" id="submitRoleBtn" class="hidden"></button>
                </form>

             <div class="flex justify-center mt-6">
       <div class="mt-6 flex justify-start space-x-4">
            <button onclick="goBack()" class="px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600 transition duration-300">
                Retour
            </button>
        </div>

        <script>
            // Cette fonction utilise l'objet history de JavaScript pour revenir à la page précédente dans l'historique de navigation du navigateur.
            function goBack() {
                window.history.back(); // Retourne à la page précédente
            }
        </script>

    </div>
            </div>

            <!-- Formulaire principal -->
            <div class="md:w-2/3">
                <form method="POST" action="{{ route('updateUser', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="id" class="block text-gray-700 text-sm font-medium mb-1">ID</label>
                        <input type="text" id="id" value="{{ $user->id }}" disabled
                            class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-medium mb-1">Nom</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label for="discord" class="block text-gray-700 text-sm font-medium mb-1">Discord</label>
                        <input type="text" name="discord" id="discord" value="{{ $user->discord }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password"
                            placeholder="Laisser vide pour ne pas changer"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div class="text-sm text-gray-500">
                        Créé le {{ $user->created_at->format('d/m/Y à H:i') }}
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition shadow-sm">
                        Enregistrer les modifications
                    </button>

        
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
