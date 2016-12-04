<?php

use Janitor\Repositories\Posts;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_add_a_new_post()
    {
        $data = $this->make()->toArray();

        $post = new Posts;
        $post->create($data);

        $this->seeInDatabase('posts', $data);
    }

    /** @test **/
    public function post_slug_must_be_unique()
    {
        $this->create(['title' => 'New Post', 'slug' => 'new-post']);
        $data = $this->make(['title' => 'New Post', 'slug' => 'new-post'])->toArray();

        $post = new Posts;
        $post->create($data);

        $this->seeInDatabase('posts', array_merge($data, ['slug' => 'new-post-1']));
    }

    /** @test **/
    public function it_can_update_an_existing_post()
    {
        $data = $this->create();

        $post = new Posts;
        $post->update($data->id, array_merge($data->toArray(), ['title' => 'Updated Post', 'slug' => 'updated-post']));

        $this->seeInDatabase('posts', array_merge($data->toArray(), ['title' => 'Updated Post', 'slug' => 'updated-post']));
    }

    /** @test **/
    public function post_slug_must_be_unique_even_on_update()
    {
        $this->create(['title' => 'New Post', 'slug' => 'new-post']);
        $data = $this->create();

        $post = new Posts;
        $post->update($data->id, array_merge($data->toArray(), ['title' => 'New Post', 'slug' => 'new-post']));

        $this->seeInDatabase('posts', array_merge($data->toArray(), ['title' => 'New Post', 'slug' => 'new-post-1']));
    }

    /** @test **/
    public function it_can_delete_a_post()
    {
        $data = $this->create();

        $post = new Posts;
        $post->delete($data->id);

        $this->notSeeInDatabase('posts', $data->toArray());
    }

    private function make($overrides = [])
    {
        return factory(Janitor\Models\Post::class)->make($overrides);
    }

    private function create($overrides = [])
    {
        return factory(Janitor\Models\Post::class)->create($overrides);
    }
}
