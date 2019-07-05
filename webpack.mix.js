const mix = require('laravel-mix');
const webpack = require('webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

 mix
     .options({
         uglify: {
             uglifyOptions: {
                 compress: {
                     drop_console: true,
                 }
             }
         }
     })
     .webpackConfig({
         plugins: [
             new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
         ],
     });

mix
     .setPublicPath('public')
     .js('resources/js/app.js', 'public')
     .sass('resources/sass/app.scss', 'public')
     .version()
     .copy('public', '../ambulatorytest/public/vendor/ambulatory');