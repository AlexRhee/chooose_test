jQuery( document ).ready( function( $ ){

	$('body').on( 'change', '.wcpbc_subscription_price[type=text]', function(){

		var subscription_price_field = $(this);				
		var subscription_price = parseFloat( accounting.unformat( subscription_price_field.val(), woocommerce_admin.mon_decimal_point ) );

		var regular_price_field = $('#' + subscription_price_field.attr('id').replace('_subscription','_regular') ) ;		
		regular_price_field.val(subscription_price);

	});

	$('#woocommerce-product-data').on('woocommerce_variations_added woocommerce_variations_loaded', function(){		
			
		$('.wpbc_variable_pricing input[name*="variable_regular_price"]').closest('p.form-row').addClass('hide_if_variable-subscription');			

		if ( $('select#product-type').val()=='variable-subscription' ) {
			$('.wpbc_variable_pricing input[name*="variable_regular_price"]').closest('p.form-row').hide().next().removeClass('form-row-last').addClass('form-row-full');					
			$('.wcpbc_wrapper_variable_sale_price_dates').removeClass('form-row-full').addClass('form-row-last');
		}		
	});

	

});