import { getElements } from 'js@/utils/get-elements';

/**
 * @param {String} html
 */
export const updateLanguageSwitchers = (html) => {
	const languageSwitchers = getElements(document, '.js-language-switch');

	if (languageSwitchers.length) {
		languageSwitchers.forEach((switcher) => {
			switcher.innerHTML = html;
		});
	}
};
