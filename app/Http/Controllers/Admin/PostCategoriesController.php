<?php

namespace Janitor\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Janitor\Http\Controllers\Controller;
use Janitor\Repositories\PostCategories;
use Janitor\Http\Requests\Admin\PostCategory;

class PostCategoriesController extends Controller
{
    /**
     * Property to store the instance of Illuminate\Http\Request.
     *
     * @var object
     */
    protected $request;

    /**
     * Property to stor the instance of Janitor\Repositories\PostCategories.
     *
     * @var object
     */
    private $category;

    public function __construct(Request $request, PostCategories $category)
    {
        $this->request = $request;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->admin('posts.categories', ['pageTitle' => 'Post Categories']);
    }

    /**
     * Return the data from datatables.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return $this->category->dataTables($this->request->all());
    }

    /**
     * Save the new created post category.
     *
     * @param object $validation Instance of Janitor\Http\Requests\Admin\PostCategory
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PostCategory $validation)
    {
        if (!$this->category->create($this->request->all())) {
            return $this->error('Unable to add new category, please try again.');
        }

        return $this->success('New category has been successfully created.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param object $validation Instance of Janitor\Http\Requests\Admin\PostCategory
     * @param int    $id         The id of the post category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PostCategory $validation, int $id)
    {
        if (!$this->category->update($id, $this->request->all())) {
            return $this->error('Unable to save changes, please try again.');
        }

        return $this->success('Changes has been successfully saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id The id of the post category
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (!$this->category->delete($id)) {
            return $this->error('Unable to delete post category, please try again.');
        }

        return $this->success('Post category has been successfully deleted.');
    }
}
