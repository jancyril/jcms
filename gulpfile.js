const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    // Admin Dashboard Assets
    mix.styles([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'bower_components/fontawesome/css/font-awesome.css',
        'bower_components/pnotify/dist/pnotify.css',
        'bower_components/metisMenu/dist/metisMenu.css',
        'bower_components/animate.css/animate.css',
        'bower_components/nprogress/nprogress.css',
        'bower_components/sweetalert/dist/sweetalert.css',
        'css/sb-admin-2.css'
    ], 'public/css/dashboard.css', 'resources/assets/');

    mix.scripts([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/pnotify/dist/pnotify.js',
        'bower_components/pnotify/dist/pnotify.animate.js',
        'bower_components/nprogress/nprogress.js',
        'bower_components/vue/dist/vue.js',
        'bower_components/vue-resource/dist/vue-resource.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        'bower_components/sweetalert/dist/sweetalert.min.js',
        'bower_components/metisMenu/dist/metisMenu.js',
        'bower_components/animate.css/animate.js',
        'js/sb-admin-2.js'
    ], 'public/js/dashboard.js', 'resources/assets/');

    // Admin Login Assets
    mix.styles([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'bower_components/fontawesome/css/font-awesome.css',
        'bower_components/pnotify/dist/pnotify.css',
        'bower_components/nprogress/nprogress.css',
        'bower_components/animate.css/animate.css',
        'css/sb-admin-2.css'
    ], 'public/css/login.css', 'resources/assets/');

    mix.scripts([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/pnotify/dist/pnotify.js',
        'bower_components/pnotify/dist/pnotify.animate.js',
        'bower_components/nprogress/nprogress.js',
        'bower_components/vue/dist/vue.js',
        'bower_components/vue-resource/dist/vue-resource.js'
    ], 'public/js/login.js', 'resources/assets/');

    // Copy fonts
    mix.copy([
        'resources/assets/bower_components/fontawesome/fonts',
        'resources/assets/bower_components/bootstrap/fonts',
        'resources/assets/bower_components/Ionicons/fonts',
    ], 'public/fonts');

    mix.copy([
        'resources/assets/bower_components/summernote/dist/font'
    ], 'public/css/font');

    /**
     * Add versioning for all asset files
     */
    mix.version([
        'public/css/login.css',
        'public/js/login.js',
        'public/css/dashboard.css',
        'public/js/dashboard.js'
    ]);
});
