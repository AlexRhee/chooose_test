(function( $ ){
	
	"use strict";

	var apbAjaxLoadData = function( container, trigger, filter )
	{	
		var	type			= jQuery( container ).attr('data-block'),
			query 			= jQuery( container ).attr('data-query'),
			attributes 		= jQuery( container ).attr('data-attributes'),
			load_method 	= jQuery( container ).attr('data-pagination-type'),
			ajax_url 		= jQuery( container ).attr('data-ajaxurl'),
			post_count 		= jQuery( container ).attr('data-post-count'),
			ajax_action		= trigger;
		
			//if( parseInt( data_offset ) < parseInt( total ) )
			//{
				jQuery( container ).addClass('loading');
				jQuery( container + ' .apb-preloader').addClass('active');

				
				jQuery.ajax({
					  url: ajax_url,
					  type:'POST',
					  data:{
							action			: 'apb_ajaxdata',
							type			: type,
							query			: query,
						  	filter			: filter,
						  	attributes		: attributes,
						  	ajax_action		: ajax_action
					  },
					  dataType:"json",
					  success:function(data)
					  {
						    var post_offset = parseInt( jQuery( container ).attr('data-post-offset') );
						  		  	
						  
						    jQuery( container ).attr('data-post-count', data.found_posts );
							jQuery( container ).attr('data-query', data.query );
						
						  	
							jQuery( container ).find('.apb-inner-wrap').html( data.output );
						  
						    if( ( data.post_offset + data.post_count  ) < data.found_posts )
							{
								jQuery( container ).find('.apb-pagination.next').removeClass('not-active');
							}
						    else
							{
								jQuery( container ).find('.apb-pagination.next').addClass('not-active');
							}
						  
						    if( data.post_offset > post_offset )
							{
								jQuery( container ).find('.apb-pagination.prev').removeClass('not-active');
							}	
						    else
							{
								jQuery( container ).find('.apb-pagination.prev').addClass('not-active');
							}						  

						  	jQuery( container + ' .apb-preloader').removeClass('active');						  
						  	jQuery( container ).removeClass('loading');
							/*jQuery( container + ' .apb-ajax-loading').slideUp();

							if( load_method === 'scroll_load' )
							{
								jQuery.waypoints('refresh');	
							}
							else if( load_method === 'click_load' && parseInt( jQuery( container + ' > .dynamic-frame').attr('data-offset') ) >= parseInt( total ) )
							{
								jQuery( container + ' .apb-pagination .right').addClass('disable');
							}

							jQuery(window).trigger('resize');*/
					  }	  
				});						
			//}
	};

	jQuery(document).ready(function()
	{			
		jQuery( '.apb-wrap' ).each(function()
		{
			var load_method = jQuery( this ).attr('data-pagination-type'),
				container = '#' + jQuery(this).attr('id');
			
			if( load_method === 'scroll_load' )
			{
				jQuery( this ).waypoint(function(direction)
				{
					if( direction === 'down')
					{
						apbAjaxLoadData( container );								
					}
				},{
					offset: 'bottom-in-view'
				});				
			}
			else if( load_method === 'click_load' ) 
			{			
				jQuery( this ).find('.apb-pagination').on( 'click', function()
				{
					var trigger = jQuery( this ).attr('data-action');
					apbAjaxLoadData( container, trigger );	
				});
			}	

			jQuery( this ).find('.apb-ajax-filter ul li a ').on( 'click', function(e)
			{		
				e.preventDefault();
				
				var filter = jQuery( this ).attr('data-cat-id'),
					trigger = 'category';
				
				console.log( filter );
				
				apbAjaxLoadData( container, trigger, filter );	
			});
		});
	});

})(jQuery);