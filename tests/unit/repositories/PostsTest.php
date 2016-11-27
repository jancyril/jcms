<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase
{
    use DatabaseTransactions;

    private function make()
    {
        return factory(Janitor\Models\Post::class)->make();
    }
}
