<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coaching extends Model
{
    use HasFactory;

    protected $table = 'coachings';

    protected $fillable = ['user_id', 'game_id', 'coach_id', 'date_coaching', 'duree', 'commentaires', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'student');
    }
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id')->where('role', 'coach');
    }
    public function jeu()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
    public function notes()
    {
        return $this->hasMany(Note::class, 'coaching_id', 'id');
    }

    }
