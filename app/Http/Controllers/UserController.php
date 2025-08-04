<?php
namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Game;
use \App\Models\Coaching;
use \App\Models\Demande;
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
        
        // Récupère les demandes de coaching pour l'utilisateur
        $demandes = $user->demandesCoaching()->get();

        // Récupère les coachings à venir pour l'utilisateur (statut accepted et dans la semaine en cours)
        $startOfWeek = now()->startOfWeek(); // Début de la semaine (lundi)
        $endOfWeek = now()->endOfWeek();     // Fin de la semaine (dimanche)
        
        if ($user->role === 'coach') {
            $coachingIncoming = Coaching::where('coach_id', $user->id)
                ->where('status', 'accepted')
                ->whereBetween('date_coaching', [$startOfWeek, $endOfWeek])
                ->where('date_coaching', '>=', now()) // Seulement les coachings à partir de maintenant
                ->orderBy('date_coaching', 'asc')
                ->get();

            // Récupère les coachings passés pour le coach
            $coachingPast = Coaching::where('coach_id', $user->id)
                ->where('status', 'accepted')
                ->where('date_coaching', '<', now())
                ->get();
        } else {
            // Pour les étudiants
            $coachingIncoming = Coaching::where('user_id', $user->id)
                ->where('status', 'accepted')
                ->whereBetween('date_coaching', [$startOfWeek, $endOfWeek])
                ->where('date_coaching', '>=', now()) // Seulement les coachings à partir de maintenant
                ->orderBy('date_coaching', 'asc')
                ->get();

            // Récupère les coachings passés pour l'étudiant
            $coachingPast = Coaching::where('user_id', $user->id)
                ->where('status', 'accepted')
                ->where('date_coaching', '<', now())
                ->get();
        }

        // Fusionne les coachings à venir et passés pour le calendrier
        $allCoachings = $coachingIncoming->concat($coachingPast);

        // Formate les événements pour FullCalendar (tous les coachings acceptés)
        $events = $allCoachings->map(function ($coaching) use ($user) {
            if ($user->role === 'coach') {
                $title = 'Coaching avec ' . $coaching->user->name;
            } else {
                $title = 'Coaching avec ' . $coaching->coach->name;
            }
            return [
                'title' => $title,
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

    // Affiche toutes les demandes de coaching d'un étudiant
    public function showStudentDemandes(User $user)
    {
        // Vérification d'autorisation - seul l'étudiant peut voir ses propres demandes
        if (auth()->user()->role === 'student' && auth()->user()->id !== $user->id) {
            abort(403, 'Action non autorisée.');
        }

        // Récupère toutes les demandes de l'étudiant avec les relations coach et game
        $demandes = $user->demandesCoaching()
            ->with(['coach', 'coach.game'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.demande', compact('user', 'demandes'));
    }

    // Annule une demande de coaching en attente
    public function cancelDemande($id)
    {
        $demande = Demande::findOrFail($id);

        // Vérification d'autorisation - seul l'étudiant qui a fait la demande peut l'annuler
        if (auth()->user()->id !== $demande->user_id) {
            abort(403, 'Action non autorisée.');
        }

        // Vérification que la demande est encore en attente
        if ($demande->status !== 'pending') {
            return redirect()->back()->with('error', 'Vous ne pouvez annuler que les demandes en attente.');
        }

        // Suppression de la demande
        $demande->delete();

        return redirect()->back()->with('success', 'Votre demande a été annulée avec succès.');
    }
}
