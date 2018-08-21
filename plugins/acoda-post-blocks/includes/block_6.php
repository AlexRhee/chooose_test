<?php
/**
* Standard acoda posts widget template
*
* @version     1.0.0
*/



	if ($before_posts) :
		$output .= '<div class="apb-before">';
		$output .= wpautop($before_posts); 
		$output .= '</div>';
	endif; 

	$arr = $featured_array = array();

	$count = 1;
	$column = '';


	if ($apb_query->have_posts()) :

	$output .= '<div class="acoda-post-block apb-'. esc_attr( $layout ) .'">';

	if( $column_width == 'widget' )
	{
		$column = '';
		$full_width = false;
	}
	else if( $column_width == '1/1' && $page_layout == 'layout_one' )
	{
		$column = 'apb-col-4';
		$full_width = true;
	}
	else
	{
		$column = 'apb-col-6';
		$full_width = false;
	}
	

	while ($apb_query->have_posts()) : $apb_query->the_post();


	$current_post = ($post->ID == $current_post_id && is_single()) ? 'current-post-item' : '';

	if( ( ( $count -1 ) % 3 == 0 && $full_width == true ) || ( ( $count -1 ) % 2 == 0 && $full_width == false )  ) 
	{
		$output .= '<div class="apb-row">';
	}

	$output .= '<div class="apb-column '. esc_attr( $column ) .'">';

	$output .=	'<div class="apb-module featured' . ( $post->ID == $current_post_id && is_single() ? ' current-post-item' : '' ) .'">';

		if ( current_theme_supports('post-thumbnails') ) :

			$output .= apb_thumbnail( true, $show_cats, $arr, 'apb-featured' );

		endif;

		$output .= '<div class="apb-content">';

		if (get_the_title() ) :
			$output .= apb_title( $title_tag, $arr, $title_length );
		endif; 
		
				
		if ($show_author) :
			$output .= apb_author( $show_date );
		endif;
		
			
		if ($show_date) :
			$output .= apb_date();
		endif;
		

		if ($show_comments) :
			$output .= apb_comments();
		endif; 


		if ($custom_fields) : 
			$output .= apb_custom_fields( $custom_fields );
		endif;

		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		

		if( ( $count % 3 == 0 && $full_width == true ) || ( $count % 2 == 0 && $full_width == false ) || ( $count == $post_count ) ) 
		{
			$output .= '</div>';
		}

		$count++;
		

	endwhile;


	$output .= '</div>';

else :

	$output .= '<p>'. __('No posts found.', 'apb') .'</p>';

endif;

if ($after_posts) : 
	$output .= '<div class="apb-after">';
	$output .= wpautop($after_posts); 
	$output .= '</div>';
endif;