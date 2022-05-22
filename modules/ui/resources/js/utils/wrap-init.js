/**
 * @param {Array} elements
 * @param {Function} fn
 */
export const wrapInit = (elements, fn) => {
	const init = (el) => {
		if (!el.dataset.inited) {
			fn(el);
		}

		el.dataset.inited = 'true';
	};

	if (elements.length === 1) {
		init(elements[0]);
	} else {
		elements.forEach((el) => {
			init(el);
		});
	}
};
