/*
|--------------------------------------------------------------------------
| Index
|--------------------------------------------------------------------------
*/

$.router('/admin/products', function()
{
    var form = $('form');

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
                url: '/admin/products/order',
                data:
                {
                    products: $(this).sortable('toArray').join(',')
                }
            });
        }
    }).disableSelection();
});


/*
|--------------------------------------------------------------------------
| Add
|--------------------------------------------------------------------------
*/

$.router('/admin/products/add', function()
{
    var form = $('form');

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
            url: '/admin/products/insert',
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
            success: function(product)
            {
                location.href = '/admin/products/edit/' + product.id;
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
        buttons:
        {
            h1: false,
            img: false,
            blockquote: false,
            code: false
        }
    });
});


/*
|--------------------------------------------------------------------------
| Edit
|--------------------------------------------------------------------------
*/

$.router('/admin/products/edit/[0-9]+', function()
{
    var form = $('form');

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
            url: '/admin/products/update',
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
    | Delete product
    | --------------------
    */
    form.on('click', 'button.delete_product', function()
    {
        if (confirm('Are you sure you want to delete this product?'))
        {
            $.ajax(
            {
                type: 'post',
                url: '/admin/products/delete',
                data:
                {
                    id: form.find('[name=id]').val()
                },
                success: function()
                {
                    location.href = '/admin/products';
                }
            });
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
        request:
        {
            params:
            {
                product_id: form.find('[name=id]').val()
            },
            inputName: 'image',
            endpoint: '/admin/products/photos/insert'
        },
        validation:
        {
            sizeLimit: 15728640,
            acceptFiles: 'image/jpg, image/jpeg, image/tif, image/tiff',
            stopOnFirstInvalidFile: false
        },
        callbacks:
        {
            onUpload: function(id, filename)
            {
                // Hide "no photos" message
                form.find('.photos ul li.no_photos').hide();

                // Insert row for new photo
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
                    html = '<img class="thumb" src="' + response.url + '" width="75" height="75">';
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
                else
                {
                    // Show error
                    form.find('#photo_' + id).html('Sorry, but we were unable to save the file: ' + filename + ' <button type="button" class="delete_photo">OK</button>').addClass('error');
                }
            }
        }
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
    | Delete photo
    | --------------------
    */
    form.on('click', 'button.delete_photo', function()
    {
        // Get photo id
        var li = $(this).closest('li');
        var id = $(this).data('id');

        // Send request
        if (id)
        {
            $.ajax(
            {
                type: 'post',
                url: '/admin/products/photos/delete',
                data:
                {
                    id: id
                }
            });
        }

        // Disable min height
        form.find('.photos ul').css({ 'min-height': 0 });

        // Remove list item
        li.remove();

        // Re-enable min height
        form.find('.photos ul').css(
        {
            'min-height': form.find('.photos ul').height() + 'px'
        });

        // Hide "no photos" message
        if (form.find('.photos ul li:visible').length === 0)
        {
            form.find('.photos ul li.no_photos').show();
        }
    });
});