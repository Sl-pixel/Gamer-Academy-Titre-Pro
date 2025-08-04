@extends('layout')

@section('title', 'Mes Demandes de Coaching')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
         @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <h1 class="text-4xl font-bold text-gray-900">Mes Demandes de Coaching</h1>
        <div class="flex justify-end">
            <a href="{{ route('studentDashboard', $user->id) }}"
                class="px-6 py-3 bg-indigo-600 text-white text-sm leading-5 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Retour au Dashboard
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($demandes as $demande)
        <div class="bg-white shadow-xl rounded-xl overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-800">Demande de Coaching</h2>
            <div class="mt-4">
                <p class="text-gray-600"><strong>Coach:</strong> {{ $demande->coach->name }}</p>
                <p class="text-gray-600"><strong>Jeu:</strong> {{ $demande->coach->game->name ?? 'Non spécifié' }}</p>
                <p class="text-gray-600"><strong>Date demandée:</strong> {{ \Carbon\Carbon::parse($demande->date_coaching)->format('d/m/Y à H:i') }}</p>
                <p class="text-gray-600"><strong>Durée:</strong> {{ $demande->duree }} minutes</p>
                <p class="text-gray-600"><strong>Mon message:</strong></p>
                <p class="text-gray-700 italic bg-gray-50 p-3 rounded mt-1">{{ $demande->message }}</p>
                <p class="text-gray-600 mt-3">
                    <strong>Statut:</strong>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $demande->status === 'accepted' ? 'bg-green-100 text-green-800' : ($demande->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        @if($demande->status === 'accepted')
                            ✅ Acceptée
                        @elseif($demande->status === 'rejected')
                            ❌ Refusée
                        @else
                            ⏳ En attente
                        @endif
                    </span>
                </p>
                <p class="text-xs text-gray-500 mt-2">Demande envoyée le {{ \Carbon\Carbon::parse($demande->created_at)->format('d/m/Y à H:i') }}</p>
            </div>
            
            @if($demande->status === 'accepted')
            <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                <p class="text-green-800 font-semibold">🎉 Coaching confirmé !</p>
                <p class="text-green-700 text-sm mt-1">Votre séance de coaching a été acceptée. Vous recevrez bientôt les détails de connexion.</p>
                <div class="mt-3">
                    <a href="{{ route('showCoaching', $demande->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition duration-150">
                        Voir les détails
                    </a>
                </div>
            </div>
            @elseif($demande->status === 'rejected')
            <div class="mt-6 p-4 bg-red-50 rounded-lg border border-red-200">
                <p class="text-red-800 font-semibold">❌ Demande refusée</p>
                <p class="text-red-700 text-sm mt-1">Votre demande a été refusée. Vous pouvez essayer de contacter un autre coach ou modifier votre demande.</p>
                <div class="mt-3">
                    <a href="{{ route('showCoaches', $demande->coach->game) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150">
                        Chercher un autre coach
                    </a>
                </div>
            </div>
            @else
            <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <p class="text-yellow-800 font-semibold">⏳ En attente de réponse</p>
                <p class="text-yellow-700 text-sm mt-1">Votre demande est en cours d'examen par le coach. Vous recevrez une notification dès qu'il aura répondu.</p>
                <div class="mt-3 flex space-x-3">
                    <form action="{{ route('demande.cancel', $demande->id) }}" method="POST" class="inline-block" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette demande ? Cette action est irréversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler la demande
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-gray-50 rounded-lg p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande de coaching</h3>
                <p class="text-gray-600 mb-6">Vous n'avez pas encore fait de demande de coaching. Commencez dès maintenant !</p>
                <a href="{{ route('index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-150">
                    Trouver un coach
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
