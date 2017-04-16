@include('admin.partials.navigation')

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jan Cyril Segubience">

    <title>{{ $pageTitle }}</title>

    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('customcss')
  </head>

  <body>
    <div id="wrapper">
      @yield('navigation')

      <div id="page-wrapper">
        <div id="jcms">
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">{{ $pageTitle }}</h1>
            </div>
            @yield('content')
          </div>
        </div>
      </div>
    </div>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @include('admin.js')
  @yield('customjs')
  </body>
</html>
