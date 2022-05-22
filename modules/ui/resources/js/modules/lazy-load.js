/**
 * @typedef lozad
 * @property {function} observe
 * @property {function} triggerLoad
 */
/**
 * @see https://github.com/ApoorvSaxena/lozad.js
 * @param {Object} options
 * @return {Promise<lozad>}
 */
export const lazyLoad = (options) => {
	options = Object.assign(
		{},
		{
			rootMargin: '50px'
		},
		options
	);

	return new Promise((resolve, reject) => {
		import('lozad')
			.then(({ default: lozad }) => {
				resolve(lozad('.lazy', options));
			})
			.catch((e) => {
				reject(e);
			});
	});
};

/**
 * @param {HTMLImageElement} el
 */
export const imageLazyTrigger = (el) => {
	if (el instanceof HTMLImageElement && el.classList.contains('lazy')) {
		lazyLoad().then((lozad) => {
			lozad.triggerLoad(el);
		});
	}
};
