const mix = require('laravel-mix');

const paths = {
    src: '_examples/src',
    dist: '_examples/diy-widget/resources',
};

mix.js(paths.src+'/countdown.js', paths.dist)
    .sass(paths.src+'/countdown.scss', paths.dist)
    .sass(paths.src+'/element-list.scss', paths.dist)
    .sass(paths.src+'/element-stats.scss', paths.dist)
    .sass(paths.src+'/ratio.scss', paths.dist)
    .js(paths.src+'/search.js', paths.dist)
    .sass(paths.src+'/search.scss', paths.dist);
