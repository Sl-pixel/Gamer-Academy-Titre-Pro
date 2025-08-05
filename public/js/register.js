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