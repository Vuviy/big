export const sweetAlertGeneralOptions = {};

/**
 * @param {SweetAlertOptions} options
 */
export const mergeSweetAlertOptions = (options) => {
	return Object.assign({}, sweetAlertGeneralOptions, options);
};
