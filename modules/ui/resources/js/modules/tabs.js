import arrayFrom from 'js@/var/array-from';
import { addClass, removeClass } from 'js@/utils/classes';
import { dispatch } from 'js@/utils/dispatch';
import { getDelegateTarget } from 'js@/utils/get-delegate-target';
import { getElements } from 'js@/utils/get-elements';

const wsTabs = {
	events: {
		on: 'tabs-on',
		off: 'tabs-off',
		again: 'tabs-again'
	},

	cssClass: {
		active: 'is-active',
		disabled: 'is-disabled'
	},

	keys: {
		ns: 'tabs-ns',
		button: 'tabs-button',
		block: 'tabs-block',
		dataNs: 'tabsNs',
		dataButton: 'tabsButton',
		dataBlock: 'tabsBlock',
		dataToggle: 'tabsToggle'
	},

	/**
	 * @param {HTMLElement} context
	 */
	init(context = document.body) {
		context.addEventListener(
			'click',
			(event) => {
				const target = getDelegateTarget(event, `[data-${wsTabs.keys.button}]`);

				if (target) {
					if (!_isToggle(target)) {
						_changeTab(target, context);

						return true;
					}

					if (_isToggle(target) && this.noReact(target)) {
						const { block, syncButtons } = this.ejectData(target);

						removeClass(block, this.cssClass.active);
						removeClass(target, this.cssClass.active);
						removeClass(syncButtons, this.cssClass.active);
					} else {
						_changeTab(target, context);
					}
				}
			},
			false
		);
	},

	/**
	 * @param {HTMLElement} button
	 * @param {HTMLElement} context
	 * @returns {{readonly, buttonsSelector: string, buttonSyncSelector: string, blocksSelector: string, siblingBlocks: HTMLElement[], ns: *, name: *, siblingButtons: HTMLElement[], blockSelector: string, block: *, syncButtons: unknown[]}|string|HTMLElement[]|*}
	 */
	ejectData(button, context = document.body) {
		return _ejectData(button, context);
	},

	/**
	 * @param {HTMLElement} button
	 * @returns {boolean|undefined}
	 */
	noReact(button) {
		return _noReact(button);
	},

	/**
	 * @param {HTMLElement} button
	 * @param {HTMLElement} context
	 */
	changeTab(button, context = document.body) {
		if (!button) return;

		_changeTab(button, context);
	},

	/**
	 * @param {HTMLElement} context
	 */
	setActive(context = document.body) {
		const buttons = getElements(context, `[data-${this.keys.button}]`);
		_setActive(arrayFrom(buttons), context);
	}
};

/**
 * @param {HTMLElement} button
 * @returns {boolean}
 * @private
 */
function _isToggle(button) {
	return button.dataset[wsTabs.keys.dataToggle] === 'true';
}

/**
 * @param {HTMLElement[]} buttons
 * @param context
 * @returns {boolean|*}
 * @private
 */
function _setActive(buttons, context) {
	const ns = buttons[0].dataset[wsTabs.keys.dataNs];
	const selector = `[data-${wsTabs.keys.ns}="${ns}"]`;
	const group = buttons.filter((button) => button.matches(selector));

	if (group.length) {
		const active = group.filter((button) => button.matches(`.${wsTabs.cssClass.active}`));

		if (!active.length) {
			_changeTab(group[0], context);
		}

		if (group.length < buttons.length) {
			_setActive(
				buttons.filter((button) => !button.matches(selector)),
				context
			);
		}
	}
}

/**
 * @param {HTMLElement} button
 * @return {boolean|undefined}
 * @private
 */
function _noReact(button) {
	return (
		button.classList.contains(wsTabs.cssClass.active) ||
		button.classList.contains(wsTabs.cssClass.disabled) ||
		button.disabled
	);
}

/**
 * @param {HTMLElement} button
 * @param {HTMLElement} context
 * @private
 */
function _changeTab(button, context) {
	const { block, siblingBlocks, siblingButtons, syncButtons } = _ejectData(button, context);

	if (_noReact(button)) {
		dispatch([button, block], wsTabs.events.again, {
			button,
			block
		});

		return false;
	}

	removeClass(siblingButtons, wsTabs.cssClass.active);
	removeClass(siblingBlocks, wsTabs.cssClass.active);

	dispatch(siblingButtons, wsTabs.events.off, {
		siblingButtons
	});
	dispatch(siblingBlocks, wsTabs.events.off, {
		siblingBlocks
	});

	addClass(button, wsTabs.cssClass.active);
	addClass(syncButtons, wsTabs.cssClass.active);
	addClass(block, wsTabs.cssClass.active);

	dispatch([button, block], wsTabs.events.on, {
		siblingButtons,
		syncButtons
	});
}

/**
 * @param button
 * @param context
 * @returns {{readonly buttonsSelector: string, readonly buttonSyncSelector: string, readonly blocksSelector: string, readonly siblingBlocks: HTMLElement[], ns: *, name: *, readonly siblingButtons: HTMLElement[], readonly blockSelector: string, readonly block: *, readonly syncButtons: unknown[]}|string|HTMLElement[]|any}
 * @private
 */
function _ejectData(button, context) {
	return {
		ns: button.dataset[wsTabs.keys.dataNs],
		name: button.dataset[wsTabs.keys.dataButton],
		get buttonsSelector() {
			return `[data-${wsTabs.keys.ns}="${this.ns}"][data-${wsTabs.keys.button}]`;
		},
		get buttonSyncSelector() {
			return `[data-${wsTabs.keys.ns}="${this.ns}"][data-${wsTabs.keys.button}="${this.name}"]`;
		},
		get blocksSelector() {
			return `[data-${wsTabs.keys.ns}="${this.ns}"][data-${wsTabs.keys.block}]`;
		},
		get blockSelector() {
			return `[data-${wsTabs.keys.ns}="${this.ns}"][data-${wsTabs.keys.block}="${this.name}"]`;
		},
		get block() {
			return context.querySelector(this.blockSelector);
		},
		get siblingBlocks() {
			return _getElements(this.block, this.blocksSelector, context, true);
		},
		get siblingButtons() {
			return _getElements(button, this.buttonsSelector, context, true);
		},
		get syncButtons() {
			const elements = _getElements(button, this.buttonsSelector, context, true);
			return elements.filter((elem) => elem.matches(this.buttonSyncSelector));
		}
	};
}
/**
 * @param {HTMLElement} element
 * @param {string} selector
 * @param {HTMLElement} context
 * @param {boolean} notSelf
 * @returns {HTMLElement[]}
 * @private
 */
function _getElements(element, selector, context = document.body, notSelf) {
	const elements = getElements(context, selector, true);

	if (notSelf) {
		return elements.filter((item) => item !== element);
	}

	return elements;
}

export { wsTabs };
