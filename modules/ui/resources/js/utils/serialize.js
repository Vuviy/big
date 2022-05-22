/**
 * @param {Object} obj
 * @param {String} prefix
 * @returns {string}
 */
export const serialize = (obj, prefix = '') => {
	const str = [];

	for (const p in obj) {
		if (obj.hasOwnProperty(p)) {
			const k = prefix ? prefix + '[' + p + ']' : p;
			const v = obj[p];

			str.push(
				v !== null && typeof v === 'object'
					? serialize(v, k)
					: encodeURIComponent(k) + '=' + encodeURIComponent(v)
			);
		}
	}

	return str.join('&');
};
