<?php

namespace Test\Feature\Admin;

use Janitor\Models;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_go_to_posts_index_page()
    {
        $this->get(route('admin::posts'))
            ->assertStatus(200);
    }

    /** @test **/
    public function it_can_go_to_create_new_post_page()
    {
        $this->get(route('admin::new-post'))
            ->assertStatus(200);
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_title_is_empty()
    {
        $data = $this->make(['title' => '']);

        $this->post(route('admin::post-new-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_content_is_empty()
    {
        $data = $this->make(['content' => '']);

        $this->post(route('admin::post-new-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_category_id_is_empty()
    {
        $data = $this->make(['category_id' => '']);

        $this->post(route('admin::post-new-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_category_id_is_not_an_integer()
    {
        $data = $this->make(['category_id' => 'a']);

        $this->post(route('admin::post-new-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_fail_if_status_is_empty()
    {
        $data = $this->make(['status' => '']);

        $this->post(route('admin::post-new-post'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function adding_a_new_post_will_succeed_if_all_data_are_valid()
    {
        $data = $this->make();

        $this->post(route('admin::post-new-post'), $data)
            ->assertSee('Success')
            ->assertStatus(200);
    }

    /** @test **/
    public function it_can_go_to_edit_post_page()
    {
        $data = $this->create();

        $this->get(route('admin::edit-post', $data->id))
            ->assertStatus(200)
            ->assertSee($data->title);
    }

    /** @test **/
    public function updating_a_post_will_fail_if_title_is_empty()
    {
        $data = $this->create();
        $data['title'] = '';

        $this->put(route('admin::put-post', $data->id), $data->toArray())
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function updating_a_post_will_fail_if_content_is_empty()
    {
        $data = $this->create();
        $data['content'] = '';

        $this->put(route('admin::put-post', $data->id), $data->toArray())
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function updating_a_post_will_fail_if_category_id_is_empty()
    {
        $data = $this->create();
        $data['category_id'] = '';

        $this->put(route('admin::put-post', $data->id), $data->toArray())
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function updating_a_post_will_fail_if_category_id_is_not_an_integer()
    {
        $data = $this->create();
        $data['category_id'] = 'Technology';

        $this->put(route('admin::put-post', $data->id), $data->toArray())
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function updating_a_post_will_fail_if_status_is_empty()
    {
        $data = $this->create();
        $data['status'] = '';

        $this->put(route('admin::put-post', $data->id), $data->toArray())
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function updating_a_post_will_succeed_if_all_data_are_valid()
    {
        $data = $this->create();
        $data['title'] = 'Edited Post';

        $this->put(route('admin::put-post', $data->id), $data->toArray())
            ->assertSee('Success')
            ->assertStatus(200);
    }

    /** @test **/
    public function it_can_delete_a_post()
    {
        $data = $this->create();

        $this->delete(route('admin::delete-post', $data->id))
            ->assertSee('Success')
            ->assertStatus(200);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->admin();
    }

    private function make(array $overrides = [])
    {
        return factory(Models\Post::class)->make($overrides)->toArray();
    }

    private function create(array $overrides = [])
    {
        return factory(Models\Post::class)->create($overrides);
    }

    private function admin()
    {
        $user = factory(Models\User::class)->create();

        $this->actingAs($user);
    }
}
