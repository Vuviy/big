import { CLASS_NAMES } from 'js@/constants/class-names';
import { lockScreen } from 'js@/utils/lock-screen';
import { unlockScreen } from 'js@/utils/unlock-screen';

export function catalogFilter(data) {
	return {
		isFilterOpen: false,

		get refs() {
			return this.$refs;
		},

		toggleFilter(e) {
			e.preventDefault();

			lockScreen();

			if (this.isFilterOpen) {
				unlockScreen();
			}

			this.isFilterOpen = !this.isFilterOpen;
		},
	}
}
