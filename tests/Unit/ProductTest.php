<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_category()
    {
        $product = Product::factory()->create();
        $this->assertInstanceOf(Category::class, $product->category);
    }

    /** @test */
    public function it_is_out_of_stock_when_stock_is_zero()
    {
        $product = Product::factory()->create(['stock' => 0]);
        $this->assertEquals(0, $product->stock);
    }

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $category = Category::factory()->create();
        $product = Product::create([
            'name' => 'Smartphone',
            'price' => 599.99,
            'stock' => 15,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Smartphone',
            'price' => 599.99,
            'stock' => 15,
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $product = Product::factory()->create(['name' => 'TV']);
        $product->update(['name' => 'Smart TV']);

        $this->assertEquals('Smart TV', $product->fresh()->name);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $product = Product::factory()->create();
        $product->delete();

        $this->assertModelMissing($product);
    }

    /** @test */
    public function it_requires_a_name_to_be_created()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'price' => 10,
            'stock' => 1,
            'category_id' => Category::factory()->create()->id,
        ]);
    }

    /** @test */
    public function it_requires_a_category_to_be_created()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'name' => 'Tablet',
            'price' => 200,
            'stock' => 3,
        ]);
    }
}
