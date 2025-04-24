<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_category(): void
    {
        Livewire::test(CreateCategory::class)
            ->fillForm([
                'name' => 'Test Category',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }

    public function test_it_requires_name_to_create_category(): void
    {
        Livewire::test(CreateCategory::class)
            ->fillForm([])
            ->call('create')
            ->assertHasFormErrors(['name']);
    }

    public function test_it_can_read_a_category(): void
    {
        Category::create(['name' => 'Test Category']);

        Livewire::test(ListCategories::class)
            ->assertSee('Test Category');
    }

    public function test_it_can_update_a_category(): void
    {
        $category = Category::create(['name' => 'Old Name']);

        Livewire::test(EditCategory::class, ['record' => $category->getKey()])
            ->fillForm([
                'name' => 'Updated Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_it_can_delete_a_category(): void
    {
        $category = Category::create(['name' => 'To Be Deleted']);

        $category->delete();

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
