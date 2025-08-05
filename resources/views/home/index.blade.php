@extends('layout')

@section('title', 'mariokart')

@section('content')
@if(session('success'))
    <div class="center-container">
        <div class="alert-success">
            <p class="text-center">{{ session('success') }}</p>
        </div>
    </div>
@endif

<section class="hero-section" style="background-image: url('{{ asset($firstGame->image) }}');">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Bienvenue dans la Gamer Academy</h1>
        <p class="hero-desc">
            {{ $firstGame->description }}
        </p>
        <div class="hero-actions">
            <a href="{{ route('showCoaches', $firstGame) }}" class="btn-main">
                Trouver un coach
            </a>
            <div class="dropdown">
                <button class="dropdown-btn">Choix du jeu</button>
                <ul class="dropdown-list">
                    @foreach($games as $game)
                        <li>
                            <a href="{{ route('showGame', $game->slug) }}" class="dropdown-link">{{ $game->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="desc-section">
    <h1 class="desc-title">Comment ça marche ?</h1>
    <div class="desc-steps">
        <div class="desc-col">
            <div class="desc-step">
                <h2 class="desc-step-title">Choisissez votre jeu</h2>
                <p class="desc-step-text">
                    Nous proposons des cours de coaching pour les jeux en ligne les plus populaires, dispensés par les meilleurs entraîneurs disponibles.
                </p>
            </div>
            <div class="desc-step">
                <h2 class="desc-step-title">Trouvez votre coach</h2>
                <p class="desc-step-text">
                    Grâce à notre algorithme soigneusement conçu, nous vous permettons de trouver facilement le coach idéal.
                </p>
            </div>
        </div>
        <div class="desc-arrow">
            <img src="{{ asset('images/arrow.png') }}" alt="Flèches de progression" class="arrow-img" />
        </div>
        <div class="desc-step desc-step-final">
            <img src="{{ asset('images/trophy.png') }}" class="trophy-img" alt="Coupe trophée">
            <h2 class="desc-step-title">Devenez un pro</h2>
            <p class="desc-step-text text-center">
                Commencez vos leçons avec notre entraîneur pour commencer à atteindre vos objectifs en jeu et devenir un joueur professionnel.
            </p>
        </div>
    </div>
</section>

<section class="avis-section">
    <h1 class="avis-title">Avis des élèves</h1>
    @if(isset($notes) && count($notes))
    <div id="carousel-notes" class="carousel-notes">
        <div class="carousel-viewport">
            <div class="carousel-inner" id="carousel-inner">
                @foreach($notes as $note)
                    <div class="carousel-slide">
                        <span class="carousel-date">{{ $note->created_at->format('d/m/Y') }}</span>
                        <p class="carousel-comment">"{{ $note->commentaire }}"</p>
                        <div class="carousel-names">
                            <span class="carousel-student">{{ $note->student->name ?? 'Élève inconnu' }}</span>
                            <span class="carousel-arrow">→</span>
                            <span class="carousel-coach">{{ $note->coach->name ?? 'Coach inconnu' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button id="prev-btn" class="carousel-btn carousel-btn-left">&#8592;</button>
        <button id="next-btn" class="carousel-btn carousel-btn-right">&#8594;</button>
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
        <p class="avis-empty">Aucun avis pour le moment.</p>
    @endif
</section>
@endsection