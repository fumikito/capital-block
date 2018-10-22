var gulp          = require('gulp'),
    fs            = require('fs'),
    $             = require('gulp-load-plugins')(),
    eventStream   = require('event-stream'),
    webpack       = require('webpack-stream'),
    webpackBundle = require('webpack'),
    named         = require('vinyl-named'),
    browserSync   = require('browser-sync').create();


// Sass tasks
gulp.task('sass', function () {
  return gulp.src(['./src/scss/**/*.scss'])
    .pipe($.plumber({
      errorHandler: $.notify.onError('<%= error.message %>')
    }))
    .pipe($.sourcemaps.init({loadMaps: true}))
    .pipe($.sass({
      errLogToConsole: true,
      outputStyle    : 'compressed',
      includePaths   : [
        './src/scss'
      ]
    }))
    .pipe($.autoprefixer({browsers: ['last 2 version', '> 5%']}))
    .pipe($.sourcemaps.write('./map'))
    .pipe(gulp.dest('./assets/css'));
});


// JS Hint
gulp.task('eslint', function () {
  return gulp.src(['src/**/*.js'])
    .pipe($.eslint({ useEslintrc: true }))
    .pipe($.eslint.format());
});

// Transpile JS
gulp.task('js', function () {
  return gulp.src(['./src/js/**/*.js'])
    .pipe($.plumber({
      errorHandler: $.notify.onError('<%= error.message %>')
    }))
    .pipe(named())
    .pipe(webpack({
      mode: 'production',
      devtool: 'source-map',
      module: {
        rules: [
          {
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
              loader: 'babel-loader',
              options: {
                presets: ['@babel/preset-env'],
                plugins: ['@babel/plugin-transform-react-jsx']
              }
            }
          }
        ]
      }
    }, webpackBundle))
    .pipe(gulp.dest('./assets/js'));
});

// Pug task
gulp.task('pug', function () {
  return gulp.src(['src/pug/**/*', '!src/pug/**/_*'])
    .pipe($.plumber({
      errorHandler: $.notify.onError('<%= error.message %>')
    }))
    .pipe($.pug({
      pretty: true
    }))
    .pipe(gulp.dest('.'))
});

// Browser Sync
gulp.task('server', function () {
  return browserSync.init({
    files: ["assets/**/*", "./*.html"],
    server: {
      baseDir: ".",
      index: "index.html"
    },
    reloadDelay: 2000
  });
});

// Reload browser sync
gulp.task('reload', function () {
  gulp.watch([ './*.html', 'assets/**/*'], function () {
    return browserSync.reload();
  });
});

// watch
gulp.task('watch', function () {
  // Make SASS
  gulp.watch('src/scss/**/*.scss', ['sass']);
  // JS
  gulp.watch(['src/js/**/*.js'], ['js']);
  // PUG
  gulp.watch(['src/pug/**/*'], ['pug']);
});

// Build
gulp.task('build', ['js', 'pug', 'sass']);

// Default Tasks
gulp.task('default', ['watch']);

gulp.task('serve', ['server', 'reload', 'watch']);
