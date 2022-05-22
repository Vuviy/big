import isArray from 'js@/var/is-array';
import { JSONParse } from 'js@/utils/json-parse';
import { serializeArray } from 'js@/utils/serialize-array';
import { sortFromTo } from 'js@/modules/catalog/utils';
import { getElements } from 'js@/utils/get-elements';

const SPEC_DELIMITER = ';';
const KEY_VAL_DELIMITER = '=';
const VALUES_DELIMITER = ',';
const URL_PREFIX = '/filter/';

class Filter {
	constructor(element) {
		this.filter = element;
		this.fields = getElements(element, 'input[name]:not(.js-ignore), select[name]:not(.js-ignore)', true);
		this.valuesByDefault = this.getDefaultValues();
		this.elementsGetParams = {};
	}

	setElementForGETParameters(element) {
		if (element) {
			this.elementsGetParams[element.name] = element;
		}
	}

	getDefaultValues() {
		const result = {};

		this.fields.forEach((elem) => {
			if (elem.dataset.defaultValue) {
				result[elem.name] = elem.dataset.defaultValue;
			}
		});

		return result;
	}

	getParamsFromFields() {
        const extraData = this.getExtraParams();

        let data = sortFromTo(serializeArray(this.fields));

		if (Object.keys(this.valuesByDefault).length) {
			data = data.filter((elem) => {
				return elem.value !== this.valuesByDefault[elem.name];
			});
		}

		if (Object.keys(extraData).length) {
			for (const key in extraData) {
				if (extraData.hasOwnProperty(key)) {
					if (isArray(extraData[key])) {
						extraData[key].forEach((value) => {
							data.push({
								name: key,
								value: value
							});
						});
					} else {
						data.push({
							name: key,
							value: extraData[key]
						});
					}
				}
			}
		}

		data.sort((a, b) => {
			if (a.name > b.name) return 1;
			if (a.name < b.name) return -1;
			return 0;
		});

		const values = {};
		let temp = null;

		for (let i = 0; i < data.length; i++) {
			const prop = data[i];

			if (prop.value === '') {
				continue;
			}

			if (prop.name !== temp) {
				temp = prop.name;
				values[prop.name] = [prop.value];
			} else {
				values[prop.name].push(prop.value);
			}
		}

		Object.keys(values).forEach((value) => {
			values[value] = values[value].sort();
		});

		return values;
	}

	getExtraParams() {
		return JSONParse(this.filter.dataset.extraParams, {});
	}

	getParamsFromUrl() {
		let values = window.location.href.split(URL_PREFIX)[1];
		const result = {};

		if (values) {
			values = values.split('?')[0];

			if (values && values.length) {
				values.split(SPEC_DELIMITER).forEach((str) => {
					str = str.split(KEY_VAL_DELIMITER);
					result[str[0]] = str[1].split(VALUES_DELIMITER);
				});
			}
		}

		return result;
	}
    //todo не удалять логирование
	makeUrl(fromUrl) {
        console.group('makeUrl()');
        let url = '';
        let values = {};
        let valuesFromUrl = {};
        let currentParams = window.location.pathname.split('filter/');
        console.log('currentParams after splitting by "filter/":' + currentParams);
        if (currentParams.join() !== window.location.pathname) {
            currentParams = currentParams[currentParams.length - 1];
            console.log('currentParams after getting only query string:' + currentParams);
			currentParams = currentParams.split(';');
			console.group('List of parameters from URL:')
			currentParams.forEach(function(el) {
				el = el.split('=');
				console.log(el[0] + ':' + el[1]);
				valuesFromUrl[el[0]] = [el[1]];
			});
			console.groupEnd();
		}

		if (!fromUrl) {
			values = this.getParamsFromFields();
        } else {
			if (this.applied) {
				values = this.getParamsFromUrl();
			}
		}
		if (valuesFromUrl.hasOwnProperty('category')) {
		    console.info('URL has "category" parameter');
			values.category = valuesFromUrl.category;
		}

        if (valuesFromUrl.hasOwnProperty('tag')) {
            console.info('URL has "tag" parameter');
            values.tag = valuesFromUrl.tag;
        }

		const keysValues = Object.keys(values);

		if (keysValues.length) {
			keysValues.forEach((value, index) => {
				url += value + KEY_VAL_DELIMITER + values[value].join(VALUES_DELIMITER);
				url += index !== keysValues.length - 1 ? SPEC_DELIMITER : '';
			});
		}
        console.log('URL params as result:' + url);
        console.groupEnd();
        return this.addGETParams(url);
	}

	searchGETParams() {
		return JSONParse(this.filter.dataset.searchParams, {});
	}

	addGETParams(url = '') {
		const params = [];

		if (Object.keys(this.elementsGetParams).length) {
			for (const key in this.elementsGetParams) {
				if (this.elementsGetParams.hasOwnProperty(key)) {
					const element = this.elementsGetParams[key];

					switch (element.tagName.toLowerCase()) {
						case 'select': {
							const selectedOption = element.options[element.selectedIndex];

							if (selectedOption.value) {
								params.push({
									key: element.name.toLowerCase(),
									value: selectedOption.value.toLowerCase()
								});
							}

							break;
						}
						case 'input': {
							const value = element.value.toLowerCase();

							if (value) {
								params.push({
									key: element.name.toLowerCase(),
									value: value.toLowerCase()
								});
							}

							break;
						}
						default: {
							break;
						}
					}
				}
			}
		}

		const searchGETParams = this.searchGETParams();

		if (Object.keys(searchGETParams).length) {
			for (const key in searchGETParams) {
				if (searchGETParams.hasOwnProperty(key)) {
					params.push({
						key,
						value: searchGETParams[key]
					});
				}
			}
		}

		if (params.length) {
			url += /\?/.test(url) ? '' : '?';
			params.forEach((param) => {
				url += param.key.toLowerCase() + '=' + param.value.toLowerCase() + '&';
			});
			url = url.substr(0, url.length - 1);
		}

		return url;
	}

	getUrl(fromUrl = false) {
		const query = this.makeUrl(fromUrl);
		const dataset = this.filter.dataset;
		console.log(fromUrl, URL_PREFIX, query, dataset);

		if (query.split('?')[0].length) {
			return dataset.route + URL_PREFIX + query;
		} else {
			return dataset.route + query;
		}
	}

	get applied() {
		return window.location.href.includes(URL_PREFIX);
	}
}

export { Filter };
