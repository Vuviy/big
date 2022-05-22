import { wrapInit } from 'js@/utils/wrap-init';
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

function init(element) {
	const config = element.dataset.tippy ?? {};
	if (element._tippy) {
		element._tippy.destroy();
	}
	tippy(
		element,
		Object.assign(
			{},
			{
				content(reference) {
					const id = reference.getAttribute('data-template');
					const template = document.getElementById(id);
					return template.innerHTML;
				},
				allowHTML: !!element.dataset.template
				// trigger: 'click'
			},
			config
		)
	);
}

/**
 * @param {Array} elements
 */
export default (elements) => {
	wrapInit(elements, init);
};
