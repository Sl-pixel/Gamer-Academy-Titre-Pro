{{-- Ce fichier est une vue Blade dans Laravel, qui étend un layout de base --}}
@extends('layout')

{{-- Définit le titre de la page --}}
@section('title', 'mariokart')

{{-- Section principale du contenu de la page --}}
@section('content')
@if(session('success'))
    <div class="flex justify-center items-center">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 w-full max-w-4xl mx-4" role="alert">
            <p class="text-center">{{ session('success') }}</p>
        </div>
    </div>
@endif
    <section
        class="flex flex-col items-center justify-center min-h-[600px] md:min-h-[800px] bg-gradient-to-br from-indigo-900 to-indigo-700 text-white py-24 px-4 rounded-lg shadow-lg mb-12 relative overflow-hidden"
        style="background-image: url('{{ asset($firstGame->image) }}'); background-size: cover; background-position: center;">

        <!-- Overlay sombre pour améliorer la lisibilité du texte -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Conteneur principal pour le contenu -->
        <div class="relative z-10 flex flex-col items-center text-center w-full max-w-screen-lg px-4">
            <!-- Titre principal -->
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Bienvenue dans la Gamer Academy</h1>
            <!-- Paragraphe de description -->
            <p class="max-w-2xl text-lg md:text-xl mb-8">
                {{ $firstGame->description }}
            </p>

            <!-- Conteneur pour le menu déroulant et le bouton -->
            <div class="flex justify-center items-center space-x-4 w-full mt-4">
                <!-- Bouton pour trouver un coach -->
                <a href="{{ route('showCoaches', $firstGame) }}"
                    class="inline-block bg-pink-600 hover:bg-pink-700 text-white font-semibold px-8 py-3 rounded-full shadow-lg transition">
                    Trouver un coach
                </a>
                <!-- Menu déroulant pour le choix du jeu -->
                <div class="relative group">
                    <button
                        class="font-semibold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        Choix du jeu
                    </button>
                    <ul
                        class="absolute left-0 mt-2 bg-white bg-opacity-20 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-1000 ease-in group-hover:pointer-events-auto z-30 min-w-[120px]">
                        @foreach($games as $game)
                            <li><a href="{{ route('showGame', $game->slug) }}"
                                    class="block px-4 py-2 hover:bg-indigo-50 hover:bg-opacity-30">{{ $game->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Commentaire HTML indiquant le début de la section de description -->
    <!-- section description -->
    <section class="flex flex-col items-center justify-center py-12">
        <!-- Titre de la section -->
        <h1 class="text-3xl md:text-4xl font-bold mb-10">Comment ça marche ?</h1>

        <!-- Conteneur pour les étapes -->
        <div class="flex flex-col md:flex-row items-center gap-8">
            <!-- Première colonne avec deux étapes -->
            <div class="flex flex-col gap-8">
                <!-- Étape 1 : Choisissez votre jeu -->
                <div class="bg-white rounded-lg shadow p-6 w-72">
                    <h2 class="text-xl font-semibold mb-2 text-indigo-700">Choisissez votre jeu</h2>
                    <p class="text-gray-700">
                        Nous proposons des cours de coaching pour les jeux en ligne les plus populaires, dispensés par les
                        meilleurs entraîneurs disponibles.
                    </p>
                </div>

                <!-- Étape 2 : Trouvez votre coach -->
                <div class="bg-white rounded-lg shadow p-6 w-72">
                    <h2 class="text-xl font-semibold mb-2 text-indigo-700">Trouvez votre coach</h2>
                    <p class="text-gray-700">
                        Grâce à notre algorithme soigneusement conçu, nous vous permettons de trouver facilement le coach
                        idéal.
                    </p>
                </div>
            </div>

            <!-- Image de flèches de progression -->
            <div class="flex justify-center items-center">
                <img src="{{ asset('images/arrow.png') }}" alt="Flèches de progression" class="w-16 h-16 md:w-24 md:h-24" />
            </div>

            <!-- Étape 3 : Devenez un pro -->
            <div class="bg-white rounded-lg shadow p-6 w-72 flex flex-col items-center">
                <img src="{{ asset('images/trophy.png') }}" class="w-16 h-16 mb-4" alt="Coupe trophée">
                <h2 class="text-xl font-semibold mb-2 text-indigo-700">Devenez un pro</h2>
                <p class="text-gray-700 text-center">
                    Commencez vos leçons avec notre entraîneur pour commencer à atteindre vos objectifs en jeu et devenir un
                    joueur professionnel.
                </p>
            </div>
        </div>
    </section>

    <!-- Carrousel des notes -->
    <section class="flex flex-col items-center justify-center py-12">
        <h1 class="text-3xl md:text-4xl font-bold mb-10">Avis des élèves</h1>
        @if(isset($notes) && count($notes))
        <div id="carousel-notes" class="relative w-full max-w-2xl mx-auto">
            <div class="overflow-hidden rounded-lg shadow-lg bg-white">
                <div class="flex transition-transform duration-500" id="carousel-inner">
                    @foreach($notes as $note)
                        <div class="min-w-full flex flex-col items-center p-8 relative">
                            <span class="absolute top-2 right-4 text-xs text-gray-400">{{ $note->created_at->format('d/m/Y') }}</span>
                            <p class="text-gray-700 italic text-lg mb-4">"{{ $note->commentaire }}"</p>
                            <div class="flex items-center">
                                <span class="font-bold text-indigo-700 mr-2">{{ $note->student->name ?? 'Élève inconnu' }}</span>
                                <span class="mx-2 text-gray-400">→</span>
                                <span class="font-bold text-pink-600">{{ $note->coach->name ?? 'Coach inconnu' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button id="prev-btn" class="absolute left-0 top-1/2 -translate-y-1/2 bg-indigo-600 text-white px-3 py-2 rounded-full shadow hover:bg-indigo-700">&#8592;</button>
            <button id="next-btn" class="absolute right-0 top-1/2 -translate-y-1/2 bg-indigo-600 text-white px-3 py-2 rounded-full shadow hover:bg-indigo-700">&#8594;</button>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carouselInner = document.getElementById('carousel-inner');
                const slides = carouselInner.children;
                let current = 0;
                function updateCarousel() {
                    carouselInner.style.transform = `translateX(-${current * 100}%)`;
                }
                document.getElementById('prev-btn').onclick = function() {
                    current = (current - 1 + slides.length) % slides.length;
                    updateCarousel();
                };
                document.getElementById('next-btn').onclick = function() {
                    current = (current + 1) % slides.length;
                    updateCarousel();
                };
                updateCarousel();
            });
        </script>
        @else
            <p class="text-gray-500">Aucun avis pour le moment.</p>
        @endif
    </section> 
@endsection