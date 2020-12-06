const mix = require('laravel-mix')

mix
  .js('resources/js/app.js', 'public/js')
  .copy('node_modules/highlight.js/styles/', 'public/css/higlightjs-styles')
  .sass('resources/sass/app.scss', 'public/css')
  .browserSync({
    proxy: 'laravel-qa.offline',
    notify: false,
  })
  .disableNotifications()
// .copy('node_modules/prismjs/themes/', 'public/css/prismjs-themes')

// .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
