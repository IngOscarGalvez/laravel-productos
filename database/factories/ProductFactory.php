<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->words(2, true),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'category_id' => Category::factory(),
            'description' => $this->faker->paragraph,
            'stock' => $this->faker->numberBetween(0, 100),
            'image_path' => null, // O usa UploadedFile en tests
        ];
    }
}
