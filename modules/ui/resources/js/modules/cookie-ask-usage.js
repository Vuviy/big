import { CLASS_NAMES } from 'js@/constants/class-names';
import { addClass, removeClass } from 'js@/utils/classes';
import { delay } from 'js@/utils/delay';
import { getElement } from 'js@/utils/get-element';
import { setCookie, getCookie } from 'js@/utils/cookie';

const cookie = {
	name: 'allow-cookie-usage',
	value: 'true',
	delay: 2000
};

export const cookieAskUsage = () => {
	if (getCookie(cookie.name) === cookie.value) {
		return false;
	}

	const block = getElement(document, '.js-cookie');
	const button = getElement(block, 'button');

	if (block && button) {
		button.addEventListener(
			'click',
			() => {
				addClass(block, CLASS_NAMES.hidden);
				setCookie(cookie.name, cookie.value, {
					expires: 60 * 60 * 24 * 365
				});
			},
			{
				once: true
			}
		);

		delay(cookie.delay).then(() => {
			removeClass(block, CLASS_NAMES.hidden);
		});

		return true;
	}
};
