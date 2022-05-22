import Swiper, { Lazy, Navigation, Pagination, Thumbs, EffectFade } from 'swiper';
import { HOOKS } from 'js@/livewire/constants';
import { getElement } from 'js@/utils/get-element';
import { getElements } from 'js@/utils/get-elements';
import { getSliderClassName } from 'js@/modules/sliders/utils';
import { slidersCache } from './storage';
import { subscribeHook } from 'js@/livewire/utils';
import(/* webpackChunkName: "swiper.min" */ 'swiper/swiper.min.css');
import(/* webpackChunkName: "swiper.lazy" */ 'swiper/components/lazy/lazy.min.css');
import(/* webpackChunkName: "swiper.navigation" */ 'swiper/components/navigation/navigation.min.css');
import(/* webpackChunkName: "swiper.pagination" */ 'swiper/components/pagination/pagination.min.css');
import(/* webpackChunkName: "swiper.fade" */ 'swiper/components/effect-fade/effect-fade.min.css');

Swiper.use([Lazy, Navigation, Pagination, Thumbs, EffectFade]);

class Slider {
	/** @param {HTMLElement} element */
	constructor(element) {
		this.element = element;
		this.selector = '.swiper-container';
		this.swiper = null;
	}

	main() {
		this.swiper = new Swiper(this.element.querySelector(this.selector), this.options);

		slidersCache[getSliderClassName(this.element.dataset.slider)] = this.swiper;

		this.events();

		subscribeHook(this.element, HOOKS.messageProcessed, () => {
			this.update();
		});
	}

	get options() {
		return {};
	}

	events() {}

	get slidesCount() {
		return getElements(this.element, '.swiper-slide').length;
	}

	hoverStopAutoplay() {
		if (this.swiper) {
			this.swiper.$el.on('mouseenter', () => {
				this.swiper.autoplay.stop();
			});
			this.swiper.$el.on('mouseleave', () => {
				this.swiper.autoplay.start();
			});
		}
	}

	update() {
		if (this.swiper) {
			this.swiper.update();
			this.swiper.navigation.update();
			this.swiper.pagination.update();
		}
	}
}

export { Swiper, Slider };
