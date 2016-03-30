module.exports = {
	options: {
		mode: true,
	},
	full: {
		cwd: '<%= project.src_dir %>',
		src: '**',
		dest: '<%= project.build_dir %>',
		expand: true,
		dot: true
	}
};