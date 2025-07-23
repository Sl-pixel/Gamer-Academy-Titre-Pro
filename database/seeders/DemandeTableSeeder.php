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
       DB::table('demandes')->delete();

        // Récupérer les utilisateurs et les jeux
        $students = DB::table('users')->where('role', 'student')->get();
        $coaches = DB::table('users')->where('role', 'coach')->get();
        $gameIds = DB::table('games')->pluck('id')->toArray();

        if ($students->isEmpty() || $coaches->isEmpty()) {
            // Pas la peine de continuer s'il n'y a pas d'étudiants ou de coachs
            return;
        }

        $statuses = ['pending', 'rejected', 'accepted'];
        $demandesToInsert = [];

        // S'assurer que chaque étudiant a 2 ou 3 demandes
        foreach ($students as $student) {
            $numberOfRequests = rand(2, 3);
            for ($i = 0; $i < $numberOfRequests; $i++) {
                $coach = $coaches->random();
                $demandesToInsert[] = [
                    'user_id' => $student->id,
                    'coach_id' => $coach->id,
                    'game_id' => $coach->game_id ?? $gameIds[array_rand($gameIds)],
                    'status' => $statuses[array_rand($statuses)],
                    'date_coaching' => now()->addDays(rand(1, 30)), // <-- Ajout ici
                    'message' => 'Message de requête exemple pour la demande de ' . $student->name,
                    'discord' => $student->discord,
                    'duree' => rand(30, 120),
                    
                ];
            }
        }

        // Maintenant, s'assurer que chaque coach a entre 2 et 3 demandes
        $coachRequestCounts = collect($demandesToInsert)->countBy('coach_id');

        foreach ($coaches as $coach) {
            $currentCount = $coachRequestCounts->get($coach->id, 0);
            $needed = rand(2, 3) - $currentCount; // Viser 2 ou 3 demandes au total

            if ($needed > 0) {
                for ($i = 0; $i < $needed; $i++) {
                    $student = $students->random();
                    $demandesToInsert[] = [
                        'user_id' => $student->id,
                        'coach_id' => $coach->id,
                        'game_id' => $coach->game_id ?? $gameIds[array_rand($gameIds)],
                        'status' => $statuses[array_rand($statuses)],
                        'date_coaching' => now()->addDays(rand(1, 30)), // <-- Ajout ici
                        'message' => 'Message de requête supplémentaire pour le coach ' . $coach->name,
                        'discord' => $student->discord,
                        'duree' => rand(30, 120),
                    ];
                }
            }
        }

        // Insérer toutes les demandes générées en une seule fois pour être plus performant
        DB::table('demandes')->insert($demandesToInsert);
    }
}