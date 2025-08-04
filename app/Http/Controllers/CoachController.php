<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Note;
use \App\Models\Coaching;
use \App\Models\Demande;
use \App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CoachController extends Controller
{
    // Affiche le tableau de bord du coach
    public function coachDashboard(User $user)
    {
        // Vérifie si l'utilisateur est authentifié et s'il a le rôle de coach
        if (!Auth::check() || Auth::user()->role !== 'coach') {
            return redirect()->route('login')->with('error', 'Vous devez être connecté en tant que coach pour accéder à cette page.');
        }

        // Logique d'autorisation pour s'assurer qu'un coach ne peut voir que son propre tableau de bord
        if (Auth::user()->id !== $user->id) {
            return redirect()->route('login')->with('error', 'Vous ne pouvez accéder qu’à votre propre tableau de bord.');
        }

        // Récupère les demandes de coaching pour le coach
        $demandes = $user->demandesCoaching()->get();

        // Récupère les coachings à venir pour le coach (statut accepted et dans la semaine en cours)
        $startOfWeek = now()->startOfWeek(); // Début de la semaine (lundi)
        $endOfWeek = now()->endOfWeek();     // Fin de la semaine (dimanche)
        
        $coachingIncoming = Coaching::where('coach_id', $user->id)
            ->where('status', 'accepted')
            ->whereBetween('date_coaching', [$startOfWeek, $endOfWeek])
            ->where('date_coaching', '>=', now()) // Seulement les coachings à partir de maintenant
            ->with(['user', 'game']) // Charge les relations
            ->orderBy('date_coaching', 'asc')
            ->get();

        // Récupère les coachings passés pour le coach
        $coachingPast = Coaching::where('coach_id', $user->id)
            ->where('status', 'accepted')
            ->where('date_coaching', '<', now())
            ->with(['user', 'game']) // Charge les relations
            ->get();

        // Fusionne les coachings à venir et passés
        $allCoachings = $coachingIncoming->concat($coachingPast);

        // Formate les événements pour FullCalendar (tous les coachings acceptés)
        $events = $allCoachings->map(function ($coaching) {
            return [
                'title' => 'Coaching avec ' . $coaching->user->name,
                'start' => $coaching->date_coaching,
                'url' => route('showCoaching', $coaching->id) // Optionnel : lien vers plus d'informations
            ];
        });

        // Calcule les revenus annuels, mensuels et quotidiens du coach
        $yearlyRevenue = DB::table('revenues')
            ->where('coach_id', $user->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $monthlyRevenue = DB::table('revenues')
            ->where('coach_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $dailyRevenue = DB::table('revenues')
            ->where('coach_id', $user->id)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->sum('amount');

        // Récupère les disponibilités du coach (availability)
        $availabilities = [];
        if ($user->availability) {
            $availabilities = json_decode($user->availability, true) ?? [];
        }

        // Génère les events de disponibilités pour le calendrier JS
        $availabilityEvents = [];
        $daysMap = [
            'Lundi' => 1,
            'Mardi' => 2,
            'Mercredi' => 3,
            'Jeudi' => 4,
            'Vendredi' => 5,
            'Samedi' => 6,
            'Dimanche' => 0,
        ];
        foreach ($availabilities as $day => $slot) {
            if ($slot && isset($slot['start']) && isset($slot['end'])) {
                // Créneau de disponibilité principal
                $availabilityEvents[] = [
                    'daysOfWeek' => [$daysMap[$day]],
                    'startTime' => $slot['start'],
                    'endTime' => $slot['end'],
                    'display' => 'background',
                    'title' => 'Disponible',
                    'color' => '#a7f3d0',
                ];
                // Créneau de pause (si défini)
                if (!empty($slot['break_start']) && !empty($slot['break_end'])) {
                    $availabilityEvents[] = [
                        'daysOfWeek' => [$daysMap[$day]],
                        'startTime' => $slot['break_start'],
                        'endTime' => $slot['break_end'],
                        'display' => 'background',
                        'title' => 'Pause',
                        'color' => '#fca5a5', // rouge clair
                    ];
                }
            }
        }

        // Passe les données à la vue
        return view('coach.dashboard', compact('user', 'yearlyRevenue', 'monthlyRevenue', 'dailyRevenue', 'demandes', 'coachingIncoming', 'events', 'availabilities', 'availabilityEvents'));
    }

    // Met à jour la biographie du coach
    public function updateCoachBio(Request $request, $id)
    {
        // Valide la requête pour s'assurer que la biographie est fournie et est une chaîne de caractères
        $request->validate([
            'biographie' => 'required|string|max:255',
        ]);

        // Trouve l'utilisateur par son identifiant et met à jour la biographie
        $user = User::findOrFail($id);
        $user->biographie = $request->input('biographie');
        $user->save();

        return back()->with('success', 'Biographie mise à jour avec succès.');
    }

    // Met à jour le tarif du coach
    public function updateCoachTarif(Request $request, $id)
    {
        // Valide la requête pour s'assurer que le tarif est fourni et est une chaîne de caractères
        $request->validate([
            'tarif' => 'required|string',
        ]);

        // Trouve l'utilisateur par son identifiant et met à jour le tarif
        $user = User::findOrFail($id);
        $user->tarif = $request->input('tarif');
        $user->save();

        return back()->with('success', 'Tarif mis à jour avec succès.');
    }

    // Affiche les demandes de coaching pour un coach spécifique
    public function showDemandeCoach($id)
    {
        $user = User::findOrFail($id);

        // Vérifie si l'utilisateur authentifié est autorisé à voir les demandes
        if (auth()->user()->role === 'coach' && auth()->user()->id !== $user->id) {
            abort(403, 'Action non autorisée.');
        }

        // Récupère les demandes de coaching en attente pour le coach
        $demandes = $user->demandesCoaching()->where('status', 'pending')->get();

        return view('coach.demande', compact('demandes', 'user'));
    }

    // Traite une demande de coaching (accepter ou refuser)
    public function traiterDemande(Request $request, $id)
    {
        $action = $request->input('action'); // 'accept' ou 'reject'

        DB::transaction(function () use ($id, $action) {
            // Trouve la demande en attente par son identifiant
            $demande = Demande::where('id', $id)->where('status', 'pending')->firstOrFail();

            // Vérifie si l'utilisateur authentifié est autorisé à traiter la demande
            if (auth()->user()->id !== $demande->coach_id) {
                abort(403, 'Action non autorisée.');
            }

            if ($action === 'accept') {
                // Si la demande est acceptée, crée un coaching ou le met à jour
                $coach = User::findOrFail($demande->coach_id);
                
                Coaching::firstOrCreate(
                    ['demande_id' => $demande->id],
                    [
                        'user_id' => $demande->user_id,
                        'coach_id' => $demande->coach_id,
                        'game_id' => $coach->game_id, // Utilise le game_id du coach
                        'date_coaching' => $demande->date_coaching,
                        'duree' => $demande->duree,
                        'commentaires' => $demande->message,
                        'status' => 'accepted',
                    ]
                );
                $demande->status = 'accepted';
            } elseif ($action === 'reject') {
                // Si la demande est refusée, met à jour le statut de la demande
                $demande->status = 'rejected';
            }

            // Sauvegarde les modifications de la demande
            $demande->save();
        });

        return back()->with('success', 'La demande a été traitée.');
    }


    // Met à jour les disponibilités du coach
    // Affiche le formulaire de disponibilités
    public function showAvailabilityForm($id)
    {
        // Vérifie que l'utilisateur authentifié correspond au coach
        if (!Auth::check() || Auth::user()->id != $id) {
            return redirect()->route('login')->with('error', 'Action non autorisée.');
        }

        $user = User::findOrFail($id);
        $availabilities = json_decode($user->availability, true) ?? [];

        return view('coach.availability', compact('user', 'availabilities'));
    }

    public function updateAvailability(Request $request, $id)
    {
        // Vérifie que l'utilisateur authentifié correspond au coach
        if (!Auth::check() || Auth::user()->id != $id) {
            return redirect()->route('login')->with('error', 'Action non autorisée.');
        }

        // Récupère les disponibilités par jour avec start/end/break
        $availability = $request->input('availability', []);
        
        // Valide que chaque jour a bien start, end et break
        foreach ($availability as $day => $slots) {
            if (!isset($slots['start']) || !isset($slots['end']) || !isset($slots['break'])) {
                return back()->with('error', 'Format de disponibilité invalide pour ' . $day);
            }
        }

        // Met à jour la colonne availability (JSON)
        $user = User::findOrFail($id);
        $user->availability = json_encode($availability);
        $user->save();

        return back()->with('success', 'Disponibilités mises à jour avec succès.');
    }
}
