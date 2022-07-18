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

const assetsJs = "public/assets/js";
const assetsCss = "public/assets/css";
const resourcesJs = "resources/js";
const resourcesCss = "resources/css";
const resourcesModules = path.join(resourcesJs, "modules");

mix.js(path.join(resourcesJs, "app.js"), path.join(assetsJs, "app.js"));

mix.scripts(
    [
        path.join(resourcesModules, "ready.js"),
        path.join(resourcesModules, "capitalize.js"),
        path.join(resourcesModules, "getCookie.js"),
        path.join(resourcesModules, "csrf.js"),
    ],
    path.join(assetsJs, "bundle.js")
);

mix.postCss(path.join(resourcesCss, "app.css"), assetsCss, [
    require("tailwindcss"),
]);

mix.css(
    path.join(resourcesCss, "punch.css"),
    path.join(assetsCss, "punch.css")
);

mix.js(
    path.join(resourcesJs, "Pages", "Dashboard", "index.js"),
    path.join(assetsJs, "pages", "dashboard.index.js")
);
mix.js(
    path.join(resourcesJs, "Pages", "Roms", "index.js"),
    path.join(assetsJs, "pages", "roms.index.js")
);

mix.options({ legacyNodePolyfills: false });

if (mix.inProduction()) {
    mix.version();
}
