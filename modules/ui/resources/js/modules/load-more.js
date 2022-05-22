import { CSS_CLASSES } from 'js@/constants';
import { DMI } from 'js@/dmi';
import { HttpRequest } from 'js@/modules/http-request';
import { JSONParse } from 'js@/utils/json-parse';
import { addClass, removeClass } from 'js@/utils/classes';
import { getElement } from 'js@/utils/get-element';
import { getElements } from 'js@/utils/get-elements';
import { getCsrfToken } from 'js@/utils/get-csrf-token';
import { lazyLoad } from 'js@/modules/lazy-load';
import { livewire } from 'js@/livewire';
import { validString } from 'js@/utils/valid-string';

export const loadMore = () => {
	getElements(document, '[data-load-more]').forEach((el) => {
		initialize(el);
	});
};

/**
 * @param {HTMLElement} button
 */
function initialize(button) {
	/**
	 * @typedef {Object} params
	 * @property {string} route
	 * @property {string} appendTo
	 * @property {string} countMore
	 * @property {string} [wrapper]
	 * @property {string} [method]
	 * @property {string} [paginator]
	 * @property {boolean} [changeUrl]
	 */
	const params = JSONParse(button.dataset.loadMore);

	if (incorrectParams(params)) {
		console.log('%cLoad more route or append to - incorrect!', 'color:red');
		return;
	}

	const appendToElem = getElement(document, params.appendTo);
	const paginateElem = getElement(document, params.paginator);
	const countMoreElem = getElement(document, params.countMore);

	let wrapperBtn;

	if (validString(params.wrapper)) {
		try {
			wrapperBtn = button.closest(params.wrapper);
		} catch (e) {
			console.error(e);
		}
	}

	let loading = false;

	const loadEvent = () => {
		if (loading) {
			return;
		}

		loading = true;
		addClass(button, CSS_CLASSES.loading);

		const xhr = new HttpRequest();

		xhr.open(params.method || 'GET', params.route);
		xhr.setHeader('Accept', 'application/json');
		xhr.setHeader('X-CSRF-TOKEN', getCsrfToken());
		xhr.setHeader('Load-More', 'true');

		if (params.paginator) {
			xhr.setHeader('With-Paginator', 'true');
		}

		xhr.send(params.params)
			.then((response) => {
				responseProcessing(response);
				setTimeout(() => {
					removeClass(button, CSS_CLASSES.loading);
				}, 2000);
			})
			.catch(() => {
				setTimeout(() => {
					removeClass(button, CSS_CLASSES.loading);
				}, 2000);
			})
			.finally(() => {
				loading = false;
			});
	};

	const responseProcessing = ({ newPageUrl, html, pagination, more, titleDocument, countMore }) => {
		if (appendToElem) {
			appendToElem.insertAdjacentHTML('beforeend', html);
			livewire.rescan(appendToElem);
			DMI.importAll(appendToElem);
			lazyLoad().then((lozad) => lozad.observe());
		}

		if (pagination && paginateElem) {
			paginateElem.innerHTML = pagination;
		}

		if (countMoreElem) {
			countMoreElem.innerHTML = countMore;
		}

		if (params.replaceRoute && params.route) {
			try {
				window.history.replaceState({}, document.title, params.route);
			} catch (e) {
				console.warn(e);
			}
		}

		params.route = newPageUrl;

		if (titleDocument) {
			window.document.title = titleDocument;
		}

		if (!more) {
			if (wrapperBtn) {
				wrapperBtn.remove();
				wrapperBtn = null;
			} else if (button.parentElement.children.length === 1) {
				button.parentElement.remove();
			} else {
				button.remove();
			}

			button = null;
		}
	};

	button.addEventListener('click', loadEvent, false);
}

/**
 * @param params
 * @returns {boolean}
 */
function incorrectParams(params) {
	return !validString(params.route) || !validString(params.appendTo);
}

export default function (elements) {
	elements.forEach((el) => initialize(el));
}
