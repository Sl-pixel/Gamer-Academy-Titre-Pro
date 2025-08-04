<?php

namespace Database\Seeders;

use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevenueTableSeeder extends Seeder
{
    public function run()
    {
        // Supprimer les données existantes dans la table revenues
        DB::table('revenues')->delete();

        // Récupérer tous les utilisateurs qui sont des coachs
        $coaches = DB::table('users')->where('role', 'coach')->get();

        // Pour chaque coach, créer des revenus réalistes
        foreach ($coaches as $coach) {
            // Revenus pour l'année (sessions passées)
            $this->createYearlyRevenues($coach->id);
            
            // Revenus pour le mois en cours
            $this->createMonthlyRevenues($coach->id);
            
            // Revenus pour aujourd'hui
            $this->createDailyRevenues($coach->id);
        }
    }

    private function createYearlyRevenues($coachId)
    {
        // Créer des revenus sur les 8 derniers mois (répartis de façon réaliste)
        for ($monthsAgo = 8; $monthsAgo >= 1; $monthsAgo--) {
            $date = Carbon::now()->subMonths($monthsAgo);
            $sessionsInMonth = rand(3, 12); // Entre 3 et 12 sessions par mois
            
            for ($i = 0; $i < $sessionsInMonth; $i++) {
                $sessionDate = $date->copy()->addDays(rand(1, 28));
                $sessionAmount = rand(15, 45); // Entre 15€ et 45€ par session
                
                Revenue::create([
                    'coach_id' => $coachId,
                    'amount' => $sessionAmount,
                    'date' => $sessionDate->toDateString(),
                    'created_at' => $sessionDate,
                    'updated_at' => $sessionDate
                ]);
            }
        }
    }

    private function createMonthlyRevenues($coachId)
    {
        // Créer des revenus pour le mois en cours (3-8 sessions)
        $startOfMonth = Carbon::now()->startOfMonth();
        $sessionsThisMonth = rand(3, 8);
        
        for ($i = 0; $i < $sessionsThisMonth; $i++) {
            $sessionDate = $startOfMonth->copy()->addDays(rand(1, Carbon::now()->day - 1));
            $sessionAmount = rand(20, 40); // Entre 20€ et 40€ par session
            
            Revenue::create([
                'coach_id' => $coachId,
                'amount' => $sessionAmount,
                'date' => $sessionDate->toDateString(),
                'created_at' => $sessionDate,
                'updated_at' => $sessionDate
            ]);
        }
    }

    private function createDailyRevenues($coachId)
    {
        // 50% de chance d'avoir des revenus aujourd'hui
        if (rand(1, 2) === 1) {
            $sessionsToday = rand(1, 3); // Entre 1 et 3 sessions aujourd'hui
            
            for ($i = 0; $i < $sessionsToday; $i++) {
                $sessionAmount = rand(25, 35); // Entre 25€ et 35€ par session
                
                Revenue::create([
                    'coach_id' => $coachId,
                    'amount' => $sessionAmount,
                    'date' => Carbon::now()->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
