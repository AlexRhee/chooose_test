<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <?php echo '<input type="text" name="s" id="s" placeholder="'. acoda_settings('search_placeholder') .'" />'; ?>
	<button type="submit" id="searchsubmit"><i class="fal fa-search"></i></button>
</form>