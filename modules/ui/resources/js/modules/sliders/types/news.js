import { Slider } from '../slider';
import { getElement } from 'js@/utils/get-element';

const toggleSlider = (swiper) => {
	if (window.innerWidth >= 768) {
		swiper.enable();
	} else {
		swiper.disable();
	}
};

export default class SliderNews extends Slider {
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
					slidesPerView: 1,
					spaceBetween: 15
				},
				480: {
					slidesPerView: 2,
					spaceBetween: 20
				},
				768: {
					slidesPerView: 3,
					spaceBetween: 30,
				},
				1024: {
					slidesPerView: 4
				},
				1280: {
					slidesPerView: 5,
					spaceBetween: 0
				}
			},
			on: {
				afterInit: (swiper) => {
					toggleSlider(swiper);
				},
				resize: (swiper) => {
					toggleSlider(swiper);
				},
			}
		};
	}
}
