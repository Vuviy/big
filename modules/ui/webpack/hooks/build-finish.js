const fs = require('fs');
const del = require('del');
const paths = require('../config/paths');
const logger = require('../utils/logger');

try {
	// step 1
	if (fs.existsSync(paths.dist.build)) {
		logger.attention('Deleting previous build assets of the project');
		logger.path(paths.dist.build);

		del.sync(paths.dist.build);

		logger.done();
		logger.blank();
	}

	// step 2
	logger.attention('Moving new build files from a temporary folder to a build folder');
	logger.path(paths.dist.buildTemp);
	logger.path(paths.dist.build);

	fs.renameSync(paths.dist.buildTemp, paths.dist.build);

	logger.done();
	logger.blank();

	// step 4
	logger.done('Compilation successful!');
	logger.blank();
} catch (e) {
	logger.error(e);
	process.exit(1);
}
