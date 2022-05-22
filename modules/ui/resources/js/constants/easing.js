/*
 * @see https://easings.net/ru
 * @see https://gist.github.com/gre/1650294
 * */
export const EASING = Object.freeze({
	// linear: (t) => t,
	// easeInQuad: (t) => Math.pow(t, 2),
	// easeOutQuad: (t) => 1 - Math.pow(1 - t, 2),
	// easeInOutQuad: (t) => (t < 0.5 ? Math.pow(t * 2, 2) / 2 : (1 - Math.pow(1 - (t * 2 - 1), 2)) / 2 + 0.5),
	// easeInCubic: (t) => Math.pow(t, 3),
	// easeOutCubic: (t) => 1 - Math.pow(1 - t, 3),
	// easeInOutCubic: (t) => (t < 0.5 ? Math.pow(t * 2, 3) / 2 : (1 - Math.pow(1 - (t * 2 - 1), 3)) / 2 + 0.5),
	// easeInQuart: (t) => Math.pow(t, 4),
	// easeOutQuart: (t) => 1 - Math.pow(1 - t, 4),
	easeInOutQuart: (t) => (t < 0.5 ? Math.pow(t * 2, 4) / 2 : (1 - Math.pow(1 - (t * 2 - 1), 4)) / 2 + 0.5)
	// easeInQuint: (t) => Math.pow(t, 5),
	// easeOutQuint: (t) => 1 - Math.pow(1 - t, 5),
	// easeInOutQuint: (t) => (t < 0.5 ? Math.pow(t * 2, 5) / 2 : (1 - Math.pow(1 - (t * 2 - 1), 5)) / 2 + 0.5)
});
