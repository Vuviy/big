import { inputMask } from 'js@/modules/input-mask/input-mask';
import { wrapInit } from 'js@/utils/wrap-init';

/**
 * @param {Array} elements
 */
export default (elements) => {
	wrapInit(elements, inputMask);
};
