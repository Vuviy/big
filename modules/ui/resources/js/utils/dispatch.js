import isArray from 'js@/var/is-array';

/**
 * @param {HTMLCollection|HTMLElement[]|Window} targets
 * @param {String} eventName
 * @param {Object} detail
 */
export const dispatch = (targets, eventName, detail = {}) => {
	if (!isArray(targets)) {
		targets = [targets];
	}

	targets
		.filter((target) => target)
		.forEach((target) => {
			if (target instanceof Node || target instanceof Window) {
				target.dispatchEvent(
					new CustomEvent(eventName, {
						detail,
						bubbles: true
					})
				);
			}
		});
};
