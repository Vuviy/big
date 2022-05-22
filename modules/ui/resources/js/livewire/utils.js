import { HOOKS, WIRE_ID_SELECTOR, WIRE_IGNORE_SELECTOR, WIRE_MODEL_ATTR } from 'js@/livewire/constants';
import { getElement } from 'js@/utils/get-element';
import { livewire } from 'js@/livewire';

/**
 * @callback callback
 */

/**
 * @param {HTMLElement} element
 * @param {string} hook
 * @param {callback} callback
 * @param {boolean} [unsubscribe]
 */
export const subscribeHook = (element, hook, callback, unsubscribe = false) => {
	const hookWithoutBindingToRootComponent = () => [HOOKS.elementUpdated].includes(hook);

	if (element && !element.__livewire && !hookWithoutBindingToRootComponent()) {
		let findComponent = getWireComponentEl(element);

		if (!findComponent) {
			findComponent = getWireComponentEl(element, 'down');
		}

		if (findComponent) {
			element = findComponent;
		}
	}

	if (element && !elementIsWireIgnore(element)) {
		const handler = ({ detail }) => {
			if (typeof callback === 'function') {
				if (hookWithoutBindingToRootComponent()) {
					if (detail.el === element) {
						callback(detail);
					}
				} else {
					if (detail.component.el === element) {
						callback(detail);
					}
				}

				if (unsubscribe) {
					element.removeEventListener(hook, handler, false);
				}
			}
		};

		if (unsubscribe) {
			element.removeEventListener(hook, handler, false);
		}

		element.addEventListener(hook, handler, false);
	}
};

/**
 * @param {HTMLElement} el
 * @returns {*}
 */
export const detectWireModel = (el) => {
	return el.hasAttribute(WIRE_MODEL_ATTR) || el.hasAttribute('name');
};

/**
 * @param {HTMLElement} el
 * @returns {*}
 */
export const getWireModelName = (el) => {
	return el.getAttribute(WIRE_MODEL_ATTR) || el.getAttribute('name');
};

/**
 * @param {HTMLElement} el
 * @param {(up|down)} [findDirection]
 * @returns {HTMLElement|null}
 */
export const getWireComponentEl = (el, findDirection = 'up') => {
	if (findDirection === 'up') {
		return el.closest(WIRE_ID_SELECTOR);
	}

	return getElement(el, WIRE_ID_SELECTOR);
};

/**
 * @param {HTMLElement} el
 * @returns {*|null}
 */
export const getWireComponentId = (el) => {
	const wireComponent = getWireComponentEl(el);
	const { __livewire: wireInstance } = wireComponent;

	return wireInstance ? wireInstance.id : null;
};

/**
 * @param {HTMLElement} el
 */
export const sendInputValueToLivewire = (el) => {
	const component = livewire.components.componentsById[getWireComponentId(el)];
	const name = getWireModelName(el);

	let value = el.value;

	if (value.length === 0) {
		value = null;
	}

	if (value !== component.get(name)) {
		component.set(name, value);
	}
};

/**
 * @param {HTMLElement} el
 */
export const sendSelectValueToLivewire = (el) => {
	livewire.components.componentsById[getWireComponentId(el)].set(getWireModelName(el), el.value);
};

/**
 * @param {HTMLElement} el
 */
export const elementIsWireIgnore = (el) => {
	return el.closest(WIRE_IGNORE_SELECTOR);
};
