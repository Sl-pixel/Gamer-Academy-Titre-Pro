@extends('layout')

@section('title', 'Contactez le Support')

@section('content')
    <div class="flex justify-center items-center min-h-[60vh]">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Contactez le Support</h2>

            <form action="/submit-contact" method="post">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nom :</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email :</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-gray-700 font-semibold mb-2">Sujet :</label>
                    <select id="subject" name="subject" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="demande-information">Demande d'information</option>
                        <option value="support-technique">Support technique</option>
                        <option value="remboursement">Remboursement</option>
                        <option value="question-facturation">Question sur la facturation</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700 font-semibold mb-2">Message :</label>
                    <textarea id="message" name="message" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required></textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold py-2 rounded transition">Envoyer</button>
            </form>
        </div>
    </div>
@endsection
