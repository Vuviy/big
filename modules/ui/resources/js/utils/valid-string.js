/**
 * @param val
 * @returns {boolean}
 */
export const validString = (val) => {
	return !!(val && typeof val === 'string' && val.length);
};
