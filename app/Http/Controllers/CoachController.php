<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Note;
use \App\Models\Coaching;
use \App\Models\Demande;
use \App\Models\Game;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CoachController extends Controller
{
    // coach
    public function coachDashboard(User $user)
    {
        // Logique d'autorisation pour vous assurer qu'un coach ne peut voir que son propre tableau de bord
        if (auth()->user()->role === 'coach' && auth()->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $coachings = Coaching::whereIn('status', ['accepted', 'done'])->paginate(10);
        $demandes = $user->demandesCoaching()->get();
        $coachingIncoming = $user->coachings()->get();

        $yearlyRevenue = DB::table('revenues')
            ->where('user_id', $user->id)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        // Calcul du CA mensuel
        $monthlyRevenue = DB::table('revenues')
            ->where('user_id', $user->id)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        // Calcul du CA quotidien
        $dailyRevenue = DB::table('revenues')
            ->where('user_id', $user->id)
            ->whereDate('date', Carbon::now()->toDateString())
            ->sum('amount');

        // Passer les données à la vue
        return view('coach.dashboard', compact('user', 'yearlyRevenue', 'monthlyRevenue', 'dailyRevenue', 'coachings', 'demandes', 'coachingIncoming'));
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


    public function demandeAccept(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|accepted'
        ]);

        $demandeAccepted = Demande::findOrFail($id);
        $coaching = new Coaching();
        $coaching->demande_id = $demandeAccepted->id;
        $coaching->status = $request->input('status');
        $coaching->save();

        return back()->with('success', 'Status du Coaching mis à jour avec succès.');

    }
}
