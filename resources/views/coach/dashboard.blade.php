@extends('layout')

@section('title', 'Coach Dashboard')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Section Profil -->
        <div class="bg-white p-6 mb-6 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <svg class="w-10 h-10 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800">Profil de {{ $user->name }}</h2>
                </div>
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
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
            <!-- Demande de Coaching en Attente -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold text-gray-800">Demandes en Attente</h2>
                </div>
                <p class="mt-3 text-gray-600">Nombre de demandes en attente : <span
                        class="font-bold">{{ $demandes->where('status', 'pending')->count() }}</span></p>
                <button
                    class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                    <a href="{{ route('showDemandeCoach', $user->id)}}">Voir les demandes</a>
                </button>
            </div>

            <!-- Tarif -->
            <form method="POST" action="{{ route('updateCoachTarif', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.654 0 3-1.346 3-3s-1.346-3-3-3-3 1.346-3 3 1.346 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4zm0 8c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3z"></path>
                        </svg>
                        <h2 class="text-xl font-bold text-gray-800">Tarif</h2>
                    </div>
                    <div class="mt-3 text-gray-600">
                        <label for="tarif" class="block text-sm font-medium text-gray-700">Tarif actuel :</label>
                        <input type="number" id="tarif" name="tarif" class="mt-1 w-20 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-bold" value="{{ $user->tarif }}">
                        <span class="ml-2">€/h</span>
                    </div>
                    <button type="submit" class="mt-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                        Modifier le Tarif
                    </button>
                </div>
            </form>
        </div>

        <!-- Biographie -->
        <form method="POST" action="{{ route('updateCoachBio', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="bg-gray-100 p-6 mt-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800">Biographie</h2>
                </div>
                <label for="biographie" class="block text-sm font-medium text-gray-700 mt-3">Biographie :</label>
                <textarea name="biographie" id="biographie" class="w-full p-4 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 min-h-32">{{ $user->biographie }}</textarea>
                <button type="submit" class="mt-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                    Modifier la Biographie
                </button>
            </div>
        </form>

        <!-- Calendrier FullCalendar -->
        <div class="mt-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Calendrier</h2>
                <div id='calendar' class="w-full"></div>
            </div>
        </div>

        <!-- Coaching à Venir -->
        <div class="mt-6">
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-xl font-bold text-gray-800">Coaching à Venir</h2>
                </div>
                @foreach ($coachingIncoming as $coaching)
                    <ul class="mt-4 space-y-3">
                        <li class="p-4 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-700">Élève : <span class="font-normal">{{ $coaching->user->name }}</span></p>
                                    <p class="text-sm text-gray-500">Date : {{ $coaching->date_coaching }}</p>
                                    @if($coaching->game)
                                        <p class="text-sm text-gray-500">Jeu : {{ $coaching->game->name }}</p>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('showCoaching', $coaching->id) }}" class="text-blue-600 hover:underline text-sm">Voir la fiche coaching</a>
                            </div>
                        </li>
                    </ul>
                @endforeach
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
                events: @json($events) // Passez les événements ici
            });
            calendar.render();
        });
        </script>


        <!-- Chiffre d'Affaires -->
        <div class="bg-gray-200 p-6 mt-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Chiffre d'Affaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <p class="text-lg font-semibold text-gray-700">CA de l'année</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $yearlyRevenue }} €</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <p class="text-lg font-semibold text-gray-700">CA du mois</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $monthlyRevenue }} €</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <p class="text-lg font-semibold text-gray-700">CA du jour</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $dailyRevenue }} €</p>
                </div>
            </div>
        </div>
    </div>
@endsection
