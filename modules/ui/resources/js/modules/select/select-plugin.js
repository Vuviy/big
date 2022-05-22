import {i18n} from 'js@/i18n';
import {sendSelectValueToLivewire} from 'js@/livewire/utils';

const {select: translations} = i18n;
const defaultOptions = {
	data: null,
	searchable: false
};

class Select {
	constructor(element, options = {}) {
		this.el = element;
		this.config = Object.assign({}, defaultOptions, options);

		this.data = this.config.data;
		this.selectedOptions = [];

		this.placeholder = (this.defaultOption && this.defaultOption.innerText) || '';

		this.dropdown = null;
		this.multiple = this.el.hasAttribute('multiple');
		this.disabled = this.el.hasAttribute('disabled');
		this.label = attr(this.el, 'data-select-label');
		this.extraClass = attr(this.el, 'data-class');

		this._selectFocusedEvent = this._onFocused.bind(this);
		this._dropdownClickedEvent = this._onClicked.bind(this);
		this._dropdownKeyPressedEvent = this._onKeyPressed.bind(this);
		this._dropdownClickedOutsideEvent = this._onClickedOutside.bind(this);
		this._inputSearchChangedEvent = this._onSearchChanged.bind(this);
		this.changeTimer = false;
		this.emptyMessage = this.el.dataset.emptyMessage || '';

		this.create();
	}

	get defaultOption() {
		let option = null;

		const disableOption = this.el.querySelector('option[selected][disabled]');

		if (disableOption) {
			option = disableOption;
		}

		const firstSelected = this.el.querySelector('option[selected]:not(:disabled)');

		if (firstSelected) {
			option = firstSelected;
		}

		return option || this.el.options[0];
	}

	get isSelectedValue() {
		return this.selectedOptions.length;
	}

	create() {
		this.el.classList.add('visually-hidden');

		if (this.data) {
			this.processData(this.data);
		} else {
			this.extractData();
		}

		this.renderHTML();
		this.bindEvents();
	}

	processData(data) {
		const options = [];

		data.forEach((item) => {
			options.push({
				data: item,
				attributes: {
					selected: false,
					disabled: false
				}
			});
		});

		this.options = options;
	}

	extractData() {
		const options = this.el.querySelectorAll('option');
		const data = [];
		const allOptions = [];
		const selectedOptions = [];

		options.forEach((item) => {
			const itemData = {
				text: item.innerText,
				value: item.value
			};
			const attributes = {
				selected: item.selected,
				disabled: attr(item, 'disabled') != null
			};

			data.push(itemData);
			allOptions.push({data: itemData, attributes: attributes});
		});

		this.data = data;
		this.options = allOptions;

		if (this.options.every((option) => !option.attributes.selected)) {
			const firstOption = this.options[0];

			if (firstOption) {
				firstOption.attributes.selected = true;
			}
		}

		this.options.forEach((item) => {
			if (item.attributes.selected && !item.attributes.disabled) {
				selectedOptions.push(item);
			}
		});

		this.selectedOptions = selectedOptions;
	}

	renderHTML() {
		const classes = [
			'select',
			this.disabled ? 'is-disabled' : '',
			this.multiple ? 'has-multiple' : '',
			this.label ? 'select_with-label' : '',
			this.extraClass ? this.extraClass : ''
		];

		const searchHtml = `<div class="select__search">
				<input type="text" class="select__search-input" placeholder="${translations.searchPlaceholder}"/>
			</div>`;

		const tabindex = this.disabled ? null : 0;

		const multipleSelection = this.multiple ? 'select__selection--multiple' : '';

		const searchable = this.config.searchable ? searchHtml : '';

		const labelHtml = this.label ? `<div class="select__label">${this.label}</div>` : '';

		const html = `<div class="${classes.join(' ')}" tabindex="${tabindex}">
				${labelHtml}
				<div class="select__selection ${multipleSelection}"></div>
  				<div class="select__dropdown">
  					${searchable}
  					<ul class="select__list"></ul>
  				</div>
			</div>
		`;

		this.el.insertAdjacentHTML('afterend', html);
		this.dropdown = this.el.nextElementSibling;
		this._renderSelectedItems();
		this._renderItems();
	}

	_renderSelectedItems() {
		if (this.multiple) {
			let selectedHtml = '';

			this.selectedOptions.forEach((item) => {
				selectedHtml += `<span class="select__selection-i">${item.data.text}</span>`;
			});

			selectedHtml = selectedHtml === '' ? this.placeholder : selectedHtml;

			this.dropdown.querySelector('.select__selection').innerHTML = selectedHtml;
		} else {
			const text = this.selectedOptions.length > 0 ? this.selectedOptions[0].data.text : this.placeholder;
			const selection = this.dropdown.querySelector('.select__selection');

			selection.innerHTML = text;
			selection.setAttribute('title', text);
		}
	}

	_renderItems(clear = false) {
		const ul  = this.dropdown.querySelector('ul');

		if(clear) {
			ul.innerHTML = '';
		}

		this.options.forEach((item) => {
			ul.appendChild(this._renderItem(item));
		});
	}

