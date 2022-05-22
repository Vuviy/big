/**
 * @param {HTMLElement|Document} context
 * @param {String} selector
 * @returns {Element|null}
 */
export const getElement = (context, selector) => {
	if (!context && !selector) {
		return null;
	}

	return context.querySelector(selector);
};
