const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/backend.js', 'public/js')
    .js('resources/js/vue.js', 'public/js')
    .js('resources/js/home.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/auth.scss', 'public/css')
    .sass('resources/sass/backend.scss', 'public/css')
    .sass('resources/sass/dark-backend.scss', 'public/css');
