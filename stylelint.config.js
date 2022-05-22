module.exports = {
	extends: ['@stripped-ui/stylelint-config-scss', 'stylelint-config-prettier'],
	rules: {
		'no-descending-specificity': null,
		'selector-max-universal': 2
	}
};
