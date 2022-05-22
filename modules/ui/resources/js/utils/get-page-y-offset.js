/**
 * @returns {number}
 */
export const getPageYOffset = () => {
	return Math.ceil(window.pageYOffset || document.documentElement.scrollTop);
};
