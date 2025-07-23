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
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDashboard()
    {
        $coachs = User::where('role', 'coach')->get();
        $coachings = Coaching::whereIn('status', ['accepted', 'done'])->paginate(10);
        $students = User::where('role', 'student')->get();
        $demandes = Demande::whereIn('status', ['pending', 'rejected', 'accepted'])->get();
        return view('admin.dashboard', compact('coachings', 'students', 'coachs', 'demandes'));
    }


    // edit
    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function editCoaching($id)
    {
        $games = Game::all();
        $coaching = Coaching::find($id);
        $coach = User::find($coaching->coach_id);
        $student = User::find($coaching->user_id);
        return view('admin.coaching.edit', compact('coaching', 'student', 'coach', 'games'));
    }



    // update
public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:4',
        'discord' => 'nullable|string|unique:users,discord,' . $id,
        'profile_photo' => 'nullable|image|max:2048', // Ajout validation image
    ]);

    $user = User::findOrFail($id);
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    if ($request->filled('discord')) {
        $user->discord = $request->input('discord');
    }

    // Ajout de la mise à jour de la photo de profil
    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('profile_pictures', 'public');
        $user->profile_picture = $path;
    }

    $user->save();

    return back()->with('success', 'Utilisateur mis à jour avec succès.');
}

    public function updateRoleOnly(Request $request, $id)
    {
        $request->validate([
            'role' => ['required', Rule::in(['student', 'coach'])],
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();

        return back()->with('success', 'Rôle mis à jour avec succès.');
    }

    public function updateCoaching(Request $request, $id)
    {

        return back()->with('success', 'Rôle mis à jour avec succès.');
    }


    public function updateStatusOnly(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['accepted', 'done'])],
        ]);

        $coaching = Coaching::findOrFail($id);
        $coaching->status = $request->input('status');
        $coaching->save();

        return back()->with('success', 'Status du Coaching mis à jour avec succès.');
    }

    // show

    public function showNotes($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.note', compact('user'));
    }
    public function showDemandes($id)
    {
        $user = User::findOrFail($id);
        $demandes = $user->demandesCoaching()->get();

        return view('admin.user.note', compact('user'));
    }

    public function showUserInfo($id)
    {
        $user = User::find($id);
        $demandes = $user->demandesCoaching()->get();

        return view('admin.user.show', compact('user', 'demandes'));
    }

    public function showCoachingInfo($id)
    {
        // Retrieve the coaching session by ID
        $coaching = Coaching::find($id);

        // Check if the coaching session exists
        if (!$coaching) {
            abort(404, 'Coaching session not found');
        }

        // Retrieve the specific coach and student associated with the coaching session
        $coach = User::find($coaching->coach_id);
        $student = User::find($coaching->user_id);

        // Check if the coach and student exist
        if (!$coach || !$student) {
            abort(404, 'Coach or student not found');
        }

        // Pass the coaching session, coach, and student to the view
        return view('admin.coaching.show', compact('coaching', 'coach', 'student'));
    }
    public function showDemandeInfo ($id)
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
        return view('admin.user.demande', compact('demande', 'coach', 'student'));
    }
public function showList(string $type): View
{
    switch ($type) {
        case 'student':
            $users = User::where('role', 'student')->latest()->paginate(10);
            return view('admin.user.list', compact('users'));

        case 'coach':
            $users = User::where('role', 'coach')->latest()->paginate(10);
            return view('admin.user.list', compact('users'));

        case 'demande':
            $demandes = Demande::whereIn('status', ['pending', 'rejected'])->get();
            return view('admin.demande.list', compact('demandes'));

        case 'coaching':
            $coachings = Coaching::whereIn('status', ['accepted', 'done'])->paginate(10);
            return view('admin.coaching.list', compact('coachings'));

        default:
            // Gérer le cas par défaut, par exemple, rediriger ou retourner une vue d'erreur
            abort(404, 'Type de liste non valide');
    }
}
    // delete
    public function destroyUser($id)
    {
        $user = User::find($id);

        if ($user->role === 'student') {
            $user->delete();
            return redirect()->route('student.list')->with('success', 'Utilisateur supprimé.');
        } else if ($user->role === 'coach') {
            $user->delete();
            return redirect()->route('coach.list')->with('success', 'Utilisateur supprimé.');
        }
    }
    public function destroyCoaching($id)
    {
        $coaching = Coaching::find($id);

        $coaching->delete();
        return redirect()->route('coaching.list')->with('success', 'Coaching supprimé.');
    }
    public function destroyNote($id)
    {
        $note = Note::find($id);
        $note->delete();
        return back()->with('success', 'Note supprimée avec succès.');
    }
}
