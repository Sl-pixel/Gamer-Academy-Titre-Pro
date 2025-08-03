<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    // Spécifie le nom de la table associée à ce modèle dans la base de données
    protected $table = 'revenues';

    // Liste des attributs qui peuvent être assignés en masse
    protected $fillable = [
        'coach_id', // Identifiant du coach associé à ce revenu
        'amount',   // Montant du revenu
        'created_at', // Date et heure de création de l'enregistrement
        'updated_at', // Date et heure de la dernière mise à jour de l'enregistrement
    ];

    // Indique si le modèle doit gérer automatiquement les colonnes `created_at` et `updated_at`
    // Ici, c'est défini à `false`, donc le modèle ne gérera pas automatiquement ces timestamps
    public $timestamps = false;
}
