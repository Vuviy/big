import { Slider } from '../slider';
import { slidersCache } from '../storage';
import { getElement } from 'js@/utils/get-element';

export default class SliderExample extends Slider {
	get options() {
		return {
			simulateTouch: false,
			lazy: {
				loadOnTransitionStart: true
			},
			thumbs: {
				swiper: slidersCache.SliderMainThumbs
			},
			navigation: {
				nextEl: getElement(this.element, '.js-button-next'),
				prevEl: getElement(this.element, '.js-button-prev')
			},
			pagination: {
				el: '.swiper-pagination'
			}
		};
	}
}
