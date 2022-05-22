/**
 * @param {HTMLElement} el
 * @returns {boolean}
 */
export const isTextarea = (el) => el.tagName.toLowerCase() === 'textarea';

/**
 * @param {HTMLElement} el
 * @returns {boolean}
 */
export const isInput = (el) => el.tagName.toLowerCase() === 'input';

/**
 * @param {HTMLElement} el
 * @returns {boolean}
 */
export const isSelect = (el) => el.tagName.toLowerCase() === 'select';
