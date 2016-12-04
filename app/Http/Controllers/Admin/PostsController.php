<?php

namespace Janitor\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Janitor\Repositories\Posts;
use Janitor\Http\Requests\Admin\Post;
use Janitor\Repositories\PostCategories;
use Janitor\Http\Controllers\Controller;

class PostsController extends Controller
{
    protected $request;

    private $post;

    public function __construct(Request $request, Posts $post)
    {
        $this->request = $request;
        $this->post = $post;
    }

    public function index()
    {
        return $this->admin('posts.index', ['pageTitle' => 'Posts']);
    }

    public function get()
    {
        return $this->post->dataTables($this->request->all());
    }

    public function create(PostCategories $category)
    {
        $data = [
            'pageTitle' => 'New Post',
            'categories' => $category->get(),
        ];

        return $this->admin('posts.create', $data);
    }

    public function store(Post $validation)
    {
        if (!$this->post->create($this->request->all())) {
            return $this->error('Unable to save new post, please try again.');
        }

        return $this->success('New post has been successfully created.');
    }
}
