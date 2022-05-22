/**
 * Return element height including margins
 * @param {HTMLElement} el
 * @returns {number}
 */
export const getOuterHeight = (el) => {
	const styles = window.getComputedStyle(el);
	const margin = parseFloat(styles.marginTop) + parseFloat(styles.marginBottom);

	return Math.ceil(el.offsetHeight + margin);
};
