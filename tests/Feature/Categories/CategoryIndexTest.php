<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    public function test_it_returns_a_collection_of_categories(): void
    {
        $categories = Category::factory()->count(2)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function ($category) use ($response) {
            $response->assertJsonFragment([
                'slug' => $category->slug
            ]);
        });
    }

    public function test_it_returns_only_parent_categories(): void
    {
        $category = Category::factory()->create();

        $category->children()->save(
            Category::factory()->create()
        );

        $this->json('GET', 'api/categories')->assertJsonCount(1, 'data');
    }

    public function test_it_returns_categories_ordered_by_their_given_order(): void
    {
        $category = Category::factory()->create([
            'order' => 2
        ]);

        $anotherCategory = Category::factory()->create([
            'order' => 1
        ]);

        $this->json('GET', 'api/categories')->assertSeeInOrder([
            $anotherCategory->slug,
            $category->slug,
        ]);
    }
}
