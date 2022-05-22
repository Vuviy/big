'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');

sass.compiler = require('node-sass');

gulp.task('sass', function () {
	return gulp.src([
		'./scss/default.scss',
		'./scss/media.scss',
		'./scss/mso.scss'
	])
		.pipe(sass().on('error', sass.logError))
		.pipe(cleanCSS())
		.pipe(gulp.dest('./'));
});

gulp.task('sass:watch', function () {
	gulp.watch('./scss/**/*.scss', gulp.series('sass'));
});
