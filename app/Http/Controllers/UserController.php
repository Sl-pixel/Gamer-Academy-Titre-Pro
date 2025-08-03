<?php
namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Game;
use \App\Models\Coaching;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Affiche le tableau de bord de l'étudiant
    public function studentDashboard(User $user)
    {
        // Logique d'autorisation pour s'assurer qu'un étudiant ne peut voir que son propre tableau de bord
        if (auth()->user()->isStudent() && auth()->user()->id !== $user->id) {
            abort(403); // Interrompt l'exécution et retourne une erreur 403 si l'utilisateur n'est pas autorisé
        }
        
        // Récupère les demandes de coaching pour le coach
        $demandes = $user->demandesCoaching()->get();

        // Récupère les coachings à venir pour le coach
        $coachingIncoming = $user->coachings()->get();

        // Récupère les coachings passés pour le coach
        $coachingPast = Coaching::where('coach_id', $user->id)
            ->where('date_coaching', '<', now())
            ->get();

        // Fusionne les coachings à venir et passés
        $allCoachings = $coachingIncoming->concat($coachingPast);

        // Formate les événements pour FullCalendar
        $events = $allCoachings->map(function ($coaching) {
            return [
                'title' => 'Coaching avec ' . $coaching->coach->name,
                'start' => $coaching->date_coaching,
                'url' => route('showCoaching', $coaching->id) // Optionnel : lien vers plus d'informations
            ];
        });
        return view('student.dashboard', compact('user', 'events', 'coachingIncoming', 'coachingPast', 'demandes')); // Retourne la vue d'édition avec l'utilisateur et les événements
    }

    // Affiche le formulaire d'édition du profil
    public function editProfile($id)
    {
        $user = User::findOrFail($id); // Trouve l'utilisateur ou échoue avec une erreur 404
        $games = Game::all(); // Récupère tous les jeux

        // Vérifie si l'utilisateur authentifié est autorisé à éditer le profil
        if (auth()->user()->role === 'coach' && auth()->user()->id !== $user->id) {
            abort(403, 'Action non autorisée.'); // Interrompt l'exécution et retourne une erreur 403 si l'utilisateur n'est pas autorisé
        }

        if (auth()->user()->role === 'student' && auth()->user()->id !== $user->id) {
            abort(403, 'Action non autorisée.'); // Interrompt l'exécution et retourne une erreur 403 si l'utilisateur n'est pas autorisé
        }

        return view('user.edit', compact('user', 'games')); // Retourne la vue d'édition avec l'utilisateur et les jeux
    }

    // Met à jour le jeu associé à l'utilisateur
    public function updateGame(Request $request, User $user)
    {
        // Valide la requête pour s'assurer que le game_id est fourni et existe dans la table des jeux
        $request->validate([
            'game_id' => 'required|exists:games,id',
        ]);

        $user->game_id = $request->game_id; // Met à jour le game_id de l'utilisateur
        $user->save(); // Sauvegarde les modifications

        return back()->with('success', 'Le jeu associé a été mis à jour avec succès.'); // Retourne à la vue précédente avec un message de succès
    }

    // Affiche les coachs associés à un jeu spécifique
    public function showCoaches(Game $game)
    {
        // Récupère les utilisateurs ayant le rôle de coach et associés au jeu spécifié
        $coaches = User::where('role', '=', 'coach')->where('game_id', $game->id)->get();

        return view('home.showCoaches', compact('game', 'coaches')); // Retourne la vue des coachs avec le jeu et les coachs
    }

    // Affiche le profil d'un coach spécifique
    public function selectCoach($id)
    {
        $coach = User::find($id); // Trouve le coach par son identifiant
        return view('home.selectCoach', compact('coach')); // Retourne la vue de sélection du coach avec le coach
    }
    // Affiche le profil d'un coach spécifique
    public function demanderCoaching($id)
    {
        $coach = User::find($id); // Trouve le coach par son identifiant
        return view('home.demanderCoaching', compact('coach')); // Retourne la vue de demande de coaching avec le coach
    }
}
