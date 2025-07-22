
@extends('layout')

@section('title', 'Inscription')

@section('content')
    <div class="flex justify-center items-center min-h-[60vh]">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Créer un compte</h2>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-center">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('registerUser') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Pseudo</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Adresse email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Mot de passe</label>
                    <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
                <!-- <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div> -->
                <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold py-2 rounded transition">S'inscrire</button>
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-indigo-700 hover:underline">Déjà inscrit ? Se connecter</a>
                </div>
            </form>
        </div>
    </div>
@endsection
