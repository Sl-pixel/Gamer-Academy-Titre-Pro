@extends('layout')

@section('title', 'Connexion')

@section('content')
    <div class="flex justify-center items-center min-h-[60vh]">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Connexion</h2>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-center">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('loginUser') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        Adresse email
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        email required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        Mot de passe
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 focus:ring-indigo-400" id="remember">
                    <label class="text-gray-600" for="remember">Se souvenir de moi</label>
                </div>


                <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold py-2 rounded transition">Se connecter</button>

                <div class="mt-4 text-center">
                    <a href="{{ route('registerForm') }}" class="text-indigo-700 hover:underline">Pas encore inscrit ? Créez votre compte</a>
                </div>
            </form>
        </div>
    </div>
@endsection
