const postcssFlexbugsFixes = require('postcss-flexbugs-fixes');
const postcssPresetEnv = require('postcss-preset-env');
const postcssSortMediaQueries = require('postcss-sort-media-queries');
const sortMediaQueries = require('sort-css-media-queries');

// own
const { getBrowserslistQueries } = require('../utils/browsers-list');

/** @param {string} env */
exports.getPostcssPlugins = (env) => {
	return [
		postcssPresetEnv({
			stage: 3,
			autoprefixer: {
				grid: true,
				cascade: false,
				flexbox: 'no-2009'
			},
			features: {
				'custom-properties': false
			},
			browsers: getBrowserslistQueries({ env })
		}),
		postcssFlexbugsFixes(),
		postcssSortMediaQueries({
			sort: sortMediaQueries
		})
	];
};
