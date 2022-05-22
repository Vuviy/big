import { Slider } from '../slider';
import { getElement } from 'js@/utils/get-element';

export default class SliderProductCarouselFiveSlides extends Slider {
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
				480: {
					slidesPerView: 2
				},
				768: {
					slidesPerView: 3,
					spaceBetween: 30
				},
				1024: {
					slidesPerView: 4
				},
				1280: {
					slidesPerView: 5,
					spaceBetween: 42
				}
			}
		};
	}
}
