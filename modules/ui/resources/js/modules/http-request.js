import { JSONParse } from 'js@/utils/json-parse';
import { serverResponse } from 'js@/modules/server-response';

class HttpRequest {
	constructor() {
		this.xhr = new XMLHttpRequest();
	}

	/**
	 * @param {string} name
	 * @param {string} value
	 */
	setHeader(name, value) {
		this.xhr.setRequestHeader(name, value);
	}

	/** @param {string} type */
	setType(type) {
		this.xhr.responseType = type;
	}

	/**
	 * @param name
	 * @returns {null|string}
	 */
	getResponseHeader(name) {
		return this.xhr.getResponseHeader(name);
	}

	/**
	 * @param {string} method
	 * @param {string} uri
	 */
	open(method, uri) {
		this.xhr.open(method, uri);
	}

	send() {
		const { xhr } = this;

		return new Promise((resolve, reject) => {
			xhr.onload = () => {
				let { status, response } = xhr;

				if (!this.responseAsHTML()) {
					response = JSONParse(response, {});
				}

				if (status === 200) {
					resolve(response);
				} else {
					if (!this.responseAsHTML()) {
						serverResponse(response);
					} else {
						serverResponse.showNotice(`Error ${xhr.status}: ${xhr.statusText}`);
					}

					reject(status);
					console.error(`Error ${xhr.status}: ${xhr.statusText}`);
				}
			};

			xhr.onerror = (e) => {
				console.error(e);
				reject(new Error('fail'));
			};

			xhr.send();
		});
	}

	abort() {
		this.xhr.abort();
	}

	responseAsHTML() {
		return this.getResponseHeader('Content-Type').includes('text/html');
	}
}

export { HttpRequest };
