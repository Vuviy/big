const chalk = require('chalk');
const cleanPath = require('./clean-path');

module.exports = {
	/** @param {...string} msg */
	attention(...msg) {
		console.log(chalk.yellow('Attention!', ...msg));
	},
	/** @param {...string} msg */
	info(...msg) {
		console.log(chalk.blue('Info:', ...msg));
	},
	/** @param {...string} msg */
	done(...msg) {
		console.log(chalk.green('Done!', ...msg));
	},
	/** @param {...string} msg */
	error(...msg) {
		console.log(chalk.red('Error!', ...msg));
	},
	/** @param {string} path */
	path(path) {
		console.log(chalk.gray(cleanPath(path)));
	},
	/** @param {...string} msg */
	blank() {
		console.log('');
	}
};
