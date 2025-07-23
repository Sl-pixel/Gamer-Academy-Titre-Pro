@extends('layout')

@section('title', 'Liste des Demandes')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
         @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <h1 class="text-4xl font-bold text-gray-900">Liste des Demandes</h1>
        <div class="flex justify-end">
            <a href="{{ route('coachDashboard', $user->id) }}"
                class="px-6 py-3 bg-indigo-600 text-white text-sm leading-5 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($demandes as $demande)
        <div class="bg-white shadow-xl rounded-xl overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-800">Demande #{{ $demande->id }}</h2>
            <div class="mt-4">
                <p class="text-gray-600"><strong>Utilisateur:</strong> {{ $demande->user->name }}</p>
                <p class="text-gray-600"><strong>Coach:</strong> {{ $demande->coach->name }}</p>
                <p class="text-gray-600"><strong>Message:</strong> {{ $demande->message }}</p>
                <p class="text-gray-600"><strong>Date:</strong> {{ $demande->date_coaching }}</p>
                <p class="text-gray-600"><strong>id:</strong> {{ $demande->id }}</p>
                <p class="text-gray-600">
                    <strong>Status:</strong>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $demande->status === 'accepted' ? 'bg-green-100 text-green-800' : ($demande->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($demande->status) }}
                    </span>
                </p>
            </div>
            <div class="mt-6 flex space-x-4">
                <form action="{{ route('demande.traiter', $demande->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="accept">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        Accepter
                    </button>
                </form>
                <form action="{{ route('demande.traiter', $demande->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        Refuser
                    </button>
                </form>

            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
