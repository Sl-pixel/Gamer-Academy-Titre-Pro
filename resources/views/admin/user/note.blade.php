@extends('layout')
@section('title', 'Notes')
@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-3xl bg-white shadow-2xl rounded-2xl overflow-hidden p-6">
        <div class="flex items-center mb-8">
            <svg class="w-10 h-10 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h1 class="text-3xl font-bold text-gray-900">Notes</h1>
        </div>
        @if($user->role === 'coach')
            <div class="flex items-center mb-6">
                <svg class="w-7 h-7 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zm-6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-800">Notes des étudiants</h2>
            </div>
            @if($user->students->isNotEmpty())
                <div class="space-y-5">
                    @foreach($user->students as $student)
                        <div class="bg-gray-50 p-5 rounded-xl shadow transition duration-300 ease-in-out hover:shadow-lg">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="font-semibold text-xl text-gray-900">{{ $student->name }}</h3>
                                </div>
                                <form method="POST" action="{{ route('destroyNote', $student->pivot->id) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                            <p class="mt-3 text-gray-700">{{ $student->pivot->notes }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-4">Aucune note des étudiants pour le moment.</p>
            @endif
        @endif

        @if($user->role === 'student')
            <div class="flex items-center mb-6">
                <svg class="w-7 h-7 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-800">Notes pour les entraîneurs</h2>
            </div>
            @if($user->coaches->isNotEmpty())
                <div class="space-y-5">
                    @foreach($user->coaches as $coach)
                        <div class="bg-gray-50 p-5 rounded-xl shadow transition duration-300 ease-in-out hover:shadow-lg">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <h3 class="font-semibold text-xl text-gray-900">{{ $coach->name }}</h3>
                                </div>
                                <form method="POST" action="{{ route('destroyNote', $coach->pivot->id) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                            <p class="mt-3 text-gray-700">{{ $coach->pivot->notes }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-4">Aucune note pour les entraîneurs pour le moment.</p>
            @endif
        @endif

        <div class="mt-8 flex justify-start">
            <a href="{{ route('showUserInfo', $user->id) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-sm leading-5 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h12a2 2 0 012 2v4a2 2 0 01-2 2h-6m-4 0H7a2 2 0 01-2-2v-4a2 2 0 012-2h4"></path>
                </svg>
                Retour au profil
            </a>
        </div>
    </div>
</div>
@endsection
