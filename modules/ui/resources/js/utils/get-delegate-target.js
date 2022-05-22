/**
 * @param {Event} event
 * @param {String} selector
 * @returns {HTMLElement | null}
 */
export const getDelegateTarget = (event, selector) => {
	const target = event.target;

	if (target.matches(selector)) {
		return target;
	} else {
		return target.closest(selector);
	}
};
