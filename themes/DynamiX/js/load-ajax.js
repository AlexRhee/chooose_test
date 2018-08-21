(function( $ ){
	
	"use strict";

	var acodaAjaxLoadData = function( container )
	{
		var	type			= jQuery( container ).attr('data-type'),
			source			= jQuery( container ).attr('data-source'),
			query 			= jQuery( container ).attr('data-query'),
			load_method 	= jQuery( container ).attr('data-load-method'),
			ajax_url 		= jQuery( container ).attr('data-ajaxurl'),
			attributes 	= jQuery( container ).attr('data-attributes'),	
			postlayout 	= jQuery( container ).attr('data-postlayout'),	
			grid_columns 	= jQuery( container ).attr('data-grid-columns'),
			data_offset 	= jQuery( container + ' > .dynamic-frame').attr('data-offset'),	
			load_value 	= jQuery( container + ' > .dynamic-frame').attr('data-load-value'),
			total 			= jQuery( container + ' > .dynamic-frame').attr('data-total'),
			gallery_type	= jQuery( container + ' > .dynamic-frame').attr('data-gallery-type');
			
		
			if( parseInt( data_offset ) < parseInt( total ) )
			{
				
				jQuery( container + ' .acoda-ajax-loading').slideDown();

				
				jQuery.ajax({
					  url: ajax_url,
					  type:'POST',
					  data:{
							action			: 'acoda_ajaxdata',
							type			: type,
							query			: query,
							source			: source,
							data_offset		: data_offset,
							load_value		: load_value,
							attributes		: attributes,
							postlayout		: postlayout,
							grid_columns	: grid_columns
					  },
					  success:function(data)
					  {
							jQuery( container + ' > .dynamic-frame').attr('data-offset', parseInt( data_offset ) + parseInt( load_value ) );

							// Masonry
							if( jQuery( container ).hasClass('masonry') || jQuery( container ).hasClass('filter search') || jQuery( container ).hasClass('click filter')  )
							{													
								jQuery( container + ' > .dynamic-frame' ).isotope( 'insert', jQuery( data ) );

								jQuery( container + ' > .dynamic-frame' ).imagesLoaded( function()
								{						
									jQuery( container + ' > .dynamic-frame' ).isotope( 'layout' );
									jQuery( container + ' .columns.acoda-animate-in' ).not( container + ' .columns.acoda-animate-in.loaded' ).each(function(i)
									{
										//jQuery(this).waypoint(function(down)
										//{
											var column = $(this);
											//setTimeout(function() {
												column.addClass('loaded');
											//}, 20*i);
										//},
										//{
										//	offset: '85%'
										//});		
									});

									jQuery(window).trigger('resize');							
								});							
							}
							else
							{
								jQuery( container + ' > .dynamic-frame' ).append( jQuery( data ) );

								jQuery( container + ' .columns.acoda-animate-in' ).not( container + ' .columns.acoda-animate-in.loaded' ).each(function(i)
								{
									//jQuery(this).waypoint(function(down)
									//{
										var column = $(this);
										//setTimeout(function() {
											column.addClass('loaded');
										//}, 20*i);
									//},
									//{
										//offset: '85%'
									//});		
								});	
							}

							jQuery( container + ' .acoda-ajax-loading').slideUp();

							if( load_method == 'scroll_load' )
							{
								jQuery.waypoints('refresh');	
							}
							else if( load_method == 'click_load' && parseInt( jQuery( container + ' > .dynamic-frame').attr('data-offset') ) >= parseInt( total ) )
							{
								jQuery( container + ' .acoda-ajax-loaddata').slideUp();
							}

							jQuery(window).trigger('resize');
					  }	  
				});						
			}
	}

	jQuery(document).ready(function()
	{			
		jQuery( '.acoda-ajax-container' ).each(function(i)
		{
			
			var load_method = jQuery( this ).attr('data-load-method');
			
			if( load_method == 'scroll_load' )
			{
				jQuery( this ).waypoint(function(direction)
				{
					if( direction == 'down')
					{
						var	container = '#' + jQuery(this).attr('id');		
						acodaAjaxLoadData( container );								
					}
				},{
					offset: 'bottom-in-view'
				});				
			}
			else if( load_method == 'click_load' ) 
			{
				var	container = '#' + jQuery(this).attr('id');		
		
				jQuery( this ).find('.acoda-ajax-loaddata').on( 'click', function()
				{	
						acodaAjaxLoadData( container );	
				});
			}	
		});
	});

})(jQuery);