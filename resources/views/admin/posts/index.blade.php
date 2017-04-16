@extends('admin.master')
@include('admin.javascript.vue_headers')
@include('admin.posts.javascript.index')

@section('customcss')
  <link rel="stylesheet" href="{{ asset('bower/datatables.net-bs/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="row" style="margin-bottom: 20px;">
  <div class="col-xs-2 pull-right">
    <a href="{{ route('admin::new-post') }}" class="btn btn-block btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> New Post
    </a>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table id="posts" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Title</th>
          <th>Date Created</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>
@endsection

@section('customjs')
  <script src="{{ asset('bower/datatables.net/js/jquery.dataTables.js') }}" charset="utf-8"></script>
  <script src="{{ asset('bower/datatables.net-bs/js/dataTables.bootstrap.js') }}" charset="utf-8"></script>
  @yield('vue_headers')
  @yield('index_js')
@endsection
