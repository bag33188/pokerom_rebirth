const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [require("tailwindcss")])
    .css("resources/css/punch.css", "public/css")
    .js("resources/js/modules/capitalize.js", "public/js/modules")
    .js("resources/js/modules/ready.js", "public/js/modules")
    .js("resources/js/Pages/Dashboard/index.js", "public/js/dashboard.js")
    .js("resources/js/Pages/Roms/index.js", "public/js/roms.js");

if (mix.inProduction()) {
    mix.version();
}
