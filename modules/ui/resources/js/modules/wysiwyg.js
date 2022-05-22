import { getElements } from 'js@/utils/get-elements';

function wysiwyg() {
	const elements = getElements(document, '.js-wysiwyg');

	if (!elements.length) {
		return;
	}

	// Wrap first level tables for horizontal scrolling
	elements.forEach((el) => {
		const children = el.children;

		if (children.length) {
			for (let i = 0, child; (child = children[i]); i++) {
				if (child.tagName.toLowerCase() === 'table') {
					const parent = child.parentNode;
					const wrapper = document.createElement('div');

					wrapper.style.overflowX = 'auto';
					parent.insertBefore(wrapper, child);
					wrapper.appendChild(child);
				}
			}
		}
	});
}

export { wysiwyg };
