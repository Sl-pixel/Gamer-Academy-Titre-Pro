<!-- Dans resources/views/students/show.blade.php -->
@extends('layout')

@section('title', 'Informations de l\'Étudiant')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Informations de l'Étudiant</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Prénom</label>
                <p>{{ $user->name }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <p>{{ $user->email }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Numéro de téléphone</label>
                <p>{{ $user->phone_number }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Date de naissance</label>
                <p>{{ $user->date_of_birth }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Adresse</label>
                <p>{{ $user->address }}</p>
            </div>
        </div>
    </div>
@endsection
