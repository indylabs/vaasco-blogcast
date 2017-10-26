var gulp = require('gulp');
var runSequence = require('run-sequence');
var eslint = require('gulp-eslint');
var polylint = require('gulp-polylint');
var exec = require('child_process').exec;

gulp.task('build', function(callback) {
  runSequence('npm-update', 'bower-update', 'eslint', 'polylint', 'polymer-build', callback);
});

gulp.task('npm-update', function(cb) {
  return exec('npm update', function (err, stdout, stderr) {
    console.log(stdout);
    console.log(stderr);
    cb(err);
  });
});

gulp.task('bower-update', function(cb) {
  return exec('bower update', function (err, stdout, stderr) {
    console.log(stdout);
    console.log(stderr);
    cb(err);
  });
});

gulp.task('polymer-build', function(cb) {
  return exec('polymer build', function (err, stdout, stderr) {
    console.log(stdout);
    console.log(stderr);
    cb(err);
  });
});

gulp.task('eslint', function() {
  return gulp.src([
    'src/**/*.js',
    'src/**/*.html',
    'gulpfile.js'
  ])
  .pipe(eslint())
  .pipe(eslint.format())
  .pipe(eslint.failAfterError());
});

gulp.task('polylint', function() {
  return gulp.src('src/**/*.html')
    .pipe(polylint({ noRecursion: true }))
    .pipe(polylint.reporter(polylint.reporter.stylishlike))
    .pipe(polylint.reporter.fail({ buffer: true, ignoreWarnings: false }));
});
