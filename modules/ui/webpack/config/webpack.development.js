/** @fileOverview Конфигурация webpack под dev режим разработки */

const { join } = require('path');
const { merge } = require('webpack-merge');

// webpack plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

// own
const paths = require('./paths');
const babelLoader = require('./babel-loader');
const commonWebpackConfig = require('../../../../webpack.config');
const { getPostcssPlugins } = require('./postcss');
const { getBrowserslistEnvList } = require('../utils/browsers-list');
const { generateManifest } = require('../utils/generate-manifest');
const { excludeFileNamesFromManifest } = require('../config/exclude-from-manifest');

const env = getBrowserslistEnvList()[0] || 'modern';

/**
 * Составляем webpack конфиг заточенный под инкрементальную сборку в dev режиме
 * @type {Configuration}
 */
module.exports = merge(commonWebpackConfig, {
	mode: process.env.NODE_ENV,
	devtool: 'inline-source-map',
	watch: true,
	entry: {
		app: join(paths.src.js, 'app.js'),
		generic: join(paths.src.sass, 'generic/_all-generic.scss'),
		elements: join(paths.src.sass, 'elements/_all-elements.scss'),
		objects: join(paths.src.sass, 'objects/_all-objects.scss'),
		components: join(paths.src.sass, 'components/_all-components.scss'),
		utilities: join(paths.src.sass, 'utilities/_all-utilities.scss'),
		tinymce: join(paths.src.sass, 'tinymce.scss'),
		noscript: join(paths.src.sass, 'noscript.scss'),
		'unsupported-browser': join(paths.src.sass, 'unsupported-browser.scss'),
		'ui-kit': join(paths.src.sass, 'ui-kit.scss')
	},
	output: {
		path: paths.dist.build,
		publicPath: paths.public.build,
		filename: '[name].bundle.js',
		chunkFilename: 'chunks/[name].js'
	},
	module: {
		rules: [
			{
				test: /\.(png|jpg|jpeg|svg|gif|woff|woff2|eot|ttf)$/,
				loader: 'url-loader'
			},
			babelLoader(env),
			{
				test: /\.(scss|sass|css)$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: true,
							importLoaders: 1,
							url: false
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true,
							postcssOptions: {
								plugins: getPostcssPlugins(env)
							}
						}
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true,
							implementation: require('sass'),
							additionalData: [
								`$ENV: '${env}';`,
								`$STATIC_PATH: '/';`,
								`$PUBLIC_PATH: '${paths.public.root}';`
							].join('\n')
						}
					}
				]
			}
		]
	},
	plugins: [
		new CleanWebpackPlugin(),
		new MiniCssExtractPlugin({
			filename: (pathData) => {
				if (excludeFileNamesFromManifest.includes(pathData.chunk.name)) {
					return '[name].css';
				}

				return '[name].[contenthash].bundle.css';
			},
			chunkFilename: `[name].[contenthash].css`,
			insert: function (linkTag) {
				// Don't need to use here ES5(6) etc.
				var reference = document.querySelector('#style-insert');
				if (reference) {
					reference.parentNode.insertBefore(linkTag, reference.previousSibling);
				}
			}
		}),
		new WebpackManifestPlugin({
			fileName: `manifest.${env}.json`,
			generate: generateManifest
		})
	],
	stats: {
		all: undefined,
		chunks: false,
		chunkGroups: false,
		modules: false,
		assets: true,
		errors: true,
		warnings: true
	}
});
