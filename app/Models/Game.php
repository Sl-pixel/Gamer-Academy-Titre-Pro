<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    // Spécifie le nom de la table associée à ce modèle dans la base de données
    protected $table = 'games';

    // Liste des attributs qui peuvent être assignés en masse
    protected $fillable = [
        'name', // Nom du jeu
        'description', // Description du jeu
        'genre', // Genre du jeu
        'plateforme', // Plateforme sur laquelle le jeu est disponible
        'image', // URL ou chemin vers l'image du jeu
        'slug' // Slug du jeu
    ];
    // Liste des attributs à cacher dans les réponses JSON
    protected $hidden = ['created_at', 'updated_at'];

}
