<?php

namespace Test\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_go_to_posts_index_page()
    {
        $this->admin();

        $this->get(route('admin::posts'))
            ->assertStatus(200);
    }

    /** @test **/
    public function it_can_go_to_create_new_post_page()
    {
        $this->admin();

        $this->get(route('admin::new-post'))
            ->assertStatus(200);
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_title_is_empty()
    {
        $this->admin();

        $data = $this->make(['title' => '']);

        $this->post(route('admin::post-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_content_is_empty()
    {
        $this->admin();

        $data = $this->make(['content' => '']);

        $this->post(route('admin::post-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_category_id_is_empty()
    {
        $this->admin();

        $data = $this->make(['category_id' => '']);

        $this->post(route('admin::post-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_category_id_is_not_an_integer()
    {
        $this->admin();

        $data = $this->make(['category_id' => 'a']);

        $this->post(route('admin::post-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_succeed_if_all_data_are_valid()
    {
        $this->admin();

        $data = $this->make();

        $this->post(route('admin::post-post'), $data)
            ->assertSee('Success')
            ->assertStatus(200);
    }

    private function make(array $overrides = [])
    {
        return factory(\Janitor\Models\Post::class)->make($overrides)->toArray();
    }

    private function admin()
    {
        $user = factory(\Janitor\Models\User::class)->create();

        $this->actingAs($user);
    }
}
