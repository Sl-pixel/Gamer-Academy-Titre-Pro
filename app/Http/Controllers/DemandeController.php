<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \App\Models\Note;
use \App\Models\Coaching;
use \App\Models\Demande;
use \App\Models\Game;

class DemandeController extends Controller
{
    // Affiche les détails d'une demande de coaching spécifique
    public function showDemande($id)
    {
        // Récupère la demande de coaching par son identifiant
        $demande = Demande::find($id);

        // Vérifie si la demande de coaching existe
        if (!$demande) {
            abort(404, 'Session de coaching non trouvée'); // Retourne une erreur 404 si la demande n'est pas trouvée
        }

        // Récupère le coach et l'étudiant spécifiques associés à la demande de coaching
        $coach = User::find($demande->coach_id);
        $student = User::find($demande->user_id);

        // Vérifie si le coach et l'étudiant existent
        if (!$coach || !$student) {
            abort(404, 'Coach ou étudiant non trouvé'); // Retourne une erreur 404 si le coach ou l'étudiant n'est pas trouvé
        }

        // Passe la demande de coaching, le coach et l'étudiant à la vue
        return view('user.showDemande', compact('demande', 'coach', 'student'));
    }
}
