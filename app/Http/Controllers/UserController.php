<?php

namespace App\Http\Controllers;
use \App\Models\User;
use \App\Models\Game;
use Illuminate\Http\Request;



class UserController extends Controller
{
    // student
    // public function studentDashboard (User $user) {
    //     // logique d'autorisation pour vous assurer
    //     // qu'un étudiant ne peut voir que son propre tableau de bord.
    //     if (auth()->user()->isStudent() && auth()->user()->id !== $user->id) {
    //         abort(403);
    //     }

    //     $games = Game::all();
    //     return view('user.edit', compact('user', 'games'));
    // }
  public function editProfile($id)
    {
        $user = User::findOrFail($id);
        $games = Game::all();
        if (auth()->user()->role === 'coach' && auth()->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->role === 'student' && auth()->user()->id !== $user->id) {
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
        public function showCoaches(Game $game)
    {
        $coaches = User::where('role', '=', 'coach')->where('game_id', $game->id)->get();
        return view('home.showCoaches', compact('game', 'coaches'));
    }

    public function selectCoach ($id) {

        $coach = User::find($id);

        return view('home.selectCoach', compact('coach'));
    }
}
