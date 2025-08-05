@extends('layout') 

@section('title', 'Inscription')

@section('content')
<!-- Lien CSS natif (à mettre dans le layout ou ici si besoin) -->
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Créer un compte</h2>

        <form id="registerForm" method="POST" action="{{ route('registerUser') }}" novalidate>
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Pseudo</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" class="form-input">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p id="nameError" class="form-error hidden">Veuillez entrer un pseudo.</p>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" class="form-input">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p id="emailError" class="form-error hidden">Veuillez entrer une adresse email.</p>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" required class="form-input">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p id="passwordError" class="form-error hidden">Veuillez entrer un mot de passe.</p>
            </div>

            <p id="registerError" class="form-error mb-2 hidden">Veuillez remplir tous les champs.</p>
            <button type="submit" class="btn btn-primary btn-full">S'inscrire</button>

            <div class="auth-link">
                <a href="{{ route('login') }}">Déjà inscrit ? Se connecter</a>
            </div>
        </form>
        <script>
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                let valid = true;
                const name = document.getElementById('name');
                const email = document.getElementById('email');
                const password = document.getElementById('password');
                const nameError = document.getElementById('nameError');
                const emailError = document.getElementById('emailError');
                const passwordError = document.getElementById('passwordError');

                if (!name.value.trim()) {
                    nameError.classList.remove('hidden');
                    valid = false;
                } else {
                    nameError.classList.add('hidden');
                }

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email.value.trim() || !emailPattern.test(email.value)) {
                    emailError.textContent = !email.value.trim() ? 'Veuillez entrer une adresse email.' : 'Veuillez entrer une adresse email valide.';
                    emailError.classList.remove('hidden');
                    valid = false;
                } else {
                    emailError.classList.add('hidden');
                }

                if (!password.value.trim() || password.value.length < 4) {
                    passwordError.textContent = !password.value.trim() ? 'Veuillez entrer un mot de passe.' : 'Le mot de passe doit contenir au moins 4 caractères.';
                    passwordError.classList.remove('hidden');
                    valid = false;
                } else {
                    passwordError.classList.add('hidden');
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        </script>
    </div>
</div>
@endsection