/**
 * @param {String} data.namespaceRef
 * @param {String} data.selectedId
 * @returns {{ref(*): *, namespaceRef: String, isOpened(*): boolean, selectedId: null, resize(*=): void, open(*=): void}|boolean|*}
 */
import { slideToggle } from 'js@/utils/slide-toggle';

export function singleAccordion(data) {
	return {
		namespaceRef: data.namespaceRef,
		selectedId: data.selectedId ?? null,

		open(id) {
			if (this.selectedId === id) {
				this.selectedId = null;
				slideToggle(this.ref(id), false);
			} else {
				if (this.selectedId !== null) {
					slideToggle(this.ref(this.selectedId), false);
				}

				this.selectedId = id;
				slideToggle(this.ref(id), true);
			}
		},
		ref(id) {
			return this.$refs[`${this.namespaceRef}` + id];
		},
		isOpened(id) {
			return this.selectedId === id;
		},
		resize(id) {
			if (this.selectedId === id) {
				this.ref(id).style.maxHeight = '100%';
			}
		}
	};
}
