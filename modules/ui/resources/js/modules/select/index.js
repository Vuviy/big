import { select } from 'js@/modules/select/select';
import { wrapInit } from 'js@/utils/wrap-init';

/**
 * @param {Array} elements
 */
export default (elements) => {
	wrapInit(elements, select);
};
