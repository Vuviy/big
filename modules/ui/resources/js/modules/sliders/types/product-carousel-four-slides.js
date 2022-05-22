import { Slider } from '../slider';
import { getElement } from 'js@/utils/get-element';

export default class SliderProductCarouselFourSlides extends Slider {
	get options() {
		return {
			preloadImages: false,
			lazy: true,
			slidesPerView: 1,
			spaceBetween: 20,
			navigation: {
				nextEl: getElement(this.element, '.js-slider-next'),
				prevEl: getElement(this.element, '.js-slider-prev')
			},
			breakpoints: {
				320: {
					slidesPerView: 1
				},
				568: {
					slidesPerView: 2
				},
				1024: {
					slidesPerView: 3,
					spaceBetween: 30
				},
				1280: {
					slidesPerView: 4,
					spaceBetween: 63
				}
			}
		};
	}
}
