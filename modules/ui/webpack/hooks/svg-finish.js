const fs = require('fs');
const { join, basename } = require('path');
const glob = require('glob');

// own
const paths = require('../config/paths');
const logger = require('../utils/logger');
const normalizePath = require('../utils/normalize-path');

try {
	// step 1
	logger.info('Generating SVG manifest');

	const pattern = join(paths.dist.svg, '*.svg');

	logger.path(pattern);

	const files = glob.sync(pattern).reduce((data, path) => {
		const name = basename(path);
		const key = name.split('.')[0];
		const value = join(paths.public.svg, name);
		return {
			...data,
			[key]: normalizePath(value)
		};
	}, {});

	logger.done();
	logger.blank();

	// step 2
	logger.info('Saving SVG manifest');

	const manifest = join(paths.dist.svg, 'manifest.json');

	logger.path(manifest);

	fs.writeFileSync(manifest, JSON.stringify(files, undefined, '  '));

	logger.done();
	logger.blank();

	// step 3
	logger.done('Compilation successful!');
	logger.blank();
} catch (e) {
	logger.error(e);
	process.exit(1);
}
