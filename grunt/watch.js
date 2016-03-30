module.exports = {
	sass: {
		files: ['<%= project.src_dir %>app/assets/css/**/*.scss'],
		tasks: ['stylesheet'],
	},
	js: {
		files: ['<%= project.src_dir %>app/assets/js/app.js'],
		tasks: ['javascript'],
	},
	all: {
		files: ['<%= project.src_dir %>**/*', '!<%= project.src_dir %>app/assets/css/**/*.scss', '!<%= project.src_dir %>app/assets/js/**/*.js'],
		tasks: ['newer:copy'],
	},
	livereload: {
		options: {
			livereload: true
		},
		files: ['<%= project.build_dir %>**/*'],
	}
};