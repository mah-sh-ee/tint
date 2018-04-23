'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    cssnext = require('postcss-cssnext'),
    coffee = require('gulp-coffee'),
    plumber = require('gulp-plumber'),
    notify = require('gulp-notify'),
    uglify = require('gulp-uglify'),
    cache = require('gulp-cached'),
    browserSync = require("browser-sync");

var proxyRoot = "http://tint.test/";

var paths = {
  images: {
    src: './assets/images/',
    files: './assets/images/**/*.png',
    dest: '../assets/img/'
  },
  styles: {
    src: './**/stylesheets/sass',
    srcEn: './assets/stylesheets/sass/main/style.scss',
    srcJa: './cocoon/stylesheets/sass/main/style.scss',
    files: './**/stylesheets/sass/**/*.scss',
    filesJa: './cocoon/stylesheets/sass/**/*.scss',
    destEn: '../wp-content/themes/simplicity2-child/',
    destJa: '../wp-content/themes/cocoon-child-master/'
  },
  coffee: {
    src: './assets/javascripts/coffee/',
    files: './assets/javascripts/coffee/*.coffee',
    dest: '../assets/js/'
  }
};

// var AUTOPREFIXER_BROWSERS = [
//   'last 2 version',
//   'ie >= 9',
//   'iOS >= 7',
//   'Android >= 4.2'
// ];

gulp.task("browserSyncTask", function () {
  browserSync.init({
    proxy: proxyRoot
  });
});
gulp.task('browserSyncReload', function () {
   browserSync.reload();
});

gulp.task('sassEn', function() {
  var processors = [
      cssnext({ browsers: 'last 2 versions' })
  ];
  return gulp.src(paths.styles.srcEn)
    // .pipe(cache('sass'))
    .pipe(plumber({
      errorHandler: notify.onError('Error:  <%= error.message %>')
    }))
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(postcss(processors))
    .pipe(gulp.dest(paths.styles.destEn));
});
gulp.task('sassJa', function() {
  var processors = [
      cssnext({ browsers: 'last 2 versions' })
  ];
  return gulp.src(paths.styles.srcJa)
    // .pipe(cache('sass'))
    .pipe(plumber({
      errorHandler: notify.onError('Error:  <%= error.message %>')
    }))
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(postcss(processors))
    .pipe(gulp.dest(paths.styles.destJa));
});

// gulp.task('coffee', function() {
//   return gulp.src(paths.coffee.files)
//     .pipe(plumber({
//       errorHandler: notify.onError("Error:  <%= error.message %>")
//     }))
//     .pipe(coffee())
//     .pipe(uglify())
//     .pipe(gulp.dest(paths.coffee.dest))
// });

gulp.task('default', ['browserSyncTask'] , function() {
  gulp.watch(paths.styles.files, ['sassEn', 'sassJa' , 'browserSyncReload']);
  // gulp.watch(paths.coffee.files, ['coffee']);
});
