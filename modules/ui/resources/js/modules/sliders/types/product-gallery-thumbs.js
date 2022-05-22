import { Slider } from '../slider';
import { getElement } from 'js@/utils/get-element';

export default class SliderProductGalleryThumbs extends Slider {
	get options() {
		return {
			direction: 'vertical',
			preloadImages: false,
			allowTouchMove: false,
			lazy: {
				threshold: 50,
				loadPrevNext: true,
				loadPrevNextAmount: 6
			},
			slidesPerView: 3,
			spaceBetween: 10,
			watchSlidesVisibility: true,
			navigation: {
				nextEl: getElement(this.element, '.js-slider-next'),
				prevEl: getElement(this.element, '.js-slider-prev'),
				disabledClass: 'swiper-button-hidden'
			},
			breakpoints: {
				0: {
					direction: 'horizontal',
					slidesPerView: 3,
				},
				480: {
					direction: 'horizontal',
					slidesPerView: 4,
				},
				568: {
					direction: 'horizontal',
					slidesPerView: 6,
				},
				768: {
					direction: 'horizontal',
					slidesPerView: 8,
				},
				1024: {
					direction: 'vertical',
					slidesPerView: 5,
					spaceBetween: 10,
					allowTouchMove: true,
				},
			}
		};
	}
}
