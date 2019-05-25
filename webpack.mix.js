const mix = require('laravel-mix');
const webpack = require('webpack');
const tailwindcss = require('tailwindcss');

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
         },
         processCssUrls: false,
     })
     .webpackConfig({
         plugins: [
             new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
         ],
     });

mix
     .setPublicPath('public')
     .js('resources/js/app.js', 'public')
     .sass('resources/sass/app.scss', 'public', {}, [tailwindcss('./tailwind.config.js')])
     .version()
     .copy('public', '../reliquitest/public/vendor/ambulatory');