@extends('layout')
@section('title', 'Dashboard')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Tableau de bord de l'utilisateur</h1>

    <div class="bg-white shadow-md rounded my-6">
        <h2 class="text-xl font-semibold p-4 border-b">Mes Demandes</h2>
        <div class="p-4">
            @if($student->demandes && $student->demandes->isNotEmpty())
                <ul class="list-disc pl-5">
                    @foreach($student->demandes as $demande)
                        <li class="text-gray-700 mb-2">
                            <span class="font-semibold">ID:</span> {{ $demande->id }} |
                            <span class="font-semibold">Status:</span> {{ $demande->status }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucune demande trouvée.</p>
            @endif
        </div>
    </div>
</div>
@endsection
