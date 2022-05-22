/**
 * @param {string} str
 * @returns {string|undefined}
 */
export function getYoutubeId(str) {
	str = str.replace(/#t=.*$/, '');

	const shortCode = /youtube:\/\/|https?:\/\/youtu\.be\/|http:\/\/y2u\.be\//g;

	if (shortCode.test(str)) {
		const shortCodeId = str.split(shortCode)[1];
		return stripParameters(shortCodeId);
	}

	const inlineV = /\/v\/|\/vi\//g;

	if (inlineV.test(str)) {
		const inlineId = str.split(inlineV)[1];
		return stripParameters(inlineId);
	}

	const parameterV = /v=|vi=/g;

	if (parameterV.test(str)) {
		const arr = str.split(parameterV);
		return stripParameters(arr[1].split('&')[0]);
	}
}

/**
 * @param str
 * @returns {String}
 */
function stripParameters(str) {
	if (str.indexOf('?') > -1) {
		return str.split('?')[0];
	} else if (str.indexOf('/') > -1) {
		return str.split('/')[0];
	} else if (str.indexOf('&') > -1) {
		return str.split('&')[0];
	}

	return str;
}
