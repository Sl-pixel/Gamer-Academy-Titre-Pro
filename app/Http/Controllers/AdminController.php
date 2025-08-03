<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
    // Affiche le tableau de bord de l'administrateur
    public function adminDashboard()
    {
        $coachs = User::where('role', 'coach'); 
        $coachings = Coaching::all(); 
        $students = User::where('role', 'student'); 
        $demandes = Demande::all(); 

        return view('admin.dashboard', compact('coachings', 'students', 'coachs', 'demandes')); // Retourne la vue du tableau de bord avec les données
    }

    // Affiche le formulaire d'édition d'un utilisateur
    public function editUser($id)
    {
        $user = User::find($id); // Trouve l'utilisateur par son identifiant
        return view('admin.user.edit', compact('user')); // Retourne la vue d'édition avec l'utilisateur
    }

    // Met à jour les informations d'un utilisateur
    public function updateUser(Request $request, $id)
    {
        // Valide les entrées de l'utilisateur
        $request->validate([
            'name' => 'nullable|string|unique:users,name,' . $id . '|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:4',
            'discord' => 'nullable|string|unique:users,discord,' . $id,
            'profile_picture' => 'nullable|image|max:2048',
        ], [
            'name.unique' => 'Ce pseudo est déjà utilisé.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'discord.unique' => 'Ce pseudo Discord est déjà utilisé.',
            'password.min' => 'Le mot de passe doit contenir au moins 4 caractères.'
        ]);

        $user = User::findOrFail($id); // Trouve l'utilisateur ou échoue avec une erreur 404

        if ($request->filled('name')) {
            $user->name = $request->input('name'); // Met à jour le nom s'il est fourni
        }
        if ($request->filled('email')) {
            $user->email = $request->input('email'); // Met à jour l'email s'il est fourni
        }
        if ($request->filled('password')) {
            // Vérifie si le nouveau mot de passe est identique à l'ancien
            if (Hash::check($request->input('password'), $user->password)) {
                return back()->withErrors(['password' => 'Le nouveau mot de passe ne peut pas être identique à l\'ancien.'])->withInput();
            }
            $user->password = Hash::make($request->input('password'));
        }
        if ($request->filled('discord')) {
            $user->discord = $request->input('discord'); // Met à jour le discord s'il est fourni
        }

        // Met à jour la photo de profil si un fichier est fourni
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save(); // Sauvegarde les modifications

        // Si le rôle est admin, redirige vers la page showUserInfo
        if (Auth::user() && Auth::user()->role === 'admin') {
            return redirect()->route('showUserInfo', $user->id)->with('success', 'Utilisateur mis à jour avec succès.');
        }

        return back()->with('success', 'Utilisateur mis à jour avec succès.'); // Retourne avec un message de succès
    }

    // Met à jour uniquement le rôle d'un utilisateur
    public function updateRoleOnly(Request $request, $id)
    {
        // Valide le rôle fourni
        $request->validate([
            'role' => ['required', Rule::in(['student', 'coach'])],
        ]);

        $user = User::findOrFail($id); // Trouve l'utilisateur ou échoue avec une erreur 404
        $user->role = $request->input('role'); // Met à jour le rôle
        $user->save(); // Sauvegarde les modifications

        return back()->with('success', 'Rôle mis à jour avec succès.'); // Retourne avec un message de succès
    }

    // Met à jour le statut d'un coaching
    public function updateStatusOnly(Request $request, $id)
    {
        // Valide le statut fourni
        $request->validate([
            'status' => ['required', Rule::in(['accepted', 'done'])],
        ]);

        $coaching = Coaching::findOrFail($id); // Trouve le coaching ou échoue avec une erreur 404
        $coaching->status = $request->input('status'); // Met à jour le statut
        $coaching->save(); // Sauvegarde les modifications

        return back()->with('success', 'Statut du Coaching mis à jour avec succès.'); // Retourne avec un message de succès
    }

    // Affiche les notes d'un utilisateur
    public function showNotes($id)
    {
        $user = User::findOrFail($id); // Trouve l'utilisateur ou échoue avec une erreur 404
        return view('admin.user.note', compact('user')); // Retourne la vue des notes avec l'utilisateur
    }


    // Affiche les informations d'un utilisateur
    public function showUserInfo($id)
    {
        $user = User::find($id); // Trouve l'utilisateur
        return view('admin.user.show', compact('user')); // Retourne la vue des informations de l'utilisateur avec l'utilisateur et ses demandes
    }

    // Affiche les informations d'un coaching
    public function showCoachingInfo($id)
    {
        // Récupère le coaching par son identifiant
        $coaching = Coaching::find($id);

        // Vérifie si le coaching existe
        if (!$coaching) {
            abort(404, 'Coaching n\'existe pas'); // Retourne une erreur 404 si le coaching n'est pas trouvé
        }

        // Récupère le coach et l'étudiant associés au coaching
        $coach = User::find($coaching->coach_id);
        $student = User::find($coaching->user_id);

        // Vérifie si le coach et l'étudiant existent
        if (!$coach || !$student) {
            abort(404, 'Coach ou étudiant n\'existe pas'); // Retourne une erreur 404 si le coach ou l'étudiant n'est pas trouvé
        }

        // Passe le coaching, le coach et l'étudiant à la vue
        return view('admin.coaching.show', compact('coaching', 'coach', 'student'));
    }

    // Affiche les informations d'une demande de coaching
    public function showDemandeInfo($id)
    {
        // Récupère la demande de coaching par son identifiant
        $demande = Demande::find($id);

        // Vérifie si la demande existe
        if (!$demande) {
            abort(404, 'Demande n\'existe pas'); // Retourne une erreur 404 si la demande n'est pas trouvée
        }

        // Récupère le coach et l'étudiant associés à la demande
        $coach = User::find($demande->coach_id);
        $student = User::find($demande->user_id);

        // Vérifie si le coach et l'étudiant existent
        if (!$coach || !$student) {
            abort(404, 'Coach ou étudiant n\'existe pas'); // Retourne une erreur 404 si le coach ou l'étudiant n'est pas trouvé
        }

        // Passe la demande, le coach et l'étudiant à la vue
        return view('admin.demande.show', compact('demande', 'coach', 'student'));
    }

    // Affiche une liste d'utilisateurs ou de coachings ou de demandes en fonction du type
    public function showList(string $type): View
    {
        switch ($type) {
            case 'student':
                $users = User::where('role', 'student')->latest()->paginate(10); // Récupère les étudiants
                return view('admin.user.list', compact('users'));
            case 'coach':
                $users = User::where('role', 'coach')->latest()->paginate(10); // Récupère les coachs
                return view('admin.user.list', compact('users'));
            case 'demande':
                $demandes = Demande::paginate(10); 
                return view('admin.demande.list', compact('demandes'));
            case 'coaching':
                $coachings = Coaching::paginate(10);
                return view('admin.coaching.list', compact('coachings'));
            default:
                abort(404, 'Type de liste non valide');
        }
    }

    // Supprime un utilisateur
    public function destroyUser($id)
    {
        $user = User::find($id); // Trouve l'utilisateur
        if (Auth::user() && Auth::user()->role === 'student' || Auth::user()->role === 'coach') {
            $user->delete(); // Supprime l'utilisateur
            return redirect()->route('index')->with('success', 'Votre compte a été supprimé avec succès.');
        }
        if ($user->role === 'student') {
            $user->delete(); // Supprime l'utilisateur
            return redirect()->route('student.list')->with('success', 'Utilisateur supprimé.'); // Redirige avec un message de succès
        } else if ($user->role === 'coach') {
            $user->delete(); // Supprime l'utilisateur
            return redirect()->route('coach.list')->with('success', 'Utilisateur supprimé.'); // Redirige avec un message de succès
        }

    }

    // Supprime un coaching
    public function destroyCoaching($id)
    {
        $coaching = Coaching::find($id); // Trouve le coaching
        $coaching->delete(); // Supprime le coaching
        return redirect()->route('coaching.list')->with('success', 'Coaching supprimé.'); // Redirige avec un message de succès
    }

    // Supprime une demande de coaching
    public function destroyDemande($id)
    {
        $demande = Demande::find($id); // Trouve la demande
        $demande->delete(); // Supprime la demande
        return redirect()->route('demande.list')->with('success', 'Demande supprimée.'); // Redirige avec un message de succès
    }

    // Supprime une note
    public function destroyNote($id)
    {
        $note = Note::find($id); // Trouve la note
        $note->delete(); // Supprime la note
        return back()->with('success', 'Note supprimée avec succès.'); // Retourne avec un message de succès
    }

    // Affiche le formulaire de création d'un administrateur
    public function create()
    {
        return view('admin.create'); // Retourne la vue de création d'un administrateur
    }

    // Crée un nouvel administrateur
    public function createAdmin(Request $request)
    {
        // Valide les entrées de l'utilisateur pour la création d'un administrateur
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
        ], [
            'name.unique' => 'Ce Pseudo est déjà utilisé. Veuillez utiliser un autre.',
            'email.unique' => 'Cet email est déjà utilisé. Veuillez utiliser un autre email.',
            'password.min' => 'Ce mot de passe est trop court, veuillez mettre plus de 4 caractères.',
        ]);

        // Crée un nouvel administrateur avec les informations fournies
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password), // Hache le mot de passe avant de le stocker
            'role' => 'admin', // Définit le rôle comme 'admin'
        ]);

        return back()->with('success', 'Admin créé avec succès'); // Retourne avec un message de succès
    }
}
