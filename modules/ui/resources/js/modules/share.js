export const share = (event, element) => {
	event.preventDefault();

	if (element.href) {
		const h = 600;
		const w = 600;
		const y = window.top.outerHeight / 2 + window.top.screenY - h / 2;
		const x = window.top.outerWidth / 2 + window.top.screenX - w / 2;

		window.open(
			element.href,
			null,
			`toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=${w}, height=${h}, top=${y}, left=${x}`
		);
	}
};
