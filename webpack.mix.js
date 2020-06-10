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

mix.js('resources/assets/admin/js/app.js', 'public/admin/js')
    .sass('resources/assets/admin/sass/app.scss', 'public/admin/css')
    .copyDirectory('resources/assets/admin/dist/img', 'public/dist/img')
    .styles([
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/font-awesome/css/font-awesome.min.css',
        'node_modules/Ionicons/css/ionicons.min.css',
        'resources/assets/admin/dist/css/AdminLTE.min.css',
        'resources/assets/admin/dist/css/skins/_all-skins.min.css',
    ], 'public/admin/lte/css/library.min.css')

    .scripts([
        'node_modules/jquery-ui/jquery-ui.min.js',
        'resources/assets/admin/dist/js/adminlte.min.js',
    ], 'public/admin/lte/js/library.min.js');
