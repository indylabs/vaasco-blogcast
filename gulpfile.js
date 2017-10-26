var gulp = require('gulp');
var runSequence = require('run-sequence');
var exec = require('child_process').exec;
var zip = require('gulp-zip');
var chug = require('gulp-chug');
var phplint = require('gulp-phplint');
var eslint = require('gulp-eslint');

// build
gulp.task('build', function(callback) {
  runSequence(
      'npm-update', 
      'blogcast-widget-build',
      'blogcast-plugin-build',
      'load-web-components', 
      'create-dist',
      'zip-dist',
      callback
    );
});

// npm update
gulp.task('npm-update', function(cb) {
  return exec('npm update', function (err, stdout, stderr) {
    console.log(stdout);
    console.log(stderr);
    cb(err);
  });
});

gulp.task( 'blogcast-widget-build', function () {
    gulp.src( './src/vaasco-blogcast-widget/gulpfile.js' )
        .pipe( chug( {
            tasks:  [ 'build' ]
        } ) );
});

gulp.task( 'blogcast-plugin-build', function () {
    gulp.src( './src/vaasco-blogcast-plugin/gulpfile.js' )
        .pipe( chug( {
            tasks:  [ 'build' ]
        } ) );
});

gulp.task( 'load-web-components', function () {
    return gulp.src(['./src/vaasco-blogcast-widget/build/bundled/src/components/vaasco-widget/vaasco-widget.html'])
        .pipe(gulp.dest('./src/vaasco-blogcast-plugin/public/components/'));
});

gulp.task( 'create-dist', function(){
    return gulp.src([
        './src/vaasco-blogcast-plugin/**/*.*', 
        '!./src/vaasco-blogcast-plugin/node_modules/**/*.*',
        '!./src/vaasco-blogcast-plugin/composer.*',
        '!./src/vaasco-blogcast-plugin/*.js',
    ])
    .pipe(gulp.dest('./dist/vaasco-blogcast/'));
});

gulp.task( 'zip-dist', function(){
    return gulp.src(['./dist/vaasco-blogcast/**/*.*'])
        .pipe(zip('vaasco-blogcast.zip'))
        .pipe(gulp.dest('./dist/'))
});