import { getElement } from 'js@/utils/get-element';
import { getElements } from 'js@/utils/get-elements';
import { selectors } from 'js@/modules/catalog/catalog-selectors';

export const getNodes = (context) => {
	return {
		filter: getElement(context, selectors.filter),
		filterApplyButton: getElement(context, selectors.filterApplyButton),
		filterButton: getElement(context, selectors.filterButton),
		filterClose: getElements(context, selectors.filterClose),
		filterCount: getElement(context, selectors.filterCount),
		filterDynamic: getElement(context, selectors.filterDynamic),
		filterGoodsCount: getElement(context, selectors.filterGoodsCount),
		filterResetButton: getElement(context, selectors.filterResetButton),
		filterStickyButtons: getElement(context, selectors.filterStickyButtons),
		loadPending: getElements(context, selectors.loadPending),
		pagination: getElement(context, selectors.pagination),
		productsList: getElement(context, selectors.productsList),
		catalogFlags: getElement(context, selectors.catalogFlags),
		selectSort: getElement(context, selectors.selectSort),
		selection: getElement(context, selectors.selection),
		showMore: getElement(context, selectors.showMore),
        footerTags: document.querySelector(selectors.footerTags)
	};
};
