// Écoute l'événement 'DOMContentLoaded' qui se déclenche lorsque le DOM est complètement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Récupère les éléments du formulaire et des messages d'erreur
    const form = document.getElementById('admin-create-form');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const nameError = document.getElementById('name-error');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    // Ajoute un écouteur d'événement pour la soumission du formulaire
    form.addEventListener('submit', function(e) {
        let valid = true; // Variable pour suivre la validité du formulaire

        // Cache tous les messages d'erreur au début de la validation
        nameError.classList.add('hidden');
        emailError.classList.add('hidden');
        passwordError.classList.add('hidden');

        // Validation du champ 'name' (pseudo)
        if (!name.value.trim()) {
            nameError.textContent = 'Le pseudo est requis.';
            nameError.classList.remove('hidden');
            valid = false;
        } else if (name.value.length < 3) {
            nameError.textContent = 'Le pseudo doit contenir au moins 3 caractères.';
            nameError.classList.remove('hidden');
            valid = false;
        }

        // Validation du champ 'email'
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expression régulière pour valider l'email
        if (!email.value.trim()) {
            emailError.textContent = 'L\'email est requis.';
            emailError.classList.remove('hidden');
            valid = false;
        } else if (!emailPattern.test(email.value)) {
            emailError.textContent = 'Le format de l\'email est invalide.';
            emailError.classList.remove('hidden');
            valid = false;
        }

        // Validation du champ 'password' (mot de passe)
        if (!password.value) {
            passwordError.textContent = 'Le mot de passe est requis.';
            passwordError.classList.remove('hidden');
            valid = false;
        } else if (password.value.length < 4) {
            passwordError.textContent = 'Le mot de passe doit contenir au moins 4 caractères.';
            passwordError.classList.remove('hidden');
            valid = false;
        }

        // Si le formulaire n'est pas valide, empêche sa soumission
        if (!valid) {
            e.preventDefault(); // Empêche l'envoi du formulaire
        }
    });
});
// Écoute l'événement 'DOMContentLoaded' pour s'assurer que le DOM est chargé avant d'exécuter le script
// Ce script gère la validation du formulaire d'inscription pour les administrateurs
// Il vérifie que les champs requis sont remplis et affichera des messages d'erreur si nécessaire