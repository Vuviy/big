/**
 * @param {String|null|undefined} str
 */
export const dashToCapWords = (str) => {
	if (typeof str === 'string') {
		return str.replace(/^.|-./g, (letter, index) =>
			index === 0 ? letter.toUpperCase() : letter.substr(1).toUpperCase()
		);
	}

	return '';
};
