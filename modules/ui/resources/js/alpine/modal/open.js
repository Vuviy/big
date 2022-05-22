import { MODAL_EVENT_OPEN, MODAL_EVENT_PRELOAD } from 'js@/alpine/modal/constants';
import { dispatch } from 'js@/utils/dispatch';
import { livewire } from 'js@/livewire';
import { HOOKS } from 'js@/livewire/constants';

const observer = new MutationObserver(() => {
	dispatch(window, 'modalresize');
});

livewire.hook(HOOKS.elementUpdated, (el, component) => {
	if (el.id === 'login-form' || el.id === 'register-form') {
		observer.disconnect();
		observer.observe(el, { characterData: true, childList: true, subtree: true, attributes: true });
	}
});

export function openModal(name, params = {}) {
	return {
		detail() {
			return {
				el: this.$el,
				name,
				params: {
					...params
				}
			};
		},

		dispatchModalEvent(e, detail) {
			detail.eventName = e.type.toLowerCase();

			if (detail.eventName === 'mouseenter') {
				dispatch(window, MODAL_EVENT_PRELOAD, detail);
			} else {
				dispatch(window, MODAL_EVENT_OPEN, detail);
			}
		},

		open(e) {
			this.dispatchModalEvent(e, this.detail());
		},

		forceOpen(e) {
			const detail = this.detail();

			detail.force = true;
			this.dispatchModalEvent(e, detail);
		},

		// Open after load page
		openOnLoad() {
			const handler = () => {
				dispatch(window, MODAL_EVENT_OPEN, this.detail());
				window.removeEventListener('load', handler);
			};

			window.addEventListener('load', handler);
		}
	};
}
