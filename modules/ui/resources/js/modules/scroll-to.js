import { BREAKPOINTS } from 'js@/constants/breakpoints';
import { EASING } from 'js@/constants/easing';
import { delay } from 'js@/utils/delay';
import { getDelegateTarget } from 'js@/utils/get-delegate-target';
import { getElement } from 'js@/utils/get-element';

const mobileHeader = getElement(document, '.js-m-header');

function getElementY(el) {
	let offset = 0;

	if (window.innerWidth < BREAKPOINTS.df) {
		offset = mobileHeader ? mobileHeader.offsetHeight : 0;
	}

	return window.pageYOffset + el.getBoundingClientRect().top - offset;
}

/**
 * @param {Element} el
 * @param {number|null} offset
 * @param {number} duration
 * @param {callback} callback
 */
export const scrollTo = ({ el, offset = 0, duration = 300, callback = () => {} }) => {
	if (!el) {
		return;
	}

	if (!offset) {
		offset = 0;
	}

	const pageY = window.pageYOffset;
	const elementY = getElementY(el) - offset;
	const targetY =
		document.body.scrollHeight - elementY < window.innerHeight
			? document.body.scrollHeight - window.innerHeight
			: elementY;
	const diff = targetY - pageY;

	let start;

	if (!diff) {
		callback();

		return;
	}

	window.requestAnimationFrame(function step(timestamp) {
		if (!start) start = timestamp;

		const time = timestamp - start;
		let percent = Math.min(time / duration, 1);

		percent = EASING.easeInOutQuart(percent);
		window.scrollTo(0, pageY + diff * percent);

		if (time < duration) {
			window.requestAnimationFrame(step);
		} else {
			callback();
		}
	});
};

export const scrollToObserve = () => {
	document.addEventListener(
		'click',
		(event) => {
			const target = getDelegateTarget(event, '[data-scroll-to]');

			if (!target) {
				return;
			}

			const scrollToEl = getElement(document, target.dataset.scrollTo);

			if (!scrollToEl) {
				return;
			}

			const { scrollToDelay } = target.dataset;

			if (scrollToDelay) {
				delay(Number(scrollToDelay) || 0).then(() => {
					scrollTo({ el: scrollToEl });
				});
			} else {
				scrollTo({ el: scrollToEl });
			}
		},
		false
	);
};
