<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoachingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the table before inserting new data
        DB::table('coachings')->truncate();

        // Retrieve the IDs of existing users with the role of 'student'
        $userIds = DB::table('users')->where('role', 'student')->pluck('id')->toArray();

        // Retrieve the IDs of users with the role of 'coach'
        $coachIds = DB::table('users')->where('role', 'coach')->pluck('id')->toArray();

        // Retrieve demande IDs
        $demandeIds = DB::table('demandes')->pluck('id')->toArray();

        // Ensure there are users, coaches, and demandes available
        if (empty($userIds) || empty($coachIds) || empty($demandeIds)) {
            throw new \Exception("No users, coaches, or demandes found in the database.");
        }

        // Define possible statuses
        $statuses = ['accepted', 'done'];

        // Define random comments for coaching sessions
        $commentaires = [
            'Excellente session ! Le joueur a montré une grande amélioration dans ses techniques de base et sa compréhension du jeu.',
            'Nous avons travaillé sur les stratégies défensives. Le joueur progresse bien et reste motivé pour les prochaines sessions.',
            'Session axée sur la communication en équipe et le positionnement. Des progrès notables ont été observés.',
            'Le joueur a démontré une excellente attitude et une volonté d\'apprendre. Nous continuerons sur cette lancée.',
            'Travail intensif sur les mécaniques de jeu avancées. Le joueur s\'adapte rapidement aux nouvelles techniques.',
            'Session productive avec focus sur l\'analyse des erreurs passées et l\'amélioration des réflexes.',
            'Excellent travail sur la gestion du stress en situation de compétition. Le joueur gagne en confiance.',
            'Nous avons abordé les stratégies offensives et la prise de décision rapide. Très bon retour du joueur.',
            'Session dédiée à l\'amélioration de la coordination et du timing. Progrès visibles dès cette séance.',
            'Le joueur montre une grande détermination. Nous avons perfectionné ses techniques de mouvement.',
            'Travail sur la lecture du jeu adverse et l\'anticipation. Le joueur développe son sens tactique.',
            'Session enrichissante avec mise en pratique des concepts théoriques vus précédemment.',
        ];

        // GARANTIR que CHAQUE coach a AU MINIMUM les sessions requises
        foreach ($coachIds as $coachId) {
            // OBLIGATOIRE : 4 à 7 coachings passés pour chaque coach
            $pastSessions = rand(4, 7);
            for ($i = 0; $i < $pastSessions; $i++) {
                $userId = $userIds[array_rand($userIds)];
                $demandeId = $demandeIds[array_rand($demandeIds)];
                $dateCoaching = now()->subDays(rand(7, 180)); // 7 à 180 jours dans le passé

                DB::table('coachings')->insert([
                    'user_id' => $userId,
                    'coach_id' => $coachId,
                    'demande_id' => $demandeId,
                    'duree' => rand(30, 120),
                    'commentaires' => $commentaires[array_rand($commentaires)],
                    'status' => 'done',
                    'date_coaching' => $dateCoaching,
                    'created_at' => $dateCoaching,
                    'updated_at' => $dateCoaching,
                ]);
            }

            // OBLIGATOIRE : 3 à 6 coachings à venir pour chaque coach
            $futureSessions = rand(3, 6);
            for ($i = 0; $i < $futureSessions; $i++) {
                $userId = $userIds[array_rand($userIds)];
                $demandeId = $demandeIds[array_rand($demandeIds)];
                
                // Répartir les coachings futurs intelligemment
                if ($i < 2) {
                    // Les 2 premiers dans la semaine en cours
                    $dateCoaching = now()->addDays(rand(1, 7));
                } else {
                    // Les autres dans les semaines suivantes
                    $dateCoaching = now()->addDays(rand(8, 30));
                }

                DB::table('coachings')->insert([
                    'user_id' => $userId,
                    'coach_id' => $coachId,
                    'demande_id' => $demandeId,
                    'duree' => rand(30, 120),
                    'commentaires' => $commentaires[array_rand($commentaires)],
                    'status' => 'accepted',
                    'date_coaching' => $dateCoaching,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Ensuite, créer des sessions supplémentaires aléatoires pour les étudiants
        foreach ($userIds as $userId) {
            $additionalSessions = rand(1, 3); // Sessions supplémentaires aléatoires

            for ($i = 0; $i < $additionalSessions; $i++) {
                $coachId = $coachIds[array_rand($coachIds)];
                $demandeId = $demandeIds[array_rand($demandeIds)];
                
                // 70% chance de session passée, 30% chance de session future
                if (rand(1, 10) <= 7) {
                    $dateCoaching = now()->subDays(rand(1, 120));
                    $status = 'done';
                    $createdAt = $dateCoaching;
                } else {
                    $dateCoaching = now()->addDays(rand(1, 45));
                    $status = 'accepted';
                    $createdAt = now();
                }

                DB::table('coachings')->insert([
                    'user_id' => $userId,
                    'coach_id' => $coachId,
                    'demande_id' => $demandeId,
                    'duree' => rand(30, 120),
                    'commentaires' => $commentaires[array_rand($commentaires)],
                    'status' => $status,
                    'date_coaching' => $dateCoaching,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
