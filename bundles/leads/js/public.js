$.router('/.*', function()
{
    function submit(event)
    {
        // Prevent default browser action
        event.preventDefault();

        // Cache form selector
        var form = $(this);

        // Validate
        if (validate(form))
        {
            send_request(form);
        }
    }

    function validate(form)
    {
        // Default valid status
        var valid = true;

        // Remove existing errors
        form.find('.error').removeClass('error');
        form.find('.error_message').remove();

        // Cache form fields
        var fields = {
            name: form.find('[name="name"]'),
            email: form.find('[name="email"]'),
            phone: form.find('[name="phone"]'),
            address: form.find('[name="address"]'),
            interest: form.find('[name="interest"]'),
            budget: form.find('[name="budget"]'),
            message: form.find('[name="message"]'),
            referral: form.find('[name="referral"]')
        };

        // Validate name
        if (fields.name.data('required') && $.trim(fields.name.val()) === '')
        {
            valid = false;
            fields.name.addClass('error').after('<div class="error_message">Required field.</div>');
        }

        // Validate email
        if (fields.email.data('required') && $.trim(fields.email.val()) === '')
        {
            valid = false;
            fields.email.addClass('error').after('<div class="error_message">Required field.</div>');
        }
        else if (fields.email.data('required') && validate_email(fields.email.val()) === false)
        {
            valid = false;
            fields.email.addClass('error').after('<div class="error_message">Invalid email address.</div>');
        }

        // Validate phone
        if (fields.phone.data('required') && $.trim(fields.phone.val()) === '')
        {
            valid = false;
            fields.phone.addClass('error').after('<div class="error_message">Required field.</div>');
        }

        // Validate address
        if (fields.address.data('required') && $.trim(fields.address.val()) === '')
        {
            valid = false;
            fields.address.addClass('error').after('<div class="error_message">Required field.</div>');
        }

        // Validate interest
        if (fields.interest.data('required') && $.trim(fields.interest.val()) === '')
        {
            valid = false;
            fields.interest.addClass('error').after('<div class="error_message">Required field.</div>');
        }

        // Validate budget
        if (fields.budget.data('required') && $.trim(fields.budget.val()) === '')
        {
            valid = false;
            fields.budget.addClass('error').after('<div class="error_message">Required field.</div>');
        }

        // Validate message
        if (fields.message.data('required') && $.trim(fields.message.val()) === '')
        {
            valid = false;
            fields.message.addClass('error').after('<div class="error_message">Required field.</div>');
        }

        // Validate referral
        if (fields.referral.data('required') && $.trim(fields.referral.val()) === '')
        {
            valid = false;
            fields.referral.addClass('error').after('<div class="error_message">Required field.</div>');
        }

        return valid;
    }

    function validate_email(value)
    {
        return (/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i).test(value);
    }

    function send_request(form)
    {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/leads/submit',
            data: form.serialize(),
            error: function()
            {
                alert('An error occurred and were were unable to send this request. Please contact us directly. Sorry for this inconvenience!');
            },
            success: function()
            {
                location.href = form.find('[name="success_url"]').val();
            }
        });
    }

    $('.bundle_leads_form').bind('submit', submit);

});