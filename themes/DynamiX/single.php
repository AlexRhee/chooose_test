<?php
/**
 * @package WordPress
 * @subpackage acoda
 */

	get_header();

	$acoda_layout 		= acoda_settings('page_layout');
	$acoda_layout_style	= acoda_settings('post_layout_style');
		
	if (have_posts()) : 
	
			$columns = 'large-8';
				
			if( 
			$acoda_layout == "layout_one" || 
			$acoda_layout == "layout_zero" )				: $columns = 'large-12';
			elseif( $acoda_layout == "layout_two" )		: $columns = 'large-8 last';
			elseif( $acoda_layout == "layout_three" ) 	: $columns = 'large-6 last';
			elseif( $acoda_layout == "layout_four" ) 	: $columns = 'large-8';
			elseif( $acoda_layout == "layout_five" )  	: $columns = 'large-6';
			elseif( $acoda_layout == "layout_six" )  	: $columns = 'large-6';
			endif;
		
			echo "\n\t". '<div id="content" class="columns '. esc_attr( $columns .' '. $acoda_layout .' '. $acoda_layout_style ) .'">';
	
	while (have_posts()) : the_post();
	
				get_template_part( 'content', get_post_format() );
							
	endwhile; endif; 

	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}				
			
	echo "\n\t". '</div><!-- #content -->'; 
			
	get_sidebar();
	get_footer();