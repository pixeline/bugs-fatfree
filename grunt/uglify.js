module.exports = {
	js: {
		options: {
			// preserveComments: 'all',
			compress: {
				drop_console: false
			},
			preserveComments: false,
			sourceMap: true,
			mangle: false // Replaces variables and functions by shorter names if true
		},
		files: {
			'<%= project.build_dir %>app/assets/js/app.js'
		}
	},
	js_build: {
		options: {
			// preserveComments: 'all',
			compress: {
				drop_console: true
			},
			preserveComments: false,
			sourceMap: true,
			mangle: true
		},
		files: {
			'<%= project.build_dir %>app/assets/js/app.js'
		}
	}
};