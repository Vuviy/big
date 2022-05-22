import { DMI } from 'js@/dmi';
import { HOOKS } from 'js@/livewire/constants';
import { dispatch } from 'js@/utils/dispatch';
import { imageLazyTrigger } from 'js@/modules/lazy-load';
import { isTextarea } from 'js@/utils/tag-name';
import { livewire } from 'js@/livewire';

/**
 * A message has been fully received and implemented (DOM updates, etc...)
 */
livewire.hook(HOOKS.messageProcessed, (message, component) => {
	dispatch(component.el, HOOKS.messageProcessed, {
		message,
		component
	});

	['sliders', 'inputMask', 'select', 'delivery'].forEach((name) => {
		DMI.importModule(name, component.el);
	});
});
/*

/**
 * A new Livewire message was just sent to the server
 */
livewire.hook(HOOKS.messageSent, (message, component) => {
	dispatch(component.el, HOOKS.messageSent, {
		message,
		component
	});
});

/**
 * A new element has been initialized
 */
livewire.hook(HOOKS.elementInitialized, (el, component) => {
	imageLazyTrigger(el);
});

let textareaStyles;

/**
 * An element is about to be updated after a Livewire request
 */
livewire.hook(HOOKS.elementUpdating, (fromEl, toEl, component) => {
	// Save text area styles before Livewire request
	if (isTextarea(fromEl) && fromEl.hasAttribute('style')) {
		textareaStyles = fromEl.getAttribute('style');
	}
});

/**
 * An element has just been updated from a Livewire request
 */
livewire.hook(HOOKS.elementUpdated, (el, component) => {
	dispatch(el, HOOKS.elementUpdated, {
		component,
		el
	});

	imageLazyTrigger(el);

	// Set text area styles after Livewire request
	if (isTextarea(el) && textareaStyles) {
		el.setAttribute('style', textareaStyles);
		textareaStyles = null;
	}
});

/**
 * This Livewire private hooks, this is not in the documentation
 */
livewire.hook('beforePushState', (state) => {
	state.reload = true;
});

livewire.hook('beforeReplaceState', (state) => {
	state.reload = true;
});
