@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh]">
    <h1 class="text-4xl font-bold mb-8 text-gray-800">Tableau de Bord Administrateur</h1>

    <a href="{{ route('create') }}" class="mb-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Créer un Adminisateur
    </a>

    <div class="grid grid-cols-2 gap-6 w-full max-w-4xl">
        <!-- Première rangée -->
        <!-- Élèves -->
        <a href="{{ route('student.list') }}" class="p-6 rounded-xl shadow-lg cursor-pointer hover:shadow-xl transition-shadow duration-300 ease-in-out transform hover:scale-105 flex flex-col items-center bg-white">
            <svg class="w-16 h-16 text-blue-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-800">Élèves</h2>
            <p class="text-xl text-gray-600">{{ $students->count() }}</p>
        </a>
        <!-- Coachings -->
        <a href="{{ route('coaching.list') }}" class="p-6 rounded-xl shadow-lg cursor-pointer hover:shadow-xl transition-shadow duration-300 ease-in-out transform hover:scale-105 flex flex-col items-center bg-white">
            <svg class="w-16 h-16 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.042M12 20v-8m0 0l-3-3m3 3l3-3"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-800">Coachings</h2>
            <p class="text-xl text-gray-600">{{ $coachings->count() }}</p>
        </a>
        <!-- Deuxième rangée -->
        <!-- Coachs -->
        <a href="{{ route('coach.list') }}" class="p-6 rounded-xl shadow-lg cursor-pointer hover:shadow-xl transition-shadow duration-300 ease-in-out transform hover:scale-105 flex flex-col items-center bg-white">
            <svg class="w-16 h-16 text-purple-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-800">Coachs</h2>
            <p class="text-xl text-gray-600">{{ $coachs->count() }}</p>
        </a>
        <!-- Demandes -->
        <a href="{{ route('demande.list') }}" class="p-6 rounded-xl shadow-lg cursor-pointer hover:shadow-xl transition-shadow duration-300 ease-in-out transform hover:scale-105 flex flex-col items-center bg-white">
            <svg class="w-16 h-16 text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-800">Demandes</h2>
            <p class="text-xl text-gray-600">{{ $demandes->count() }}</p>
        </a>
    </div>
</div>
@endsection
