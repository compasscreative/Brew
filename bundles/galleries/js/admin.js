/*
|--------------------------------------------------------------------------
| Add
|--------------------------------------------------------------------------
*/
$(function()
{
	var form = $('form#galleries_gallery_add');

	if (form.length)
	{
		/*
		| --------------------
		| Form submit
		| --------------------
		*/
		form.bind('submit', function(event)
		{
			// Prevent default
			event.preventDefault();

			// Send request
			$.ajax(
			{
				type: 'post',
				url: '/admin/galleries/insert',
				data: form.serialize(),
				dataType: 'json',
				beforeSend: function()
				{
					// Clear existing errors
					form.find('.error_message').hide();
					form.find('input, select, textarea').removeClass('error');

					// Validate title
					if ($.trim(form.find('[name=title]').val()).length === 0)
					{
						form.find('[name=title]').addClass('error').siblings('.error_message.required').show();
					}

					// Return validation results
					return form.find('.error').length === 0;
				},
				success: function(gallery)
				{
					location.href = '/admin/galleries/edit/' + gallery.id;
				}
			});
		});

		/*
		| --------------------
		| Setup markbar editor
		| --------------------
		*/
		form.find('[name=description]').markbar(
		{
			h1: false,
			img: false,
			blockquote: false,
			code: false
		});
	}
});


/*
|--------------------------------------------------------------------------
| Edit
|--------------------------------------------------------------------------
*/
$(function()
{
	var form = $('form#galleries_gallery_edit');

	if (form.length)
	{
		/*
		| --------------------
		| Form submit
		| --------------------
		*/
		form.bind('submit', function(event)
		{
			// Prevent default
			event.preventDefault();

			// Send request
			$.ajax(
			{
				type: 'post',
				url: '/admin/galleries/update',
				data: form.serialize(),
				dataType: 'json',
				beforeSend: function()
				{
					// Clear existing errors
					form.find('.error_message').hide();
					form.find('input, select, textarea').removeClass('error');

					// Validate title
					if ($.trim(form.find('[name=title]').val()).length === 0)
					{
						form.find('[name=title]').addClass('error').siblings('.error_message.required').show();
					}

					// Return validation results
					return form.find('.error').length === 0;
				},
				success: function()
				{
					// Display success message
					form.find('.saved_message').fadeIn('fast', function()
					{
						setTimeout(function()
						{
							form.find('.saved_message').fadeOut('fast');

						}, 1000);
					});
				}
			});
		});

		/*
		| --------------------
		| Setup markbar editor
		| --------------------
		*/
		form.find('[name=description]').markbar(
		{
			h1: false,
			img: false,
			blockquote: false,
			code: false
		});

		/*
		| --------------------
		| Setup image sorting
		| --------------------
		*/
		form.find('.photos ul').sortable(
		{
			handle: 'img'
		}).css(
		{
			'min-height': form.find('.photos ul').height() + 'px'
		});

		/*
		| --------------------
		| Setup image uploading
		| --------------------
		*/
		var uploader = new qq.FineUploaderBasic(
		{
			button: form.find('a.upload_photo')[0],
			request:
			{
				params:
				{
					gallery_id: form.find('[name=id]').val()
				},
				inputName: 'image',
				endpoint: '/admin/galleries/photos/insert'
			},
			validation:
			{
				sizeLimit: 15728640,
				acceptFiles: 'image/jpg, image/jpeg, image/tif, image/tiff',
				stopOnFirstInvalidFile: false
			},
			callbacks:
			{
				onError: function(id, name, errorReason)
				{
					alert(errorReason);
				},
				onUpload: function(id, filename)
				{
					form.find('.photos ul').append('<li id="photo_' + id + '" class="uploading"></li>');
				},
				onProgress: function(id, filename, uploaded_bytes, total_bytes)
				{
					var uploaded = Math.round((uploaded_bytes/total_bytes)*100);

					if (uploaded >= 100)
					{
						form.find('#photo_' + id).html('Processing ' + filename + '&hellip;');
					}
					else
					{
						form.find('#photo_' + id).html('Uploading ' + filename + '&hellip; (' + uploaded + '%)');
					}
				},
				onComplete: function(id, filename, response)
				{
					if (response.success)
					{
						// Update list with new photo
						html = '<img class="thumb" src="/galleries/photo/xsmall/' + response.id + '" width="75" height="75">';
						html += '<div class="tools">';
						html += '<textarea name="photos[' + response.id + ']"></textarea>';
						html += '<button type="button" data-id="' + response.id + '" class="delete_photo">Delete</button>';
						html += '</div>';

						// Remove uploading class
						form.find('#photo_' + id).html(html).removeClass('uploading');

						// Update min height
						form.find('.photos ul').css(
						{
							'min-height': form.find('.photos ul').height() + 'px'
						});
					}
				}
			}
		});

		/*
		| --------------------
		| Delete gallery
		| --------------------
		*/
		form.on('click', 'button.delete_gallery', function()
		{
			if (confirm('Are you sure you want to delete this gallery?'))
			{
				$.ajax(
				{
					type: 'post',
					url: '/admin/galleries/delete',
					data:
					{
						id: form.find('[name=id]').val()
					},
					success: function()
					{
						location.href = '/admin/galleries';
					}
				});
			}
		});

		/*
		| --------------------
		| Delete photo
		| --------------------
		*/
		form.on('click', 'button.delete_photo', function()
		{
			if (confirm('Are you sure you want to delete this photo?'))
			{
				// Get photo id
				var li = $(this).closest('li');
				var id = $(this).data('id');

				// Send request
				$.ajax(
				{
					type: 'post',
					url: '/admin/galleries/photos/delete',
					data:
					{
						id: id
					},
					success: function()
					{
						// Disable min height
						form.find('.photos ul').css({ 'min-height': 0 });

						// Remove list item
						li.remove();

						// Re-enable min height
						form.find('.photos ul').css(
						{
							'min-height': form.find('.photos ul').height() + 'px'
						});
					}
				});
			}
		});
	}
});