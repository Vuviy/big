import inView from 'in-view/dist/in-view.min';
import { DMI_SELECTOR } from 'js@/dmi/constants';
import { create } from './create';

//config imports

import configTippy from 'js@/modules/tooltip/config';
import configDelivery from 'js@/modules/delivery/config';

function importConditionInView(elements, container, stats) {
	inView(this.filter).on('enter', () => {
		DMI.importModule(stats.moduleName, container, true);
	});

	return false;
}

export const DMI = create({
	selector: DMI_SELECTOR,
	debug: true,
	modules: {
		sliders: {
			filter: '[data-slider]',
			importFn: () => import('js@/modules/sliders'),
			// importCondition: importConditionInView
		},
		googleMap: {
			filter: '[data-gmap]',
			importFn: () => import('js@/modules/google-map/google-map-import')
		},
		inputMask: {
			filter: '.js-input-mask',
			importFn: () => import('js@/modules/input-mask'),
			importCondition: importConditionInView
		},
		tippy: {
			filter: configTippy.filterSelector,
			importFn: () => import('js@/modules/tooltip'),
			importCondition: importConditionInView
		},
		select: {
			filter: '.js-select',
			importFn: () => import('../modules/select')
		},
		catalog: {
			filter: '.js-catalog',
			importFn: () => import('../modules/catalog')
		},
		valueCheck: {
			filter: 'form',
			importFn: () => import('../modules/value-check')
		},
		delivery: {
			filter: configDelivery.filterSelector,
			importFn: () => import('../modules/delivery')
		},
	}
});
