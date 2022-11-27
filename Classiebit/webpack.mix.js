const mix = require('laravel-mix');

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
 //mix.js('resources/js/events_show/index.js', 'public/js/events_show_v1.8.js').vue();
 mix
 // events create seperate vue js
 .js('resources/js/events_manage/index.js', 'publishable/assets/js/events_manage_v1.9.js')
 
 // events show seperate vue js
 .js('resources/js/events_show/index.js', 'publishable/assets/js/events_show_v1.9.js')
 
 // events listing seperate vue js
 .js('resources/js/events_listing/index.js', 'public/js/events_listing_v1.8.js')
 
 // organiser events
 .js('resources/js/myevents/index.js', 'public/js/myevents_v1.8.js')
 
 // customer bookings seperate vue js
 .js('resources/js/bookings_customer/index.js', 'public/js/bookings_customer_v1.8.js')
 
 // organiser bookings seperate vue js
 .js('resources/js/bookings_organiser/index.js', 'public/js/bookings_organiser_v1.8.js')
 
 // events welcome seperate vue js
 .js('resources/js/welcome/index.js', 'public/js/welcome_v1.8.js')
 
 // events tags seperate vue js
 .js('resources/js/tags_manage/index.js', 'public/js/tags_manage_v1.8.js')
 
 // events venues seperate vue js
 .js('resources/js/venues_manage/index.js', 'publishable/assets/js/venues_manage_v1.9.js')
 
 
 // v1.2-----------
 // events create seperate vue js
 .js('resources/js/ticket_scan/index.js', 'public/js/ticket_scan_v1.8.js')
 // v1.2-----------
 
 // organiser event earning seperate vue js
 .js('resources/js/event_earning/index.js', 'public/js/event_earning_v1.8.js')
 
 
 // events listing seperate vue js
 .js('resources/js/venues_listing/index.js', 'public/js/venues_listing_v1.8.js').vue();
 