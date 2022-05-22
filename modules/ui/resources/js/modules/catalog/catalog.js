import { AccFilter } from 'js@/modules/catalog/accordion';
import { BREAKPOINTS, CSS_CLASSES } from 'js@/constants';
import { DMI } from 'js@/dmi';
import { Filter } from 'js@/modules/catalog/filter';
import { HttpRequest } from 'js@/modules/http-request';
// import { PriceRange } from 'js@/modules/catalog/price-range';
import { getDelegateTarget } from 'js@/utils/get-delegate-target';
import { getElement } from 'js@/utils/get-element';
import { getElements } from 'js@/utils/get-elements';
import { getCsrfToken } from 'js@/utils/get-csrf-token';
import { getNodes } from 'js@/modules/catalog/catalog-nodes';
import { lazyLoad } from 'js@/modules/lazy-load';
import { livewire } from 'js@/livewire';
import { scrollTo } from 'js@/modules/scroll-to';
import { selectors } from 'js@/modules/catalog/catalog-selectors';

const body = document.body;

/** @param {HTMLElement} context */
function catalog(context) {
	const nodes = getNodes(context);

	const components = {
		accordion: new AccFilter(nodes.filter)
	};

	const isMobile = () => window.innerWidth < BREAKPOINTS.df;

	let isPendingLoad = false;

	let xhr = null;

	let isResetSelectSort = false;

	const initComponents = () => {
		try {
			components.filter = new Filter(nodes.filter);
			components.filter.setElementForGETParameters(nodes.selectSort);
			// components.priceRange = new PriceRange(getElement(nodes.filter, selectors.priceRange));
		} catch (e) {
			console.error(e);
		}
	};

	const destroyComponents = () => {
		components.filter = null;
		// components.priceRange.destroy();
		// components.priceRange = null;
		getElements(nodes.filterDynamic, 'select').forEach((select) => {
			if (select.__select) {
				select.__select.unbindEvents();
			}
		});
	};

	const rebindNodes = () => {
		nodes.showMore = getElement(context, selectors.showMore);
	};

	/**
	 * @param {String} url
	 * @param {Boolean} withFilter
	 * @param {Boolean} showMoreEvent
	 * @returns {Promise<{}>}
	 */
	const sendRequest = (url, withFilter = true, showMoreEvent = false) => {
		activatePendingLoad();

		console.log(url);

		if (showMoreEvent) {
			if (nodes.showMore) {
				nodes.showMore.classList.add(CSS_CLASSES.loading);
			}
		}

		return new Promise((resolve, reject) => {
			xhr = new HttpRequest();
			xhr.open('GET', url);
			xhr.setHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setHeader('Accept', 'application/json');
			xhr.setHeader('X-CSRF-TOKEN', getCsrfToken());

			if (withFilter) {
				xhr.setHeader('X-Filter', 'true');
			}

			xhr.send()
				.then((response) => {
					requestDone(response, showMoreEvent);
					deactivatePendingLoad();
					checkVisibleFilterButtons();
					resolve(response);
					xhr = null;
				})
				.catch((reason) => {
					if (reason.message === 'fail') {
						window.location.reload();
					}

					deactivatePendingLoad();
					reject(reason);
					xhr = null;
				});
		});
	};

	/**
	 * @param {Object} response
	 * @param {Boolean} showMoreEvent
	 */
	const requestDone = (response, showMoreEvent) => {
		if (response.filter) {
			destroyComponents();

			if (nodes.filterDynamic) {
				nodes.filterDynamic.innerHTML = response.filter;
			}

			if (nodes.productsList) {
				nodes.productsList.innerHTML = response.products;
				rebindNodes();
				livewire.rescan(nodes.productsList);
				lazyLoad().then((lozad) => lozad.observe());
			}

			if (nodes.footerTags && response['filter-tags']) {
                nodes.footerTags.innerHTML = response['filter-tags'];
            }

			initComponents();
			DMI.importAll(nodes.filterDynamic);
			components.accordion.update();
		} else {
			if (nodes.productsList) {
				if (showMoreEvent) {
					if (nodes.showMore) {
						nodes.showMore.parentElement.remove();
					}
					nodes.productsList.insertAdjacentHTML('beforeend', response.products);
				} else {
					nodes.productsList.innerHTML = response.products;
				}

				rebindNodes();
				livewire.rescan(nodes.productsList);
				lazyLoad().then((lozad) => lozad.observe());
			}
		}

		if (response['filter-flags']) {
            if (nodes.catalogFlags) {
                nodes.catalogFlags.innerHTML = response['filter-flags'];
                rebindNodes();
                livewire.rescan(nodes.catalogFlags);
            }
        }

		if (nodes.selection) {
			nodes.selection.innerHTML = response.selected || '';
		}

		updateFiltersCounter();
		checkStateSelectSort(response.total);
		// nodes.filterGoodsCount.innerHTML = response.total;

		if (nodes.pagination) {
			nodes.pagination.innerHTML = response.pagination;
		}

		if (window.history && response.url) {
			window.history.pushState(
				{
					filter: true
				},
				null,
				response.url
			);
		}

		if (response.titleDocument) {
			window.document.title = response.titleDocument;
		}
	};

	const activatePendingLoad = () => {
		isPendingLoad = true;

		if (nodes.loadPending.length) {
			nodes.loadPending.forEach((el) => {
				el.dataset.loadPending = 'true';
			});
		}
	};

	const deactivatePendingLoad = () => {
		isPendingLoad = false;

		if (nodes.loadPending.length) {
			nodes.loadPending.forEach((el) => {
				el.dataset.loadPending = 'false';
			});
		}
	};

	const checkVisibleFilterButtons = () => {
		if (nodes.filterStickyButtons) {
			if (nodes.selection.innerHTML !== '') {
				nodes.filterStickyButtons.removeAttribute('hidden');
			} else {
				nodes.filterStickyButtons.setAttribute('hidden', '');
			}
		}
	};

	/** @param {HTMLElement} target */
	const showFilterItemHiddenOptions = (target) => {
		const parent = target.parentElement;
		const nodeText = getElement(target, '[data-text]');
		const nodesInvisible = getElements(parent, '[data-invisible]');

		const changeText = () => {
			let temp = nodeText.innerText;

			nodeText.innerText = nodeText.dataset.text;
			nodeText.dataset.text = temp;
			temp = null;
		};

		const show = () => {
			nodesInvisible.forEach((el) => {
				el.removeAttribute('hidden');
			});
		};

		const hide = () => {
			nodesInvisible.forEach((el) => {
				el.setAttribute('hidden', '');
			});
		};

		if (target.classList.contains(CSS_CLASSES.open)) {
			target.classList.remove(CSS_CLASSES.open);
			hide();
		} else {
			target.classList.add(CSS_CLASSES.open);
			show();
		}

		changeText();
	};

	/** @param {HTMLElement} target */
	const resetAllFilterItemParameters = (target) => {
		const type = target.dataset.type;
		const parent = target.parentElement.parentElement;
		const checkedParams = parent.querySelectorAll('input[name]:checked');

		if (type === 'checkbox') {
			checkedParams.forEach((el) => {
				el.checked = false;
			});
		}
	};

	/** @param {Number} total */
	const checkStateSelectSort = (total) => {
		if (nodes.selectSort) {
			if (!total) {
				nodes.selectSort.disabled = true;
				nodes.selectSort.__select.disable();
			} else {
				nodes.selectSort.disabled = false;
				nodes.selectSort.__select.enable();
			}
		}
	};

	let timer = null;

	const addTransition = () => {
		body.classList.add('show-filter-transition');
	};

	const removeTransition = () => {
		clearTimeout(timer);
		timer = setTimeout(() => {
			body.classList.remove('show-filter-transition');
		}, 300);
	};

	const showFilter = () => {
		body.classList.add('show-filter');
		addTransition();
		removeTransition();
	};

	const hideFilter = () => {
		if (isPendingLoad) {
			return;
		}

		addTransition();
		body.classList.remove('show-filter');
		removeTransition();
	};

	const countSelectedFilters = () => nodes.selection.querySelectorAll('.js-selection-i:not([data-reset])').length;

	const updateFiltersCounter = () => {
		if (nodes.filterCount) {
			const countFilters = countSelectedFilters();

			if (countFilters === 0) {
				nodes.filterCount.innerHTML = '';
			} else {
				nodes.filterCount.innerHTML = '(' + countFilters + ')';
			}
		}
	};

	updateFiltersCounter();
	initComponents();

	// events
	if (nodes.filter) {
		nodes.filter.addEventListener(
			'change',
			(event) => {
				const target = getDelegateTarget(event, selectors.filterDelegate);

				if (!target || target.classList.contains('js-ignore')) {
					return;
				}
                console.log(1111, components, event);
				sendRequest(components.filter.getUrl());
			},
			false
		);

		nodes.filter.addEventListener(
			'click',
			(event) => {
				const targetLink = getDelegateTarget(event, selectors.selectionLink);
				const targetMore = getDelegateTarget(event, selectors.filterItemMore);
				const targetReset = getDelegateTarget(event, selectors.filterItemReset);

				if (targetLink) {
					event.preventDefault();
					sendRequest(targetLink).then(() => {
						if (targetLink.hasAttribute('data-reset')) {
							isResetSelectSort = true;
							nodes.selectSort.__select.reset();
							isResetSelectSort = false;
						}
					});
				}

				if (targetMore) {
					showFilterItemHiddenOptions(targetMore);
				}

				if (targetReset) {
					resetAllFilterItemParameters(targetReset);
					sendRequest(components.filter.getUrl());
				}
			},
			false
		);
	}

	if (nodes.selectSort) {
		nodes.selectSort.addEventListener(
			'change',
			() => {
				if (!isResetSelectSort) {
					sendRequest(components.filter.getUrl(true), false);
				}
			},
			false
		);
	}

	if (nodes.pagination) {
		nodes.pagination.addEventListener(
			'click',
			(event) => {
				const target = getDelegateTarget(event, 'a');
                const targetShowMore = getDelegateTarget(event, selectors.showMore);

                if (targetShowMore) {
                    const route = targetShowMore.dataset.route;

                    if (typeof route === 'string' && route.length) {
                        sendRequest(route, false, true);
                    }
                } else if (target) {
                    event.preventDefault();
                    scrollTo({ el: context });
                    sendRequest(target.href, false);
                }
			},
			false
		);
	}

	// if (nodes.productsList) {
	// 	nodes.showMore.addEventListener(
	// 		'click',
	// 		(event) => {
	// 		    console.log(1111111111)
	// 			const target = getDelegateTarget(event, selectors.showMore);
    //
	// 			if (!target) {
	// 				return;
	// 			}
    //
	// 			const route = target.dataset.route;
    //
	// 			if (typeof route === 'string' && route.length) {
	// 				sendRequest(route, false, true);
	// 			}
	// 		},
	// 		false
	// 	);
	// }

	if (nodes.filterApplyButton) {
		nodes.filterApplyButton.addEventListener(
			'click',
			() => {
				if (isMobile()) {
					hideFilter();
				}

				scrollTo({ el: context });
			},
			false
		);
	}

	if (nodes.filterResetButton) {
		nodes.filterResetButton.addEventListener(
			'click',
			() => {
				const route = nodes.filterResetButton.dataset.route;

				if (typeof route === 'string' && route.length) {
					scrollTo({ el: context });
					sendRequest(route);
				}
			},
			false
		);
	}

	window.addEventListener(
		'change.range',
		() => {
			sendRequest(components.filter.getUrl());
		},
		false
	);

	window.addEventListener('popstate', ({ state }) => {
		if (state && state.filter) {
			xhr && xhr.abort();
			window.location.reload();
		}
	});

	// mobile
	// nodes.filterButton.addEventListener(
	// 	'click',
	// 	() => {
	// 		showFilter();
	// 	},
	// 	false
	// );

	nodes.filterClose.forEach((node) => {
		node.addEventListener(
			'click',
			() => {
				hideFilter();
			},
			false
		);
	});
}

export { catalog };
