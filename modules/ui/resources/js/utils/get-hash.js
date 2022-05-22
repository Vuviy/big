export const getHash = () => {
	const { hash } = window.location;

	return hash ? hash.slice(1) : null;
};
