<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productNames = [
            'MacBook Pro 14" M3',
            'iPhone 15 Pro Max',
            'Samsung Galaxy S24 Ultra',
            'Sony WH-1000XM5',
            'iPad Air 5',
            'Apple Watch Series 9',
            'Dell XPS 13',
            'PlayStation 5',
            'Xbox Series X',
            'Nintendo Switch OLED',
            'AirPods Pro 2',
            'Samsung QLED 4K TV'
        ];

        $brands = ['Apple', 'Samsung', 'Sony', 'Microsoft', 'Dell', 'HP', 'Lenovo', 'Asus', 'LG'];

        $name = $this->faker->randomElement($productNames);
        $price = $this->faker->randomFloat(2, 99, 2999);
        $hasDiscount = $this->faker->boolean(25);

        return [
            'name' => $name,
            'price' => $price,
            'old_price' => $hasDiscount ? $price * (1 + $this->faker->randomFloat(2, 0.1, 0.4)) : null,
            'discount_percentage' => $hasDiscount ? $this->faker->numberBetween(10, 40) : null,
            'description' => $this->faker->paragraphs($this->faker->numberBetween(2, 5), true),
            'short_description' => $this->faker->sentence(8),
            'rating' => $this->faker->randomFloat(1, 3.5, 5.0),
            'review_count' => $this->faker->numberBetween(5, 1000),
            'image' => $this->faker->imageUrl(600, 600, 'electronics', true, $name),
            'slug' => Str::slug($name),
            'sku' => strtoupper(Str::substr($name, 0, 3) . '-' . $this->faker->unique()->numerify('####')),
            'weight' => $this->faker->randomFloat(2, 0.2, 15),
            'dimensions' => $this->faker->numberBetween(10, 50) . 'x' .
                $this->faker->numberBetween(5, 30) . 'x' .
                $this->faker->numberBetween(1, 15) . ' cm',
            'brand' => $this->faker->randomElement($brands),
            'stock_quantity' => $this->faker->numberBetween(0, 150),
            'in_stock' => $this->faker->boolean(85),
            'is_featured' => $this->faker->boolean(15),
            'is_active' => $this->faker->boolean(95),
            'meta_title' => $name . ' - Achat en ligne',
            'meta_description' => 'Découvrez le ' . $name . '. ' . $this->faker->sentence(8),
            'category_id' => null,
        ];
    }

    public function featured()
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
