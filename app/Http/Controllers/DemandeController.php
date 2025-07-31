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
  public function showDemande ($id)
    {
        // Retrieve the coaching session by ID
        $demande = Demande::find($id);

        // Check if the coaching session exists
        if (!$demande) {
            abort(404, 'Coaching session not found');
        }

        // Retrieve the specific coach and student associated with the coaching session
        $coach = User::find($demande->coach_id);
        $student = User::find($demande->user_id);

        // Check if the coach and student exist
        if (!$coach || !$student) {
            abort(404, 'Coach or student not found');
        }

        // Pass the coaching session, coach, and student to the view
        return view('user.showDemande', compact('demande', 'coach', 'student'));
    }
}
