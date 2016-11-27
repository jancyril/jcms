<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminPostCategoriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_go_to_post_categories_index_page()
    {
        $this->admin();

        $this->visit(route('admin::post-categories'))
            ->seePageIs(route('admin::post-categories'))
            ->see('Post Categories');
    }

    /** @test **/
    public function adding_a_new_post_category_will_fail_if_name_is_empty()
    {
        $this->admin();

        $this->post(route('admin::post-post-category'), ['name' => ''])
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_category_will_fail_if_name_is_already_taken()
    {
        $this->create(['name' => 'Sample Category']);

        $this->admin();

        $this->post(route('admin::post-post-category'), $this->make(['name' => 'Sample Category'])->toArray())
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_category_will_succeed_if_all_data_are_valid()
    {
        $this->admin();

        $this->post(route('admin::post-post-category'), $this->make()->toArray())
            ->see('Success')
            ->assertResponseOk();
    }

    /** @test **/
    public function updating_a_post_category_will_fail_if_name_is_empty()
    {
        $category = $this->create();

        $this->admin();

        $this->put(route('admin::put-post-category', ['id' => $category->id]), ['name' => ''])
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function updating_a_post_category_will_fail_if_name_is_already_taken()
    {
        $this->create(['name' => 'Sample Category']);

        $category = $this->create();

        $this->admin();

        $this->put(route('admin::put-post-category', ['id' => $category->id]), ['name' => 'Sample Category'])
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function updating_a_post_category_will_succeed_if_all_data_are_valid()
    {
        $category = $this->create();

        $this->admin();

        $this->put(route('admin::put-post-category', ['id' => $category->id]), $category->toArray())
            ->see('Success')
            ->assertResponseOk();
    }

    /** @test **/
    public function it_can_delete_a_post_category()
    {
        $category = $this->create();

        $this->admin();

        $this->delete(route('admin::delete-post-category', ['id' => $category->id]))
            ->see('Success')
            ->assertResponseOk();
    }

    private function make(array $overrides = [])
    {
        return factory(Janitor\Models\PostCategory::class)->make($overrides);
    }

    private function create(array $overrides = [])
    {
        return factory(Janitor\Models\PostCategory::class)->create($overrides);
    }

    private function admin()
    {
        $user = factory(Janitor\Models\User::class)->create();

        $this->actingAs($user);
    }
}
