@extends('layout')
@section('title', 'Coaching List')
@section('content')
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Tableau des Demandes</h1>
            <div class="flex justify-end">
                <a href="{{ route('adminDashboard') }}"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm leading-5 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Retour
                </a>
            </div>
        </div>
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Coach</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($demandes as $demande)
                        <tr class="transition-all duration-200 ease-in-out hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $demande->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $demande->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $demande->coach->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $demande->status ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('showDemandeInfo', $demande->id) }}"
                                    class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-200 mr-2">Voir</a>
                          
                                <form method="POST" action="{{ route('destroyDemande', $demande->id) }}" class="inline"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coaching ?');">
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
        <!-- <div class="mt-4">
        </div> -->
    </div>
@endsection
