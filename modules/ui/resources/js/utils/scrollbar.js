export const scrollbar = {
	has() {
		return document.body.scrollHeight > window.innerHeight;
	},
	width() {
		return window.innerWidth - document.documentElement.clientWidth;
	},
	widthWithUnit() {
		return this.width() + 'px';
	}
};
