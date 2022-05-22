import { scrollbar } from "js@/utils/scrollbar";

export const lockScreen = () => {
	const html = document.documentElement;

	if (scrollbar.has()) {
		html.style.marginRight = scrollbar.widthWithUnit();
	}

	html.style.overflow = 'hidden';
};
