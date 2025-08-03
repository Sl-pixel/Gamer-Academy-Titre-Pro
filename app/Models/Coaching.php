<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coaching extends Model
{
    use HasFactory;

    // Spécifie le nom de la table associée à ce modèle dans la base de données
    protected $table = 'coachings';

    // Liste des attributs qui peuvent être assignés en masse
    protected $fillable = [
        'user_id', // Identifiant de l'utilisateur (étudiant) associé à ce coaching
        'game_id', // Identifiant du jeu associé à ce coaching
        'coach_id', // Identifiant du coach associé à ce coaching
        'date_coaching', // Date prévue pour le coaching
        'duree', // Durée prévue pour le coaching
        'commentaires', // Commentaires associés à ce coaching
        'status', // Statut du coaching 
        'demande_id' // Identifiant de la demande associée à ce coaching
    ];

    // Définit une relation "appartient à" avec le modèle User pour l'utilisateur (étudiant)
    public function user()
    {
        // Retourne l'utilisateur associé à ce coaching avec le rôle 'student'
        return $this->belongsTo(User::class, 'user_id')->where('role', 'student');
    }

    // Définit une relation "appartient à" avec le modèle User pour le coach
    public function coach()
    {
        // Retourne le coach associé à ce coaching avec le rôle 'coach'
        return $this->belongsTo(User::class, 'coach_id')->where('role', 'coach');
    }

    // Définit une relation "appartient à" avec le modèle Game pour le jeu
    public function jeu()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    // Définit une relation "un à plusieurs" avec le modèle Note pour les notes associées
    public function notes()
    {
        return $this->hasMany(Note::class, 'coaching_id', 'id');
    }
}
