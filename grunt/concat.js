module.exports = {
	options: {
		separator: ';\n',
		stripBanners: true,
		banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %> */',
		sourceMap: false,
		nonull: true, // tells if a file is missing
	},
	parent: {
		src: [
		'<%= project.src_dir %>app/assets/js/plugins/jquery.min.js',
		'<%= project.src_dir %>app/assets/js/plugins/jQuery-File-Upload-9.12.3/js/vendor/jquery.ui.widget.js',
		'<%= project.src_dir %>app/assets/js/plugins/load-image.all.min.js',
		'<%= project.src_dir %>app/assets/js/plugins/canvas-to-blob.min.js',
		'<%= project.src_dir %>app/assets/js/plugins/jQuery-File-Upload-9.12.3/js/jquery.fileupload.js',
		'<%= project.src_dir %>app/assets/js/plugins/jQuery-File-Upload-9.12.3/js/jquery.fileupload-process.js',
		'<%= project.src_dir %>app/assets/js/plugins/jQuery-File-Upload-9.12.3/js/jquery.fileupload-image.js',
		'<%= project.src_dir %>app/assets/js/plugins/jQuery-File-Upload-9.12.3/js/jquery.fileupload-video.js',
		'<%= project.src_dir %>app/assets/js/plugins/jQuery-File-Upload-9.12.3/js/jquery.fileupload-validate.js',
		'<%= project.src_dir %>app/assets/js/app.js'
		],
		dest: '<%= project.build_dir %>app/assets/js/app.js'
	}
};