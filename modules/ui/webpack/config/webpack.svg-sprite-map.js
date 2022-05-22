/** @fileOverview Конфигурация webpack под dev режим разработки */

const fs = require('fs');
const { join, basename } = require('path');
const glob = require('glob');

// webpack plugins
const SVGSpriteMapPlugin = require('svg-spritemap-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

// own
const paths = require('./paths');
const cleanPath = require('../utils/clean-path');

const sprites = glob
	.sync(paths.svgSprites.folders, {
		ignore: paths.svgSprites.entry
	})
	.filter((path) => fs.lstatSync(path).isDirectory())
	.map((src) => ({
		src: cleanPath(join(src, '/*')),
		filename: basename(src)
	}));

/**
 * Составляем webpack конфиг заточенный под инкрементальную сборку в dev режиме
 * @type {Configuration}
 */
module.exports = {
	mode: 'production',
	devtool: false,
	watch: false,
	entry: paths.svgSprites.entry,
	output: {
		path: paths.dist.svg,
		publicPath: paths.public.svg,
		filename: 'blank.js'
	},
	plugins: [
		new CleanWebpackPlugin(),
		...sprites.map(
			({ src, filename }) =>
				new SVGSpriteMapPlugin(src, {
					output: {
						filename: `./${filename}.svg`,
						svgo: {
							plugins: [
								'cleanupAttrs',
								'removeViewBox',
								'removeEmptyContainers',
								'cleanupIDs',
								'convertPathData',
								'mergePaths',
								'removeUnknownsAndDefaults'
							]
						}
					},
					sprite: {
						prefix: false,
						gutter: 5,
						generate: {
							title: false
						}
					}
				})
		)
	]
};
