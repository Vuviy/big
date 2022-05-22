/**
 * Does not include parent position relative
 * @param {HTMLElement} el
 * @returns {number}
 */
export const getElementYOffset = (el) => {
	return (el && Math.ceil(el.getBoundingClientRect().top)) || 0;
};
