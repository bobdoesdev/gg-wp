/*

Run these commands

## if the project is already set up and running:
npm install

## if you check package.json and there aren't dependencies listed ( there should be no reason to do this )
npm install gulp
npm install gulp-concat --save-dev
npm install gulp-plumber --save-dev
npm install gulp-autoprefixer --save-dev
npm install gulp-clean-css --save-dev
npm install gulp-uglify --save-dev
npm install gulp-rename --save-dev
npm install gulp-notify --save-dev
npm install gulp-sass --save-dev
npm install gulp-sass-glob --save-dev
npm install gulp-load-plugins --save-dev

## always ( to compile/watch/etc )
gulp
*/

// Config for theme
var themePath = './';

// Gulp Nodes
var gulp        = require( 'gulp' ),
    gulpPlugins = require( 'gulp-load-plugins' )();

// Error Handling
var onError = function( err ) {
    console.log( 'An error occurred:', err.message );
    this.emit( 'end' );
};

gulp.task('scss', function () {
    const { autoprefixer, cleanCss, notify, plumber, sass, sassGlob } = gulpPlugins;
    // return sass(themePath + 'style.scss', { sourcemap: false })
    return gulp.src(themePath + 'boilerplate-frontend.scss')
        .on('error', sass.logError)
        .pipe(plumber())
        .pipe(sassGlob())
        .pipe(sass())
        .pipe(autoprefixer('last 4 version'))
        .pipe(cleanCss())
        .pipe(gulp.dest(themePath))
        .pipe(notify({ message: 'Scss task complete' }));
});

gulp.task('scripts', function() {
    const { concat, notify, plumber, rename, uglify } = gulpPlugins;
    return gulp.src( [themePath + 'js/libs/**/*.js', themePath + 'js/development/**/*.js'] )
        .pipe(plumber())
        .pipe(concat('js/boilerplate-frontend.js'))
        .pipe(gulp.dest(themePath))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(themePath))
        .pipe(notify({ message: 'Scripts task complete' }));
});

// Watch task -- this runs on every save.
gulp.task( 'watch', function() {

    // Watch all .scss files
    gulp.watch( themePath + '**/**/*.scss', gulp.series( 'scss' ) );

    // Watch js files
    gulp.watch( themePath + 'js/development/**/*.js', gulp.series( 'scripts' ) );
});

// Default task -- runs scss and watch functions
gulp.task( 'default', gulp.series('scripts', 'scss', 'watch'));
