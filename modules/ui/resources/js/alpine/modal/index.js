import { DMI } from 'js@/dmi';
import { HOOKS } from 'js@/livewire/constants';
import { HttpRequest } from 'js@/modules/http-request';
import { MODAL_EVENT_BEFORE_CHANGE, MODAL_EVENT_SHOW, MODAL_TRANSITION_TIME } from 'js@/alpine/modal/constants';
import { addClass, removeClass } from 'js@/utils/classes';
import { addEventScrollToFormErrors } from 'js@/livewire/events';
import { dispatch } from 'js@/utils/dispatch';
import { getElement } from 'js@/utils/get-element';
import { getElements } from 'js@/utils/get-elements';
import { isNotEqual } from 'js@/alpine/modal/utils';
import { isObject } from 'js@/utils/is-object';
import { isObjectEmpty } from 'js@/utils/is-object-empty';
import { livewire } from 'js@/livewire';
import { scrollbar } from 'js@/utils/scrollbar';
import { serialize } from 'js@/utils/serialize';
import { subscribeHook } from 'js@/livewire/utils';
import { validString } from 'js@/utils/valid-string';

export function modal() {
	const componentUrl = window.app.route.component;
	const html = document.documentElement;
	const body = document.body;

	let timer = null;
	let last = null;

	return {
		isOpen: false,
		isShow: false,
		/** isLoaded - additional flag for block "modal-box" animation if has event mouseenter (preload) */
		isLoaded: false,
		loadClass: 'modal_load',
		eventName: 'click',

		get isMouseEnter() {
			return this.eventName === 'mouseenter';
		},

		/** @param {MouseEvent} event */
		open(event) {
			this.eventName = event.detail.eventName;

			// Checking if the button is in a modal and has event preload
			if (this.isOpen && this.isMouseEnter) {
				return;
			}

			this.preload(event);

			if (scrollbar.has()) {
				html.style.marginRight = scrollbar.widthWithUnit();
			}

			body.style.overflow = 'hidden';
			this.isOpen = true;

			if (this.isLoaded) {
				this.isShow = true;
				dispatch(window, MODAL_EVENT_SHOW, {
					modal: this.modal,
					content: this.content
				});
			}
		},

		/** @param {MouseEvent} event */
		preload({ detail }) {
			this.eventName = detail.eventName;

			// if (isNotEqual(detail, last)) {
				dispatch(window, MODAL_EVENT_BEFORE_CHANGE, {
					modal: this.modal,
					content: this.content
				});

				last = detail;
				this.content.innerHTML = '';
				removeClass(this.modal, this.loadClass);
				this.isLoaded = false;
				this.isShow = false;
				this.load(detail);
			// }
		},

		/** @param {Object} detail */
		load(detail) {
			if (validString(detail.html)) {
				this.done(detail.html);
				return;
			}

			const { name, params = {} } = detail;

			if (isObject(name) && validString(name.content)) {
				this.done(name.content);
				return;
			}

			const query = {};
			let requestUrl = null;

			if (isObject(name) && validString(name.url)) {
				requestUrl = name.url;
			} else {
				requestUrl = componentUrl;
				query.name = name;
			}

			if (!isObjectEmpty(params)) {
				query.params = params;
			}

			const xhr = new HttpRequest();

			xhr.open('GET', requestUrl + (!isObjectEmpty(query) ? '?' + serialize(query) : ''));

			xhr.send()
				.then((html) => {
					this.done(html);
				})
				.catch((e) => {
					console.error(e);
					this.close();
					last = null;
				});
		},

		/** @param {String} html */
		done(html) {
			this.content.innerHTML = html;
			this.appendCloseButton();
			this.onLoad();
		},

		onLoad() {
			livewire.rescan(this.content);
			DMI.importAll(this.content, true);
			addEventScrollToFormErrors(getElements(this.content, 'form'));
			addClass(this.modal, this.loadClass);

			this.isLoaded = true;
			this.isShow = true;

			if (!this.isMouseEnter) {
				dispatch(window, MODAL_EVENT_SHOW, {
					modal: this.modal,
					content: this.content
				});
			}

			subscribeHook(this.content, HOOKS.messageProcessed, () => {
				this.appendCloseButton();
			});
		},

		close() {
			clearTimeout(timer);

			timer = setTimeout(() => {
				html.style.marginRight = '';
				body.style.overflow = '';
			}, MODAL_TRANSITION_TIME);

			this.isOpen = false;
			this.isShow = false;
		},

		get modal() {
			return this.$refs.modal;
		},

		get content() {
			return this.$refs.content;
		},

		appendCloseButton() {
			const content = getElement(this.content, '[data-content]');
			const { firstChild } = this.content;

			if (content) {
				content.appendChild(this.buttonClose);
			} else if (firstChild && firstChild.tagName && firstChild.tagName.toLowerCase() === 'div') {
				firstChild.appendChild(this.buttonClose);
			} else {
				this.content.appendChild(this.buttonClose);
			}
		},

		cloneButtonClose: null,

		get buttonClose() {
			if (this.cloneButtonClose) {
				return this.cloneButtonClose;
			}

			let button = getElement(this.modal, '[x-el\\:button-close]');

			if (button) {
				this.cloneButtonClose = button.cloneNode(true);

				button.remove();
				button = null;

				this.cloneButtonClose.removeAttribute('hidden');

				return this.cloneButtonClose;
			}

			return document.createElement('div');
		}
	};
}
