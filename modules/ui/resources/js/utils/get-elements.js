import arrayFrom from 'js@/var/array-from';

/**
 * @param {HTMLElement|Document|Window} context
 * @param {string} selector
 * @param {boolean} [returnAsArray=false]
 * @returns {null|*|[]|NodeListOf<HTMLElementTagNameMap[*]>|NodeListOf<Element>|NodeListOf<SVGElementTagNameMap[*]>}
 */
export const getElements = (context, selector, returnAsArray = false) => {
	if (!context && !selector) {
		return [];
	}

	return returnAsArray ? arrayFrom(context.querySelectorAll(selector)) : context.querySelectorAll(selector);
};
