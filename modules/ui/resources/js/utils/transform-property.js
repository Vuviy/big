export const transformProperty = (() => {
	const div = document.createElement('div');

	if (div.style.transform == null) {
		const prefixes = ['Webkit', 'Moz'];

		for (const prefix in prefixes) {
			if (prefixes.hasOwnProperty(prefix)) {
				if (div.style[prefixes[prefix] + 'Transform'] !== undefined) {
					return prefixes[prefix] + 'Transform';
				}
			}
		}
	}

	return 'transform';
})();
