const mix = require('laravel-mix');

// mix.webpackConfig({
//     experiments: {
//         topLevelAwait: true
//     }
// });
require('laravel-mix-workbox');
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


// const crypto = require('crypto');


mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/color_mode.js', 'public/js')
    // .js('resources/js/bootstrap.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/print.scss', 'public/css')
    .css('resources/css/sidebar.css', 'public/css')
    .css('resources/css/swatch.css', 'public/css')
    .sourceMaps()
    .injectManifest({
        swSrc: './resources/js/sw.js',
    });
