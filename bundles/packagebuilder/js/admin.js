/*
|--------------------------------------------------------------------------
| Index
|--------------------------------------------------------------------------
*/
    var form = $('form#packagebuilder_index');

    if (form.length)
    {
        /*
        | --------------------
        | Setup image sorting
        | --------------------
        */
        form.find('ul').sortable(
        {
            items: 'li:not(.headings)',
            handle: '.drag_handle',
            placeholder: 'drag_placeholder',
            forcePlaceholderSize: true,
            update: function(event, ui)
            {
                $.ajax(
                {
                    type: 'post',
                    url: '/admin/package-builder/order',
                    data:
                    {
                        options: $(this).sortable('toArray').join(',')
                    }
                });
            }
        }).disableSelection();
    }


/*
|--------------------------------------------------------------------------
| Add
|--------------------------------------------------------------------------
*/
$(function()
{
    var form = $('form#packagebuilder_option_add');

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
                url: '/admin/package-builder/insert',
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function()
                {
                    // Clear existing errors
                    form.find('.error_message').hide();
                    form.find('input, select, textarea').removeClass('error');

                    // Validate name
                    if ($.trim(form.find('[name=name]').val()).length === 0)
                    {
                        form.find('[name=name]').addClass('error').siblings('.error_message.required').show();
                    }

                    // Validate prices
                    $.each(['small_price_1', 'small_price_2', 'medium_price_1', 'medium_price_2', 'large_price_1', 'large_price_2'], function(index, field)
                    {
                        if ($.trim(form.find('[name=' + field + ']').val()).length === 0)
                        {
                            form.find('[name=' + field + ']').addClass('error').siblings('.error_message.required').show();
                        }
                        else if (!(!isNaN(parseFloat(form.find('[name=' + field + ']').val())) && isFinite(form.find('[name=' + field + ']').val())))
                        {
                            form.find('[name=' + field + ']').addClass('error').siblings('.error_message.invalid').show();
                        }
                    });

                    // Return validation results
                    return form.find('.error').length === 0;
                },
                success: function(team_member)
                {
                    location.href = '/admin/package-builder/edit/' + team_member.id;
                }
            });
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
    var form = $('form#packagebuilder_option_edit');

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
                url: '/admin/package-builder/update',
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function()
                {
                    // Clear existing errors
                    form.find('.error_message').hide();
                    form.find('input, select, textarea').removeClass('error');

                    // Validate name
                    if ($.trim(form.find('[name=name]').val()).length === 0)
                    {
                        form.find('[name=name]').addClass('error').siblings('.error_message.required').show();
                    }

                    // Validate prices
                    $.each(['small_price_1', 'small_price_2', 'medium_price_1', 'medium_price_2', 'large_price_1', 'large_price_2'], function(index, field)
                    {
                        if ($.trim(form.find('[name=' + field + ']').val()).length === 0)
                        {
                            form.find('[name=' + field + ']').addClass('error').siblings('.error_message.required').show();
                        }
                        else if (!(!isNaN(parseFloat(form.find('[name=' + field + ']').val())) && isFinite(form.find('[name=' + field + ']').val())))
                        {
                            form.find('[name=' + field + ']').addClass('error').siblings('.error_message.invalid').show();
                        }
                    });

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
        | Setup image uploading
        | --------------------
        */
        var uploaders = [];

        $.each(['small', 'medium', 'large'], function(index, size)
        {
            uploaders[size] = new qq.FineUploaderBasic(
            {
                button: form.find('.photo.' + size + ' a')[0],
                multiple: false,
                request:
                {
                    params:
                    {
                        id: form.find('[name=id]').val(),
                        size: size
                    },
                    inputName: 'image',
                    endpoint: '/admin/package-builder/update-photo'
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
                        form.find('.photo.' + size + ' p').html('An error occurred.');
                    },
                    onUpload: function(id, filename)
                    {
                        form.find('.photo.' + size + ' p').html('Uploading&hellip;');
                    },
                    onProgress: function(id, filename, uploaded_bytes, total_bytes)
                    {
                        var uploaded = Math.round((uploaded_bytes/total_bytes)*100);

                        if (uploaded >= 100)
                        {
                            form.find('.photo.' + size + ' p').html('Processing ' + filename + '&hellip;');
                        }
                        else
                        {
                            form.find('.photo.' + size + ' p').html('Uploading ' + filename + '&hellip; (' + uploaded + '%)');
                        }
                    },
                    onComplete: function(id, filename, response)
                    {
                        if (response.success)
                        {
                            form.find('.photo.' + size + ' p').html('');
                            form.find('.photo.' + size + ' img').remove();
                            form.find('.photo.' + size).prepend('<img src="' + response.url + '" width="260"  height="260">');
                        }
                        else
                        {
                            form.find('.photo.' + size + ' p').html('Unable to use that file.');
                        }
                    }
                }
            });
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
                    url: '/admin/package-builder/delete',
                    data:
                    {
                        id: form.find('[name=id]').val()
                    },
                    success: function()
                    {
                        location.href = '/admin/package-builder';
                    }
                });
            }
        });
    }
});