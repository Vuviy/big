'use strict';

/**
 * @module initEach
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 1.0.0
 */

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {Function} AbstractClass
 * @param {Object} factory
 * @param {jQuery|Element} container
 * @param {Object} data
 * @private
 */
export default function createNewFactory(AbstractClass, factory, container, data = {}) {
	const { Factory, settings: clientSettings = {}, props: clientProps = {} } = data;

	if (Factory in factory) {
		return new factory[Factory](container, clientSettings, clientProps);
	} else {
		return new AbstractClass(container, clientSettings, clientProps);
	}
}
