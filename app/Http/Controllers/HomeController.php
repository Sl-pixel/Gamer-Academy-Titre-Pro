<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Models\Note;
use Illuminate\Http\Request;

class HomeController extends Controller {
    // Récupère les notes à afficher sur la page d'accueil (avec relations)
    protected function getNotesForHome()
    {
        return Note::with(['student', 'coach'])->latest()->take(10)->get();
    }
    // Affiche un jeu spécifique basé sur son slug ou le premier jeu si aucun slug n'est fourni
    public function showGame($slug = null)
    {
        $games = Game::all(); // Récupère tous les jeux
        if ($slug) {
            $firstGame = Game::where('slug', '=', $slug)->first();
        } else {
            $firstGame = $games->first();
        }

        $notes = $this->getNotesForHome();

        return view('home.index', [
            'games' => $games,
            'firstGame' => $firstGame,
            'notes' => $notes,
        ]);
    }

    // Affiche le formulaire de contact
    public function contactForm()
    {
        return view('contact.contact'); // Retourne la vue du formulaire de contact
    }
}