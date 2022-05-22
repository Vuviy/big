import arrayFrom from 'js@/var/array-from';

/**
 * @param {HTMLCollection|HTMLElement[]} elements
 * @returns {Array}
 */
export const serializeArray = (elements) => {
	return elements
		.filter((field) => {
			switch (field.type) {
				case 'checkbox':
				case 'radio':
					return field.checked;
				case 'select-one':
					return arrayFrom(field.options).find((option) => {
						return (
							option.selected && !option.disabled && option.hasAttribute('value') && Boolean(option.value)
						);
					});
				default:
					return field.value !== '';
			}
		})
		.reduce((result, element) => {
			result.push({
				name: element.name,
				value: element.value
			});
			return result;
		}, []);
};
