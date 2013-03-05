app.admin_galleries_add_page = (function()
{
	var form;
	var fields;
	var locked = false;

	function submit(event)
	{
		// Prevent default browser behavior
		event.preventDefault();

		// Stop if form is locked (prevents double submits)
		if (locked)
		{
			return false;
		}
		// Otherwise lock it and continue
		else
		{
			locked = true;
		}

		// Validate the form data
		if(validate())
		{
			// Passed, submit the request
			send_request();
		}
		else
		{
			// Failed, unlock form
			locked = false;
		}
	}

	function validate()
	{
		// Clear existing messages and errors
		form.find('.error_message').hide();
		form.find('input,select,textarea').removeClass('error');

		// Validate title
		if($.trim(fields.title.val()).length === 0)
		{
			fields.title.addClass('error').siblings('.error_message.required').show();
		}

		// Return validation results
		return form.find('.error').length === 0;
	}

	function send_request()
	{
		$.ajax(
		{
			type: 'post',
			url: '/admin/galleries/insert',
			data: form.serialize(),
			dataType: 'json',
			success: function(gallery)
			{
				location.href = '/admin/galleries/edit/' + gallery.id;
			}
		});
	}

	return {
		init: function()
		{
			// Cache selectors
			form = $('#admin_galleries_add_page form');
			fields =
			{
				title: form.find('[name=title]'),
				description: form.find('[name=description]')
			};

			// Setup events
			form.bind('submit', submit);

			// Setup markbar editor
			fields.description.markbar(
			{
				h1: false,
				img: false,
				blockquote: false,
				code: false
			});
		}
	};

}());

app.admin_galleries_edit_page = (function()
{
	var form;
	var fields;
	var locked = false;

	function submit(event)
	{
		// Prevent default browser behavior
		event.preventDefault();

		// Stop if form is locked (prevents double submits)
		if (locked)
		{
			return false;
		}
		// Otherwise lock it and continue
		else
		{
			locked = true;
		}

		// Validate the form data
		if(validate())
		{
			// Passed, submit the request
			send_request();
		}
		else
		{
			// Failed, unlock form
			locked = false;
		}
	}

	function validate()
	{
		// Clear existing messages and errors
		form.find('.error_message').hide();
		form.find('input,select,textarea').removeClass('error');

		// Validate title
		if($.trim(fields.title.val()).length === 0)
		{
			fields.title.addClass('error').siblings('.error_message.required').show();
		}

		// Return validation results
		return form.find('.error').length === 0;
	}

	function send_request()
	{
		$.ajax(
		{
			type: 'post',
			url: '/admin/galleries/update',
			data: form.serialize(),
			dataType: 'json',
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

				// Re-enable the form
				locked = false;
			}
		});
	}

	function delete_gallery()
	{
		if (confirm('Are you sure you want to delete this gallery?'))
		{
			$.ajax(
			{
				type: 'post',
				url: '/admin/galleries/delete',
				data:
				{
					id: fields.id.val()
				},
				success: function()
				{
					location.href = '/admin/galleries';
				}
			});
		}
	}

	function delete_photo()
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
	}

	return {
		init: function()
		{
			// Cache selectors
			form = $('#admin_galleries_edit_page form');
			fields =
			{
				id: form.find('[name=id]'),
				title: form.find('[name=title]'),
				description: form.find('[name=description]')
			};

			// Setup events
			form.bind('submit', submit);
			form.on('click', 'button.delete_gallery', delete_gallery);
			form.on('click', 'button.delete_photo', delete_photo);

			// Setup markbar editor
			fields.description.markbar(
			{
				h1: false,
				img: false,
				blockquote: false,
				code: false
			});

			// Setup image sorting
			form.find('.photos ul').sortable(
			{
				handle: 'img'
			}).css(
			{
				'min-height': form.find('.photos ul').height() + 'px'
			});

			// Setup image uploading
			var uploader = new qq.FineUploaderBasic(
			{
				button: form.find('a.upload_photo')[0],
				request:
				{
					params:
					{
						gallery_id: fields.id.val()
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
							html = '<img class="thumb" src="/photo-galleries/photo/xsmall/' + response.id + '" width="75" height="75">';
							html += '<div class="tools">';
							html += '<textarea name="photos[][photo][' + response.id + ']"></textarea>';
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
		}
	};

}());