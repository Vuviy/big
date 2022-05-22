export const slideToggle = (el, toOpen = false, time = 0, callback = () => {}) => {
	if (el instanceof HTMLElement) {
		if (toOpen) {
			el.style.height = '0px';
			// el.style.transition = `height ${time}ms`;
			el.style.display = '';
			el.style.overflow = 'hidden';

			setTimeout(() => {
				el.style.height = el.scrollHeight + 'px';

				setTimeout(() => {
					el.style = {};
					callback();
				}, time);
			}, 0);
		} else {
			el.style.height = el.scrollHeight + 'px';
			// el.style.transition = `height ${time}ms`;
			el.style.overflow = 'hidden';

			setTimeout(() => {
				el.style.height = '0px';

				setTimeout(() => {
                    el.style = {};
					el.style.display = 'none';
					callback();
				}, time);
			}, 0);
		}
	}
};
