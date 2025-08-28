<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer d'abord les catégories
        $categories = Category::factory()->count(20)->create();

        // Créer des produits avec des catégories aléatoires
        Product::factory()
            ->count(200)
            ->create([
                'category_id' => function () use ($categories) {
                    return rand(0, 100) > 10 
                        ? $categories->random()->id
                        : null;
                }
            ]);

        // créer quelques produits sans catégorie
        Product::factory()
            ->count(5)
            ->create(['category_id' => null]);

        // créer des produits featured
        Product::factory()
            ->count(3)
            ->featured()
            ->create([
                'category_id' => $categories->random()->id
            ]);
    }
}
