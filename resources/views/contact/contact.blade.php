@extends('layout')

@section('title', 'Contactez le Support')

@section('content')
    <div class="flex justify-center items-center min-h-[60vh]">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Contactez le Support</h2>

            <form id="contactForm" action="/submit-contact" method="post" novalidate>
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nom :</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                    <p id="nameError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer votre nom.</p>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email :</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer un email valide.</p>
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-gray-700 font-semibold mb-2">Sujet :</label>
                    <select id="subject" name="subject" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="">-- Choisissez un sujet --</option>
                        <option value="demande-information">Demande d'information</option>
                        <option value="support-technique">Support technique</option>
                        <option value="remboursement">Remboursement</option>
                        <option value="question-facturation">Question sur la facturation</option>
                        <option value="autre">Autre</option>
                    </select>
                    <p id="subjectError" class="text-red-500 text-sm mt-1 hidden">Veuillez sélectionner un sujet.</p>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700 font-semibold mb-2">Message :</label>
                    <textarea id="message" name="message" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required></textarea>
                    <p id="messageError" class="text-red-500 text-sm mt-1 hidden">Veuillez entrer un message.</p>
                </div>
                <button type="submit" class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold py-2 rounded transition">Envoyer</button>
            </form>
            
            <script>
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                let valid = true;
                // Nom
                const name = document.getElementById('name');
                const nameError = document.getElementById('nameError');
                if (!name.value.trim()) {
                    nameError.classList.remove('hidden');
                    valid = false;
                } else {
                    nameError.classList.add('hidden');
                }
                // Email
                const email = document.getElementById('email');
                const emailError = document.getElementById('emailError');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email.value.trim() || !emailPattern.test(email.value)) {
                    emailError.classList.remove('hidden');
                    valid = false;
                } else {
                    emailError.classList.add('hidden');
                }
                // Sujet
                const subject = document.getElementById('subject');
                const subjectError = document.getElementById('subjectError');
                if (!subject.value) {
                    subjectError.classList.remove('hidden');
                    valid = false;
                } else {
                    subjectError.classList.add('hidden');
                }
                // Message
                const message = document.getElementById('message');
                const messageError = document.getElementById('messageError');
                if (!message.value.trim()) {
                    messageError.classList.remove('hidden');
                    valid = false;
                } else {
                    messageError.classList.add('hidden');
                }
                if (!valid) {
                    e.preventDefault();
                }
            });
            </script>
        </div>
    </div>
@endsection
