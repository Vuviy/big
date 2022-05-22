/**
 * @param {String} data.nowOpen
 * @param {String} data.container
 * @returns {{ref(*): *, nowOpen: String, isOpen(*): boolean, container: String, resize(*=): void, init(): void, open(*=): void}|boolean|*}
 */

export function tabs(data) {
	return {
		nowOpen: data.nowOpen,
		container: data.container,
		align: data.align || false,

		init(idOpen) {
			if (idOpen || this.ref(this.nowOpen)) {
				this.$nextTick(() => {
					this.ref(this.container).style.height = this.ref(idOpen || this.nowOpen).scrollHeight + 'px';
				});
			} else {
				this.resize();
			}
		},

		open(id) {
			if (id === this.nowOpen || !this.ref(id)) {
				return;
			}

			this.nowOpen = id;
			this.moveUnderline();

			if (this.align) {
				this.toggleContainer(this.ref(id));
			}
		},

		scroll(id) {
			scroll({
				top: this.ref(id).offsetTop,
				behavior: 'smooth'
			});
		},

		moveUnderline() {
			this.ref('underline').style.setProperty('--left', this.ref('button-' + this.nowOpen).offsetLeft + 'px');
			this.ref('underline').style.setProperty('--width', this.ref('button-' + this.nowOpen).clientWidth + 'px');
		},

		toggleContainer(toHeight, callback = () => {}) {
			if (!toHeight) {
				return;
			}

			const container = this.ref(this.container);
			const nowHeight = container.scrollHeight;

			toHeight.style.position = 'absolute';
			toHeight.style.top = '0';
			toHeight.style.left = '0';
			toHeight.style.width = '100%';
			container.style.height = nowHeight + 'px';
			container.style.transition = 'height 0.3s';
			container.style.overflow = 'hidden';
			toHeight.classList.add('in-progress');
			setTimeout(() => {
				container.style.height = toHeight.scrollHeight + 'px';

				setTimeout(() => {
					toHeight.style = {};
					container.style = {};
					toHeight.classList.remove('in-progress');
					callback();
				}, 300);
			}, 50);
		},
		ref(id) {
			return this.$refs[id];
		},
		isOpen(id) {
			return this.nowOpen === id;
		},
		resize() {
			this.ref(this.container).style.height = this.ref(this.nowOpen).scrollHeight + 'px';
		}
	};
}
