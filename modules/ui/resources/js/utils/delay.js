/**
 * @param {Number} ms
 * @returns {Promise<unknown>}
 */
export const delay = (ms = 5) => {
	return new Promise((resolve) => setTimeout(resolve, ms));
};
