/**
 * @fileOverview Базовый конфиг с общими параметрами для всех режимов сборки.
 * Также файл поможет вашей IDE корректно ресолвить все алиасы по проекту
 */

const paths = require('./modules/ui/webpack/config/paths');

module.exports = {
	resolve: {
		alias: {
			'js@': paths.src.js,
			'sass@': paths.src.sass
		},
		modules: paths.resolveModules
	},
	externals: {
		jquery: 'jQuery'
	},
	stats: {
		colors: true,
		env: true,
		publicPath: true,
		assets: false,
		entrypoints: false,
		chunks: true,
		chunkGroups: true,
		modules: false,
		children: false
	}
};
