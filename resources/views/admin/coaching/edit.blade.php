@extends('layout')

@section('title', 'Edit Coaching Session')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-6xl bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="p-8">
                <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-8">Edit Coaching Session</h1>

                <!-- Edit Coaching Session Form -->
                <form action="{{ route('updateCoaching', $coaching->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Coaching Session Info -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Coaching Session Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <p type="text" name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $coaching->status }}
                                </p>
                                </disabled>
                            </div>



                            <div>
                                <label for="duree" class="block text-sm font-medium text-gray-700">Duree
                                    (minutes)</label>
                                <input type="number" name="duree" id="duree" value="{{ $coaching->duree }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="game" class="block text-sm font-medium text-gray-700">Jeu</label>
                                <select
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                    @foreach($games as $game)
                                        <option value="student" {{ $coaching->status == 'accepted' ? 'selected' : '' }}>
                                            {{ $game->slug }}
                                    @endforeach
                                </select>

                            </div>
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="datetime-local" name="date" id="date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>


                    <!-- Commentaire Section -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Commentaire</h2>
                        <div class="bg-white p-4 rounded shadow-inner">
                            <p name="commentaire" id="commentaire"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>
                                {{ $coaching->commentaires ?? 'No commentaire available.' }}
                            </p>
                        </div>
                    </div>



                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Coaching Session
                        </button>
                    </div>
                </form>
                <form action="{{ route('updateStatusOnly', $coaching->id) }}" method="POST" id="statusForm"
                    class="mt-4 w-full text-center">
                    @csrf
                    @method('PUT')

                    <select name="role" onchange="document.getElementById('submitStatusBtn').click()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="student" {{ $coaching->status == 'accepted' ? 'selected' : '' }}>accepted</option>
                        <option value="coach" {{ $coaching->status == 'done' ? 'selected' : '' }}>done</option>
                    </select>
                    <button type="submit" id="submitStatusBtn" class="hidden"></button>
                </form>
            </div>
        </div>
    </div>
@endsection