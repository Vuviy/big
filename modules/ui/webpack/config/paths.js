const fromCWD = require('from-cwd');

module.exports = {
	src: {
		js: fromCWD('./modules/ui/resources/js/'),
		sass: fromCWD('./modules/ui/resources/sass/')
	},
	svgSprites: {
		folders: fromCWD('./modules/ui/resources/svg/*'),
		entry: fromCWD('./modules/ui/resources/svg/readme.js')
	},
	resolveModules: [fromCWD('./modules/ui/resources/sass/'), fromCWD('./node_modules/')],
	public: {
		root: '/',
		build: '/build/',
		svg: '/svg/'
	},
	dist: {
		root: fromCWD('./public/'),
		build: fromCWD('./public/build/'),
		buildTemp: fromCWD('./public/.build-temp/'),
		svg: fromCWD('./public/svg/')
	}
};
