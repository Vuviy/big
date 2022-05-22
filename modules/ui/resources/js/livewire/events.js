import { FORM_ERROR_SELECTOR, HOOKS } from 'js@/livewire/constants';
import { delay } from 'js@/utils/delay';
import { getElements } from 'js@/utils/get-elements';
import { getWireComponentEl, subscribeHook } from 'js@/livewire/utils';
import { isInViewport } from 'js@/utils/is-in-viewport';
import { livewire } from 'js@/livewire';
import { serverResponse } from 'js@/modules/server-response';
import { updateLanguageSwitchers } from 'js@/modules/language-switcher';

const events = {
	jsResponse(...params) {
		serverResponse(params[0]);
	},

	changeUrl(url, title) {
		document.title = title;

		try {
			window.history.pushState({ reload: true }, title, url);
		} catch (e) {
			console.error(e);
		}
	},

	changeTitle(title) {
		document.title = title;
	},

	updateLangSwitcher(html) {
		updateLanguageSwitchers(html);
	}
};

for (const key in events) {
	livewire.on(key, events[key]);
}

// Scrolling to the form errors if needed
const handlerFormSubmit = function () {
	const wireComponent = getWireComponentEl(this);

	subscribeHook(
		wireComponent,
		HOOKS.messageProcessed,
		() => {
			const errors = getElements(wireComponent, FORM_ERROR_SELECTOR);

			if (errors.length) {
				if (!isInViewport(errors.item(0))) {
					delay().then(() => {
						errors.item(0).scrollIntoView({ block: 'center', behavior: 'smooth' });
					});
				}
			}
		},
		true
	);
};

if (document.forms.length) {
	for (const form of document.forms) {
		form.addEventListener('submit', handlerFormSubmit, false);
	}
}

/**
 * @param {NodeList} forms
 */
export const addEventScrollToFormErrors = (forms) => {
	if (forms.length) {
		for (const form of forms) {
			form.addEventListener('submit', handlerFormSubmit, false);
		}
	}
};
