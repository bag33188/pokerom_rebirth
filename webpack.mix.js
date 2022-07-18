const mix = require("laravel-mix");
const path = require("path");

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
const resourcesModules = path.resolve(resourcesJs, "modules");
const assetsJs = "public/assets/js";
const assetsCss = "public/assets/css";

mix.js("resources/js/app.js", assetsJs)
    .scripts(
        [
            `${resourcesModules}/ready.js`,
            `${resourcesModules}/capitalize.js`,
            `${resourcesModules}/getCookie.js`,
            `${resourcesModules}/csrf.js`,
        ],
        path.join(assetsJs, "bundle.js")
    )
    .postCss(`${resourcesCss}/app.css`, assetsCss, [require("tailwindcss")])
    .css(`${resourcesCss}/punch.css`, assetsCss)
    .js(
        `${resourcesJs}/Pages/Dashboard/index.js`,
        `${assetsJs}/pages/dashboard.index.js`
    )
    .js(`${resourcesJs}/Pages/Roms/index.js`, `${assetsJs}/pages/roms.index.js`)
    .options({ legacyNodePolyfills: false });

if (mix.inProduction()) {
    mix.version();
}
