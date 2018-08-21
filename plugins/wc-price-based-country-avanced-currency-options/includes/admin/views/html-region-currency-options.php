<!-- Auto update exchange rate -->			
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="auto_exchange_rate"><?php _e( 'Auto update exchange rate', 'wc-price-based-country' ); ?></label>		
	</th>
	<td class="forminp forminp-radio">
		<fieldset>
			<ul>
				<li>
					<label><input name="auto_exchange_rate" value="yes" <?php checked( $region['auto_exchange_rate'], 'yes' ); ?> type="radio"> <?php _e( 'Yes, Update exchange rate daily from API provider.', 'wc-price-based-country' ); ?></label>
				</li>
				<li>
					<label><input name="auto_exchange_rate" value="no" <?php checked( $region['auto_exchange_rate'], 'no' ); ?> type="radio"> <?php _e( 'No, I will enter enter exchange rate manually.', 'wc-price-based-country' ); ?></label>
				</li>
			</ul>
		</fieldset>
	</td>
</tr>

<!-- Currency format -->			
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="currency_format"><?php _e( 'Currency Format', 'wc-price-based-country' ); ?></label>
		<?php echo wc_help_tip( __( 'Enter the currency format. Supports the following placeholders: [code] = currency code, [symbol] = currency symbol, [price] = product price.', 'wc-price-based-country' ) ); ?>
	</th>
	<td class="forminp forminp-text">
		<input name="currency_format" id="currency_format" style="min-width:350px;" value="<?php echo $region['currency_format']; ?>" class="" placeholder="<?php echo get_option( 'wc_price_based_currency_format' ); ?>" type="text">
		<span class="description"><?php _e( 'Leave empty to use default currency format.', 'wc-price-based-country' ); ?></span>
	</td>
</tr>

<!-- Thousand Separator -->			
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="price_thousand_sep"><?php _e('Thousand Separator', 'wc-price-based-country'); ?></label>		
		<?php echo wc_help_tip( __( 'This sets the thousand separator of displayed prices.', 'woocommerce' ) ); ?>
	</th>
	<td class="forminp forminp-text">
		<input name="price_thousand_sep" id="price_thousand_sep" style="width:50px;" value="<?php echo $region['price_thousand_sep']; ?>" class="" placeholder="" type="text"> 						
	</td>
</tr>

<!-- Decimal Separator -->			
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="price_decimal_sep"><?php _e('Decimal Separator', 'wc-price-based-country'); ?></label>		
		<?php echo wc_help_tip( __( 'This sets the decimal separator of displayed prices.', 'woocommerce' ) ); ?>
	</th>
	<td class="forminp forminp-text">
		<input name="price_decimal_sep" id="price_decimal_sep" style="width:50px;" value="<?php echo $region['price_decimal_sep']; ?>" class="" placeholder="" type="text"> 						
	</td>
</tr>

<!-- Num Decimals -->			
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="price_num_decimals"><?php _e('Number of Decimals', 'wc-price-based-country'); ?></label>	
		<?php echo wc_help_tip( __( 'This sets the number of decimal points shown in displayed prices.', 'woocommerce' ) ); ?>	
	</th>
	<td class="forminp forminp-text">
		<input name="price_num_decimals" id="price_num_decimals" style="width:50px;" value="<?php echo $region['price_num_decimals']; ?>" class="" placeholder="" min="0" step="1" type="number" > 						
	</td>
</tr>