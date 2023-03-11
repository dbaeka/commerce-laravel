const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [//
    ])
    .combine('resources/plugins/css/*.scss', 'public/css/plugins.css')
    .webpackConfig({
        devtool: "cheap-module-source-map", resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js')
            }
        }, output: {
            chunkFilename: 'js/chunks/[name].js?id=[chunkhash]'
        }
    });


if (mix.inProduction()) {
    mix.version();
}
