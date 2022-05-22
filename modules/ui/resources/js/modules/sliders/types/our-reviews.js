import { Slider } from '../slider';
import { slidersCache } from 'js@/modules/sliders/storage';
import {getElement} from 'js@/utils/get-element';

export default class SliderOurReviews extends Slider {


	get options() {
		return {
			preloadImages: false,
			lazy: true,
			slidesPerView: 1,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
			autoHeight: true,
			navigation: {
				nextEl: getElement(this.element, '.js-slider-next'),
				prevEl: getElement(this.element, '.js-slider-prev')
			}
		};
	}
}
