import { dashToCapWords } from 'js@/utils/dash-to-cap-words';

/**
 * @param {String|undefined|null} dashName
 */
export const getSliderClassName = (dashName) => {
	return `Slider${dashToCapWords(dashName)}`;
};
