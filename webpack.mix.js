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
    .js('resources/js/register.js','public/js')
    .js('resources/js/systemAdmin.js','public/js')
    .js('resources/js/company.js','public/js')
    .js('resources/js/home.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/register.scss','public/css')
    .sass('resources/sass/style.scss','public/css')
    .sass('resources/sass/login.scss','public/css')
    .sass('resources/sass/systemAdmin.scss','public/css')
    .sass('resources/sass/companyAdmin.scss','public/css')
    .sass('resources/sass/home.scss','public/css');