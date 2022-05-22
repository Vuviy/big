import './styles/nouislider.scss';
import noUiSlider from 'nouislider';
import { dispatch } from 'js@/utils/dispatch';
import { getElement } from 'js@/utils/get-element';

const selectors = {
	slider: '.js-range-slider',
	inputFrom: '.js-range-from',
	inputTo: '.js-range-to'
};

class PriceRange {
	constructor(element) {
		if (!element) {
			return;
		}

		this.element = getElement(element, selectors.slider);
		this.inputFrom = getElement(element, selectors.inputFrom);
		this.inputTo = getElement(element, selectors.inputTo);

		this.paramMin = +this.element.dataset.min;
		this.paramMax = +this.element.dataset.max;
		this.paramFrom = +this.element.dataset.from;
		this.paramTo = +this.element.dataset.to;

		this.options = {
			start: [this.paramFrom, this.paramTo],
			connect: true,
			range: {
				min: this.paramMin,
				max: this.paramMax
			}
		};

		this.handlerInputFrom = this.eventInputFrom.bind(this);
		this.handlerInputTo = this.eventInputTo.bind(this);

		if (this.element.dataset.init) {
			return;
		}

		this.element.dataset.init = true;
		this.checkMinMaxSame();
		this.noUiSlider = noUiSlider.create(this.element, this.options);
		this.events();
	}

	checkMinMaxSame() {
		if (this.paramMin === this.paramMax) {
			this.options.range.max = 0;
			this.element.setAttribute('disabled', true);
		}
	}

	destroy() {
		if (!this.element) {
			return;
		}

		this.noUiSlider.off('update');
		this.noUiSlider.off('change');
		this.inputFrom.removeEventListener('change', this.handlerInputFrom);
		this.inputTo.removeEventListener('change', this.handlerInputTo);
	}

	eventInputFrom() {
		let value = parseInt(this.inputFrom.value);

		if (isNaN(value) || value < this.paramMin) {
			value = this.paramMin;
		} else if (value > this.paramTo) {
			value = this.paramTo;
		}

		this.inputFrom.value = value;
		this.noUiSlider.set([value, null]);
	}

	eventInputTo() {
		let value = parseInt(this.inputTo.value);

		if (isNaN(value) || value > this.paramMax) {
			value = this.paramMax;
		} else if (value < this.paramFrom) {
			value = this.paramFrom;
		}

		this.inputTo.value = value;
		this.noUiSlider.set([null, value]);
	}

	events() {
		let prevFrom = this.paramFrom;
		let prevTo = this.paramTo;

		this.noUiSlider.on('update', (values) => {
			let [from, to] = values;

			from = parseInt(from);
			to = parseInt(to);

			this.paramFrom = from;
			this.paramTo = to;
			this.inputFrom.value = from;
			this.inputTo.value = to;
		});

		this.noUiSlider.on('change', (values) => {
			let [from, to] = values;

			from = parseInt(from);
			to = parseInt(to);

			if (prevFrom === from && prevTo === to) {
				return false;
			}

			prevFrom = from;
			prevTo = to;

			dispatch(window, 'change.range');
		});

		this.inputFrom.addEventListener('change', this.handlerInputFrom, false);
		this.inputTo.addEventListener('change', this.handlerInputTo, false);
	}
}

export { PriceRange };
