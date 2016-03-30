module.exports = {
	options: {
		separator: ''
	},
	parent: {
		src: ['<%= project.src_dir %>app/assets/js/plugins/*.js', '<%= project.src_dir %>app/assets/js/app.js'],
		dest: '<%= project.build_dir %>app/assets/js/app.js'
	}
};