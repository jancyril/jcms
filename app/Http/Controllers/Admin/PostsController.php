<?php

namespace Janitor\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Janitor\Repositories\Posts;
use Janitor\Http\Requests\Admin\Post;
use Janitor\Http\Controllers\Controller;
use Janitor\Repositories\PostCategories;

class PostsController extends Controller
{
    /**
     * Property that will hold the instance of Illuminate\Http\Request.
     *
     * @var object
     */
    protected $request;

    /**
     * Property that will hold the instance of Janitor\Repositories\Posts.
     *
     * @var object
     */
    private $post;

    /**
     * Class constructor.
     *
     * @param Request $request
     * @param Posts   $post
     */
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

    public function edit(PostCategories $categories, int $id)
    {
        if (!$post = $this->post->findById($id)) {
            abort(404);
        }

        $data = [
            'pageTitle' => $post->title,
            'post' => $post,
            'categories' => $categories->get(),
        ];

        return $this->admin('posts.edit', $data);
    }

    public function update(Post $validation, int $id)
    {
        if (!$this->post->update($id, $this->request->all())) {
            return $this->error('Unable to save changes, please try again.');
        }

        return $this->success('Changes has been successfully saved.');
    }

    public function destroy(int $id)
    {
        if (!$this->post->delete($id)) {
            return $this->error('Unable to delete post, please try again.');
        }

        return $this->success('Post has been successfully deleted.');
    }
}
