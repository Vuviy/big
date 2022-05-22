const babelLoaderExcludeNodeModulesExcept = require('babel-loader-exclude-node-modules-except');
const { getBrowserslistQueries } = require('../utils/browsers-list');

/**
 * @param {"modern"|"legacy"} env
 * @returns {Object}
 */
module.exports = (env) => ({
	test: /\.js$/,
	exclude: babelLoaderExcludeNodeModulesExcept([
		// ES6+ modules from node_modules/
		'@wezom/browserizr',
		'@wezom/dynamic-modules-import',
		'custom-jquery-methods',
		// 'dom7',
		// 'swiper'
	]),
	use: [
		{
			loader: 'babel-loader',
			options: {
				cacheDirectory: false,
				presets: [
					[
						'@babel/preset-env',
						{
							targets: getBrowserslistQueries({ env }),
							browserslistEnv: 'package.json',
							useBuiltIns: 'entry',
							corejs: 3,
							exclude: ['transform-typeof-symbol']
						}
					]
				]
			}
		}
	]
});
