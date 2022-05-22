import * as types from 'js@/modules/sliders/types';
import { getSliderClassName } from 'js@/modules/sliders/utils';
import { wrapInit } from 'js@/utils/wrap-init';

/**
 * @param {HTMLElement} element
 */
function sliderInit(element) {
	const sliderType = getSliderClassName(element.dataset.slider);

	if (!types[sliderType]) {
		return;
	}

	const slider = new types[sliderType](element);
	slider.main();


}

/**
 * @param {HTMLElement[]} elements
 */
function slidersObserver(elements) {
	const observer = new window.IntersectionObserver(
		(entries, observer) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					try {
						observer.unobserve(entry.target);
						sliderInit(entry.target);
					} catch (e) {
						console.log('text');
						console.error(e);
					}
				}
			});
		},
		{
			rootMargin: '0px 0px 500px 0px',
			threshold: 0
		}
	);

	wrapInit(elements, (el) => {
		if (el.hasAttribute('data-force-init')) {
			sliderInit(el);
		} else {
			observer.observe(el);
		}
	});
}

/**
 * @param {HTMLElement[]} elements
 */
export default function (elements) {
	slidersObserver(elements);
}
