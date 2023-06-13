let mix = require('laravel-mix');
require('mix-tailwindcss');


mix.css('resources/input.css', 'src/web/assets/dist/input.css');

mix.js('resources/js/app.js', 'src/web/assets/dist/PluginBundle.js')
    .sass('resources/sass/sync-bookings.scss', 'src/web/assets/dist/SyncBookingsUtility.css')
    .sass('resources/sass/plugin-bundle.scss', 'src/web/assets/dist/PluginBundle.css')
    .tailwind();
