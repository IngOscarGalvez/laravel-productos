<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_name()
    {
        $category = Category::factory()->create(['name' => 'Ropa']);
        $this->assertEquals('Ropa', $category->name);
    }

    /** @test */
    public function it_can_be_created()
    {
        $category = Category::create(['name' => 'Electrónica']);
        $this->assertDatabaseHas('categories', ['name' => 'Electrónica']);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $category = Category::factory()->create(['name' => 'Antiguo']);
        $category->update(['name' => 'Nuevo']);
        $this->assertEquals('Nuevo', $category->fresh()->name);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $category = Category::factory()->create();
        $category->delete();
        $this->assertModelMissing($category);
    }

    /** @test */
    public function it_fails_to_create_without_name()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Category::create([]);
    }

    /** @test */
    public function it_can_be_found_by_id()
    {
        $category = Category::factory()->create();
        $found = Category::find($category->id);
        $this->assertNotNull($found);
        $this->assertEquals($category->id, $found->id);
    }
}
