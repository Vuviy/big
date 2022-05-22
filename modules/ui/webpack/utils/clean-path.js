const fromCWD = require('from-cwd');
const normalizePath = require('./normalize-path');
const _root = fromCWD('');

/**
 * @param {string} path
 * @return {string}
 */
module.exports = (path) => {
	path = normalizePath(path.replace(_root, ''));
	return path.replace(/^\//, '');
};
