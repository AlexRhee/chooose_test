<?php
/**
* Standard acoda posts widget template
*
* @version     1.0.0
*/

$output = '';

if ($before_posts) :
	$output .= '<div class="apb-before">';
	$output .= wpautop($before_posts); 
	$output .= '</div>';
endif; 

	$arr = array();

	if( $layout == 'layout_2' || $thumb_align != 'top' )
	{
		$category_overlay = $title_overlay = $author_overlay = $date_overlay = $comments_overlay = false;
	}

	// Reset Image Style
	if( $layout == 'layout_1' && $thumb_style == 'circle'  )
	{
		$thumb_style = 'square';
	}

	// Reset Image Align
	if( $layout == 'layout_2' && $thumb_align != 'top'  )
	{
		$thumb_align = 'top';
	}

	
	if ($apb_query->have_posts()) :

	$output .= '<ul class="acoda-posts-widget apb-'. $layout .' '. $thumb_style .' '. $thumb_align .' text-'. $text_align .'">';

	while ($apb_query->have_posts()) : $apb_query->the_post();

	$current_post = ($post->ID == $current_post_id && is_single()) ? 'current-post-item' : '';

	$output .=	'<li class="'. ( $post->ID == $current_post_id && is_single() ? 'current-post-item' : '' ) .'">';

		if (current_theme_supports('post-thumbnails') && $show_thumbnail ) :
			
			$output .= '<div class="apb-image '. $thumb_style .'">';
			$output .= '<a href="'. get_the_permalink() .'">';
			
					
				if( empty( $thumb_size ) )
				{
					if( $layout == 'layout_1' && $thumb_align == 'top' )
					{
						$thumb_size = 'medium';
					}
					else
					{
						$thumb_size = 'thumbnail';
					}					
				}


				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size );
					
				$url 	= $image[0];
				$width 	= $image[1];
				$height = $image[2];	
	
				$alt = strtr(get_the_title(), $arr );  
				
				if( empty( $url ) )
				{
					$url = $placeholder_img;
				}
					
				$output .= '<img src="'. $url .'" alt="'. $alt .'" width="'. $width .'" height="'. $height .'" class="attachment-thumbnail size-thumbnail wp-post-image" />';

			
			$output .= '</a>';

			
				
			$overlay = array(
				$category_overlay,
				$title_overlay,
				$author_overlay,
				$date_overlay		
			);
				
			if( array_search("true",$overlay) !== false )
			{
				$output .= '<div class="overlay-bg"></div>';
				$output .= '<div class="overlay-content">';
			}
				
			if ( $title_overlay == true )
			{				
				if (get_the_title() && $show_title) :
					$output .= '<'. $title_tag .' class="post-title">';
					$output .= '<a href="'. get_the_permalink() .'">';

					$output .= strtr(get_the_title(), $arr );

					$output .= '</a>';

					$output .= '</'. $title_tag .'>';
				endif; 
			} 
			
			if ( $author_overlay == true )
			{			
				if ($show_author) :
				$output .= '<span class="post-author">'. get_the_author_posts_link() . ( $date_overlay == true ? ' - ' : '' ) .'</span>';
				endif;
			} 
				
				if ( $date_overlay == true )
				{				
					if ($show_date) :
					$output .= '<span class="post-date">'. the_time($date_format) .'</span>';
					endif;
				} 
				

				if ( $comments_overlay == true )
				{
					if ($show_comments) :
					$output .= '<span class="post-comments link_color_hover">';
						$output .= get_comments_number(__('0', 'apb'), __('1', 'apb'), __('%', 'apb'));
					$output .= '</span>';
					endif; 
				} 				

				if( array_search("true",$overlay) !== false )
				{
					$output .= '</div>';
				} 
				
				if ( $category_overlay == true )
				{
					$categories = get_the_term_list($post->ID, 'category', '', ', ');
					if ($show_cats && $categories) :
					$output .= '<span class="post-cats link_color_hover">'. $categories .'</span>';
					endif;
				} 
								                                                                            

			$output .= '</div>';
		endif;

		$output .= '<div class="apb-content">';

		if ( $category_overlay != true )
		{
			$categories = get_the_term_list($post->ID, 'category', '', ', ');
			if ( $show_cats && $categories) :
				$output .= '<div class="post-cats link_color_hover">'. $categories  .'</div>';
			endif; 
		}          

		if ( $title_overlay != true )
		{			
			if (get_the_title() && $show_title) :
			$output .= '<'. $title_tag .' class="post-title">';
				$output .= '<a href="'. get_the_permalink() .'">';
				$output .= strtr(get_the_title(), $arr );
		
			$output .=	'</a>';
			$output .= '</'. $title_tag .'>';
			endif; 
		}   


		if ( $author_overlay != true )
		{			
			if ($show_author) :
			$output .= '<span class="post-author">'. get_the_author_posts_link() . ( $show_date == true  ? ' - ' : '' ) .'</span>';
			endif;
		} 

		if ( $date_overlay != true )
		{				
			if ($show_date) :
			$output .= '<span class="post-date">'.  get_the_time($date_format) .'</span>';
			endif;
		} 

		if ( $comments_overlay != true )
		{
			if ($show_comments) :
			$output .= '<span class="post-comments link_color_hover">';
			$output .= get_comments_number(__('0', 'apb'), __('1', 'apb'), __('%', 'apb'));
			$output .= '</span>';
			endif; 
		}

		if ($show_excerpt) : 
	
			$linkmore = '';
			if ($show_readmore) {
				$linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>';
			}
		
			$output .= '<p class="post-excerpt">'. get_the_excerpt() . $linkmore .'</p>';
		endif;

		if ($show_content) :
			$output .= '<p class="post-content">'. get_the_content() .'</p>';
		endif;

		$tags = get_the_term_list($post->ID, 'post_tag', '', ', ');
		if ($show_tags && $tags) :
			$output .= '<p class="post-tags">';
			$output .= '<span class="post-tags-label">'. __('Tags', 'apb') . ':</span>';
			$output .= '<span class="post-tags-list">'. $tags .'</span>';
			$output .= '</p>';
		endif;

		if ($custom_fields) {
			$custom_field_name = explode(',', $custom_fields);
			foreach ($custom_field_name as $name) { 
				$name = trim($name);
				$custom_field_values = get_post_meta($post->ID, $name, true);
				if ($custom_field_values) {
					$output .= '<p class="post-meta post-meta-'.$name.'">';
					if (!is_array($custom_field_values)) {
						$output .= $custom_field_values;
					} else {
						$last_value = end($custom_field_values);
						foreach ($custom_field_values as $value) {
							$output .= $value;
							if ($value != $last_value) $output .= ', ';
						}
					}
					$output .= '</p>';
				}
			} 
		} 

		$output .= '</div>';

		$output .= '</li>';

	endwhile;

	$output .= '</ul>';

else :

	$output .= '<p>'. __('No posts found.', 'apb') .'</p>';

endif;

if ($after_posts) : 
	$output .= '<div class="apb-after">';
	$output .= wpautop($after_posts); 
	$output .= '</div>';
endif;