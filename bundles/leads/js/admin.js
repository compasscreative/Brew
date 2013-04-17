/*
|--------------------------------------------------------------------------
| Edit
|--------------------------------------------------------------------------
*/

$.router('/admin/leads/edit/[0-9]+', function()
{
    var form = $('form');

    /*
    | --------------------
    | Delete lead
    | --------------------
    */
    form.find('button.delete_lead').bind('click', function()
    {
        if (confirm('Are you sure you want to delete this lead?'))
        {
            $.ajax(
            {
                type: 'post',
                url: '/admin/leads/delete',
                data: form.serialize(),
                success: function()
                {
                    location.href = '/admin/leads';
                }
            });
        }
    });
});