@extends('layout')
@section('title', 'Dashboard')
@section('content')
<div class="flex-container">
    <!-- Conteneur principal de la fenêtre -->
    <h1 class="main-title">Tableau de Bord Administrateur</h1>
    <!-- Titre principal du tableau de bord -->
    <!-- Lien pour créer un nouvel administrateur -->
    <a href="{{ route('create') }}" class="create-admin-link">
        Créer un Administrateur
    </a>
    <!-- Dashboard -->
    <div class="dashboard-grid">
        <!-- Première rangée -->
        <!-- Carte pour les Élèves -->
        <a href="{{ route('student.list') }}" class="card">
            <!-- Icône SVG pour les élèves -->
            <svg class="card-icon icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h2 class="card-title">Élèves</h2> <!-- Titre de la carte -->
            <p class="card-count">{{ $students->count() }}</p> <!-- Nombre d'élèves -->
        </a>
        <!-- Carte pour les Coachings -->
        <a href="{{ route('coaching.list') }}" class="card">
            <!-- Icône SVG pour les coachings -->
            <svg class="card-icon icon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.042M12 20v-8m0 0l-3-3m3 3l3-3"></path>
            </svg>
            <h2 class="card-title">Coachings</h2> <!-- Titre de la carte -->
            <p class="card-count">{{ $coachings->count() }}</p> <!-- Nombre de coachings -->
        </a>
        <!-- Deuxième rangée -->
        <!-- Carte pour les Coachs -->
        <a href="{{ route('coach.list') }}" class="card">
            <!-- Icône SVG pour les coachs -->
            <svg class="card-icon icon-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h2 class="card-title">Coachs</h2> <!-- Titre de la carte -->
            <p class="card-count">{{ $coachs->count() }}</p> <!-- Nombre de coachs -->
        </a>
        <!-- Carte pour les Demandes -->
        <a href="{{ route('demande.list') }}" class="card">
            <!-- Icône SVG pour les demandes -->
            <svg class="card-icon icon-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h2 class="card-title">Demandes</h2> <!-- Titre de la carte -->
            <p class="card-count">{{ $demandes->count() }}</p> <!-- Nombre de demandes -->
        </a>
    </div>
</div>
@endsection
