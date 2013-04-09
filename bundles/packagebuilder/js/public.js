$(function()
{
	var form = $('form.package_builder');

	if (form.length)
	{
		// Show/hide options
		form.find('.options li').click(function()
		{
			form.find('.options li').removeClass('selected');
			$(this).addClass('selected');
		});

		// Update budget
		form.find('input[type="radio"]').change(function()
		{
			// Set defaults
			var total = {
				low: 0,
				high: 0
			};

			// Add options
			form.find('input[type="radio"]:checked').each(function(index)
			{
				total.low += $(this).data().priceLow;
				total.high += $(this).data().priceHigh;
			});

			// Add extras
			form.find('.extra').each(function(index)
			{
				// Set percentage
				var percentage = parseInt($(this).data().percentage, 10);

				// Calculate extras
				var extra =
				{
					low: total.low * (percentage/100),
					high: total.high * (percentage/100)
				};

				// Update totals
				total.low += extra.low;
				total.high += extra.high;

				// Display extras
				$(this).find('strong').html('$' + extra.low.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,') + ' to $' + extra.high.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,'));
			});

			// Display total
			form.find('.total strong').html('$' + total.low.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,') + ' to $' + total.high.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,'));
		});
	}
});