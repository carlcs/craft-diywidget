const mix = require('laravel-mix');

const paths = {
    src: '_examples/src',
    dist: '_examples/diy-widget',
};

mix.js(paths.src+'/countdown.js', paths.dist)
    .js(paths.src+'/search.js', paths.dist)
    .sass(paths.src+'/countdown.scss', paths.dist)
    .sass(paths.src+'/photo.scss', paths.dist)
    .sass(paths.src+'/search.scss', paths.dist)
    .sass(paths.src+'/weekday-bear.scss', paths.dist);
