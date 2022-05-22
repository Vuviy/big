import { CSS_CLASSES } from 'js@/constants';
import { hasClass, addClass, removeClass } from 'js@/utils/classes';
import { getElements } from 'js@/utils/get-elements';
import { getDelegateTarget } from 'js@/utils/get-delegate-target';
import { getElement } from 'js@/utils/get-element';
import { slideToggle } from 'js@/utils/slide-toggle';

const selector = '.js-acc-click';

class AccFilter {
	constructor(context) {
		this.filterNode = context;
		this.state = {};
		this.btns = getElements(this.filterNode, selector);

		this.getState();
		this.watch();
	}

	watch() {
		this.filterNode.addEventListener(
			'click',
			(event) => {
				const target = getDelegateTarget(event, selector);

				if (!target) {
					return;
				}

				this.toggleOpen(target);
			},
			false
		);
		window.addEventListener('resize', this.updateHeights, false);
	}

	getContentHeight(el) {
		return el.scrollHeight + 'px';
	}

	getContent(btn) {
		return getElement(this.filterNode, `[data-acc-block="${btn.dataset.accIndex}"]`);
	}

	toggleOpen(target) {
		if (target instanceof HTMLElement) {
			const title = target;
			const content = this.getContent(title);

			if (title && content) {
				if (hasClass(title, CSS_CLASSES.open)) {
					removeClass(title, CSS_CLASSES.open);
                    slideToggle(content, false);
					this.changeState(title.dataset.accIndex, 'close');
				} else {
					addClass(title, CSS_CLASSES.open);
					// content.style.display = '';
                    slideToggle(content, true);
					this.changeState(title.dataset.accIndex, 'open');
				}
			}
		}
	}

	getState() {
		if (this.btns.length) {
			this.btns.forEach((button) => {
				if (hasClass(button, CSS_CLASSES.open)) {
					this.state[button.dataset.accIndex] = 1;
				} else {
					this.state[button.dataset.accIndex] = 0;
				}
			});
		}
	}

	changeState(key, action) {
		if (action === 'open') {
			this.state[key] = 1;
		} else {
			this.state[key] = 0;
		}
	}

	setState() {
		const { state } = this;

		this.btns.forEach((button) => {
			const key = button.dataset.accIndex;

			if (key in state) {
				const prop = state[key];
				const content = this.getContent(button);

				if (prop === 0) {
					removeClass(button, CSS_CLASSES.open);

					if (content) {
						content.style.display = 'none';
						// slideToggle(content, false, 0);
						// content.style.height = '0px';
					}
				} else {
					addClass(button, CSS_CLASSES.open);

					if (content) {
						// slideToggle(content, true, 0);
						content.style.display = '';
						// content.style.height = this.getContentHeight(content);
					}
				}
			}
		});
	}

	clearState() {
		this.state = {};
	}

	update() {
		this.btns = getElements(this.filterNode, selector);
		this.setState();
		this.clearState();
		this.getState();
	}

	// updateHeights() {
	// 	this.btns.forEach((button) => {
	// 		const key = button.dataset.accIndex;
	//
	// 		if (key in this.state && this.state[key]) {
	// 			const content = this.getContent(button);
	// 			content.style.height = this.getContentHeight(content);
	// 		}
	// 	});
	// }
}

export { AccFilter };
