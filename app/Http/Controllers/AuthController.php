<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Affiche le formulaire de connexion
    public function login()
    {
        return view('auth.login');
    }

    // Gère la connexion de l'utilisateur
    public function loginUser(Request $request)
    {
        // Valide les entrées de l'utilisateur
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4'
        ]);

        // Tente de connecter l'utilisateur avec les informations fournies
        $userEstValide = \Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        // Si les informations d'identification sont valides
        if ($userEstValide) {
            $request->session()->regenerate(); // Régénère la session pour éviter les attaques de fixation de session

            // Redirige l'utilisateur en fonction de son rôle
            if (auth()->user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else if (auth()->user()->role === 'student') {
                return redirect()->intended('/');
            } else if (auth()->user()->role === 'coach') {
                return redirect()->intended('/coach/dashboard/' . auth()->user()->id);
            } else {
                return redirect()->intended('/');
            }
        }

        // Si les informations d'identification ne sont pas valides, redirige vers la page de connexion avec un message d'erreur
        return redirect('/login')->with('error', 'L’email ou le mot de passe est invalide.');
    }

    // Déconnecte l'utilisateur
    public function logout()
    {
        \Auth::logout(); // Déconnecte l'utilisateur
        return to_route('index'); // Redirige vers la page d'accueil
    }

    // Affiche le formulaire d'inscription
    public function registerForm()
    {
        return view('auth.register');
    }

    // Gère l'inscription d'un nouvel utilisateur
    public function registerUser(Request $request)
    {
        // Valide les entrées de l'utilisateur pour l'inscription
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
        ], [
            'name.unique' => 'Ce pseudo est déjà utilisé. Veuillez en choisir un autre.',
            'email.unique' => 'Cet email est déjà utilisé. Veuillez utiliser un autre email.',
        ]);

        // Crée un nouvel utilisateur avec les informations fournies
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password), // Hache le mot de passe avant de le stocker
            'role' => 'student', // Par défaut, le rôle est 'student'
        ]);

        // Redirige l'utilisateur vers la page de connexion avec un message de succès
        return redirect()->route('login')->with('success', 'Utilisateur créé avec succès.');
    }
}
