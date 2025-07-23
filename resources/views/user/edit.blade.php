@extends('layout')
@section('title', 'Informations de l\'Étudiant')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Bienvenue dans votre espace utilisateur, {{ $user->name }}!</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Rectangle pour le rôle et le jeu sur le côté gauche -->
            <div class="w-full md:w-1/4 p-4 bg-gray-100 rounded-lg shadow-md">
                <!-- Rôle actuel -->
                <div>
                    <p class="text-sm text-gray-600 mb-1">Rôle actuel :</p>
                    <span class="text-md font-semibold text-indigo-600 capitalize">{{ $user->role }}</span>
                    <form action="{{ route('user.updateRoleOnly', $user->id) }}" method="POST" id="roleForm" class="mt-4 w-full text-center">
                        @csrf
                        @method('PUT')
                        @if($user->role === 'coach')


                        <select name="role"
                            onchange="document.getElementById('submitRoleBtn').click()"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <option value="coach" {{ $user->role == 'coach' ? 'selected' : '' }}>Coach</option>
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Étudiant</option>
                        </select>
                        @else
                        if($user->role === 'student')
                            <select name="role"
                            onchange="document.getElementById('submitRoleBtn').click()"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">

                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Étudiant</option>
                            <option value="coach" {{ $user->role == 'coach' ? 'selected' : '' }}>Coach</option>
                        </select>
                        @endif
                        <button type="submit" id="submitRoleBtn" class="hidden"></button>
                    </form>
                </div>

                <!-- Sélection de jeu pour les coachs -->
                @if($user->role === 'coach')
                <div class="mt-6">
                    <label for="game_id" class="block text-gray-700 text-sm font-medium mb-1">Jeu associé</label>
                    <span class="text-md font-semibold text-indigo-600 capitalize">{{ $user->game->name }}</span>
                    <form action="{{ route('user.updateGame', $user->id) }}" method="POST" id="gameForm" class="mt-4 w-full">
                        @csrf
                        @method('PUT')
                        <select name="game_id" id="game_id"
                            onchange="document.getElementById('submitGameBtn').click()"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <option value="">-- Sélectionner un jeu --</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ $user->game_id == $game->id ? 'selected' : '' }}>
                                    {{ $game->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" id="submitGameBtn" class="hidden"></button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Formulaire principal sur le côté droit -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <!-- Photo de profil -->
                    <div class="flex justify-center mb-4">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Pas de photo</span>
                            </div>
                        @endif
                    </div>

                    <!-- Formulaire principal -->
                    <form method="POST" action="{{ route('updateUser', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="profile_picture" class="block text-gray-700 text-sm font-medium mb-1">Photo de profil</label>
                            <input type="file" name="profile_picture" id="profile_picture"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
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
                            Compte créé le {{ $user->created_at->format('d/m/Y à H:i') }}
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
