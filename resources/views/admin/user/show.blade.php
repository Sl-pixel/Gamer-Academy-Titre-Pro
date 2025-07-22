@extends('layout')

@section('title', 'Profil utilisateur')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Profile Picture Column -->
                <div class="flex flex-col items-center justify-center p-6 bg-indigo-50 lg:w-1/3">
                    <img src="{{ $user->profile_picture }}" alt="Photo de {{ $user->name }}"
                        class="w-40 h-40 rounded-full object-cover shadow-lg mb-4 border-4 border-indigo-100">
                    <span class="text-indigo-800 font-bold text-lg capitalize">{{ $user->role }}</span>
                </div>
                <!-- User Information Column -->
                <div class="p-8 lg:w-2/3 w-full flex flex-col justify-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">ID : <span class="font-medium">{{ $user->id }}</span></p>
                    </div>
                    <div class="mt-6 border-t-2 border-gray-100 pt-6 text-base text-gray-600 space-y-3">
                        <p><span class="font-semibold text-gray-900">Email :</span> <a href="mailto:{{ $user->email }}"
                                class="text-indigo-600 hover:text-indigo-800">{{ $user->email }}</a></p>
                        <p><span class="font-semibold text-gray-900">Discord :</span> {{ $user->discord }}</p>
                        <p><span class="font-semibold text-gray-900">Créé le :</span>
                            {{ $user->created_at->format('d/m/Y \à H:i') }}</p>
                        <p><span class="font-semibold text-gray-900">Dernière mise à jour :</span>
                            {{ $user->updated_at->format('d/m/Y \à H:i') }}</p>
                    </div>
                    @if($user->role === 'coach')
                        <!-- Game Section -->
                        @if(isset($user->game))
                            <div class="mt-6 border-t-2 border-gray-100 pt-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $user->game->name }}</h3>
                                <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                    <p class="text-gray-700">Le coach est associé à ce jeu.</p>
                                </div>
                            </div>

                        @endif

                        <!-- Coaching Sessions Section -->
                        <div class="mt-6 border-t-2 border-gray-100 pt-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Coaching Sessions</h3>
                            @if($user->coachings->isNotEmpty())
                                <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                    <ul class="list-disc pl-5 space-y-2">
                                        @foreach($user->coachings as $coaching)
                                            <li class="text-gray-700">

                                                <a href="{{ route('showCoachingInfo', $coaching->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-800">
                                                    <span class="font-semibold">Coaching id:</span> {{ $coaching->id }}
                                                </a>
                                                <span class="font-semibold">Status:</span> {{ $coaching->status }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mt-6 border-t-2 border-gray-100 pt-6">
                                        <h3 class="text-xl font-bold text-gray-900 mb-4">Notes</h3>
                                        <button class="text-gray-700">

                                            <a href="{{ route('showNotes', $user->id) }}">Afficher les Notes</a>
                                        </button>
                                    </div>
                                </div>

                            @else
                                <p class="text-gray-700">Pas de coaching pour le moment.</p>
                            @endif
                        </div>
                    @endif

                    @if($user->role === 'student')


                        <!-- Coaching Sessions Section -->
                        <div class="mt-6 border-t-2 border-gray-100 pt-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Coaching Sessions</h3>
                            @if($user->coachings->isNotEmpty())
                                <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                    <ul class="list-disc pl-5 space-y-2">
                                        @foreach($user->coachings as $coaching)
                                            <li class="text-gray-700">

                                                <a href="{{ route('showCoachingInfo', $coaching->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-800">
                                                    <span class="font-semibold">Coaching id:</span> {{ $coaching->id }}
                                                </a>
                                                <span class="font-semibold">Status:</span> {{ $coaching->status }}
                                            </li>
                                        @endforeach

                                    </ul>
                                    <div class="mt-6 border-t-2 border-gray-100 pt-6">
                                        <h3 class="text-xl font-bold text-gray-900 mb-4">Notes</h3>
                                        <button class="text-gray-700">
                                            <a href="{{ route('showNotes', $user->id) }}">Afficher les Notes</a>
                                        </button>
                                    </div>
                                </div>

                            @else
                                <p class="text-gray-700">Pas de coaching pour le moment.</p>
                            @endif
                        </div>
                    @endif
                    <div class="mt-6 flex justify-start">
                        <a href="{{ route('student.list') }}"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm leading-5 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                            Retour
                        </a>
                        <a href="{{ route('editUser', $user->id) }}"
                            class="inline-block px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-200">
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection