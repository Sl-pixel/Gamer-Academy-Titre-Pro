<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $table = 'demandes'; // Nom de la table associée au modèle
    protected $fillable = ['user_id', 'coach_id', 'date_coaching', 'duree', 'message', 'status', 'discord'];
    protected $hidden = ['created_at', 'updated_at']; // Champs à cacher dans les réponses JSON
  public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'student');
    }
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id')->where('role', 'coach');
    }
}   
