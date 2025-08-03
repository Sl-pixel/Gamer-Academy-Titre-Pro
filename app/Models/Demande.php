<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    // Spécifie le nom de la table associée à ce modèle dans la base de données
    protected $table = 'demandes';

    // Liste des attributs qui peuvent être assignés en masse
    protected $fillable = [
        'user_id', // Identifiant de l'utilisateur qui fait la demande
        'coach_id', // Identifiant du coach à qui la demande est adressée
        'date_coaching', // Date prévue pour le coaching
        'duree', // Durée prévue pour le coaching
        'message', // Message accompagnant la demande
        'status', // Statut de la demande (par exemple, en attente, acceptée, refusée)
        'discord' // Informations Discord associées à la demande
    ];

    // Liste des attributs à cacher dans les réponses JSON
    protected $hidden = ['created_at', 'updated_at'];

    // Définit une relation "appartient à" avec le modèle User pour l'utilisateur
    public function user()
    {
        // Retourne l'utilisateur associé à cette demande avec le rôle 'student'
        return $this->belongsTo(User::class, 'user_id')->where('role', 'student');
    }

    // Définit une relation "appartient à" avec le modèle User pour le coach
    public function coach()
    {
        // Retourne le coach associé à cette demande avec le rôle 'coach'
        return $this->belongsTo(User::class, 'coach_id')->where('role', 'coach');
    }
}
