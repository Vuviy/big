import { scrollbar } from "js@/utils/scrollbar";

export const unlockScreen = () => {
	const html = document.documentElement;

	if (scrollbar.has()) {
		html.style.marginRight = null;
	}

	html.style.overflow = null;
};
