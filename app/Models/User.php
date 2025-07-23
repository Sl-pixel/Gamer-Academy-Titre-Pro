<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // ou 'user' si ta table est bien au singulier
    protected $fillable = ['name', 'email', 'password', 'role', 'profile_picture', 'biographie', 'revenues'];
    protected $hidden = ['password', 'remember_token', 'email'];
    public function isCoach()
    {
        return $this->role === 'coach';
    }
    public function isStudent()
    {
        return $this->role === 'student';
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function coachings()
    {
        if ($this->role === 'coach') {
            // Si l'utilisateur est un coach, on retourne les coachings où il est le coach.
            return $this->hasMany(Coaching::class, 'coach_id', 'id');
        }

        // Par défaut, pour les étudiants, on retourne les coachings où ils sont l'utilisateur.
        return $this->hasMany(Coaching::class, 'user_id', 'id');
    }
    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    public function demandesCoaching()
    {
        return $this->hasMany(Demande::class, 'coach_id', 'id'); // Relation avec le modèle Request
    }
    public function demandes()
{
    return $this->hasMany(Demande::class);
}

    public function students()
    {
        return $this->belongsToMany(User::class, 'notes', 'coach_id', 'student_id')
            ->withPivot('id', 'notes')
            ->where('users.role', 'student');
    }
    public function coaches()
    {
        return $this->belongsToMany(User::class, 'notes', 'student_id', 'coach_id')
            ->withPivot('id', 'notes')
            ->where('users.role', 'coach');
    }
    public function revenues()
    {
        return $this->hasMany(Revenue::class, 'coach_id');
    }
}
