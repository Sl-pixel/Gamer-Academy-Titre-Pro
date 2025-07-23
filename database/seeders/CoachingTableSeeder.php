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

        // Create a random number of coaching sessions for each student
        foreach ($userIds as $userId) {
            $numberOfSessions = rand(1, 5); // Random number of sessions between 1 and 5 for each student

            for ($i = 0; $i < $numberOfSessions; $i++) {
                $status = $statuses[array_rand($statuses)];

                do {
                    $coachId = $coachIds[array_rand($coachIds)];
                } while ($status !== 'pending' && $userId == $coachId);

                $demandeId = $demandeIds[array_rand($demandeIds)];

                DB::table('coachings')->insert([
                    'user_id' => $userId,
                    'coach_id' => $coachId,
                    'demande_id' => $demandeId,
                    'duree' => rand(30, 120), // Random duration between 30 and 120 minutes
                    'commentaires' => 'Lors de cette session, nous nous sommes concentrés sur l\'amélioration des stratégies défensives et de la communication au sein de l\'équipe. Le joueur a fait preuve d\'un grand enthousiasme et d\'une réelle volonté d\'apprendre. Nous continuerons à travailler sur ces aspects lors de la prochaine session afin d\'améliorer davantage les performances sur le terrain.',
                    'status' => $status,
                    'date_coaching' => now()->addDays(rand(1, 30)), // <-- Ajout ici
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
