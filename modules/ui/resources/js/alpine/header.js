import MmenuLight from 'mmenu-light';
import { CLASS_NAMES } from 'js@/constants/class-names';
import { lockScreen } from 'js@/utils/lock-screen';
import { unlockScreen } from 'js@/utils/unlock-screen';
import(/* webpackChunkName: 'mmenu-light.css' */ 'mmenu-light/src/mmenu-light.scss');

export function header(data) {
	return {
		isSearchBarOpen: false,
		isSearchOpen: false,
		hasSearchFieldValue: false,
		isDesktopNavOpen: false,
		isMobileNavOpen: false,
		currentCategoryId: null,
		prevCategoryId: null,
		isMmenuOpen: false,
		mmenuInstance: null,
		mmenuNavigatorInstance: null,
		mmenuDrawerInstance: null,

		get refs() {
			return this.$refs;
		},

		openSearch(e) {
			e.preventDefault();

			this.isSearchBarOpen = !this.isSearchBarOpen;
			setTimeout(() => this.refs.searchInput.focus(), 0);
		},

		onSearchInput(e) {
			this.hasSearchFieldValue = !!e.target.value;
		},

		onSearchInputClear(e) {
			this.$refs.searchInput.value = '';
			this.$refs.searchResult.remove();
			this.hasSearchFieldValue = !!this.refs.searchInput.value;
		},

		toggleDesktopNav(e) {
			e.preventDefault();

			lockScreen();

			if (!this.isDesktopNavOpen) {
				this.refs.dropdownMenu.style.setProperty(
					'--height',
					`calc(100vh - ${this.refs.header.offsetHeight}px)`
				);
				this.refs.dropdownMenu.classList.add(CLASS_NAMES.active);
			} else {
				this.refs.dropdownMenu.style.setProperty('--height', 0);
				this.refs.dropdownMenu.classList.remove(CLASS_NAMES.active);

				unlockScreen();
			}

			this.isDesktopNavOpen = !this.isDesktopNavOpen;
		},

		setActiveCategory(id) {
			if (!this.currentCategoryId) {
				this.currentCategoryId = id;
			} else if (!this.prevCategoryId) {
				this.prevCategoryId = id;
			}

			this.prevCategoryId = this.currentCategoryId;
			this.currentCategoryId = id;
			this.refs[`menu-item-${this.prevCategoryId}`].classList.remove(CLASS_NAMES.active);
			this.refs[`menu-preview-item-${this.prevCategoryId}`].classList.remove(CLASS_NAMES.active);
			this.refs[`menu-item-${id}`].classList.add(CLASS_NAMES.active);
			this.refs[`menu-preview-item-${id}`].classList.add(CLASS_NAMES.active);
		},

		toggleMobileNav(e) {
			e.preventDefault();

			lockScreen();

			if (this.isMobileNavOpen) {
				unlockScreen();
			}

			this.isMobileNavOpen = !this.isMobileNavOpen;
		},

		mmenuInit() {
			this.mmenuInstance = new MmenuLight(this.refs.menuList);
			this.mmenuNavigatorInstance = this.mmenuInstance.navigation({
				title: this.refs.menuList.dataset.menuTitle || 'Menu'
			});
			this.mmenuDrawerInstance = this.mmenuInstance.offcanvas();
			this.mmenuInstance.menu.removeAttribute('hidden');
			this.mmenuDrawerInstance.backdrop.addEventListener('click', () => {
				this.isMmenuOpen = !this.isMmenuOpen;
			});
		},

		openMmenu(e) {
			e.preventDefault();

			this.isMmenuOpen = !this.isMmenuOpen;
			this.mmenuDrawerInstance.open();
		},

		closeMmenu() {
			this.isMmenuOpen = !this.isMmenuOpen;
			this.mmenuDrawerInstance.close();
		}
	};
}
