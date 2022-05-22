import { Slider } from '../slider';
import { slidersCache } from 'js@/modules/sliders/storage';

export default class SliderOurHistory extends Slider {
	get options() {

		return {
			preloadImages: false,
			lazy: true,
			slidesPerView: 1,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
			autoHeight: true,
			thumbs: {
				swiper: slidersCache.SliderOurHistoryYears
			},
			navigation: {
				nextEl: slidersCache.SliderOurHistoryYears.navigation.nextEl,
				prevEl: slidersCache.SliderOurHistoryYears.navigation.prevEl
			},
		};
	}
}
