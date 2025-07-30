@extends('layout')
@section('title', 'Profil utilisateur')
@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl bg-white shadow-2xl rounded-2xl overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <!-- Profile Picture Column -->
            <div class="flex flex-col items-center justify-center p-6 bg-indigo-600 lg:w-1/3">
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('/images/default-avatar-profile.jpg') }}" alt="Photo de {{ $user->name }}"
                    class="w-40 h-40 rounded-full object-cover shadow-lg mb-4 border-4 border-white">
                <span class="text-white font-bold text-xl capitalize">{{ $user->role }}</span>
            </div>
            <!-- User Information Column -->
            <div class="p-8 lg:w-2/3 w-full">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">ID : <span class="font-medium">{{ $user->id }}</span></p>
                </div>
                <div class="mt-6 border-t-2 border-gray-200 pt-6 text-base text-gray-600 space-y-3">
                    <p><span class="font-semibold text-gray-900">Email :</span> <a href="mailto:{{ $user->email }}"
                            class="text-indigo-600 hover:text-indigo-800 transition duration-300">{{ $user->email }}</a></p>
                    <p><span class="font-semibold text-gray-900">Discord :</span> {{ $user->discord }}</p>
                    <p><span class="font-semibold text-gray-900">Créé le :</span>
                        {{ $user->created_at->format('d/m/Y \à H:i') }}</p>
                    <p><span class="font-semibold text-gray-900">Dernière mise à jour :</span>
                        {{ $user->updated_at->format('d/m/Y \à H:i') }}</p>
                </div>

                @if($user->role === 'coach')
                    <!-- Game Section -->
                    @if(isset($user->game))
                        <div class="mt-6 border-t-2 border-gray-200 pt-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $user->game->name }}</h3>
                            <div class="bg-gray-50 p-4 rounded-lg shadow">
                                <p class="text-gray-700">Le coach est associé à ce jeu.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Coaching Sessions Section -->
                    <div class="mt-6 border-t-2 border-gray-200 pt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Sessions de Coaching</h3>
                        @if($user->coachings && $user->coachings->isNotEmpty())
                            <div class="bg-gray-50 p-4 rounded-lg shadow">
                                <ul class="list-disc pl-5 space-y-2">
                                    @foreach($user->coachings as $coaching)
                                        <li class="text-gray-700">
                                            <a href="{{ route('showCoachingInfo', $coaching->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 transition duration-300">
                                                <span class="font-semibold">ID Coaching:</span> {{ $coaching->id }}
                                            </a>
                                            <span class="font-semibold">Statut:</span> {{ $coaching->status }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-gray-700">Pas de sessions de coaching pour le moment.</p>
                        @endif
                    </div>
                @endif

                @if($user->role === 'student')
                    <!-- Coaching Sessions Section -->
                    <div class="mt-6 border-t-2 border-gray-200 pt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Sessions de Coaching</h3>
                        @if($user->coachings && $user->coachings->isNotEmpty())
                            <div class="bg-gray-50 p-4 rounded-lg shadow">
                                <ul class="list-disc pl-5 space-y-2">
                                    @foreach($user->coachings as $coaching)
                                        <li class="text-gray-700">
                                            <a href="{{ route('showCoachingInfo', $coaching->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 transition duration-300">
                                                <span class="font-semibold">ID Coaching:</span> {{ $coaching->id }}
                                            </a>
                                            <span class="font-semibold">Statut:</span> {{ $coaching->status }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-gray-700">Aucune session de coaching trouvée.</p>
                        @endif
                    </div>

                    <!-- Demandes Section -->
                    <div class="mt-6 border-t-2 border-gray-200 pt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Demandes</h3>
                        @if($user->demandes && $user->demandes->isNotEmpty())
                            <div class="bg-gray-50 p-4 rounded-lg shadow">
                                <ul class="list-disc pl-5 space-y-2">
                                    @foreach($user->demandes as $demande)
                                        <li class="text-gray-700">
                                            <a href="{{ route('showDemandeInfo', $demande->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 transition duration-300">
                                                <span class="font-semibold">ID Demande:</span> {{ $demande->id }}
                                            </a>
                                            <span class="font-semibold">Statut:</span> {{ $demande->status }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-gray-700">Aucune demande trouvée.</p>
                        @endif
                    </div>
                @endif

                <!-- Notes Section -->
                <div class="mt-6 border-t-2 border-gray-200 pt-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Notes</h3>
                    <a href="{{ route('showNotes', $user->id) }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                        Afficher les Notes
                    </a>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-6 flex justify-start space-x-4">
    <button onclick="goBack()" class="px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600 transition duration-300">
        Retour
    </button>
    <a href="{{ route('editUser', $user->id) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-300">
        Modifier
    </a>
</div>

<script>
    // Cette fonction utilise l'objet history de JavaScript pour revenir à la page précédente dans l'historique de navigation du navigateur.
    function goBack() {
        window.history.back(); // Retourne à la page précédente
    }
</script>

            </div>
        </div>
    </div>
</div>
@endsection
