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
                    <ul class="list-disc list-inside">
                        @foreach ($coach->disponibilites as $disponibilite)
                            <li>{{ $disponibilite }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('reserverSession', $coach->id) }}"
                       class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-3 rounded-full shadow-lg transition-colors duration-300 inline-block">
                        Réserver une session
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
