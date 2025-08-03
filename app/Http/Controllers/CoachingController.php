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

class CoachingController extends Controller
{
    // Affiche les détails d'une session de coaching spécifique
    public function showCoaching($id)
    {
        // Récupère la session de coaching par son identifiant
        $coaching = Coaching::find($id);

        // Vérifie si la session de coaching existe
        if (!$coaching) {
            abort(404, 'Session de coaching non trouvée'); // Retourne une erreur 404 si la session n'est pas trouvée
        }

        // Récupère le coach et l'étudiant spécifiques associés à la session de coaching
        $coach = User::find($coaching->coach_id);
        $student = User::find($coaching->user_id);

        // Vérifie si le coach et l'étudiant existent
        if (!$coach || !$student) {
            abort(404, 'Coach ou étudiant non trouvé'); // Retourne une erreur 404 si le coach ou l'étudiant n'est pas trouvé
        }

        // Passe la session de coaching, le coach et l'étudiant à la vue
        return view('user.showCoaching', compact('coaching', 'coach', 'student'));
    }
}