	/**
	 * @param { Object } option
	 * @private
	 */
	_renderItem(option) {
		const el = document.createElement('li');

		el.setAttribute('data-value', option.data.value);

		const classes = [
			'select__option',
			option.attributes.selected ? 'is-selected' : null,
			option.attributes.disabled ? 'is-disabled' : null
		];

		el.classList.add(...classes.filter((cls) => cls));
		el.innerHTML = option.data.text;
		el.addEventListener('click', this._onItemClicked.bind(this, option));
		option.element = el;

		return el;
	}

	update() {
		this.extractData();

		if (this.dropdown) {
			const open = hasClass(this.dropdown, 'is-open');

			this.dropdown.parentNode.removeChild(this.dropdown);
			this.create();

			if (open) {
				triggerClick(this.dropdown);
			}
		}
	}

	disable() {
		if (!this.disabled) {
			this.disabled = true;
			addClass(this.dropdown, 'is-disabled');
		}
	}

	enable() {
		if (this.disabled) {
			this.disabled = false;
			removeClass(this.dropdown, 'is-disabled');
		}
	}

	reset() {
		const classes = ['is-focus', 'is-selected', 'is-disabled'];

		this.selectedOptions = [];

		this.options.forEach((item) => {
			item.element.classList.remove(...classes);

			if (item.attributes.selected) {
				this.selectedOptions.push(item);
				item.element.classList.add('is-selected');
			}
		});

		this._renderSelectedItems();
		this.updateSelectValue();

		triggerChange(this.el);
	}

	destroy() {
		if (this.dropdown) {
			this.unbindEvents();
			this.dropdown.parentNode.removeChild(this.dropdown);
			this.el.classList.remove('visually-hidden');
		}
	}

	bindEvents() {
		this.el.addEventListener('focus', this._selectFocusedEvent, false);
		this.dropdown.addEventListener('click', this._dropdownClickedEvent);
		this.dropdown.addEventListener('keydown', this._dropdownKeyPressedEvent);
		window.addEventListener('click', this._dropdownClickedOutsideEvent);

		if (this.config.searchable) {
			this._bindSearchEvent();
		}
	}

	unbindEvents() {
		this.el.removeEventListener('focus', this._selectFocusedEvent, false);
		this.dropdown.removeEventListener('click', this._dropdownClickedEvent);
		this.dropdown.removeEventListener('keydown', this._dropdownKeyPressedEvent);
		window.removeEventListener('click', this._dropdownClickedOutsideEvent);

		if (this.config.searchable && this.searchInput) {
			this.searchInput.removeEventListener('click', this._preventClick);
			this.searchInput.removeEventListener('input', this._inputSearchChangedEvent);
		}
	}

	/**
	 * @param {MouseEvent} e
	 * @private
	 */
	_preventClick(e) {
		e.stopPropagation();
		e.preventDefault();
	}

	_bindSearchEvent() {
		this.searchInput = this.dropdown.querySelector('.select__search-input');

		if (this.searchInput) {
			this.searchInput.addEventListener('click', this._preventClick);
			this.searchInput.addEventListener('input', this._inputSearchChangedEvent);
		}
	}

	_onFocused() {
		triggerClick(this.dropdown);
		this.dropdown.focus();
	}

	_onClicked() {
		this.dropdown.classList.toggle('is-open');

		if (hasClass(this.dropdown, 'is-open')) {
			if (this.searchInput) {
				this.searchInput.value = '';
				this.searchInput.focus();
			}

			let focusEl = this.dropdown.querySelector('.is-focus');

			removeClass(focusEl, 'is-focus');

			focusEl = this.dropdown.querySelector('.is-selected');

			addClass(focusEl, 'is-focus');

			this.dropdown.querySelectorAll('ul li').forEach((item) => {
				item.style.display = '';
			});
		} else {
			this.dropdown.focus();
		}
	}

	/**
	 * @param { Object } option
	 * @param {MouseEvent} e
	 * @private
	 */
	_onItemClicked(option, e) {
		const optionEl = e.target;

		if (!hasClass(optionEl, 'is-disabled')) {
			if (this.multiple) {
				if (!hasClass(optionEl, 'is-selected')) {
					addClass(optionEl, 'is-selected');
					this.selectedOptions.push(option);
				}
			} else {
				this.selectedOptions.forEach((item) => {
					removeClass(item.element, 'is-selected');
				});

				addClass(optionEl, 'is-selected');
				this.selectedOptions = [option];
			}

			this._renderSelectedItems();
			this.updateSelectValue();
		}
	}

	updateSelectValue() {
		if (this.multiple) {
			this.selectedOptions.forEach((item) => {
				const el = this.el.querySelector('option[value="' + item.data.value + '"]');

				if (el) {
					el.setAttribute('selected', true);
				}
			});
		} else if (this.selectedOptions.length > 0) {
			this.el.value = this.selectedOptions[0].data.value;
		} else {
			this.el.selectedIndex = this.defaultOption.index || 0;
			this.el.value = this.defaultOption.value || this.defaultOption.innerText;
		}

		triggerChange(this.el);
	}

