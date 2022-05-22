import { catalog } from './catalog';
import { wrapInit } from 'js@/utils/wrap-init';

/**
 * @param {Array} elements
 */
export default (elements) => {
	wrapInit(elements, catalog);
};
