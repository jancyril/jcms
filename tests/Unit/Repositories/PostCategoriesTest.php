<?php

namespace Test\Unit\Repositories;

use Tests\TestCase;
use Janitor\Repositories\PostCategories;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostCategoriesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_add_a_new_post_category()
    {
        $data = $this->data()->toArray();

        $category = new PostCategories();
        $category->create($data);

        $this->assertDatabaseHas('post_categories', $data);
    }

    /** @test **/
    public function it_can_update_a_post_category()
    {
        $data = $this->data()->toArray();

        $category = new PostCategories();
        $category->create($data);

        $category->update($category->id, ['name' => 'Sample Category']);

        $this->assertDatabaseHas('post_categories', array_merge($data, ['name' => 'Sample Category']));
    }

    /** @test **/
    public function it_can_delete_a_post_category()
    {
        $data = $this->data()->toArray();

        $category = new PostCategories();
        $category->create($data);

        $category->delete($category->id);

        $this->assertDatabaseMissing('post_categories', $data);
    }

    private function data(array $overrides = [])
    {
        return factory(\Janitor\Models\PostCategory::class)->make($overrides);
    }
}
