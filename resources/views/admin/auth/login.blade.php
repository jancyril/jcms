<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $pageTitle }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Login Assets -->
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div id="app" class="login-box">
  <div class="login-logo">
    <strong>Administrator Login</strong>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"></p>

    <form method="post" v-on:submit.prevent="login">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" v-model="form.email" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" v-model="form.password" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" :disabled="submitting">
            <i class="fa fa-spinner fa-pulse" v-show="submitting"></i> Sign In
          </button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- Login JS -->
<script src="{{ asset('js/login.js') }}"></script>
<script>
Vue.http.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";

new Vue({
  el: '#app',

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
        this.submitting = false;
      }, (error) => {
        this.submitting = false;
        vueError(error);
      });

      NProgress.done();
    }
  }
});

$('input').iCheck({
  checkboxClass: 'icheckbox_square-blue',
  radioClass: 'iradio_square-blue',
  increaseArea: '20%'
});
</script>
@include('admin.js')
</body>
</html>
