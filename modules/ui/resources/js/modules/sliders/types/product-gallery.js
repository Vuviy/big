import { Slider } from '../slider';
import { slidersCache } from 'js@/modules/sliders/storage';

export default class SliderProductGallery extends Slider {
	get options() {
		return {
			lazy: {
				loadOnTransitionStart: true
			},
			effect: 'fade',
			slidesPerView: 1,
			watchOverflow: true,
			spaceBetween: 0,
			fadeEffect: {
				crossFade: true
			},
			thumbs: {
				swiper: slidersCache.SliderProductGalleryThumbs
			},
			navigation: {
				nextEl: slidersCache.SliderProductGalleryThumbs.navigation.nextEl,
				prevEl: slidersCache.SliderProductGalleryThumbs.navigation.prevEl
			},
			on: {
				afterInit: (swiper) => {
					setTimeout(() => {
						swiper.update();
					}, 1000);
				}
			}
		};
	}
}
