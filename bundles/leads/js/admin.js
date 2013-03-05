app.admin_leads_edit_page = (function()
{
	var self = {};
	var page;

	self.init = function()
	{
		// Cache selectors
		page = $('#admin_leads_edit_page');

		// Bind events
		page.find('button.delete_lead').bind('click', self.delete_lead);
	};

	self.delete_lead = function()
	{
		if (confirm('Are you sure you want to delete this lead?'))
		{
			$.ajax(
			{
				url: '/admin/leads/delete',
				data: page.find('form').serialize(),
				success: function()
				{
					location.href = '/admin/leads';
				}
			});
		}
	};

	return {
		init: self.init
	};

}());