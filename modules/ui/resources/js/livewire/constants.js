export const WIRE_MODEL_ATTR = 'wire:model';
export const WIRE_ID_SELECTOR = '[wire\\:id]';
export const WIRE_IGNORE_SELECTOR = '[wire\\:ignore]';
export const FORM_ERROR_SELECTOR = '.form-error';

export const HOOKS = {
	messageProcessed: 'message.processed', // A message has been fully received and implemented (DOM updates, etc...)
	messageSent: 'message.sent', // A new Livewire message was just sent to the server
	elementUpdated: 'element.updated', //  An element has just been updated from a Livewire request
	elementUpdating: 'element.updating', // An element is about to be updated after a Livewire request
	elementInitialized: 'element.initialized' // A new element has been initialized
};
