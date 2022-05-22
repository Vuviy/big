import { googleMapSetup } from './setup';
import { loadGoogleScript } from './utils';
import { MAP_LOAD_CSS_CLASS } from './constants';

/**
 * @param {Element} maps
 */
function init(maps) {
	if (maps.length && !window.google) {
		loadGoogleScript()
			.then((result) => {
				if (result.status) {
					initMaps(maps);
				}
			})
			.catch((e) => {
				console.warn(e);
			});
	} else {
		initMaps(maps);
	}
}

/**
 * @param {Element} maps
 */
function initMaps(maps) {
	maps.map((map, index) => {
		if (map.dataset.mapInit) {
			return true;
		}

		map.classList.add(MAP_LOAD_CSS_CLASS);
		googleMapSetup(map);
	});
}

export { init };
