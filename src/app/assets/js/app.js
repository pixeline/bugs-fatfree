$(function() {
	'use strict';
	var url = '/upload',
		uploadButton = $('<button/>').prop('disabled', true).text('Processing...').on('click', function() {
			var $this = $(this),
				data = $this.data();
			$this.off('click').text('Abort').on('click', function() {
				$this.remove();
				data.abort();
			});
			data.submit().always(function() {
				$this.remove();
			});
		});
	$('.js-fileupload').fileupload({
		url: url,
		dataType: 'json',
		autoUpload: false,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		maxFileSize: 999000,
		// Enable image resizing, except for Android and Opera,
		// which actually support image resizing, but fail to
		// send Blob objects via XHR requests:
		disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
		previewMaxWidth: 100,
		previewMaxHeight: 100,
		previewCrop: true
	}).on('fileuploadadd', function(e, data) {
		var fileContainer = $(this).parents('.file-uploader').find('.files');
		var progressBar = $(this).parents('.file-uploader').find('.progress-bar').addClass('progress-bar-init').css('width', '0%');

		data.context = $('<div/>').addClass('a-file').appendTo(fileContainer);
		$.each(data.files, function(index, file) {
			var node = $('<p/>').append($('<span/>').addClass('a-file-name').text(file.name));
			if (!index) {
				node.append('<br>').append(uploadButton.clone(true).data(data));
			}
			node.appendTo(data.context);
		});
	}).on('fileuploadprocessalways', function(e, data) {
		var index = data.index,
			file = data.files[index],
			node = $(data.context.children()[index]);
		if (file.preview) {
			node.prepend('<br>').prepend(file.preview);
		}
		if (file.error) {
			node.append('<br>').append($('<span class="text-danger"/>').text(file.error));
		}
		if (index + 1 === data.files.length) {
			data.context.find('button').text('Upload').prop('disabled', !! data.files.error);
		}
	}).on('fileuploadprogressall', function(e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		var progressBar = $(this).parents('.file-uploader').find('.progress-bar').css('width', progress + '%');
		
	}).on('fileuploaddone', function(e, data) {
		var progressBar = $(this).parents('.file-uploader').find('.progress-bar').removeClass('progress-bar-init').addClass('progress-bar-success');
		$.each(data.result.files, function(index, file) {
			if (file.url) {
				var link = $('<a>').addClass('modal').attr('target', '_blank').prop('href', '//' + file.url);
				$(data.context.children()[index]).wrap(link);
			} else if (file.error) {
				var error = $('<span class="text-danger"/>').text(file.error);
				$(data.context.children()[index]).append('<br>').append(error);
			}
		});
	}).on('fileuploadfail', function(e, data) {
		$.each(data.files, function(index) {
			var error = $('<span class="text-danger"/>').text('File upload failed.');
			$(data.context.children()[index]).append('<br>').append(error);
		});
	}).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
});