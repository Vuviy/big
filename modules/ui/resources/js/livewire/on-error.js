import { i18n } from 'js@/i18n';
import { importSweetAlert } from 'js@/modules/sweet-alert';
import { livewire } from 'js@/livewire';
import { mergeSweetAlertOptions } from 'js@/modules/sweet-alert/options';

livewire.onError((statusCode) => {
	importSweetAlert().then((SweetAlert) => {
		let sweetAlert;

		switch (statusCode) {
			case 419:
				sweetAlert = new SweetAlert(
					mergeSweetAlertOptions({
						icon: 'warning',
						title: i18n.csrfExpires,
						text: i18n.wouldYourLikeRefreshPage,
						confirmButtonText: i18n.confirmReloadPage,
						showCancelButton: true,
						cancelButtonText: i18n.no
					})
				);

				sweetAlert.then((result) => {
					if (result.isConfirmed) {
						window.location.reload();
					}
				});

				break;
			case 503:
				sweetAlert = new SweetAlert(
					mergeSweetAlertOptions({
						icon: 'info',
						title: i18n.error503,
						text: i18n.error503HelpText,
						confirmButtonText: i18n.ok
					})
				);

				break;
			case 500:
			default:
				sweetAlert = new SweetAlert(
					mergeSweetAlertOptions({
						icon: 'error',
						title: i18n.serverError,
						text: i18n.pleaseTryAgainLater,
						confirmButtonText: i18n.ok
					})
				);

				break;
		}
	});

	return false;
});
