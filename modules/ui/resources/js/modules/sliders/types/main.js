import { Slider } from '../slider';
import { getElement } from 'js@/utils/get-element';

export default class SliderMain extends Slider {
	get options() {
		return {
			preloadImages: true,
			lazy: true,
			navigation: {
				nextEl: getElement(this.element, '.js-button-next'),
				prevEl: getElement(this.element, '.js-button-prev')
			},
			pagination: {
				el: '.slider-pagination',
				clickable: true
			}
		};
	}
}
