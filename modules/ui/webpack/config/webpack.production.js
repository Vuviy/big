/** @fileOverview Конфигурация webpack под продакшин режим финальной сборки */

const { join } = require('path');
const { merge } = require('webpack-merge');

// webpack plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

// own
const webpackConfigCommon = require('../../../../webpack.config');
const paths = require('./paths');
const babelLoader = require('./babel-loader');
const { getPostcssPlugins } = require('./postcss');
const { getBrowserslistEnvList } = require('../utils/browsers-list');
const { generateManifest } = require('../utils/generate-manifest');
const { excludeFileNamesFromManifest } = require('../config/exclude-from-manifest');

/**
 * @param {"modern"|"legacy"} env
 * @returns {Object}
 */
const createConfig = (env) =>
	merge(webpackConfigCommon, {
		mode: process.env.NODE_ENV,
		devtool: false,
		entry: {
			app: join(paths.src.js, 'app.js'),
			styles: join(paths.src.sass, 'app.scss'),
			tinymce: join(paths.src.sass, 'tinymce.scss'),
			noscript: join(paths.src.sass, 'noscript.scss'),
			'unsupported-browser': join(paths.src.sass, 'unsupported-browser.scss')
		},
		output: {
			path: paths.dist.buildTemp,
			publicPath: paths.public.build,
			filename: `[name].${env}.[contenthash].js`,
			chunkFilename: `chunks/[name].${env}.[contenthash].js`
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
								sourceMap: false,
								importLoaders: 1,
								url: false
							}
						},
						{
							loader: 'postcss-loader',
							options: {
								sourceMap: false,
								postcssOptions: {
									plugins: getPostcssPlugins(env)
								}
							}
						},
						{
							loader: 'sass-loader',
							options: {
								sourceMap: false,
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
		optimization: {
			minimize: true,
			minimizer: [
				new CssMinimizerPlugin({
					minimizerOptions: {
						preset: [
							'default',
							{
								zindex: false,
								autoprefixer: false,
								reduceIdents: false,
								discardUnused: false,
								cssDeclarationSorter: false,
								postcssCalc: false,
								discardComments: {
									removeAll: true
								}
							}
						]
					}
				}),
				new TerserPlugin({
					terserOptions: {
						mangle: true
					}
				})
			]
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: (pathData) => {
					if (excludeFileNamesFromManifest.includes(pathData.chunk.name)) {
						return '[name].css';
					}

					return `[name].${env}.[contenthash].css`;
				},
				chunkFilename: `[name].${env}.[contenthash].css`,
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
		]
	});

/** Составляем список webpack конфигов заточенный под финальный билд */
module.exports = getBrowserslistEnvList().map(createConfig);
