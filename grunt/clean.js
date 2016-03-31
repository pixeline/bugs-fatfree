module.exports = {
	wipe: {
		// wipe build directory content.
		src: '<%= project.build_dir %>/'
	},
	source_in_build: {
		src: [
		// Delete sass files in build
		'<%= project.build_dir %>app/assets/css/**/*.scss', '<%= project.build_dir %>src', '<%= project.build_dir %>composer.json', '<%= project.build_dir %>composer.lock', '<%= project.build_dir %>vendor/bcosca/fatfree/composer.json', '<%= project.build_dir %>vendor/bcosca/fatfree/config.ini', '<%= project.build_dir %>vendor/bcosca/fatfree/readme.md', '<%= project.build_dir %>vendor/bcosca/fatfree/ui', ]
	},
};