	/**
	 * @param {MouseEvent} e
	 * @private
	 */
	_onClickedOutside(e) {
		if (!this.dropdown.contains(e.target)) {
			this.dropdown.classList.remove('is-open');
		}
	}

	/**
	 * @param {MouseEvent} e
	 * @private
	 */
	_onKeyPressed(e) {
		const focusedOption = this.dropdown.querySelector('.is-focus');
		const open = this.dropdown.classList.contains('is-open');

		// Enter
		if (e.keyCode === 13) {
			if (open) {
				triggerClick(focusedOption);
			} else {
				triggerClick(this.dropdown);
			}
		} else if (e.keyCode === 40) {
			// Down
			if (!open) {
				triggerClick(this.dropdown);
			} else {
				const next = this._findNext(focusedOption);

				if (next) {
					const t = this.dropdown.querySelector('.is-focus');

					removeClass(t, 'is-focus');
					addClass(next, 'is-focus');
				}
			}
			e.preventDefault();
		} else if (e.keyCode === 38) {
			// Up
			if (!open) {
				triggerClick(this.dropdown);
			} else {
				const prev = this._findPrev(focusedOption);

				if (prev) {
					const t = this.dropdown.querySelector('.is-focus');

					removeClass(t, 'is-focus');
					addClass(prev, 'is-focus');
				}
			}
			e.preventDefault();
		} else if (e.keyCode === 27 && open) {
			// Esc
			triggerClick(this.dropdown);
		}

		return false;
	}

	/**
	 * @param {HTMLElement} el
	 * @private
	 */
	_findNext(el) {
		if (el) {
			el = el.nextElementSibling;
		} else {
			el = this.dropdown.querySelector('.select__option');
		}

		while (el) {
			if (!hasClass(el, 'is-disabled') && el.style.display !== 'none') {
				return el;
			}

			el = el.nextElementSibling;
		}

		return null;
	}

	/**
	 * @param {HTMLElement} el
	 * @private
	 */
	_findPrev(el) {
		if (el) {
			el = el.previousElementSibling;
		} else {
			el = this.dropdown.querySelector('.select__option:last-child');
		}

		while (el) {
			if (!hasClass(el, 'is-disabled') && el.style.display !== 'none') {
				return el;
			}

			el = el.previousElementSibling;
		}

		return null;
	}

	/**
	 * @param {MouseEvent} e
	 * @private
	 */
	_onSearchChanged(e) {
		const open = this.dropdown.classList.contains('is-open');
		let text = e.target.value;

		if (this.el.dataset.ajaxSearch && this.el.dataset.url) {
			if (text.length >= 3) {
				if (this.changeTimer !== false) clearTimeout(this.changeTimer);
				this.changeTimer = setTimeout(() => {
					let url = new URL(this.el.dataset.url);
					url.searchParams.append('query', text);
					fetch(url, {
						method: 'get'
					}).then(
						response => response.text()
					).then(
						(response) => {
							if (JSON.parse(response)) {
								response = JSON.parse(response);
								this.el.innerHTML = '';
								let options = '';
								if (response.cities.length > 0) {
									for (let city of response.cities) {
										options += `<option value="${city.id}">${city.text}</option>`;
									}
								} else {
									options = `<option selected disabled value="">${this.emptyMessage}</option>`;
								}
								this.el.innerHTML = options;
								this.extractData();
								this._renderSelectedItems();
								this._renderItems(true);
							}
						}
					)
					this.changeTimer = false;
				}, 300);
			}
		} else {
			text = text.toLowerCase();

			if (text === '') {
				this.options.forEach((item) => {
					item.element.style.display = '';
				});
			} else if (open) {
				const matchReg = new RegExp(text);

				this.options.forEach((item) => {
					const optionText = item.data.text.toLowerCase();
					const matched = matchReg.test(optionText);

					item.element.style.display = matched ? '' : 'none';
				});
			}
		}

		this.dropdown.querySelectorAll('.is-focus').forEach((item) => {
			removeClass(item, 'is-focus');
		});

		const firstEl = this._findNext(null);

		addClass(firstEl, 'is-focus');
	}
}

export { Select };

// TODO review
// utils
function triggerClick(el) {
	const event = document.createEvent('MouseEvents');
	event.initEvent('click', true, false);
	el.dispatchEvent(event);
}

function triggerChange(el) {
	const event = document.createEvent('HTMLEvents');
	event.initEvent('change', true, false);
	el.dispatchEvent(event);
}

function attr(el, key) {
	return el.getAttribute(key);
}

function hasClass(el, className) {
	if (el) return el.classList.contains(className);
	else return false;
}

function addClass(el, className) {
	if (el) return el.classList.add(className);
}

function removeClass(el, className) {
	if (el) return el.classList.remove(className);
}
