(function($) {
	
	"use strict";

	jQuery(document).ready(function($) {

	  $('#widgets-right').on('click', '.apb-tab-item', function(event) {
		event.preventDefault();
		var widget = $(this).parents('.widget');
		console.log(widget);
		widget.find('.apb-tab-item').removeClass('active');
		$(this).addClass('active');
		widget.find('.apb-tab').addClass('apb-hide');
		widget.find('.' + $(this).data('toggle')).removeClass('apb-hide');
	  });

	});
	
});	