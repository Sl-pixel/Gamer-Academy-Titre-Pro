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
        
        // Messages aléatoires que les étudiants peuvent envoyer aux coachs
        $messages = [
            'Bonjour ! Je suis débutant et j\'aimerais améliorer mes compétences de base. Pouvez-vous m\'aider ?',
            'Salut ! Je bloque sur certaines stratégies avancées, j\'aurais besoin de conseils pour progresser.',
            'Hello ! Je cherche à monter de rang mais je stagne depuis plusieurs semaines. Une session m\'aiderait beaucoup !',
            'Bonsoir ! Je participe à des tournois bientôt et j\'aimerais peaufiner ma technique avec un coach expérimenté.',
            'Salut ! Mon équipe et moi avons des difficultés en communication, pourriez-vous nous donner des conseils ?',
            'Bonjour ! Je souhaite travailler sur ma gestion du stress en compétition, c\'est mon point faible.',
            'Hello ! J\'ai vu vos résultats impressionnants, j\'aimerais apprendre vos techniques de positioning.',
            'Salut ! Je débute en compétitif et j\'aurais besoin d\'aide pour comprendre les méta actuelles.',
            'Bonsoir ! Je cherche à améliorer mon aim et ma précision, accepteriez-vous de me coacher ?',
            'Bonjour ! Mon game sense n\'est pas terrible, j\'aimerais travailler la lecture de jeu avec vous.',
            'Hello ! Je prépare une compétition importante, une session intensive m\'aiderait énormément !',
            'Salut ! Je voudrais apprendre les techniques pro que vous utilisez, êtes-vous disponible ?',
        ];
        
        $demandesToInsert = [];

        // PREMIÈRE ÉTAPE : Garantir que CHAQUE coach a AU MINIMUM 4 demandes
        foreach ($coaches as $coach) {
            $minimumDemands = rand(4, 6); // Entre 4 et 6 demandes par coach OBLIGATOIRE
            
            for ($i = 0; $i < $minimumDemands; $i++) {
                $student = $students->random();
                
                // Répartition intelligente des statuts
                if ($i < 2) {
                    $status = 'pending'; // Au moins 2 demandes en attente par coach
                } elseif ($i < 4) {
                    $status = 'accepted'; // Au moins 2 demandes acceptées par coach
                } else {
                    $status = $statuses[array_rand($statuses)]; // Le reste aléatoire
                }
                
                $demandesToInsert[] = [
                    'user_id' => $student->id,
                    'coach_id' => $coach->id,
                    'game_id' => $coach->game_id ?? $gameIds[array_rand($gameIds)],
                    'status' => $status,
                    'date_coaching' => now()->addDays(rand(1, 30)),
                    'message' => $messages[array_rand($messages)],
                    'discord' => $student->discord,
                    'duree' => rand(30, 120),
                ];
            }
        }

        // DEUXIÈME ÉTAPE : Ajouter des demandes supplémentaires depuis les étudiants
        foreach ($students as $student) {
            $additionalRequests = rand(1, 3); // Demandes supplémentaires par étudiant
            for ($i = 0; $i < $additionalRequests; $i++) {
                $coach = $coaches->random();
                $demandesToInsert[] = [
                    'user_id' => $student->id,
                    'coach_id' => $coach->id,
                    'game_id' => $coach->game_id ?? $gameIds[array_rand($gameIds)],
                    'status' => $statuses[array_rand($statuses)],
                    'date_coaching' => now()->addDays(rand(1, 30)),
                    'message' => $messages[array_rand($messages)],
                    'discord' => $student->discord,
                    'duree' => rand(30, 120),
                ];
            }
        }

        // Insérer toutes les demandes générées en une seule fois pour être plus performant
        DB::table('demandes')->insert($demandesToInsert);
    }
}