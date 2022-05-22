import { Slider } from '../slider';
import { getElement } from 'js@/utils/get-element';

export default class SliderOurHistoryYears extends Slider {
	update() {
		super.update();
	}

	get options() {
		return {
			preloadImages: false,
			lazy: true,
			slidesPerView: 1,
			navigation: {
				nextEl: getElement(this.element, '.js-slider-next'),
				prevEl: getElement(this.element, '.js-slider-prev')
			},
			breakpoints: {
				1280: {
					slidesPerView: 5
				},
				1024: {
					slidesPerView: 4
				},
				768: {
					slidesPerView: 3
				},
				640: {
					slidesPerView: 2
				}
			},
			on: {
				init: (swiper) => {
					setTimeout(function () {
						swiper.update();
					}, 200);
				}
			}
		};
	}
}
