/**
 * @param {Array} array
 * @returns {any[]}
 */
export const arrayUnique = (array) => {
	return Array.from(new Set(array));
};
