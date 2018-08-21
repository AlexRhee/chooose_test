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

	$arr = array();

	$count = 1;
	$column = '';


	if ($apb_query->have_posts()) :

	$output .= '<div class="acoda-post-block apb-'. esc_attr( $layout ) .'">';
	

	if( $column_width == '1/1' && $page_layout == 'layout_one' )
	{
		$column = 'apb-col-4';
	}
	else
	{
		$column = 'apb-col-6';
	}

	while ($apb_query->have_posts()) : $apb_query->the_post();

	//setup_postdata( $post );

	$current_post = ($post->ID == $current_post_id && is_single()) ? 'current-post-item' : '';

	if( $count == 1 || $count == 2 || ( $column_width == '1/1' && $post_count > 5 && $count == 6 ) )
	{
		$output .= '<div class="apb-column '. esc_attr( $column ) .'">';
	}


	$output .=	'<div class="apb-module' . ( $count == 1 ? ' featured' : '' ) . ( $post->ID == $current_post_id && is_single() ? ' current-post-item' : '' ) .'">';

		if ( current_theme_supports('post-thumbnails') ) :
			$featured = ( in_array( $count, array('1') ) ? true : false );
			$output .= apb_thumbnail( $featured, $show_cats, $arr );
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
		

		if ( $count == 1 ) : 
			$output .= apb_excerpt( $excerpt_length,  get_the_excerpt() );
		endif;


		if ($custom_fields) : 
			$output .= apb_custom_fields( $custom_fields );
		endif;

		$output .= '</div>';


		if( $count == 1 || $count == $post_count || ( $column_width == '1/1' && $post_count > 5 && $count == 5 ) )
		{
			$output .= '</div>';
		}

		$output .= '</div>';


		
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