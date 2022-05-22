import { validString } from 'js@/utils/valid-string';

/**
 * @typedef {Object} cookieOptions
 * @property {string} [path]
 * @property {Date|number|string} [expires]
 * @property {Date|number|string} [max-age]
 * @property {string} [domain]
 * @property {string} [secure]
 * @property {string} [samesite=lax|strict]
 */
/**
 * @param {string} name
 * @param {*} value
 * @param {cookieOptions} options
 * @see {@link https://learn.javascript.ru/cookie}
 */
export const setCookie = (name, value, options = {}) => {
	options = {
		path: '/',
		...options
	};

	let expires = options.expires || '';

	if (typeof expires === 'number') {
		const date = new Date();

		date.setTime(date.getTime() + expires * 1000);
		expires = date;
	}

	if (validString(expires)) {
		const date = new Date(expires);

		if (!isNaN(date)) {
			expires = date;
		}
	}

	if (expires instanceof Date) {
		options.expires = expires.toUTCString();
	}

	let updatedCookie = encodeURIComponent(name) + '=' + encodeURIComponent(value);

	for (const optionKey in options) {
		updatedCookie += '; ' + optionKey;

		const optionValue = options[optionKey];

		if (optionValue !== true) {
			updatedCookie += '=' + optionValue;
		}
	}

	document.cookie = updatedCookie;
};

/**
 * @param {string} name
 * @returns {string|undefined}
 */
export const getCookie = (name) => {
	const matches = document.cookie.match(
		new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]/+^])/g, '\\$1') + '=([^;]*)')
	);

	return matches ? decodeURIComponent(matches[1]) : undefined;
};

/**
 * @param {string} name
 */
export const deleteCookie = (name) => {
	setCookie(name, '', {
		expires: -1
	});
};
