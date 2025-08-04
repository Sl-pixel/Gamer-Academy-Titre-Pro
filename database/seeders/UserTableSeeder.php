<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        DB::table('notes')->delete(); // Clear existing notes if any

        // Noms aléatoires pour les utilisateurs
        $firstNames = [
            'Alexandre', 'Baptiste', 'Camille', 'Damien', 'Emma', 'Florian', 'Gabrielle', 'Hugo',
            'Inès', 'Julien', 'Karine', 'Lucas', 'Marie', 'Nathan', 'Océane', 'Pierre',
            'Quentin', 'Romane', 'Sophie', 'Thomas', 'Valentin', 'William', 'Xavier', 'Yasmine', 'Zoé'
        ];
        
        $lastNames = [
            'Dupont', 'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Petit', 'Durand',
            'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David',
            'Bertrand', 'Roux', 'Vincent', 'Fournier', 'Morel', 'Girard', 'André', 'Lefèvre', 'Mercier'
        ];

        $gamingPrefixes = [
            'Pro', 'Dark', 'Shadow', 'Elite', 'Cyber', 'Neon', 'Alpha', 'Beta', 'Omega', 'Nova',
            'Pixel', 'Storm', 'Fire', 'Ice', 'Lightning', 'Dragon', 'Phoenix', 'Viper', 'Wolf', 'Eagle'
        ];

        $gamingSuffixes = [
            'Gaming', 'Pro', 'Master', 'King', 'Queen', 'Slayer', 'Hunter', 'Warrior', 'Legend', 'Hero',
            'God', 'Ace', 'Sniper', 'Ninja', 'Wizard', 'Beast', 'Killer', 'Champion', 'Boss', 'Elite'
        ];

        // Insert admin with random name
        $adminFirstName = $firstNames[array_rand($firstNames)];
        $adminLastName = $lastNames[array_rand($lastNames)];
        DB::table('users')->insert([
            'name' => $adminFirstName . ' ' . $adminLastName,
            'email' => strtolower($adminFirstName . '.' . $adminLastName . '@gameracademy.com'),
            'discord' => $adminFirstName . '#' . rand(1000, 9999),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $games = [
            1 => 'CS2',
            2 => 'Valorant',
            3 => 'Tekken',
            4 => 'Mario Kart',
        ];

        $coaches = [];
        $students = [];

        // Create coaches
        $usedNames = []; // Pour éviter les doublons
        for ($i = 1; $i <= 12; $i++) {
            $gameId = ($i - 1) % count($games) + 1;
            
            // Générer un nom unique
            do {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $fullName = $firstName . ' ' . $lastName;
            } while (in_array($fullName, $usedNames));
            $usedNames[] = $fullName;
            
            // Générer un pseudo Discord gaming
            $discordName = $gamingPrefixes[array_rand($gamingPrefixes)] . $gamingSuffixes[array_rand($gamingSuffixes)];
            
            // Créneaux de disponibilité fictifs pour chaque coach
            $availability = [
                'Lundi 18:00-20:00',
                'Mercredi 14:00-16:00',
                'Samedi 10:00-12:00'
            ];
            $coaches[] = [
                'name' => $fullName,
                'email' => strtolower($firstName . '.' . $lastName . '@coach.com'),
                'discord' => $discordName . '#' . rand(1000, 9999),
                'password' => Hash::make('password'),
                'role' => 'coach',
                'tarif' => rand(10, 30),
                'game_id' => $gameId,
                'biographie' => 'Coach professionnel spécialisé en ' . $games[$gameId] . '. Avec plusieurs années d\'expérience en compétition, je vous aide à développer vos compétences et à atteindre vos objectifs gaming.',
                'availability' => json_encode($availability),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        // Create students
        for ($i = 1; $i <= 12; $i++) {
            // Générer un nom unique
            do {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $fullName = $firstName . ' ' . $lastName;
            } while (in_array($fullName, $usedNames));
            $usedNames[] = $fullName;
            
            // Générer un pseudo Discord gaming
            $discordName = $gamingPrefixes[array_rand($gamingPrefixes)] . $gamingSuffixes[array_rand($gamingSuffixes)];
            
            $students[] = [
                'name' => $fullName,
                'email' => strtolower($firstName . '.' . $lastName . '@student.com'),
                'discord' => $discordName . '#' . rand(1000, 9999),
                'password' => Hash::make('password'),
                'role' => 'student',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Insert coaches and students into the database
        DB::table('users')->insert($coaches);
        DB::table('users')->insert($students);

        // Fetch the inserted coaches and students to get their IDs
        $insertedCoaches = DB::table('users')->where('role', 'coach')->get();
        $insertedStudents = DB::table('users')->where('role', 'student')->get();

        // Commentaires aléatoires pour les notes des étudiants
        $commentaires = [
            'Excellent coach ! M\'a vraiment aidé à progresser rapidement. Je recommande vivement ses services.',
            'Très professionnel et patient. Les sessions étaient parfaitement adaptées à mon niveau.',
            'Coach fantastique ! Grâce à lui, j\'ai enfin compris les stratégies avancées du jeu.',
            'Super expérience ! Le coach est très pédagogue et m\'a donné de précieux conseils.',
            'Coaching de qualité exceptionnelle. J\'ai vu une amélioration immédiate de mes performances.',
            'Coach très compétent qui sait s\'adapter au style de jeu de chacun. Merci beaucoup !',
            'Sessions enrichissantes et motivantes. Le coach m\'a redonné confiance en mes capacités.',
            'Parfait ! Le coach a su identifier mes points faibles et m\'aider à les corriger efficacement.',
            'Excellent pédagogue. Les explications sont claires et les exercices bien pensés.',
            'Coach très sympathique et professionnel. J\'ai appris énormément en peu de temps.',
            'Coaching personnalisé et de haute qualité. Je recommande sans hésitation !',
            'Merci pour ces sessions formidables ! Mon niveau de jeu s\'est considérablement amélioré.',
        ];

        // Insert notes for each coach-student pair

        foreach ($insertedStudents as $student) {
            $noteCount = 0; // Initialiser le compteur de notes pour chaque étudiant
            $assignedCoachIds = []; // Tableau pour suivre les identifiants des coachs déjà assignés

            // Convertir la collection en tableau
            $coachesArray = $insertedCoaches->all();

            // Continuer jusqu'à ce que l'étudiant ait reçu des notes de deux coachs différents
            while ($noteCount < 2) {
                // Sélectionner un coach aléatoirement
                $randomCoach = $coachesArray[array_rand($coachesArray)];

                // Vérifier si le coach n'a pas déjà été assigné à cet étudiant
                if (!in_array($randomCoach->id, $assignedCoachIds)) {
                    DB::table('notes')->insert([
                        'coach_id' => $randomCoach->id,
                        'user_id' => $student->id,
                        'commentaire' => $commentaires[array_rand($commentaires)],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    $noteCount++; // Incrémenter le compteur après chaque insertion
                    $assignedCoachIds[] = $randomCoach->id; // Ajouter l'identifiant du coach à la liste des coachs assignés
                }
            }
        }

    }
}