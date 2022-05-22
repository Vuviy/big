/**
 * @fileOverview Cписок хелперов для работы с `browserslist`
 * @see https://github.com/TrigenSoftware/bdsl-webpack-plugin/blob/master/src/libbdsl/browserslist.js
 */

const fs = require('fs');
const { basename } = require('path');
const { loadConfig, readConfig, findConfig } = require('browserslist/node');

/**
 * @param {string} file
 * @return {{defaults: string}|*}
 */
function parsePackage(file) {
	const { browserslist } = JSON.parse(fs.readFileSync(file));
	return Array.isArray(browserslist) || typeof browserslist === 'string'
		? { defaults: browserslist }
		: browserslist;
}

/**
 * Get Browserslist config.
 * @param  {object} [options] - Browserslist options.
 * @param  {string} [options.path='.'] - Path to config directory.
 * @param  {string} [options.config] - Path to config.
 * @return {object} Browserslist config.
 */
function getConfig({ path = '.', config } = {}) {
	switch (true) {
		case Boolean(process.env.BROWSERSLIST):
			return process.env.BROWSERSLIST;

		case Boolean(config || process.env.BROWSERSLIST_CONFIG): {
			const file = config || process.env.BROWSERSLIST_CONFIG;
			if (basename(file) === 'package.json') {
				return parsePackage(file);
			}
			return readConfig(file);
		}

		case Boolean(path):
			return findConfig(path);

		default:
			return undefined;
	}
}

/**
 * Get Browserslist config's environments, ignoring `defaults` env.
 * @param  {object}   [options] - Browserslist options.
 * @param  {string}   [options.path] - Path to config directory.
 * @param  {string}   [options.config] - Path to config.
 * @return {string[]} Browserslist environments.
 */
exports.getBrowserslistEnvList = (options) => {
	const config = getConfig(options);
	if (config) {
		return Object.keys(config).filter((env) => env !== 'defaults');
	}
	return [];
};

/**
 * Get queries from Browserslist config.
 * @param  {object} [options] - Browserslist options.
 * @param  {string} [options.path='.'] - Path to config directory.
 * @param  {string} [options.env] - Browserslist config environment.
 * @return {object} Browserslist queries.
 */
exports.getBrowserslistQueries = ({ path = '.', ...otherOptions } = {}) => {
	return loadConfig({
		path,
		...otherOptions
	});
};
