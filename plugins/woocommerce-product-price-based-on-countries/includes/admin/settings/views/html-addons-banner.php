<?php
	$features = array(
		__( 'Automatic updates of exchange rates.', 'wc-price-based-country' ),
		__( 'Display the currency code next to price.', 'wc-price-based-country' ),
		__( 'Thousand separator, decimal separator and number of decimals by pricing zone.', 'wc-price-based-country' ),
		__( 'Currency switcher widget.', 'wc-price-based-country' ),
		sprintf( __( 'Support to WooCommerce %sSubscriptions%s.', 'wc-price-based-country' ), '<strong>', '</strong>' ),
		sprintf( __( 'Support to WooCommerce %sProduct Bundles%s.', 'wc-price-based-country' ), '<strong>', '</strong>' ),
		sprintf( __( 'Support to WooCommerce %sProduct Add-ons%s.', 'wc-price-based-country' ), '<strong>', '</strong>' ),
		sprintf( __( 'Support to WooCommerce %sProduct Bookings%s.', 'wc-price-based-country' ), '<strong>', '</strong>' ),
		__( 'More features and integrations is coming.', 'wc-price-based-country' ),
		__( 'No ads.', 'wc-price-based-country' )
	);
?>
<div class="wc_addons_wrap wcpbc_addon_banner">
	<ul class="products">
		<li class="product" style="float:none;">
			<a href="http://www.pricebasedcountry.com/product/avanced-currency-options/?utm_source=pbc-settings&utm_medium=banner&utm_campaign=Extend" target="_blank">
				<h2><span class="dashicons dashicons-star-filled"></span><span class="feature_text">Upgrade to Pro version</span></h2>				
				<ul class="wcpbc_addon_banner_features">
					<?php 
					foreach ( $features as $feature ) {
						echo '<li><span class="dashicons dashicons-yes"></span><span class="feature_text">' . $feature . '</span></li>';					
					} 
					?>					
				</ul>
			</a>
		</li>		
	</ul>	
</div>
<div style="padding-left:20px;">
	<a class="button button-primary" href="https://www.pricebasedcountry.com/pricing/?utm_source=settings&utm_medium=banner&utm_campaign=Get_Pro">Upgrade to Pro version now!</a>
</div>