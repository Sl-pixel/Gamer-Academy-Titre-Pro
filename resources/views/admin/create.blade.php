@extends('layout')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="flex justify-center items-center min-h-[70vh] bg-gray-50 py-10">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-8">Créer un Adminisateur</h2>
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">
                <form method="POST" action="{{ route('createAdmin') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-medium mb-1">Pseudo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Mot de passe</label>
                        <input type="password" name="password" id="password" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition shadow-sm">
                        Créer L'Administrateur
                    </button>
                </form>
                <div class="mt-6 flex justify-start space-x-4">
                    <button onclick="goBack()" class="px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600 transition duration-300">
                        Retour
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection
