/**
 * @returns {Swal}
 */
export function importSweetAlert() {
	return import(/* webpackChunkName: 'sweetalert.css' */ './styles.scss').then(() =>
		import(/* webpackChunkName: 'sweetalert2' */ 'sweetalert2').then((module) => {
			const sweetAlert = module.default;

			sweetAlert.close();

			return sweetAlert;
		})
	);
}
