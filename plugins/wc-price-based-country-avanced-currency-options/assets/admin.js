jQuery( function( $ ) {

	$('document').ready(function(){				
		$('#woocommerce_currency_pos').closest('tr').hide();

		$('.wcpbc-region-settings #exchange_rate').closest('tr').insertAfter( $('input[name="auto_exchange_rate"]').closest('tr') );		
		
		$('#exchange_rate').closest('tr').toggle( ( $('input[name="auto_exchange_rate"]:checked').val() == 'no' ) );			
		
		$('input[name="auto_exchange_rate"]').on( 'click', function(){
			$('#exchange_rate').closest('tr').toggle( $(this).val() == 'no' );
		});		

		function price_preview() {
			var symbol = $('#woocommerce_currency option:selected').text();
			var symbolPos = symbol.indexOf('(');
			if (symbolPos>-1) {

				symbol = symbol.substr(symbolPos+1, 1);

				var code = $('#woocommerce_currency option:selected').val();
				var currencyFormat = $('#wc_price_based_currency_format').val();

				if ( currencyFormat.indexOf('[price]') < 0 ) {
					currencyFormat = currencyFormat + '[price]';
				}

				var currencyPreview = currencyFormat.replace('[price]', '99.99');
				currencyPreview = currencyPreview.replace('[code]', code);
				currencyPreview = currencyPreview.replace('[symbol]', symbol );				
				$('#wc_price_based_currency_format_preview').html(currencyPreview);
			}
		};

		$('#wc_price_based_currency_format').on('change', function(){
			price_preview();
		});					
		
		price_preview();

	});
});	