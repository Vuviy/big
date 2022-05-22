/**
 * @param callback
 * @returns {function(): void}
 */
export function executeOnce(callback) {
	let called = false;

	return function () {
		if (!called) {
			called = true;
			callback.apply(this, arguments);
		}
	};
}
