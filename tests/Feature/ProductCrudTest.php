<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use Illuminate\Http\UploadedFile;


class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_product(): void
    {
        Storage::fake('public');

        $category = Category::create(['name' => 'Test Category']);

        Livewire::test(CreateProduct::class)
            ->fillForm([
                'name' => 'Test Product',
                'price' => 99.99,
                'stock' => 10,
                'category_id' => $category->id,
                'image' => UploadedFile::fake()->image('product.jpg'),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }
    public function test_it_requires_fields_to_create_a_product(): void
    {
        Livewire::test(CreateProduct::class)
            ->fillForm([])
            ->call('create')
            ->assertHasFormErrors(['name', 'price', 'stock', 'category_id']);
    }

    public function test_it_can_update_a_product(): void
    {
        $category = Category::create(['name' => 'Test Category']);
        $product = Product::create([
            'name' => 'Old Product',
            'price' => 10,
            'stock' => 5,
            'category_id' => $category->id,
        ]);

        Livewire::test(EditProduct::class, ['record' => $product->getKey()])
            ->fillForm([
                'name' => 'Updated Product',
                'price' => 99.99,
                'stock' => 15,
                'category_id' => $category->id,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    public function test_it_can_list_products(): void
    {
        $category = Category::create(['name' => 'Test Category']);
        Product::create([
            'name' => 'Visible Product',
            'price' => 10,
            'stock' => 3,
            'category_id' => $category->id,
        ]);

        Livewire::test(ListProducts::class)
            ->assertSee('Visible Product');
    }

    public function test_it_can_delete_a_product(): void
    {
        $category = Category::create(['name' => 'Test Category']);
        $product = Product::create([
            'name' => 'To Be Deleted',
            'price' => 50,
            'stock' => 2,
            'category_id' => $category->id,
        ]);

        $product->delete();

        $this->assertDatabaseMissing('products', ['name' => 'To Be Deleted']);
    }
}
