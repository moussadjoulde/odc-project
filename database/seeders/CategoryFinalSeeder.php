<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryFinalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Électronique',
                'slug' => Str::slug('Électronique'),
                'description' => 'Smartphones, tablettes, ordinateurs, montres et accessoires électroniques.',
                'image' => 'electronique.jpg',
                'order' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mode',
                'slug' => Str::slug('Mode'),
                'description' => 'Vêtements, chaussures, sacs et accessoires tendance pour hommes et femmes.',
                'image' => 'mode.jpg',
                'order' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maison & Décoration',
                'slug' => Str::slug('Maison & Décoration'),
                'description' => 'Mobilier, décoration, luminaires et accessoires pour la maison.',
                'image' => 'maison.jpg',
                'order' => 3,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports & Loisirs',
                'slug' => Str::slug('Sports & Loisirs'),
                'description' => 'Équipements sportifs, loisirs et fitness pour tous les âges.',
                'image' => 'sports.jpg',
                'order' => 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
