@include('admin.partials.toplinks')

@section('navigation')
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('admin::dashboard') }}">JCMS</a>
  </div>
  <!-- /.navbar-header -->

  @yield('toplinks')

  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <li>
            <a href="{{ route('admin::dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
        </li>
        <li>
          <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Posts<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="{{ route('admin::post-categories') }}">Categories</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
@endsection