<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" id="bbp-search-form" action="<?php esc_attr( bbp_search_url() ); ?>">
	<div>
		<label class="screen-reader-text hidden" for="bbp_search"><?php esc_html_e( 'Search for:', 'dynamix' ); ?></label>
		<input type="hidden" name="action" value="bbp-search-request" />
		<input tabindex="<?php esc_attr( bbp_tab_index() ); ?>" type="text" placeholder="<?php esc_attr_e( 'Search', 'dynamix' ); ?>" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" />
		<button tabindex="<?php esc_attr( bbp_tab_index() ); ?>" type="submit" id="bbp_search_submit"><i class="fal fa-search"></i></button>
	</div>
</form>
