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
    // Admin Login Assets
    mix.styles([
        'bootstrap/dist/css/bootstrap.css',
        'fontawesome/css/font-awesome.css',
        'AdminLTE/dist/css/AdminLTE.css',
        'AdminLTE/plugins/iCheck/square/blue.css',
        'pnotify/dist/pnotify.css'
    ], 'public/css/login.css', 'bower_components/');

    mix.scripts([
        'jquery/dist/jquery.js',
        'AdminLTE/plugins/iCheck/icheck.min.js',
        'pnotify/dist/pnotify.js',
        'vue/dist/vue.js',
        'vue-resource/dist/vue-resource.js'
    ], 'public/js/login.js', 'bower_components/');

    // Copy fonts
    mix.copy([
        'bower_components/fontawesome/fonts',
        'bower_components/bootstrap/fonts',
    ], 'public/fonts');

    mix.copy([
        'bower_components/AdminLTE/plugins/iCheck/square/blue.png',
        'bower_components/AdminLTE/plugins/iCheck/square/blue@2x.png',
    ], 'public/css');

    /**
     * Add versioning for all asset files
     */
    mix.version([
        'public/css/login.css',
        'public/js/login.js'
    ]);
});
