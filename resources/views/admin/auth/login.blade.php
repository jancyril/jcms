<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jan Cyril Segubience">

  <title>{{ $pageTitle }}</title>
  
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>

<div id="jcms" class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Please Sign In</h3>
        </div>
        <div class="panel-body">
          <form role="form" v-on:submit.prevent="login">
            <fieldset>
              <div class="form-group">
                <input class="form-control" placeholder="Please enter your email" name="email" type="email" autofocus v-model="form.email">
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Please enter your password" name="password" type="password" v-model="form.password">
              </div>
              <div class="checkbox">
                <label>
                  <input name="remember" type="checkbox" value="Remember Me">Remember Me
                </label>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <button class="btn btn-success btn-block" :disabled="submitting">
                <i class="fa fa-pulse fa-spinner" v-show="submitting"></i> Login
              </button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('js/login.js') }}"></script>
<script>
Vue.http.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";

new Vue({
  el: '#jcms',

  data: {
    form: {
      email: '',
      password: ''
    },
    result: false,
    submitting: false,
  },

  methods: {
    login() {
      NProgress.start();
      this.submitting = true;

      this.$http.post("{{ route('admin::post-login') }}", JSON.stringify(this.form)).then((response) => {
        notify(response.data);
        if (response.data.result) {
          window.location.href = "{{ route('admin::dashboard') }}";
        }
        this.submitting = false;
      }, (error) => {
        this.submitting = false;
        vueError(error);
      });

      NProgress.done();
    }
  }
});
</script>
@include('admin.js')
</body>
</html>
