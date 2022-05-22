import throttle from 'lodash.throttle';
import { CLASS_NAMES } from 'js@/constants/class-names';
import { addClass, removeClass } from 'js@/utils/classes';
import { getElement } from 'js@/utils/get-element';
import { getPageYOffset } from 'js@/utils/get-page-y-offset';
import { scrollTo } from 'js@/modules/scroll-to';

export const linkToTop = () => {
	const el = getElement(document, '.js-link-to-top');

	if (!el) {
		return;
	}

	const buttonVisibilityState = () => {
		if (getPageYOffset() > window.innerHeight) {
			addClass(el, CLASS_NAMES.show);
		} else {
			removeClass(el, CLASS_NAMES.show);
		}
	};

	const clickEvent = () => {
		scrollTo({ el: document.body });
	};

	buttonVisibilityState();

	el.addEventListener('click', clickEvent, false);
	window.addEventListener('scroll', throttle(buttonVisibilityState, 100), false);
};
