/*
  Let the magic begin
*/

var gulp = require('gulp');

var es = require('event-stream');
var gutil = require('gulp-util');
var del = require('del');

var plugins = require("gulp-load-plugins")({
  pattern: ['gulp-*', 'gulp.*'],
  replaceString: /\bgulp[\-.]/
});

// Allows gulp --dev to be run for a more verbose output
var isProduction = true;
var sassStyle = 'compressed';
var sourceMap = true;
var sourcemaps = require('gulp-sourcemaps');
var sass = require('gulp-sass');

if(gutil.env.dev === true) {
  sassStyle = 'expanded';
  sourceMap = true;
  isProduction = false;
}

var changeEvent = function(evt) {
  gutil.log('File', gutil.colors.cyan(evt.path, 'was', gutil.colors.magenta(evt.type)));
};

var clean = function(path, cb) {
  // You can use multiple globbing patterns as you would with `gulp.src`
  del([path], {force:true}, cb);
};

var cssFiles = [
    // 'sass/app.scss',
    'sass/style.scss',
    // 'sass/login.scss',
    // 'sass/ionicons.scss'
  ];
var cssDest = 'css/';

gulp.task('css', function(){
  // app css
  return gulp.src(cssFiles)
    .pipe(sourcemaps.init({debug:true}))
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    // .pipe(plugins.concat('style.min.css'))
    .pipe(plugins.autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4', 'Firefox >= 4'))
    .pipe(isProduction ? plugins.combineMediaQueries({
      log: true
    }) : gutil.noop())
    .pipe(isProduction ? plugins.cssmin() : gutil.noop())
    .pipe(plugins.size())
    .on('error', function(err){
      new gutil.PluginError('CSS', err, {showStack: true});
    })
    .pipe(plugins.notify())
    .pipe(gulp.dest(cssDest));
});

var jsFiles = [];
var jsDest = '';

// gulp.task('scripts', function(){

  // return gulp.src(jsFiles)
  //   // .pipe(plugins.concat('app.js'))
  //   .pipe(isProduction ? plugins.uglify() : gutil.noop())
  //   .pipe(plugins.size())
  //   .pipe(plugins.notify())
  //   .pipe(gulp.dest(jsDest));
// });


gulp.task('watch', ['css'], function(){
  gulp.watch(cssFiles.concat('sass/**'), ['css']).on('change', function(evt) {
    changeEvent(evt);
  });

  // gulp.watch(jsFiles + '*.js', ['scripts']).on('change', function(evt) {
  //   changeEvent(evt);
  // });
});

gulp.task('default', ['css']);