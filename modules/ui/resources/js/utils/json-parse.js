/**
 * @param {string} str
 * @param {any} fallback
 * @returns {null|any}
 * @constructor
 */
export const JSONParse = (str, fallback = null) => {
	if (typeof str === 'string') {
		try {
			return JSON.parse(str);
		} catch (e) {
			console.error(e);
			return fallback;
		}
	}

	return fallback;
};
