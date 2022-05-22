import Inputmask from 'inputmask';
import { HOOKS } from 'js@/livewire/constants';
import { subscribeHook, sendInputValueToLivewire } from 'js@/livewire/utils';

const {
	mask: { phone }
} = window.app;

/**
 * @param {HTMLInputElement} input
 */
function inputMask(input) {
	if (!phone) {
		return;
	}

	let isComplete = false;

	const inputmask = new Inputmask(phone, {
		refreshValue: true,
		showMaskOnHover: false,
		oncomplete: function () {
			isComplete = true;
			sendInputValueToLivewire(this);
		},
		onincomplete: function () {
			sendInputValueToLivewire(this);
		}
	});

	inputmask.mask(input);

	const handlerPaste = () => {
		sendInputValueToLivewire(input);
	};

	const handlerChange = () => {
		if (isComplete) {
			isComplete = false;

			return;
		}

		sendInputValueToLivewire(input);
	};

	const removeEvents = () => {
		input.removeEventListener('paste', handlerPaste, false);
		input.removeEventListener('change', handlerChange, false);
	};

	const addEvents = () => {
		input.addEventListener('paste', handlerPaste, false);
		input.addEventListener('change', handlerChange, false);
	};

	removeEvents();
	addEvents();

	subscribeHook(
		input,
		HOOKS.elementUpdated,
		() => {
			removeEvents();
		},
		true
	);
}

export { inputMask };
