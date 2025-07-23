<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            GameTableSeeder::class,
            UserTableSeeder::class,
            DemandeTableSeeder::class,
            CoachingTableSeeder::class,
            RevenueTableSeeder::class,
        ]);
    }
}