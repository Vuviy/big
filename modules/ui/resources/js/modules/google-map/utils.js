import { JSONParse } from 'js@/utils/json-parse';

export function loadGoogleScript() {
	const config = window.app.maps;

	return new Promise(function (resolve, reject) {
		if (window.google) {
			resolve({ status: true });
			return null;
		}

		const query = [];
		const configQueries = config.query;

		for (const key in configQueries) {
			if (configQueries.hasOwnProperty(key)) {
				query.push(key + '=' + configQueries[key]);
			}
		}

		const src = config.source + '?' + query.join('&');
		const script = document.createElement('script');

		script.onload = () => {
			resolve({ status: true });
		};

		script.onerror = (e) => {
			reject(new Error('Request failed: ' + e));
		};

		script.src = src;
		document.body.appendChild(script);
	});
}

export const mapUtils = (() => {
	return {
		/**
		 * Get json from script application/json
		 * @param mapElement
		 * @param selector
		 * @returns {*}
		 */
		getDataJson(mapElement, selector) {
			let dataElement = mapElement.querySelector(selector || '[data-gmap-data]');
			if (!dataElement) {
				const id = mapElement.dataset.gmapId;
				dataElement = document.body.querySelector(
					selector || `[data-gmap-data${id ? '="' + id + '"' : ''}]`
				);
			}
			return dataElement ? JSONParse(dataElement.innerHTML) : null;
		},
		/**
		 * Get dom node element for mapping google map
		 * @param mapElement
		 * @param selector
		 * @returns {*|Element}
		 */
		getDisplayElement(mapElement, selector) {
			return mapElement.querySelector(selector || '[data-gmap-display]');
		},
		/**
		 * @param mapElement
		 * @param settings
		 * @returns {*}
		 */
		extendOptions(mapElement, ...settings) {
			const options = JSONParse(mapElement.dataset.options) || {};
			return Object.assign({}, ...settings, options);
		}
	};
})();
