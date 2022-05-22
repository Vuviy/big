const fs = require('fs');
const del = require('del');
const paths = require('../config/paths');
const logger = require('../utils/logger');

try {
	if (fs.existsSync(paths.dist.buildTemp)) {
		logger.attention('Removing artifacts from failed previous builds');
		logger.path(paths.dist.buildTemp);

		del.sync(paths.dist.buildTemp);

		logger.done();
		logger.blank();
	}
	logger.attention(
		'Compilation of new assets files will be performed in a temporary directory.'
	);
	logger.info(
		'After a successful compilation process, the new files will be transferred from the temporary directory to the working one with a complete replacement of the previous files'
	);
	logger.blank();
} catch (e) {
	logger.error(e);
	process.exit(1);
}
