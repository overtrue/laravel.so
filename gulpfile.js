var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
<<<<<<< HEAD
 | for your Laravel application. By default, we are compiling the Less
=======
 | for your Laravel application. By default, we are compiling the Sass
>>>>>>> ef958716c37fcdf0ea80bb89ba0c93394ae0b157
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
});
