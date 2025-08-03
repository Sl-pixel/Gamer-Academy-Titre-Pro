@extends('layout')

@section('title', 'Détails du Coach')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-center mb-10">Détails du Coach : {{ $coach->name }}</h1>

        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="{{ $coach->profile_picture ? asset('storage/' . $coach->profile_picture) : asset('/images/default-avatar-profile.jpg') }}"
                 alt="Photo de {{ $coach->name }}" class="w-full h-64 object-cover object-center">

            <div class="p-6">
                <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $coach->name }}</h2>
                <p class="text-gray-600 mb-4">{{ $coach->biographie }}</p>

                <div class="mb-4">
                    <span class="text-xl font-bold text-indigo-600">{{ $coach->tarif }}€/h</span>
                </div>

                <div class="mb-4">
                    <h3 class="text-xl font-semibold mb-2">Disponibilités</h3>
                    @php
                        $availabilities = is_array($coach->availability) ? $coach->availability : json_decode($coach->availability, true);
                    @endphp
                    <ul class="list-disc list-inside">
                        @foreach ($availabilities as $availability)
                            <li>{{ $availability }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="text-center mt-6">
                    <!-- Formulaire de demande de coaching -->
                    <form method="POST" action="{{ route('demanderCoaching', $coach->id) }}" class="bg-gray-50 p-6 rounded-lg shadow-md mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="horaire" class="block text-gray-700 font-semibold mb-1">Choisir une plage horaire :</label>
                            <select name="horaire" id="horaire" required class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="">-- Sélectionner --</option>
                                @foreach ($availabilities as $availability)
                                    <option value="{{ $availability }}">{{ $availability }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="discord" class="block text-gray-700 font-semibold mb-1">Votre pseudo Discord :</label>
                            <input type="text" name="discord" id="discord" required class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Ex: MonDiscord#1234">
                        </div>
                        <div>
                            <label for="pseudo_jeu" class="block text-gray-700 font-semibold mb-1">Votre pseudo en jeu :</label>
                            <input type="text" name="pseudo_jeu" id="pseudo_jeu" required class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Pseudo dans le jeu">
                        </div>
                        <div>
                            <label for="rang" class="block text-gray-700 font-semibold mb-1">Votre rang (en fonction du jeu) :</label>
                            <input type="text" name="rang" id="rang" required class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Ex: Gold, Platine, etc.">
                        </div>
                        <div>
                            <label for="message" class="block text-gray-700 font-semibold mb-1">Message pour le coach :</label>
                            <textarea name="message" id="message" rows="3" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Expliquez vos attentes, vos besoins, etc."></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-3 rounded-full shadow-lg transition-colors duration-300">Envoyer la demande & Procéder au paiement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
