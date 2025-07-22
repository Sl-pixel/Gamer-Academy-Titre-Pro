<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;

use Illuminate\Http\Request;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4'
        ]);

        $userEstValide = \Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        if ($userEstValide) {
            $request->session()->regenerate();

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

        return back()->withErrors([
            'authError' => 'L’email ou le mot de passe est invalide'
        ])->withInput($request->only('email', 'password'));
    }
    public function logout()
    {
        \Auth::logout();
        return to_route('index');
    }
    public function registerForm()
    {

        return view('auth.register');
    }
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // rediriger l'utilisateur après la création
        return redirect()->route('loginUser')->with('success', 'Utilisateur créé avec succès.');
    }

}

