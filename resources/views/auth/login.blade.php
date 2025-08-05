@extends('layout') 

@section('title', 'Connexion')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Connexion</h2>

        <form id="loginForm" method="POST" action="{{ route('loginUser') }}" novalidate>
            @csrf

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

            <button type="submit" class="btn btn-primary btn-full">Se connecter</button>

            <div class="auth-link">
                <a href="{{ route('registerForm') }}">Pas encore de compte ? S'inscrire</a>
            </div>
        </form>
        <script>
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                let valid = true;
                const email = document.getElementById('email');
                const password = document.getElementById('password');
                const emailError = document.getElementById('emailError');
                const passwordError = document.getElementById('passwordError');

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email.value.trim() || !emailPattern.test(email.value)) {
                    emailError.textContent = !email.value.trim() ? 'Veuillez entrer une adresse email.' : 'Veuillez entrer une adresse email valide.';
                    emailError.classList.remove('hidden');
                    valid = false;
                } else {
                    emailError.classList.add('hidden');
                }

                if (!password.value.trim()) {
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