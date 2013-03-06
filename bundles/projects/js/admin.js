/*
|--------------------------------------------------------------------------
| Add
|--------------------------------------------------------------------------
*/
$(function()
{
	var form = $('form#projects_project_add');

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
				url: '/admin/projects/insert',
				data: form.serialize(),
				dataType: 'json',
				beforeSend: function()
				{
					// Clear existing errors
					form.find('.error_message').hide();
					form.find('input, select, textarea').removeClass('error');

					// Validate title
					if($.trim(form.find('[name=title]').val()).length === 0)
					{
						form.find('[name=title]').addClass('error').siblings('.error_message.required').show();
					}

					// Validate completed date
					if ($.trim(form.find('[name=completed_date]').val()).length === 0)
					{
						form.find('[name=completed_date]').addClass('error').siblings('.error_message.required').show();
					}
					else if (/^(19|20)\d\d[-\/.](0[1-9]|1[012])[-\/.](0[1-9]|[12][0-9]|3[01])$/.test(form.find('[name=completed_date]').val()) === false)
					{
						form.find('[name=completed_date]').addClass('error').siblings('.error_message.invalid').show();
					}

					// Return validation results
					return form.find('.error').length === 0;
				},
				success: function(project)
				{
					location.href = '/admin/projects/edit/' + project.id;
				}
			});
		});

		/*
		| --------------------
		| Setup date picker
		| --------------------
		*/
		form.find('[name=completed_date]').datepicker(
		{
			dateFormat:'yy-mm-dd'
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
	var form = $('form#projects_project_edit');

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
				url: '/admin/projects/update',
				data: form.serialize(),
				dataType: 'json',
				beforeSend: function()
				{
					// Clear existing errors
					form.find('.error_message').hide();
					form.find('input, select, textarea').removeClass('error');

					// Validate title
					if($.trim(form.find('[name=title]').val()).length === 0)
					{
						form.find('[name=title]').addClass('error').siblings('.error_message.required').show();
					}

					// Validate completed date
					if ($.trim(form.find('[name=completed_date]').val()).length === 0)
					{
						form.find('[name=completed_date]').addClass('error').siblings('.error_message.required').show();
					}
					else if (/^(19|20)\d\d[-\/.](0[1-9]|1[012])[-\/.](0[1-9]|[12][0-9]|3[01])$/.test(form.find('[name=completed_date]').val()) === false)
					{
						form.find('[name=completed_date]').addClass('error').siblings('.error_message.invalid').show();
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
		| Setup date picker
		| --------------------
		*/
		form.find('[name=completed_date]').datepicker(
		{
			dateFormat:'yy-mm-dd'
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
			handle: 'img',
			items: 'li:not(:first-child)'
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
					project_id: form.find('[name=id]').val()
				},
				inputName: 'image',
				endpoint: '/admin/projects/photos/insert'
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
						html = '<img class="thumb" src="/projects/photo/xsmall/' + response.id + '" width="75" height="75">';
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

		/*
		| --------------------
		| Delete project
		| --------------------
		*/
		form.on('click', 'button.delete_project', function()
		{
			if (confirm('Are you sure you want to delete this project?'))
			{
				$.ajax(
				{
					type: 'post',
					url: '/admin/projects/delete',
					data:
					{
						id: form.find('[name=id]').val()
					},
					success: function()
					{
						location.href = '/admin/projects';
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
					url: '/admin/projects/photos/delete',
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