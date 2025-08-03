@extends('layout')
@section('title', 'Coaching Session Details')
@section('content')

          @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        <p class="font-bold">Succès</p>
        <p>{{ session('success') }}</p>
    </div>
@endif

<div class="flex justify-center items-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-6xl bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="p-8">
            <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-8">Detail de la demande de Coaching</h1>
            <!-- Coaching Session Info -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Demande de Coaching</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-700"><span class="font-semibold">ID:</span> {{ $demande->id }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Status:</span> {{ $demande->status }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Duration:</span> {{ $demande->duree }} minutes</p>
                        <p class="text-gray-700"><span class="font-semibold">Jeu:</span> {{ $coach->game->name }}</p>
                    </div>
                </div>
            </div>
            <!-- Coach and Student Info -->
            <div class="flex flex-col lg:flex-row">
                <!-- Coach Info -->
                <div class="lg:w-1/2 p-4 flex flex-col items-center">
                    <div class="bg-indigo-50 rounded-lg p-6 flex flex-col items-center w-full">
                        <img src="{{ $coach->profile_picture ? asset('storage/' . $coach->profile_picture) : asset('/images/default-avatar-profile.jpg')  }}" alt="Photo de {{ $coach->name }}"
                            class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-indigo-100 mb-4">
                        <h2 class="text-2xl font-bold text-indigo-800 mb-2 text-center">{{ $coach->name }}</h2>
                        <div class="mt-4 text-center">
                            <a href="{{ route('showUserInfo', $coach->id) }}"
                                class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-200">Voir Profile</a>
                        </div>
                    </div>
                </div>
                <!-- Student Info -->
                <div class="lg:w-1/2 p-4 flex flex-col items-center">
                    <div class="bg-purple-50 rounded-lg p-6 flex flex-col items-center w-full">
                        <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('/images/default-avatar-profile.jpg')}}" alt="Photo de {{ $student->name }}"
                            class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-purple-100 mb-4">
                        <h2 class="text-2xl font-bold text-purple-800 mb-2 text-center">{{ $student->name }}</h2>
                        <div class="mt-4 text-center">
                            <a href="{{ route('showUserInfo', $student->id) }}"
                                class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition duration-200">Voir Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Commentaire Section -->
            <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Message de l'eleve</h2>
                <div class="bg-white p-4 rounded shadow-inner">
                    <p class="text-gray-700">{{ $demande->message ?? 'No commentaire available.' }}</p>
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-center p-8 space-x-4">
            <button onclick="goBack()" class="px-4 py-2 bg-indigo-500 text-white text-sm leading-5 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
    Retour
</button>

<script>
// Cette fonction utilise l'objet history de JavaScript pour revenir à la page précédente dans l'historique de navigation du navigateur.
function goBack() {
    window.history.back(); // Retourne à la page précédente
}
</script>
                <form method="POST" action="{{ route('destroyDemande', $demande->id) }}" class="inline"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coaching ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-block px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-200">Supprimer</button>
                </form>
        </div>
    </div>
    
</div>
@endsection