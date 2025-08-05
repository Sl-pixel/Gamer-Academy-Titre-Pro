@extends('layout')
<!-- Étend le layout principal défini dans le fichier 'layout.blade.php' -->

@section('title', 'Dashboard')
<!-- Définit le titre de la page -->

@section('content')
<!-- Section principale où le contenu de la page sera inséré -->
<div class="container mx-auto p-6">
    <!-- Conteneur principal avec un rembourrage -->

    <!-- En-tête de la page avec le titre et un bouton de retour -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <h1 class="text-2xl md:text-4xl font-bold text-gray-900">Tableau des Utilisateurs</h1>
        <!-- Titre de la page, taille ajustée pour les écrans mobiles et plus grands -->

        <!-- Bouton de retour vers le tableau de bord administrateur -->
        <div class="flex justify-end mt-4 md:mt-0">
            <a href="{{ route('adminDashboard') }}"
                class="px-4 py-2 md:px-6 md:py-3 bg-indigo-600 text-white text-sm leading-5 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Retour
            </a>
        </div>
    </div>

    <!-- Tableau pour afficher la liste des utilisateurs -->
    <div class="overflow-x-auto bg-white shadow-xl rounded-xl">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- En-tête du tableau -->
            <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                <tr>
                    <th class="px-4 py-2 md:px-6 md:py-4 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 md:px-6 md:py-4 text-left text-xs font-medium uppercase tracking-wider">Pseudo</th>
                    <th class="px-4 py-2 md:px-6 md:py-4 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                    <th class="px-4 py-2 md:px-6 md:py-4 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <!-- Corps du tableau -->
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <!-- Boucle à travers chaque utilisateur -->
                <tr class="transition duration-300 ease-in-out hover:bg-indigo-50">
                    <!-- Affiche l'ID de l'utilisateur -->
                    <td class="px-4 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                    <!-- Affiche le pseudo de l'utilisateur -->
                    <td class="px-4 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->name }}</td>
                    <!-- Affiche l'email de l'utilisateur -->
                    <td class="px-4 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                    <!-- Affiche les actions possibles pour l'utilisateur -->
                    <td class="px-4 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                            <!-- Lien pour voir les détails de l'utilisateur -->
                            <a href="{{ route('showUserInfo', $user->id) }}"
                                class="inline-block px-3 py-1 md:px-4 md:py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-200">Voir</a>
                            <!-- Lien pour modifier l'utilisateur -->
                            <a href="{{ route('editUser', $user->id) }}"
                                class="inline-block px-3 py-1 md:px-4 md:py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-200">Modifier</a>
                            <!-- Formulaire pour supprimer l'utilisateur -->
                            <form method="POST" action="{{ route('destroyUser', $user->id) }}" class="inline"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                @csrf
                                <!-- Token CSRF pour sécuriser le formulaire -->
                                @method('DELETE')
                                <!-- Utilise la méthode DELETE pour la suppression -->
                                <button type="submit"
                                    class="inline-block w-full px-3 py-1 md:px-4 md:py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-200">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links('pagination::tailwind') }}
        <!-- Affiche les liens de pagination en utilisant le style Tailwind -->
    </div>
</div>

@endsection