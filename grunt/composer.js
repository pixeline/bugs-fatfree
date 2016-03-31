module.exports = {
	options: {
		cwd: '<%= project.src_dir %>',
		composerLocation: '/usr/bin/composer'
	},
	update: {
		options: {
			cwd: '<%= project.src_dir %>',
			composerLocation: '/usr/local/bin/composer update'
		}
	}
};