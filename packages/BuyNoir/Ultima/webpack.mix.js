const mix = require("laravel-mix");

if (mix == 'undefined') {
    const { mix } = require("laravel-mix");
}

require("laravel-mix-merge-manifest");

var publicPath = '../../../public/themes/ultima/assets';

if (mix.inProduction()) {
    publicPath = 'publishable/assets';
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix.js([__dirname + '/src/Resources/assets/js/app.js'], __dirname + '/' + publicPath + '/js/app.js')
    .sass(__dirname + '/src/Resources/assets/sass/admin.scss', __dirname + '/' + publicPath + '/css/admin.css')
    .sass(__dirname + '/src/Resources/assets/sass/ultima.scss', __dirname + '/' + publicPath + '/css/ultima.css')
    .options({
        processCssUrls: false
    });


if (! mix.inProduction()) {
    mix.sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}