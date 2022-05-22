/**
 * @return {string|null}
 */
export const getCsrfToken = () => {
	const meta = document.querySelector('meta[name="csrf-token"]');

	if (meta) {
		return meta.getAttribute('content');
	}

	return null;
};
