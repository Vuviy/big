import isArray from 'js@/var/is-array';
import { MODAL_EVENT_CLOSE, MODAL_EVENT_OPEN } from 'js@/alpine/modal/constants';
import { dispatch } from 'js@/utils/dispatch';
import { importSweetAlert } from 'js@/modules/sweet-alert';
import { isObject } from 'js@/utils/is-object';
import { isObjectEmpty } from 'js@/utils/is-object-empty';
import { mergeSweetAlertOptions } from 'js@/modules/sweet-alert/options';
import { validString } from 'js@/utils/valid-string';

/**
 * @param {Object} response
 * @returns {promise|boolean|Promise<void>|*}
 */
function serverResponse(response) {
	response = isObject(response) && !isObjectEmpty(response) ? response : null;

	if (!response) {
		console.warn('The response is not an object');
		return Promise.resolve();
	}

	const { notifications, errors, message } = response;

	handleModals(response);

	if (notifications && notifications.length) {
		return serverResponse.showNotices(notifications).then(() => {
			additionalActions(response);
		});
	} else {
		additionalActions(response);
	}

	if (errors && !isObjectEmpty(errors)) {
		return serverResponse.showNotices([
			{
				title: message,
				icon: 'error',
				toast: true,
				html: splitErrors(errors),
				position: 'top-right'
			}
		]);
	} else if (message) {
		return serverResponse.showNotice(message);
	}

	return Promise.resolve();
}

/**
 * @param {string|Object} title
 * @param {string} text
 * @param {string} icon
 * @returns {promise|boolean}
 * @static
 * */
serverResponse.showNotice = function (title, text = '', icon = '') {
	const firstArg = arguments[0];

	if (isObject(firstArg)) {
		if (isObjectEmpty(firstArg)) {
			return Promise.resolve();
		}

		return importSweetAlert().then((SweetAlert) => {
			return new SweetAlert(mergeSweetAlertOptions(firstArg));
		});
	}

	if (typeof title !== 'string') {
		return false;
	}

	return serverResponse.showNotices([
		{
			title,
			text,
			icon,
			toast: true,
			position: 'top-end',
			timer: 3500
		}
	]);
};

/**
 * Showed queue messages.
 * @param {SweetAlertOptions[]|SweetAlertOptions} notices - array or object setting messages
 * @returns {promise}
 * @static
 * */
serverResponse.showNotices = function (notices) {
	if (!isObject(notices) && !isArray(notices)) {
		throw new Error('The argument must be an array or object');
	}

	if (isObject(notices)) {
		notices = [notices];
	}

	if (!notices.length) {
		console.warn('Notices is empty');
	}

	return importSweetAlert().then((SweetAlert) => {
		async function show() {
			for (let i = 0; i < notices.length; i++) {
				await new SweetAlert(mergeSweetAlertOptions(notices[i]));
			}
		}

		return show();
	});
};

/**
 * @param {Object} response
 */
function handleModals(response) {
	const { modal } = response;

	if (!modal) {
		return;
	}

	if (isObject(modal)) {
		if (validString(modal.content)) {
			dispatch(window, MODAL_EVENT_OPEN, {
				html: modal.content
			});
		} else if (modal.component) {
			const { name, params = {} } = validString(modal.component) ? { name: modal.component } : modal.component;

			dispatch(window, MODAL_EVENT_OPEN, {
				name,
				params,
				force: true
			});
		} else if (validString(modal.url)) {
			dispatch(window, MODAL_EVENT_OPEN, {
				name: modal
			});
		}
	}

	if (validString(modal) && modal === 'close') {
		dispatch(window, MODAL_EVENT_CLOSE);
	}
}

/**
 * @param {Object} errors
 * @returns {string}
 */
function splitErrors(errors) {
	let html = '';

	for (const prop in errors) {
		if (errors.hasOwnProperty(prop)) {
			const list = errors[prop];

			for (let i = 0; i < list.length; i++) {
				html += `<div>${list[i]}</div>`;
			}
		}
	}

	return html;
}

/**
 * @param {Object} response
 */
function additionalActions(response) {
	const { reload, redirect } = response;

	if (reload) {
		window.location.reload();
	}

	if (validString(redirect)) {
		window.location.href = redirect;
	}
}

export { serverResponse };
