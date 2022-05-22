import { addClass, removeClass } from 'js@/utils/classes';
import { delay } from 'js@/utils/delay';
import { getElement } from 'js@/utils/get-element';

const config = {
	mainClass: 'preloader',
	showClass: 'preloader--show',
	hideClass: 'preloader--hide',
	removeDelay: 300,
	markup: '<div class="preloader__block"></div>'
};

class Preloader {
	/**
	 * @param {HTMLElement} element
	 * @param {Object} userConfig
	 */
	constructor(element, userConfig = {}) {
		if (!element) {
			this.empty = true;

			return this;
		}

		if (element.__preloader instanceof Preloader) {
			delete element.__preloader;
		}

		this.element = element;
		this.config = Object.assign({}, config, userConfig);
		this.element.__preloader = this;
		this.empty = false;
		this.timer = null;
	}

	/**
	 * @param {String} place - beforebegin, afterbegin, beforeend, afterend
	 */
	show(place = 'beforeend') {
		if (this.empty) {
			console.warn('Empty preloader cannot be shown!');
			return false;
		}

		const { mainClass, showClass, markup } = this.config;

		addClass(this.element, mainClass);

		this.element.insertAdjacentHTML(place, markup);

		delay(10).then(() => addClass(this.element, showClass));
	}

	/**
	 * @param {Boolean} removeMarkup
	 */
	hide(removeMarkup = true) {
		if (this.empty) {
			console.warn('Empty preloader cannot be hidden!');
			return false;
		}

		const { mainClass, showClass, hideClass } = this.config;

		addClass(this.element, hideClass);

		clearTimeout(this.timer);

		this.timer = setTimeout(() => {
			if (removeMarkup) {
				const preloader = getElement(this.element, '.preloader__block');

				if (preloader) {
					this.element.removeChild(preloader);
				}
			}

			removeClass(this.element, [mainClass, showClass, hideClass]);
		}, this.config.removeDelay);
	}
}

export { Preloader };
