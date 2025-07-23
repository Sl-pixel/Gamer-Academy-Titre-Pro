<?php

namespace App\Http\Controllers;
use \App\Models\User;
use \App\Models\Demande;
use \App\Models\Coaching;
use \App\Models\Game;
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
  public function editProfile($id)
    {
        $user = User::find($id);
        $games = Game::all();
        if (auth()->user()->role === 'coach' && auth()->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
    return view('user.edit', compact('user', 'games'));
    }
    
      public function updateGame(Request $request, User $user)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
        ]);

        $user->game_id = $request->game_id;
        $user->save();

        return back()->with('success', 'Le jeu associé a été mis à jour avec succès.');
    }
}

