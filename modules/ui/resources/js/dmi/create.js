import arrayFrom from 'js@/var/array-from';
import isArray from 'js@/var/is-array';
import { addClass, removeClass } from 'js@/utils/classes';
import { dispatch } from 'js@/utils/dispatch';
import { getElements } from 'js@/utils/get-elements';

/**
 * @param {DMIOptions.modules} modules
 * @param {DMIOptions.selector} selector
 * @param {DMIOptions.debug} debug
 * @param {DMIOptions.pendingCssClass} pendingCssClass
 * @param {DMIOptions.loadedCssClass} loadedCssClass
 * @param {DMIOptions.errorCssClass} errorCssClass
 * @returns {DynamicModulesImport}
 */
export const create = ({ modules, selector, debug, pendingCssClass, loadedCssClass, errorCssClass }) => {
	const cache = new Set();

	/**
	 * @param {string} message
	 */
	const log = (message) => {
		if (debug) {
			console.log('[DMI]: ' + message);
		}
	};

	/**
	 * @param {HTMLElement} container
	 * @returns {HTMLElement|NodeList}
	 */
	const getNodeList = (container) => {
		const elements = container.matches(selector) ? container : getElements(container, selector);

		if (elements.length === 0) {
			log(`No import elements with selector "${selector}"`);
		}

		return elements;
	};

	/**
	 * @param {string} moduleName
	 * @param {string} message
	 * @returns {Promise<void>}
	 */
	const resolveWithErrors = (moduleName, message) => {
		console.warn(`[DMI]: Module "${moduleName}" resolved width errors!!!`);
		console.error(message);

		return Promise.resolve();
	};

	/**
	 * @param {HTMLElement[]} elements
	 * @param {DMIModuleStats} stats
	 * @returns {Promise<void>}
	 */
	const markAsPending = (elements, stats) => {
		removeClass(elements, [DMI.loadedEvent, DMI.errorCssClass]);
		addClass(elements, DMI.pendingCssClass);
		dispatch(elements, DMI.pendingEvent, { stats });
	};

	/**
	 * @param {HTMLElement[]} elements
	 * @param {DMIModuleStats} stats
	 * @returns {Promise<void>}
	 */
	const markAsLoaded = (elements, stats) => {
		removeClass(elements, [DMI.pendingCssClass, DMI.errorCssClass]);
		addClass(elements, DMI.loadedCssClass);
		dispatch(elements, DMI.loadedEvent, { stats });
	};

	/**
	 * @param {HTMLElement[]} elements
	 * @param {DMIModuleStats} stats
	 * @returns {Promise<void>}
	 */
	const markAsError = (elements, stats) => {
		removeClass(elements, [DMI.pendingCssClass, DMI.loadedCssClass]);
		addClass(elements, DMI.errorCssClass);
		dispatch(elements, DMI.errorEvent, { stats });
	};

	/**
	 * @param {string} moduleName
	 * @param {HTMLElement[]} elements
	 * @param {HTMLElement} container
	 * @param {DMIImportCondition} useImportCondition
	 * @returns {Promise<void>|*}
	 */
	const importFn = (moduleName, elements, container, useImportCondition) => {
		if (!modules.hasOwnProperty(moduleName)) {
			return resolveWithErrors(moduleName, `Undefined moduleName "${moduleName}"`);
		}

		elements = isArray(elements) ? elements : arrayFrom(elements);

		const module = modules[moduleName];
		const moduleElements =
			typeof module.filter === 'function'
				? elements.filter(module.filter)
				: elements.filter((element) => element.matches(module.filter));

		if (moduleElements.length === 0) {
			return Promise.resolve();
		}

		const stats = { moduleName };

		if (useImportCondition && !cache.has(moduleName) && typeof module.importCondition === 'function') {
			const allowed = module.importCondition(moduleElements, container, stats);

			if (allowed !== true) {
				log(`module "${moduleName}" skipped by ".importCondition()"`);

				return Promise.resolve();
			}
		}

		cache.add(moduleName);
		markAsPending(moduleElements, stats);

		return module
			.importFn(stats)
			.then(({ default: _default }) => {
				if (typeof _default !== 'function') {
					markAsError(moduleElements, stats);

					return resolveWithErrors(
						moduleName,
						`imported module "${moduleName}" - must export default method`
					);
				}

				markAsLoaded(moduleElements, stats);
				log(`module "${moduleName}" is loaded`);
				_default(moduleElements);

				return Promise.resolve();
			})
			.catch((err) => {
				return resolveWithErrors(moduleName, err);
			});
	};

	const DMI = {
		get modules() {
			return modules;
		},

		get debug() {
			return debug === true;
		},

		get selector() {
			return selector;
		},

		get pendingCssClass() {
			return pendingCssClass || '_dmi-is-pending';
		},

		get pendingEvent() {
			return 'dmi:pending';
		},

		get loadedCssClass() {
			return loadedCssClass || '_dmi-is-loaded';
		},

		get loadedEvent() {
			return 'dmi:loaded';
		},

		get errorCssClass() {
			return errorCssClass || '_dmi-has-error';
		},

		get errorEvent() {
			return 'dmi:error';
		},

		/**
		 * @param {string} moduleName
		 * @param {HTMLElement} container
		 * @param {DMIImportCondition} ignoreImportCondition
		 * @returns {Promise<void>|*}
		 */
		importModule(moduleName, container = document.body, ignoreImportCondition) {
			const elements = getNodeList(container);

			if (elements.length === 0) {
				log('No elements');

				return Promise.resolve();
			}

			return importFn(moduleName, elements, container, ignoreImportCondition !== true);
		},

		/**
		 * @param {HTMLElement} container
		 * @param {Boolean} awaitAll
		 * @param {DMIImportCondition} ignoreImportCondition
		 * @returns {Promise<void>|Promise<void[]>}
		 */
		importAll(container = document.body, awaitAll = false, ignoreImportCondition) {
			const elements = getNodeList(container);

			if (elements.length === 0) {
				log('No elements');

				return Promise.resolve();
			}

			const _getAll = () =>
				Object.keys(modules).map((moduleName) =>
					importFn(moduleName, elements, container, ignoreImportCondition !== true)
				);

			if (awaitAll) {
				return Promise.all(_getAll());
			} else {
				_getAll();
				return Promise.resolve();
			}
		}
	};

	DMI.importModule.bind(DMI);

	return DMI;
};
