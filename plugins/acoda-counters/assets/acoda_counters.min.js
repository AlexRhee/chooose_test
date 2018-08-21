(function($) {


    $.fn.acodaCounter = function(options)
	{
		var defaults = {
			type: 'value'
		};

		var settings	= $.extend({}, defaults, options),		
			type		= settings.type
			counter		= $( this );
			
		counter.addClass('loaded');
		
		if( 'value' == type )
		{
			$( counter ).countid();
		}
		else if( 'date' == type )
		{
			var date				= counter.attr('data-date'),
				remainingFormat	= counter.attr('data-remaining-format'),
				elapsedFormat		= counter.attr('data-elapsed-format');			
							
			$( counter ).countid({
				clock: true,
				dateTime: date,
				dateTplRemaining: remainingFormat,
				dateTplElapsed: elapsedFormat,
			});
		}
	};
		
	var acodaCounter = function( counter )
	{
		var counter		= $( counter ),
			type			= counter.attr('data-type');
				
		if( ! $( counter ).hasClass('loaded') )
		{
			$( counter ).acodaCounter({ 
				type: type
			});				
		}	
	};

	$(window).load(function()
	{
		$( '.acoda-counter.date' ).each(function(index, element) 
		{
            acodaCounter( $(this) );
		});
		
		if( $.isFunction( $.fn.waypoint ) )
		{
			$('.acoda-counter.value').waypoint(function() 
			{		
				acodaCounter( $(this ) );
			}, 
			{
				offset: "95%"
			});				
		}
		else
		{	
			$( '.acoda-counter.value' ).each(function(index, element) 
			{
				acodaCounter( $(this) );
			});
		}
	});
	
})(jQuery);