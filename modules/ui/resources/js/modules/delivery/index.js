import { wrapInit } from 'js@/utils/wrap-init';

function deliveryAddress(element) {
	const select = element.querySelector('[data-delivery-select]');
	const fields = element.querySelector('[data-delivery-fields]');

	if (select) {
		if (select.value !== '') {
			fields.classList.add('_hide');
		} else {
			fields.classList.remove('_hide');
		}
	}
}

/**
 * @param {Array} elements
 */

export default (elements) => {
	wrapInit(elements, deliveryAddress);
};
