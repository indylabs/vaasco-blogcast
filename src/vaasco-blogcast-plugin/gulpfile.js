var gulp = require('gulp');
var runSequence = require('run-sequence');
var exec = require('child_process').exec;
var phplint = require('gulp-phplint');

// build
gulp.task('build', function(callback) {
  runSequence(
      'npm-update', 
      'composer-setup-install', 
      'composer-setup-verify', 
      'composer-setup-run', 
      'composer-setup-unlink',
      'dependencies-install',
      'phplint',
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

// install / setup componser
gulp.task('composer-setup-install', function(cb) {
    return exec('php -r "copy(\'https://getcomposer.org/installer\', \'composer-setup.php\');"', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

gulp.task('composer-setup-verify', function(cb) {
    return exec('php -r "if (hash_file(\'SHA384\', \'composer-setup.php\') === \'669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410\') { echo \'Installer verified\'; } else { echo \'Installer corrupt\'; unlink(\'composer-setup.php\'); } echo PHP_EOL;"', 
        function (err, stdout, stderr) {
            console.log(stdout);
            console.log(stderr);
            cb(err);
        });
});

gulp.task('composer-setup-run', function(cb) {
    return exec('php composer-setup.php', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

gulp.task('composer-setup-unlink', function(cb) {
    return exec('php -r "unlink(\'composer-setup.php\');"', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

// install dependencies
gulp.task('dependencies-install', function(cb) {
    return exec('php composer.phar install', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

// lint php
gulp.task('phplint', function() {
    return gulp.src(['./**/*.php', '!./vendor/**/*.*', '!./node_modules/**/*.*'])
        .pipe(phplint(''))
        .pipe(phplint.reporter(function(file){
        var report = file.phplintReport || {};
            if (report.error) {
                console.log(report.message + ' on line ' + report.line + ' of ' + report.filename);
                process.exit(1)
            }
        }));
});