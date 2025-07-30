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
    // coach
    public function coachDashboard(User $user)
{
    // Vérifier si l'utilisateur est authentifié et s'il a le rôle de coach
    if (!Auth::check() || Auth::user()->role !== 'coach') {
        return redirect()->route('login')->with('error', 'Vous devez être connecté en tant que coach pour accéder à cette page.');
    }

    // Logique d'autorisation pour vous assurer qu'un coach ne peut voir que son propre tableau de bord
    if (Auth::user()->id !== $user->id) {
        return redirect()->route('login')->with('error', 'Vous ne pouvez accéder qu’à votre propre tableau de bord.');
    }

    $demandes = $user->demandesCoaching()->get();
    $coachingIncoming = $user->coachings()->get();
    $coachingPast = Coaching::where('coach_id', $user->id)
        ->where('date_coaching', '<', now())
        ->get();

    // Fusionner les coachings à venir et passés
    $allCoachings = $coachingIncoming->concat($coachingPast);

    // Formater les événements pour FullCalendar
    $events = $allCoachings->map(function ($coaching) {
        return [
            'title' => 'Coaching avec ' . $coaching->user->name,
            'start' => $coaching->date_coaching,
            'url' => route('showCoachingInfo', $coaching->id) // Optionnel : lien vers plus d'informations
        ];
    });

    $yearlyRevenue = DB::table('revenues')
        ->where('user_id', $user->id)
        ->whereYear('date', Carbon::now()->year)
        ->sum('amount');

    $monthlyRevenue = DB::table('revenues')
        ->where('user_id', $user->id)
        ->whereMonth('date', Carbon::now()->month)
        ->whereYear('date', Carbon::now()->year)
        ->sum('amount');

    $dailyRevenue = DB::table('revenues')
        ->where('user_id', $user->id)
        ->whereDate('date', Carbon::now()->toDateString())
        ->sum('amount');

    // Passer les données à la vue
    return view('coach.dashboard', compact('user', 'yearlyRevenue', 'monthlyRevenue', 'dailyRevenue', 'demandes', 'coachingIncoming', 'events'));
}
    public function updateCoachBio(Request $request, $id)
    {
        // verification
        $request->validate([
            'biographie' => 'required|string|max:255',
        ]);

        // cherche l'id du user et update la bio
        $user = User::findOrFail($id);
        $user->biographie = $request->input('biographie');
        $user->save();


        return back()->with('success', 'Biographie mis à jour avec succès.');
    }

    public function updateCoachTarif(Request $request, $id)
    {
        // verification

        $request->validate([
            'tarif' => 'required|string',
        ]);

        // cherche l'id du user et update le tarif
        $user = User::findOrFail($id);
        $user->tarif = $request->input('tarif');
        $user->save();


        return back()->with('success', 'Tarif mis à jour avec succès.');
    }

    public function showDemandeCoach($id)
    {

        $user = User::findOrFail($id);

        if (auth()->user()->role === 'coach' && auth()->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $demandes = $user->demandesCoaching()->where('status', 'pending')->get();

        return view('coach.demande', compact('demandes', 'user'));

    }


 public function traiterDemande(Request $request, $id)
{
    $action = $request->input('action'); // 'accept' ou 'reject'

    DB::transaction(function () use ($id, $action) {
        $demande = Demande::where('id', $id)->where('status', 'pending')->firstOrFail();

        if (auth()->user()->id !== $demande->coach_id) {
            abort(403, 'Action non autorisée.');
        }

        if ($action === 'accept') {
            Coaching::firstOrCreate(
                ['demande_id' => $demande->id],
                [
                    'user_id'      => $demande->user_id,
                    'coach_id'     => $demande->coach_id,
                    'game_id'      => $demande->game_id,
                    'date_coaching'=> $demande->date_coaching,
                    'duree'        => $demande->duree,
                    'commentaires' => $demande->message,
                    'status'       => 'accepted',
                ]
            );
            $demande->status = 'accepted';
        } elseif ($action === 'reject') {
            $demande->status = 'rejected';
        }
        $demande->save();
    });

    return back()->with('success', 'La demande a été traitée.');
}



}
