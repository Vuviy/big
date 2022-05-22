/**
 * @param {[Object]} data - array of objects
 * @returns []
 */
export function sortFromTo(data) {
	const FROM = '_from';
	const TO = '_to';

	const fromToObjects = {};
	const resultArray = [];

	for (const i in data) {
		const row = data[i];
		const name = row.name.trim().toLowerCase();

		if (name.endsWith(FROM)) {
			const prefix = name.substring(0, name.indexOf(FROM));

			if (!fromToObjects[prefix]) {
				fromToObjects[prefix] = {};
			}

			fromToObjects[prefix].from = row.value;
		} else if (name.endsWith(TO)) {
			const prefix = name.substring(0, name.indexOf(TO));

			if (!fromToObjects[prefix]) {
				fromToObjects[prefix] = {};
			}

			fromToObjects[prefix].to = row.value;
		} else {
			resultArray.push(row);
		}
	}

	for (const prefix in fromToObjects) {
		let from = fromToObjects[prefix].from;
		let to = fromToObjects[prefix].to;

		const fromValue = parseInt(from);
		const toValue = parseInt(to);

		if (!isNaN(fromValue) && !isNaN(toValue)) {
			if (fromValue > toValue) {
				const temp = from;

				from = to;
				to = temp;
			}

			resultArray.push({ name: prefix + FROM, value: from });
			resultArray.push({ name: prefix + TO, value: to });
		} else {
			if (typeof from !== 'undefined') {
				resultArray.push({ name: prefix + FROM, value: from });
			}
			if (typeof to !== 'undefined') {
				resultArray.push({ name: prefix + TO, value: to });
			}
		}
	}

	return resultArray;
}
