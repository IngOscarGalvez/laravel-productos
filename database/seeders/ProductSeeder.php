<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de tener al menos una categoría
        if (Category::count() === 0) {
            \App\Models\Category::factory()->count(5)->create();
        }

        // Crear productos asociados a categorías existentes
        Product::factory()->count(20)->create();
    }
}
