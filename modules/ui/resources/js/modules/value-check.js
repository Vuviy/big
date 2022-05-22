import {getElements} from 'js@/utils/get-elements';

function initialize(el) {
	const items = getElements(el, '.form-item__control');
	items.forEach((item) => {

		item.addEventListener('focus', function () {
			item.classList.add('in-focus', 'is-focus');
		});

		item.addEventListener('blur', function () {
			item.classList.remove('in-focus');

			if (!item.value.length) {
				item.classList.remove('is-focus');
			}
		});

		item.addEventListener('input', function () {
			item.classList.toggle('has-value', item.value.trim().length > 0);
		});
	});
}


export default function (elements) {
	elements.forEach((el) => initialize(el));
}
