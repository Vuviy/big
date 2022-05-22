const { excludeFileNamesFromManifest } = require('../config/exclude-from-manifest');

/**
 * @param {[string]} entrypoints
 * @returns {[]}
 */
function uniqueManifestKeys(entrypoints) {
	let entries = Object.keys(entrypoints);

	if (entries.length) {
		entries = entries.filter((name) => !excludeFileNamesFromManifest.includes(name));

		return entries.reduce((result, value) => {
			let entry = entrypoints[value];

			if (/\.css/.test(entry)) {
				entry = entry.filter((item) => /\.css/.test(item));
			}

			const entryFileName = entry[0];

			if (entryFileName) {
				const partsEntryFileName = entryFileName.split('.');
				const entryFileTypeEnding = '.' + partsEntryFileName[partsEntryFileName.length - 1];

				result.push(value + entryFileTypeEnding);
			}

			return result;
		}, []);
	}

	return [];
}

/**
 * @param {{}} seed
 * @param {[Chunk]} files
 * @param {[string]} entrypoints
 * @returns {{}}
 */
exports.generateManifest = (seed, files, entrypoints) => {
	const result = {};
	const manifestKeys = uniqueManifestKeys(entrypoints);

	if (manifestKeys.length) {
		files = files.filter((file) => file.isInitial);

		if (files.length) {
			files.forEach((file) => {
				manifestKeys.forEach((key) => {
					if (key === file.name) {
						result[key] = file.path;
					}
				});
			});
		}
	}

	return result;
};
