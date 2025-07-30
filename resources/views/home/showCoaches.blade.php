{{-- Ce fichier est une vue Blade dans Laravel, qui étend un layout de base --}}
@extends('layout')

{{-- Définit le titre de la page --}}
@section('title', 'CS2')

{{-- Section principale du contenu de la page --}}
@section('content')
    <div class="container mx-auto px-4 py-12">
        {{-- Titre principal de la page --}}
        <h1 class="text-4xl font-bold text-center mb-10">Nos coachs pour {{ $game->name }}</h1>

        {{-- Vérifie si la liste des coachs est vide --}}
       
            {{-- Grille pour afficher les coachs --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                {{-- Boucle à travers chaque coach --}}
                @foreach ($coaches as $coach)
                    {{-- Carte pour chaque coach --}}
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        {{-- Image de profil du coach --}}
                        <img src="{{ $coach->profile_picture ? asset('storage/' . $coach->profile_picture) : asset('/images/default-avatar-profile.jpg') }}"
                            alt="Photo de {{ $coach->name }}" class="w-full h-56 object-cover object-center">

                        {{-- Détails du coach --}}
                        <div class="p-6">
                            {{-- Nom du coach --}}
                            <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $coach->name }}</h2>

                            {{-- Description du coach --}}
                            <p class="text-gray-600 mb-4 h-24 overflow-hidden">
                                {{ $coach->biographie }}
                            </p>

                            {{-- Pied de la carte avec tarif et bouton pour choisir le coach --}}
                            <div class="flex justify-between items-center mt-4">
                                {{-- Tarif horaire du coach --}}
                                <span class="text-xl font-bold text-indigo-600">{{ $coach->tarif }}€/h</span>

                                {{-- Bouton pour choisir le coach --}}
                                <a href="{{ route('selectCoach', $coach->id) }}"
                                    class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-2 rounded-full shadow-lg transition-colors duration-300">
                                    Choisir
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
@endsection