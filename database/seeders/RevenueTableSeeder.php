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

        // Obtenir la date de début et de fin pour l'année en cours
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

        // Pour chaque coach, créer des entrées de revenus pour chaque jour de l'année
        foreach ($coaches as $coach) {
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                Revenue::create([
                    'user_id' => $coach->id,
                    'amount' => rand(50, 500), // Montant aléatoire entre 50 et 500
                    'date' => $currentDate->toDateString(), // Date pour chaque jour de l'année
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $currentDate->addDay(); // Passer au jour suivant
            }
        }
    }
}
