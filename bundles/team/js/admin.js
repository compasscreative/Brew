/*
|--------------------------------------------------------------------------
| Index
|--------------------------------------------------------------------------
*/
	var form = $('form#team_index');

	if (form.length)
	{
		/*
		| --------------------
		| Setup image sorting
		| --------------------
		*/
		form.find('ul').sortable(
		{
			handle: 'img,.no_photo',
			update: function(event, ui)
			{
				$.ajax(
				{
					type: 'post',
					url: '/admin/team/order',
					data: form.serialize(),
					success: function(r)
					{
						console.log(r);
					}
				});
			}
		}).css(
		{
			'min-height': form.find('ul').height() + 'px'
		});
	}


/*
|--------------------------------------------------------------------------
| Add
|--------------------------------------------------------------------------
*/
$(function()
{
	var form = $('form#team_team_member_add');

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
				url: '/admin/team/insert',
				data: form.serialize(),
				dataType: 'json',
				beforeSend: function()
				{
					// Clear existing errors
					form.find('.error_message').hide();
					form.find('input, select, textarea').removeClass('error');

					// Validate first name
					if ($.trim(form.find('[name=first_name]').val()).length === 0)
					{
						form.find('[name=first_name]').addClass('error').siblings('.error_message.required').show();
					}

					// Validate last name
					if ($.trim(form.find('[name=last_name]').val()).length === 0)
					{
						form.find('[name=last_name]').addClass('error').siblings('.error_message.required').show();
					}

					// Validate email
					if (form.find('[name=email]').val().length > 0 && !/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(form.find('[name=email]').val()))
					{
						form.find('[name=email]').addClass('error').siblings('.error_message.invalid').show();
					}

					// Return validation results
					return form.find('.error').length === 0;
				},
				success: function(team_member)
				{
					location.href = '/admin/team/edit/' + team_member.id;
				}
			});
		});

		/*
		| --------------------
		| Setup markbar editor
		| --------------------
		*/
		form.find('[name=bio]').markbar(
		{
			buttons:
			{
				h1: false,
				img: false,
				blockquote: false,
				code: false
			}
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
	var form = $('form#team_team_member_edit');

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
				url: '/admin/team/update',
				data: form.serialize(),
				dataType: 'json',
				beforeSend: function()
				{
					// Clear existing errors
					form.find('.error_message').hide();
					form.find('input, select, textarea').removeClass('error');

					// Validate first name
					if ($.trim(form.find('[name=first_name]').val()).length === 0)
					{
						form.find('[name=first_name]').addClass('error').siblings('.error_message.required').show();
					}

					// Validate last name
					if ($.trim(form.find('[name=last_name]').val()).length === 0)
					{
						form.find('[name=last_name]').addClass('error').siblings('.error_message.required').show();
					}

					// Validate email
					if (form.find('[name=email]').val().length > 0 && !/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(form.find('[name=email]').val()))
					{
						form.find('[name=email]').addClass('error').siblings('.error_message.invalid').show();
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
		form.find('[name=bio]').markbar(
		{
			buttons:
			{
				h1: false,
				img: false,
				blockquote: false,
				code: false
			}
		});

		/*
		| --------------------
		| Setup image uploading
		| --------------------
		*/
		var uploader = new qq.FineUploaderBasic(
		{
			button: form.find('a.upload_photo')[0],
			multiple: false,
			request:
			{
				params:
				{
					id: form.find('[name=id]').val()
				},
				inputName: 'image',
				endpoint: '/admin/team/insert-photo'
			},
			validation:
			{
				sizeLimit: 15728640,
				acceptFiles: 'image/jpg, image/jpeg, image/tif, image/tiff'
			},
			callbacks:
			{
				onError: function(id, name, errorReason)
				{
					alert(errorReason);
				},
				onUpload: function(id, filename)
				{
					form.find('.photo').html('<div class="info">Uploading&hellip;</div>');
				},
				onProgress: function(id, filename, uploaded_bytes, total_bytes)
				{
					var uploaded = Math.round((uploaded_bytes/total_bytes)*100);

					if (uploaded >= 100)
					{
						form.find('.photo').html('<div class="info">Processing ' + filename + '&hellip;</div>');
					}
					else
					{
						form.find('.photo').html('<div class="info">Uploading ' + filename + '&hellip; (' + uploaded + '%)</div>');
					}
				},
				onComplete: function(id, filename, response)
				{
					if (response.success)
					{
						form.find('.photo').html('<img src="' + response.url + '">');
					}
				}
			}
		});

		/*
		| --------------------
		| Delete team member
		| --------------------
		*/
		form.on('click', 'button.delete', function()
		{
			if (confirm('Are you sure you want to delete this team member?'))
			{
				$.ajax(
				{
					type: 'post',
					url: '/admin/team/delete',
					data:
					{
						id: form.find('[name=id]').val()
					},
					success: function()
					{
						location.href = '/admin/team';
					}
				});
			}
		});
	}
});