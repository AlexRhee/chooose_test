(function($) {
	
	"use strict";
	
	$.fn.direction = function(type)
	{
		if( type == 'typing' )
		{
			return this.pushStack(this.get().reverse(), arguments);
		}
		else
		{
			return this.pushStack(this.get(), arguments);
		}
	}
	
    $.fn.acodaWriter = function(options)
	{
		var defaults = {
			state: 'init',
			type: 'rotate-3d',
			duration: 5000,
			delay: 1000,
			pause: 5000
		};

		var settings	= $.extend({}, defaults, options),
			writer		= this,
			writerWrap	= $(this).parents('.acoda-writer-wrap'),
			writerInner= $(this).parents('.acoda-writer-inner'),
			leadText	= $(this).parents('.acoda-writer-inner').find('span.lead-text'),
			maxWidth	= 0,
			maxHeight	= 0,
			wrapWidth	= writerInner.outerWidth(true),
			leadWidth	= leadText.outerWidth(true),
			writeTextTimeout,
			timeIn		= 50,
			timeOut		= 50,
			elementHeight = -1,
			duration,
			start,
			writerHeight;

		if( 'init' == settings.state )
		{
			$(writer).addClass('loaded');
			$('body').attr('data-acodawidth', $(window).width() );
		}
		
		// typing preset			
		if( settings.type  == 'typing' || $('body').hasClass('non_CSS3') )
		{
			timeIn		= 100;
			timeOut		= 10;
		}
		
	
		if( settings.state == 'resize' )
		{
			if( leadText.length )
			{			
				writerInner.css('max-width','none');
			}
			wrapWidth = writerInner.width();
			
			$( writer ).removeClass('ready');

			$( writer ).find('.element' ).removeClass('block');
			
			$('body').attr('data-acodawidth', $(window).width() );
		}

		$( writer ).find('.element' ).each(function(i)
		{	
			var arrValues = $(this).text().split(''),
				element = $(this);
			
			// Re-calulate Duration if timeIn exceeds it. 
			if( arrValues.length * timeIn > settings.duration )
			{
				settings.duration = arrValues.length * timeIn;
			}
		});	

		var elementHeights = $( writer ).find('.element').map(function() {
			return $(this).height();
	  	}).get();
		
		console.log( elementHeights );

		maxHeight = Math.max.apply(null, elementHeights);
		
		$( writer ).css( 'height', maxHeight );		

		var firstElement = $( writer ).find('.element:first-child' );
		
		var elementWidths = $( writer ).find('.element').map(function() {
			return $(this).width();
	  	}).get();

		maxWidth = Math.max.apply(null, elementWidths);
		
		$( writer ).css( 'width', maxWidth + 30 );

		
		$( writer ).addClass('ready');

		var writeText = function(element) 
		{
			// Check if initial load
			if( firstElement.hasClass('active') )
			{
				duration = settings.duration;	
			}
			else
			{
				duration = 500;
			}	

			
			writeTextTimeout = setTimeout(function()
			{					
				clearTimeout(writeTextTimeout);
						
				$( element ).addClass('active block visible');
				
				var prev = element.prev();
				
				// Check if on last slide
				if( prev.length === 0 )
				{
					$( writer ).find('.element').last().find('span').direction( settings.type ).each(function(i)
					{
						var character = $(this);
						var addHide = setTimeout(function()
						{
							clearTimeout(addHide);
							character.addClass('hide').removeClass('show');
						}, timeOut*i );
					});				
				}
				else
				{
					$( element ).prev().find('span').direction( settings.type ).each(function(i)
					{
						var character = $(this);
						var addHide = setTimeout(function()
						{
							clearTimeout(addHide);
							character.addClass('hide').removeClass('show');
						}, timeOut*i );
					});
				}
				
				// Delay between each slide
				$(element).delay( settings.delay ).queue(function(delay)
				{
					$(element).find('span').each(function(i)
					{
						var character = $(this);
						var addShow = setTimeout(function()
						{
							clearTimeout(addShow);
							character.removeClass('hide').addClass('show');
						}, timeIn*i );
					});		
						
					delay();
				});				

				var next = element.next();

				// Cycle back to beginning
				if (next.length === 0)
				{
					next = firstElement;				
				}

				// Pause at end
				if( $(element).is(':last-child') && settings.pause > 0 )
				{
					var pause = settings.pause;
				}
				else
				{
					var pause = 0;
				}		

				$(element).delay( pause ).queue(function(pause)
				{	
					writeText(next);
					pause();
				});
				
				
			}, duration );
			
			if( settings.state == 'resize' )
			{
				clearTimeout(writeTextTimeout);
			}
        };

        writeText( firstElement );

        return firstElement;	
    };
	

	var acodaWriters = function(state)
	{		
		$( '.acoda-writer' ).each(function()
		{
			if( $(this).hasClass('loaded' ) )
			{
				var writer	 	= $(this),
					type		= writer.attr('data-type'),
					duration	= writer.attr('data-duration'),
					delay		= writer.attr('data-delay'),
					pause		= writer.attr('data-pause');			
	
				$( writer ).acodaWriter({ 
					state: state,
					type: type,
					duration: duration,
					delay: delay,
					pause: pause
				});
			}
		});			
	};

	var acodaWriter = function( writer )
	{		
		var writer	 	= $( writer ),
			type		= writer.attr('data-type'),
			duration	= writer.attr('data-duration'),
			delay		= writer.attr('data-delay'),
			pause		= writer.attr('data-pause');			

		if( ! $( writer ).hasClass('loaded') )
		{
			$( writer ).acodaWriter({ 
				state: 'init',
				type: type,
				duration: duration,
				delay: delay,
				pause: pause
			});	
		}
	};	

	$(window).load(function()
	{
		if( $.isFunction( $.fn.waypoint ) )
		{
			$('.acoda-writer').waypoint(function() 
			{		
				acodaWriter( $(this) );
			}, 
			{
				offset: '100%'
			});	
		}
		else
		{
			$('.acoda-writer').each(function() 
			{
                acodaWriter( $(this) );
           });
		}
	});


	$(window).resize(function()
	{
		var windowWidth = $(window).width() - $('body').attr('data-acodawidth');
		if( windowWidth > 100 || windowWidth < -100  )
		{
			$('.acoda-writer .element').removeClass('visible').dequeue();
			
			setTimeout(function(){ acodaWriters('resize'); }, 100 ); // refreshes		
	
			if( $('body').hasClass('compose-mode') )
			{
				acodaWriter( $('.acoda-writer') );
			}
		}
		
	});	
	
})(jQuery);