<?php
/**
 * @package WordPress
 * @subpackage acoda
 */

/*
Template Name: Links
*/
	$acoda_layout = acoda_settings('page_layout');
	 
	$columns = 'large-8';
		
	if( $acoda_layout == "layout_one" ) 			: $columns = 'large-12';
	elseif( $acoda_layout == "layout_two" )		: $columns = 'large-8 last';
	elseif( $acoda_layout == "layout_three" ) 	: $columns = 'large-6 last';
	elseif( $acoda_layout == "layout_four" ) 	: $columns = 'large-8';
	elseif( $acoda_layout == "layout_five" )  	: $columns = 'large-6';
	elseif( $acoda_layout == "layout_six" )  	: $columns = 'large-6';
	endif;
		
	echo "\n\t". '<div id="content" class="columns '. esc_attr( $columns .' '. $acoda_layout ) .'">';
	
	wp_list_bookmarks();
		
	echo "\n\t". '</div><!-- #content -->';
		
	get_sidebar();  
	get_footer();