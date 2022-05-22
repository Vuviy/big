import isArray from 'js@/var/is-array';

/**
 * @param {HTMLElement|HTMLCollection} elements
 * @param {String|String[]} classes
 */
export const removeClass = (elements, classes) => {
	if (!elements) {
		return '';
	}

	const remove = (el) => {
		if (isArray(classes)) {
			el.classList.remove(...classes);
		} else {
			el.classList.remove(classes);
		}
	};

	if (isArray(elements) || elements instanceof NodeList) {
		elements.forEach((el) => {
			remove(el);
		});
	} else if (elements instanceof HTMLElement) {
		remove(elements);
	}
};

/**
 * @param {HTMLElement|HTMLCollection} elements
 * @param {String|String[]} classes
 */
export const addClass = (elements, classes) => {
	if (!elements) {
		return '';
	}

	const add = (el) => {
		if (isArray(classes)) {
			el.classList.add(...classes);
		} else {
			el.classList.add(classes);
		}
	};

	if (isArray(elements) || elements instanceof NodeList) {
		elements.forEach((el) => {
			add(el);
		});
	} else if (elements instanceof HTMLElement) {
		add(elements);
	}
};

/**
 * @param {HTMLElement} element
 * @param {String} selector
 * @returns {boolean}
 */
export const hasClass = (element, selector) => {
	return element && element.classList.contains(selector);
};
