import './styles/select.scss';
import { HOOKS } from 'js@/livewire/constants';
import { MIN_COUNT_FOR_DISPLAY_SEARCH } from 'js@/modules/select/constants';
import { Select } from './select-plugin';
import { subscribeHook } from 'js@/livewire/utils';

/**
 * @param {HTMLSelectElement} select
 */
function select(select) {
	select.__select = new Select(select, {
		searchable: select.dataset.searchable || select.length > MIN_COUNT_FOR_DISPLAY_SEARCH
	});

	subscribeHook(
		select,
		HOOKS.elementUpdated,
		() => {
			select.__select.unbindEvents();
		},
		true
	);
}

export { select };
