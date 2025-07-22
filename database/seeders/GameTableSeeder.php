<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            [
                'name' => 'Valorant',
                'slug' => Str::slug('Valorant'),
                'description' => 'Un jeu de tir à la première personne multijoueur développé par Riot Games.',
                'image' => 'images/' . 'valo.jpg',
                'genre' => 'Tir tactique',
                'plateforme' => 'PC',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tekken',
                'slug' => Str::slug('Tekken'),
                'description' => 'Une série de jeux de combat développée par Bandai Namco Entertainment.',
                'image' => 'images/' .  'tekken.jpg',
                'genre' => 'Combat',
                'plateforme' => 'Multiplateforme',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Counter-Strike 2',
                'slug' => Str::slug('Counter-Strike 2'),
                'description' => 'La suite du célèbre jeu de tir à la première personne multijoueur, CS:GO.',
                'image' => 'images/' . 'cs2.jpg',
                'genre' => 'Tir tactique',
                'plateforme' => 'PC',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mario Kart',
                'slug' => Str::slug('Mario Kart'),
                'description' => 'Une série de jeux de course développée par Nintendo avec des personnages de l\'univers Mario.',
                'image' => 'images/' . 'marioKart.webp',
                'genre' => 'Course',
                'plateforme' => 'Nintendo Switch',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
