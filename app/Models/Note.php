<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // Spécifie le nom de la table associée à ce modèle dans la base de données
    protected $table = 'notes';

    // Liste des attributs qui peuvent être assignés en masse
    protected $fillable = [
        'user_id', // Identifiant de l'utilisateur associé à cette note
        'coach_id', // Identifiant du coach associé à cette note
        'game_id', // Identifiant du jeu associé à cette note
        'commentaires' // Commentaires associés à cette note
    ];

    // Définit une relation "appartient à" avec le modèle User
    public function user()
    {
        // La clé étrangère est 'user_id' comme défini dans la migration
        return $this->belongsTo(User::class, 'user_id')->where('role', 'student');
    }

    // Définit une relation "appartient à" avec le modèle Game
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
    // Définit une relation "appartient à" avec le modèle User pour le coach
    public function coach()
    {
        // La clé étrangère est 'coach_id' comme défini dans la migration
        return $this->belongsTo(User::class, 'coach_id')->where('role', 'coach');
    }

    // Définit une relation "appartient à" avec le modèle Coaching
    public function coaching()
    {
        return $this->belongsTo(Coaching::class, 'coaching_id');
    }

    // Définit une relation "un à plusieurs" avec le modèle User pour l'étudiant
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'student');
    }

}
