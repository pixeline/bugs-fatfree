module.exports = {
	options: {
		curly: true,
		eqeqeq: false,
		eqnull: true,
		browser: true,
		globals: {
			jQuery: true
		}
	},
	all: ['gruntfile.js', '<%= project.src_dir %>app/assets/js/app.js']
};