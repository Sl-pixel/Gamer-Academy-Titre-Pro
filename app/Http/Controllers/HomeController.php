<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showGame($slug = null)
    {
        $games = Game::all();

        if ($slug) {
            $firstGame = Game::where('slug', '=', $slug)->first();
        } else {
            $firstGame = $games->first();
        }

        return view('home.index', [
            'games' => $games,
            'firstGame' => $firstGame,
        ]);
    }
    public function showCoaches(Game $game)
    {
        $coaches = User::where('role', '=', 'coach')->where('game_id', $game->id)->get();
        return view('home.showCoaches', compact('game', 'coaches'));
    }

public function contactForm () {
    return view('contact.contact');
}

}
