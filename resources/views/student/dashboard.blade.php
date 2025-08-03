@extends('layout')

@section('title', 'Dashboard Élève')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Section Profil Élève -->
        <div class="bg-white p-6 mb-6 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <svg class="w-10 h-10 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800">Profil de {{ $user->name }}</h2>
                </div>
                <button
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                    <a href="{{ route('editProfile', $user->id) }}" class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Modifier le Profil
                    </a>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Demandes de Coaching de l'élève -->
            <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold text-gray-800">Mes Demandes de Coaching</h2>
                </div>
                <p class="mt-3 text-gray-600">Demandes en attente : <span
                        class="font-bold">{{ $demandes->where('status', 'pending')->count() }}</span></p>
                <button
                    class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                    <a href="{{-- route('showDemandeEleve', $user->id)--}}">Voir mes demandes</a>
                </button>
            </div>
        </div>

        <!-- ...section biographie supprimée pour l'élève... -->

        <!-- Calendrier FullCalendar -->
        <div class="mt-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Calendrier</h2>
                <div id='calendar' class="w-full"></div>
            </div>
        </div>

        <!-- Coachings à venir pour l'élève -->
        <div class="mt-6">
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-xl font-bold text-gray-800">Mes Coachings à Venir</h2>
                </div>
                @forelse ($coachingIncoming as $coaching)
                    <ul class="mt-4 space-y-3">
                        <li class="p-4 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-700">Coach : <span class="font-normal">{{ $coaching->coach->name }}</span></p>
                                    <p class="text-sm text-gray-500">Date : {{ $coaching->date_coaching }}</p>
                                    @if($coaching->game)
                                        <p class="text-sm text-gray-500">Jeu : {{ $coaching->game->name }}</p>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('showCoaching', $coaching->id) }}" class="text-green-600 hover:underline text-sm">Voir la fiche coaching</a>
                            </div>
                        </li>
                    </ul>
                @empty
                    <p class="mt-4 text-gray-500">Aucun coaching à venir.</p>
                @endforelse
            </div>
        </div>

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                aspectRatio: 1,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour'
                },
                locale: 'fr',
                events: @json($events)
            });
            calendar.render();
        });
        </script>
        <!-- Bouton supprimer mon compte (sans JS, soumission directe) -->
        <div class="mt-10 flex justify-center">
            <form method="POST" action="{{ route('destroyUser', $user->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-300">Supprimer mon compte</button>
            </form>
        </div>
    </div>
@endsection
