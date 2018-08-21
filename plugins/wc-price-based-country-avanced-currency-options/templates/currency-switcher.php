<?php
/**
 * Currency Switcher template
 *
 * @author 		oscargare
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $options ) : ?>
		
	<form method="post" class="wcpbc-widget-currency-switcher">		
		<select class="currency-switcher" name="wcpbc-manual-country">
			<?php foreach ($options as $key => $value) : ?>
				<option value="<?php echo $key?>" <?php echo selected($key, $selected_country ); ?> ><?php echo $value; ?></option>
			<?php endforeach; ?>
		</select>					
	</form>			
	<script type="text/javascript">
	jQuery( document ).ready( function( $ ){
		$('.wcpbc-widget-currency-switcher').on('change', 'select.currency-switcher', function(){
			$(this).closest('form').submit();
		} );
	} );
	</script>

<?php endif; ?>