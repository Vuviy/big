// Polyfills
import 'regenerator-runtime/runtime';

// Alpine
import { scriptsAlpine } from 'js@/alpine';

// Livewire
import 'js@/livewire/events';
import 'js@/livewire/hooks';
import 'js@/livewire/on-error';

// Own
import { DMI } from 'js@/dmi';
import { cookieAskUsage } from 'js@/modules/cookie-ask-usage';
import { lazyLoad } from 'js@/modules/lazy-load';
import { linkToTop } from 'js@/modules/link-to-top';
import { loadMore } from 'js@/modules/load-more';
import { scrollToObserve } from 'js@/modules/scroll-to';
import { serverResponse } from 'js@/modules/server-response';
import { share } from 'js@/modules/share';
import { wysiwyg } from 'js@/modules/wysiwyg';

window.serverResponse = serverResponse;
window.share = share;

Object.assign(window.app, {
	alpine: {
		...scriptsAlpine
	}
});

document.addEventListener('DOMContentLoaded', () => {
	DMI.importAll();
	lazyLoad().then((lozad) => lozad.observe());
	loadMore();
	wysiwyg();
	linkToTop();
	scrollToObserve();
	cookieAskUsage();

	document.body.classList.add('is-ready');

	window.addEventListener('popstate', ({ state }) => {
		if (state && state.reload) {
			window.location.reload();
		}
	});
});
