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

        // Insert admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
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
        for ($i = 1; $i <= 12; $i++) {
            $gameId = ($i - 1) % count($games) + 1;
            // Créneaux de disponibilité fictifs pour chaque coach
            $availability = [
                'Lundi 18:00-20:00',
                'Mercredi 14:00-16:00',
                'Samedi 10:00-12:00'
            ];
            $coaches[] = [
                'name' => 'Coach ' . $i,
                'email' => 'coach' . $i . '@example.com',
                'discord' => 'Coach#' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'coach',
                'tarif' => rand(10, 30),
                'game_id' => $gameId,
                'biographie' => 'This is the biography of Coach ' . $i . '. With expertise in ' . $games[$gameId] . ', Coach ' . $i . ' is dedicated to helping players improve their skills and achieve their goals in the game.',
                'availability' => json_encode($availability),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        // Create students
        for ($i = 1; $i <= 12; $i++) {
            $students[] = [
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@example.com',
                'discord' => 'Student#' . str_pad($i, 4, '0', STR_PAD_LEFT),
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
                        'commentaire' => 'Commentaire pour le coach ' . $randomCoach->name . ' de la part de l\'étudiant ' . $student->name,
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