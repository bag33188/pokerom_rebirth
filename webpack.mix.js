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

const resourcesCss = "resources/css";
const resourcesJs = "resources/js";
const resourcesModules = `${resourcesJs}/modules/`;
const assetsJs = "public/assets/js";
const assetsCss = "public/assets/css";
const assetsModules = `${assetsJs}/modules`;

mix.js("resources/js/app.js", assetsJs)
    .postCss(`${resourcesCss}/app.css`, assetsCss, [require("tailwindcss")])
    .css(`${resourcesCss}/punch.css`, assetsCss)
    .js(`${resourcesModules}ready.js`, assetsModules)
    .js(`${resourcesModules}/capitalize.js`, assetsModules)
    .js(`${resourcesModules}/getCookie.js`, assetsModules)
    .js(`${resourcesModules}/csrf.js`, assetsModules)
    .js(
        `${resourcesJs}/Pages/Dashboard/index.js`,
        `${assetsJs}/dashboard.index.js`
    )
    .js(`${resourcesJs}/Pages/Roms/index.js`, `${assetsJs}/roms.index.js`);

if (mix.inProduction()) {
    mix.version();
}
