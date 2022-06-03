const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.setPublicPath('public');
mix.setResourceRoot('../');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/components/rewards.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/sass')
    .options({
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .version()
    .disableSuccessNotifications();
