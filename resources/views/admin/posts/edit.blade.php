@extends('admin.master')
@include('admin.javascript.vue_headers')
@include('admin.javascript.summernote')
@include('admin.posts.javascript.edit')

@section('customcss')
  <link rel="stylesheet" href="{{ asset('bower/summernote/dist/summernote.css') }}">
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div id="alert" class="alert" v-bind:class="result ? 'alert-success' : 'alert-danger'" role="alert" v-show="alert" transition="fade" @click="hideAlert">
      <i class="fa" v-bind:class="result ? 'fa-check-circle' : 'fa-meh-o'"></i>
      <strong>@{{ result ? 'Well done!' : 'Oh no!' }}</strong> @{{ message }}
    </div>
  </div>
</div>
<div class="row">
  <form id="save-post" v-on:submit.prevent="save">
    <div class="col-xs-8">
      <div class="form-group">
        <label for="title" class="control-label">Title</label>
        <input type="text" id="title" name="title" v-model="form.title" class="form-control" placeholder="Please enter a title" />
      </div>
      <div class="form-group">
        <label for="content" class="control-label">Content</label>
        <textarea id="texteditor" name="content" rows="10" class="form-control">{!!$post->content !!}</textarea>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="form-group">
        <label for="slug" class="control-label">Slug</label>
        <input type="text" id="slug" name="slug" class="form-control" placeholder="Custom slug" v-model="form.slug" />
      </div>
      <div class="form-group">
        <label for="excerpt" class="control-label">Excerpt</label>
        <textarea id="excerpt" name="excerpt" rows="3" class="form-control" v-model="form.excerpt" placeholder="Enter your excerpt here"></textarea>
      </div>
      <div class="form-group">
        <label for="category_id">Category</label>
        <select id="category_id" class="form-control" name="category_id" v-model="form.category_id">
          @if($categories)
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="form-group">
        <label for="status">Status</label>
        <select id="status" class="form-control" name="status" v-model="form.status">
          <option value="published">Published</option>
          <option value="unpublished">Unpublished</option>
        </select>
      </div>
      <div class="form-group">
        <label for="image" class="status">Featured Image</label>
        <div class="col-xs-12 text-center" style="margin-bottom: 5px" v-show="form.image">
          <img v-bind:src="photo" height="150" style="margin-bottom: 5px"/><br/><br/>
          <button id="remove" class="btn btn-sm btn-danger" @click.prevent="deletePhoto">Delete Photo</button>
        </div>
        <input type="file" class="filestyle" data-buttonText="Browse" data-iconName="fa fa-image" @change="imageUpload">
        <input type="hidden" name="image" v-model="form.image">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-large" :disabled="submitting">
          <i class="fa fa-spinner fa-pulse" v-show="submitting"></i> @{{ submit }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('customjs')
  <script src="{{ asset('bower/summernote/dist/summernote.js') }}" charset="utf-8"></script>
  <script src="{{ asset('bower/bootstrap-filestyle/src/bootstrap-filestyle.js') }}" charset="utf-8"></script>
  @yield('vue_headers')
  @yield('summernote')
  @yield('edit_js')
@endsection
