<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mainCategories = [
            'Électronique',
            'Informatique',
            'Mobile',
            'Maison Connectée',
            'Gaming',
            'Photo & Vidéo',
            'Audio',
            'Accessoires'
        ];

        $subCategories = [
            'Électronique' => ['Téléviseurs', 'Home Cinéma', 'Appareils Photo', 'Caméscopes'],
            'Informatique' => ['Ordinateurs Portables', 'Ordinateurs Bureau', 'Composants PC', 'Périphériques'],
            'Mobile' => ['Smartphones', 'Tablettes', 'Montres Connectées', 'Accessoires Mobile'],
            'Gaming' => ['Consoles', 'Jeux Vidéo', 'Manettes', 'Casques Gaming'],
            'Audio' => ['Écouteurs', 'Casques', 'Enceintes', 'Amplificateurs'],
        ];

        $mainCategory = $this->faker->randomElement(array_keys($subCategories));
        $name = $this->faker->randomElement($subCategories[$mainCategory]);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'description' => $this->faker->paragraphs(2, true),
            'image' => $this->faker->imageUrl(500, 300, 'technology', true, $name),
            'order' => $this->faker->numberBetween(0, 50),
            'is_active' => $this->faker->boolean(95),
        ];
    }

    /**
     * Indicate that the category is featured (high order).
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'order' => $this->faker->numberBetween(1, 5),
        ]);
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate a specific category name.
     */
    public function withName(string $name): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }
}
