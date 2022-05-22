/**
 * @param {any} value
 * @returns {boolean}
 */
export const isObject = (value) => {
	return Object.prototype.toString.call(value) === '[object Object]';
};
