module.exports = {
	options: {
		map: {
			inline: false,
			// save all sourcemaps as separate files...
			annotation: '<%= project.build_dir %>app/assets/css/'
		},
		processors: [
		require('pixrem')(), // add fallbacks for rem units
		require('autoprefixer')({ browsers: 'last 2 versions' }), // add vendor prefixes
		require('cssnano')() // minify the result
		]
	},
	prod: {
		src: '<%= project.build_dir %>app/assets/css/app.css'
	}
};