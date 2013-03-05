// Create main application object
var app = {};

// Application initialization
app.init = function()
{
	// Setup ajax defaults
	$.ajaxSetup(
	{
		type: 'POST',
		dataType: 'json'
	});

	// Setup ajax error handling
	$(document).ajaxError(function(e, jqXHR)
	{
		if (jqXHR.status === 0)
		{
			/* Ajax abort, just ignore! */
		}
		else if (jqXHR.status === 401)
		{
			alert('Sorry, but your login session expired.');
		}
		else
		{
			alert('Sorry, but an error occurred.');
		}
	});

	// Get page id
	app.page = $('body').attr('id');

	// Run page script
	if (app[app.page])
	{
		app[app.page].init();
	}
};

// Start the app
$(document).ready(function()
{
	app.init();
});