@extends('layout')
@section('title', 'Dashboard')
@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Tableau des Utilisateurs</h1>
        <div class="flex justify-end">
            <a href="{{ route('adminDashboard') }}"
                class="px-6 py-3 bg-indigo-600 text-white text-sm leading-5 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Retour
            </a>
        </div>
    </div>
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Pseudo</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="transition duration-300 ease-in-out hover:bg-indigo-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('showUserInfo', $user->id) }}"
                            class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-200 mr-2">Voir</a>
                        <a href="{{ route('editUser', $user->id) }}"
                            class="inline-block px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-200 mr-2">Modifier</a>
                        <form method="POST" action="{{ route('destroyUser',  $user->id) }}" class="inline"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-block px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-200">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>
@endsection
