<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    // Spécifie le nom de la table associée à ce modèle dans la base de données
    protected $table = 'users';

    // Liste des attributs qui peuvent être assignés
    protected $fillable = ['name', 'email', 'password', 'role', 'profile_picture', 'biographie', 'revenues', 'avaibility'];

    // Liste des attributs qui doivent être cachés des représentations JSON du modèle
    protected $hidden = ['password', 'remember_token', 'email'];

    // Vérifie si l'utilisateur est un coach
    public function isCoach()
    {
        return $this->role === 'coach';
    }

    // Vérifie si l'utilisateur est un étudiant
    public function isStudent()
    {
        return $this->role === 'student';
    }

    // Vérifie si l'utilisateur est un administrateur
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Définit une relation avec le modèle Coaching
    public function coachings()
    {
        if ($this->role === 'coach') {
            // Si l'utilisateur est un coach, retourne les coachings où il est le coach
            return $this->hasMany(Coaching::class, 'coach_id', 'id');
        }
        // Par défaut, pour les étudiants, retourne les coachings où ils sont l'utilisateur
        return $this->hasMany(Coaching::class, 'user_id', 'id');
    }

    // Définit une relation "un à plusieurs" avec le modèle Note
    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }

    // Définit une relation "appartient à" avec le modèle Game
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    // Définit une relation "un à plusieurs" avec le modèle Demande pour les demandes de coaching faites par cet utilisateur
    public function demandesCoaching()
    {
        if ($this->role === 'coach') {
            // Si l'utilisateur est un coach, retourne les demandes adressées à ce coach
            return $this->hasMany(Demande::class, 'coach_id', 'id');
        }
        // Pour les étudiants, retourne les demandes faites par cet étudiant
        return $this->hasMany(Demande::class, 'user_id', 'id'); 
    }

    // Définit une relation "un à plusieurs" avec le modèle Demande
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    // Définit une relation "plusieurs à plusieurs" avec le modèle User pour les étudiants
    public function students()
    {
        return $this->belongsToMany(User::class, 'notes', 'coach_id', 'user_id')
            ->withPivot('id', 'commentaire')
            ->where('users.role', 'student');
    }

    // Définit une relation "plusieurs à plusieurs" avec le modèle User pour les coachs
    public function coaches()
    {
        return $this->belongsToMany(User::class, 'notes', 'user_id', 'coach_id')
            ->withPivot('id', 'commentaire')
            ->where('users.role', 'coach');
    }

    // Définit une relation "un à plusieurs" avec le modèle Revenue pour les revenus associés au coach
    public function revenues()
    {
        return $this->hasMany(Revenue::class, 'coach_id');
    }
}
