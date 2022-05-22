export const isNotEqual = (obj1, obj2) => {
	if (!obj2) {
		return true;
	}

	return !(JSON.stringify(obj1.html) === JSON.stringify(obj2.html));
};
