@extends('admin.master')
@include('admin.javascript.vue_headers')
@include('admin.posts.javascript.categories')

@section('customcss')
  <link rel="stylesheet" href="{{ asset('bower/datatables.net-bs/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="row" style="margin-bottom: 20px;">
  <div class="col-xs-2 pull-right">
    <button type="button" class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#newCategory">
      <i class="fa fa-plus-circle"></i> New Category
    </button>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table id="post-categories" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="newCategory" tabindex="-1" role="dialog" aria-labelledby="newModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newModal">New Category</h4>
      </div>
      <form v-on:submit.prevent="add">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter a category name" v-model="form.name" />
          </div>
          <div class="form-group">
            <label class="control-label">Description</label>
            <textarea name="description" rows="3" class="form-control" placeholder="Enter a category description" v-model="form.description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" :disabled="submitting" @click="add">
            <i class="fa fa-spinner fa-pulse" v-show="submitting"></i> Save New Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="updateModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="updateModal">Update Category</h4>
      </div>
      <form v-on:submit.prevent="update">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter a category name" v-model="form.name" />
          </div>
          <div class="form-group">
            <label class="control-label">Description</label>
            <textarea name="description" rows="3" class="form-control" placeholder="Enter a category description" v-model="form.description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" :disabled="submitting" @click="update">
            <i class="fa fa-spinner fa-pulse" v-show="submitting"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('customjs')
  <script src="{{ asset('bower/datatables.net/js/jquery.dataTables.js') }}" charset="utf-8"></script>
  <script src="{{ asset('bower/datatables.net-bs/js/dataTables.bootstrap.js') }}" charset="utf-8"></script>
  @yield('vue_headers')
  @yield('categories_js')
@endsection
