<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       public function run()
    {
        // Vider la table avant d'insérer de nouvelles données
        DB::table('demandes')->truncate();

        // Récupérer les IDs des utilisateurs et des jeux existants
        $userIds = DB::table('users')->where('role', 'student')->pluck('id')->toArray();
        $coachIds = DB::table('users')->where('role', 'coach')->pluck('id')->toArray();
        $gameIds = DB::table('games')->pluck('id')->toArray();
        // Récupérer les identifiants Discord des étudiants depuis la base de données
        $studentDiscords = DB::table('users')->where('role', 'student')->pluck('discord')->toArray();

        $statuses = ['pending', 'rejected'];

        // Créer 20 requêtes fictives
        foreach (range(1, 10) as $index) {
            DB::table('demandes')->insert([
                'user_id' => $userIds[array_rand($userIds)],
                'coach_id' => $coachIds[array_rand($coachIds)],
                'game_id' => $gameIds[array_rand($gameIds)],
                'status' => $statuses[array_rand($statuses)],
                'message' => 'Message de requête exemple pour la demande ' . $index,
                'discord' => $studentDiscords[array_rand($studentDiscords)], // Utiliser un identifiant Discord aléatoire depuis les étudiants
                'duree' => rand(30, 120), // Random duration between 30 and 120 minutes
            ]);
        }
    }
}