<?php

namespace App\Http\Controllers;
use \App\Models\User;
use \App\Models\Demande;
use \App\Models\Coaching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserController extends Controller
{
    // student
    public function studentDashboard (User $user) {
        // logique d'autorisation pour vous assurer
        // qu'un étudiant ne peut voir que son propre tableau de bord.
        if (auth()->user()->isStudent() && auth()->user()->id !== $user->id) {
            abort(403);
        }

        return view('student.dashboard', compact('user'));
    }




}

