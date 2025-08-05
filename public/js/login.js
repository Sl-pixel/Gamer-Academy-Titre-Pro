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