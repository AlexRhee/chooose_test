<?php

	/* ------------------------------------
	:: POST CATEGORY DATA
	------------------------------------ */

	$postcount = $post_count = $data_id = $z = 0;
	$acoda_slidearray = '';

	// If no shortcode make empty
	if( empty( $acoda_shortcode_id ) ) $acoda_shortcode_id = ''; 
	


	/* ------------------------------------
	:: BLACK AND WHITE EFFECT	
	------------------------------------ */

	if( $acoda_imageeffect == 'shadowblackwhite' || $acoda_imageeffect == 'frameblackwhite' || $acoda_imageeffect == 'blackwhite' )
	{
		$acoda_blackwhite = 'blackwhite';
		
		if( $acoda_imageeffect == 'shadowblackwhite' ) $acoda_imageeffect = 'shadow';
		if( $acoda_imageeffect == 'frameblackwhite' ) $acoda_imageeffect = 'frame';
		if( $acoda_imageeffect == 'blackwhite' ) $acoda_imageeffect = 'none';
	}
	else
	{
		$acoda_blackwhite = '';
	}		

	$data = $taxonomy_tags = array();
	$values_pairs = preg_split('/\|/', $acoda_loop);
	
	
	foreach($values_pairs as $pair) 
	{
		if( !empty($pair) ) 
		{
			list($key, $value) = preg_split('/\:/', $pair);
			
			if( $key == 'categories' ) 
			{
				$key = 'cat';
				$filter_cats = $value;
			}
			if( $key == 'tags' ) 
			{
				$key = 'tag__in';
				$filter_tags = $value;
				$value = explode( ',' , $value );
			}
			if( $key == 'by_id' ) 
			{
				$key = 'post__in';				
				$value = explode( ',' , $value );
			}				
			if( $key == 'tax_query' ) 
			{
				$tax = explode( ',' , $value );
				$terms = get_terms(acoda_getTaxonomies(), array('include' => array_map('abs', $tax )));		
				$tax_data = $tax_arrays = array();

				$value = array( 
					'relation' => 'OR'
				);
				
				foreach ( $terms as $term )
				{
      				$tax_data[$term->taxonomy]['terms'][] = $term->term_id;
				}
				
				foreach ( $tax_data as $tax => $term )
				{
					$tax_array = array(
						'taxonomy' => $tax,
						'field' => 'id',
						'terms' => $term['terms'],
						'operator' => 'IN'
					);
					
					array_push( $value, $tax_array );
					array_push( $taxonomy_tags, $tax_array );			
    			}			
	
				
			}	
			if( $key == 'post_type' ) 
			{
				$post_type = $value;
				$value = explode( ',' , $value );
			}												
			if( $key == 'order_by' ) $key = 'orderby';
			if( $key == 'size' ) $key = 'posts_per_page';
			
			$data[$key] = $value;
		}
	}

	// Stage Timeout
	if( $acoda_show_slider == 'stageslider' )
	{
		$timeout_data		= $data;
		$timeout_data['posts_per_page'] = '-1';
		$timeout_query 	= new WP_Query($timeout_data);
	
		while ( $timeout_query->have_posts() ) : $timeout_query->the_post();
		
			$post_id = $timeout_query->post->ID;

			$acoda_slidetimeout = ( get_post_meta( $post_id , '_'. ACODA_THEME_PREFIX .'_slidetimeout', true ) !='' ) ? get_post_meta( $post_id , '_'. ACODA_THEME_PREFIX .'_slidetimeout', true ) : '';
			
			// Timeout
			if( !empty( $acoda_slidetimeout ) )
			{
				$acoda_slidearray .= $acoda_slidetimeout .","; 
			}
			elseif( !empty( $acoda_stagetimeout ) )
			{
				$acoda_slidearray .= $acoda_stagetimeout .","; 
			} 
			else
			{
				$acoda_slidearray .= "10,";
			}	
			
			$do_not_duplicate[] = get_the_ID();
		
		endwhile;
		
		wp_reset_postdata();
	}

	$featured_query = new WP_Query($data);	
	
	$post_count = $featured_query->post_count; // Check how many posts in query.	

	// Ajax Settings
	if( !empty( $load_ajax ) )
	{
		$load_limit = ( !empty( $load_limit ) ? $load_limit : get_option('posts_per_page') );
		$load_value = ( !empty( $load_value ) ? $load_value : ( !empty( $acoda_gridcolumns ) ? $acoda_gridcolumns : 1 ) );		
	}	

	/* ------------------------------------
	:: GRID ONLY
	------------------------------------ */

	if( $acoda_show_slider == 'gridgallery' )
	{	
		if( !empty( $filter_cats ) )
		{
			$cats = explode(",", $filter_cats );
			
			foreach( $cats as $cat )
			{
				$cat = get_cat_name( $cat );
				$category_array[] = $cat; // Enter Categories into an Array
			}				
		}

		if( !empty( $filter_tags ) )
		{
			$tags = explode(",", $filter_tags );
			
			foreach( $tags as $tag )
			{
				$tag = get_tag( $tag );
				$tag = $tag->name;
				$category_array[] = $tag; // Enter Categories into an Array
			}				
		}	
	
		if( !empty( $taxonomy_tags ) )
		{			
			foreach( $taxonomy_tags as $tax_id )
			{		
				$terms = $tax_id['terms'];
				
				foreach( $terms as $term )
				{
					$tax = get_term( $term, $tax_id['taxonomy'] );
					$tax_name = $tax->name;
					$category_array[] = $tax_name; // Enter Categories into an Array				
				}
			}			
		}	
		
		if( !empty( $acoda_gridfilter) ) 
		{		
			$output .= '<div class="splitter-wrap">';
			
			// Click Filter
			if( !empty( $category_array ) && $acoda_gridfilter == 'click' )
			{
				$category_array = array_unique( $category_array );
				asort( $category_array );		
									
				$output .= '<ul class="splitter '. ( !empty( $acoda_shortcode_id ) ? "id-". esc_attr( $acoda_shortcode_id ) : '' ) .'">';
				$output .= '<li>';
				$output .= '<span class="filter-text">'. esc_html__('Filter By: ', 'dynamix' ) .'</span>';
				$output .= '<ul>';
				$output .= '<li class="segment-1 selected-1 active"><a href="#" data-value="all">'. esc_html__('All', 'dynamix' ) .'</a></li>';
	
				$catcount = 2;
								
				foreach( $category_array as $catname ) // Get category ID Array
				{ 
					if( !empty( $catname ) )
					{					
						$catname_convert = acoda_replace_chars( $catname );
						
						$output .= '<li class="segment-'. esc_attr( $catcount ) .'"><a href="#'. esc_attr( str_replace( array(' ', '&amp;' ), '', $catname_convert ) ) .'" data-value="'. esc_attr( str_replace( array(' ', '&amp;' ), '', $catname_convert ) . $acoda_shortcode_id ) .'">'. esc_html( $catname ) .'</a></li>';
					}
									
					$catcount++; 
				}
				$output .= '</ul>';
			}
			// Search Filter
			elseif( $acoda_gridfilter == 'search' )
			{
				$output .= '<input type="text" class="search-filter" placeholder="'. esc_html__('Start Searching...', 'dynamix' ) .'">';
			}
			
			$output .= '</li>';
			$output .= '</ul>';
			$output .= '</div>';
		} 
		
		$output .='<div class="dynamic-frame row clearfix" '. ( !empty( $load_ajax ) ? 'data-offset="'. esc_attr( $load_limit ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $load_value ) .'"' : '' ) .'>';
		
		if( !empty( $masonry ) )
		{
			if( $masonry == 'masonry_style_2' )
			{
				$grid_sizer = 4;
			}
			else
			{
				$grid_sizer = $acoda_gridcolumns;
			}
			
			$output .=  "\n\t". '<div class="grid-sizer columns large-'. esc_attr( 12 / $grid_sizer ) .'"></div>';
		}			
	}
	
	/* ------------------------------------
	:: GRID ONLY *END*
	------------------------------------ */
	
	while ( $featured_query->have_posts() ) : $featured_query->the_post();
	
		/* ------------------------------------
		:: GET INDIVIDUAL SLIDE DATA
		------------------------------------ */
		
		$image = acoda_catch_image(); // Check for images within post
		
		$img = $img_id = '';

		// check what image to use, custom, featured, image within post. 
		if( empty( $acoda_previewimgurl ) )
		{  
			$img_id = get_post_thumbnail_id( $featured_query->post->ID );
			if ( !empty($img_id) )
			{	
				// Get Attached / Post Image Data
				$img = acoda_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size ) );
			}
			else
			{
				$img = acoda_getImageBySize( array( 'attach_id' => 'no_image', 'thumb_size' => $img_size ) );
			}		
		}		
		
		$post_id = $featured_query->post->ID;
		
		$acoda_movieurl 		= acoda_settings('mediaurl');
		$acoda_disablegallink 	= acoda_settings('post_link');
		$acoda_displaytitle 	= acoda_settings('displaytitle');
		$acoda_postsubtitle 	= acoda_settings('pagesubtitle');
		$acoda_videotype 		= acoda_settings('media_display');
		$ratio					= 'normal';
		$acoda_videoautoplay	= '';
		$acoda_slidetimeout		= '';
		$acoda_cssclasses		= acoda_settings('css_classes');
		
		if( !empty( $acoda_videotype ) && empty( $acoda_movieurl ) )
		{
			$acoda_videotype = '';
		}
		
		// Set the Permalink
		if( get_post_meta( $post_id , '_'. ACODA_THEME_PREFIX .'_altlink', true ) !='' )
		{
			$acoda_altlink = get_post_meta( $post_id , '_'. ACODA_THEME_PREFIX .'_altlink', true );
		}
		else
		{
			$acoda_altlink = get_permalink();
		}
		
		// Set the title
		if( get_post_meta( $post_id , '_'. ACODA_THEME_PREFIX .'_pagetitle', true ) )
		{
			if( !empty( $title_excerpt ) )
			{
				$acoda_posttitle = acoda_max_character_excerpt( $title_excerpt,  get_post_meta( $post_id , '_'. ACODA_THEME_PREFIX .'_pagetitle', true ) );
			}
			else
			{
				$acoda_posttitle = get_post_meta( $post_id , '_'. ACODA_THEME_PREFIX .'_pagetitle', true );
			}
		}
		else
		{
			if( !empty( $title_excerpt ) )
			{
				$acoda_posttitle = acoda_max_character_excerpt( $title_excerpt,  the_title('', '', false) );
			}
			else
			{
				$acoda_posttitle = the_title('', '', false);	
			}
			
		}
				
		$acoda_max_characters = ( !empty( $excerpt ) ? $excerpt : 240 );
		
		if ( empty($post->post_excerpt) )
		{
			
			if( !function_exists('the_advanced_excerpt') )
			{
				$acoda_description = acoda_max_character_excerpt( $acoda_max_characters,  get_the_excerpt() );
			}
			else
			{
				$acoda_description = the_advanced_excerpt('length='. $acoda_galleryexcerpt .'&ellipsis=',true);
			}
		} 
		else
		{
			$acoda_description = get_the_excerpt(); 
		}		
		
		$acoda_videoautoplay = ( empty( $acoda_videoautoplay ) ) ? '0' : '1';


		/* ------------------------------------
		:: GRID ONLY
		------------------------------------ */
			
		$categories = '';
		
		if( !empty( $filter_cats ) )
		{		
			$post_cats = wp_get_post_categories( get_the_ID() );
			
			foreach( $post_cats as $cat )
			{
				$cat = get_cat_name( $cat );
				$categories .= str_replace( ' ', '', $cat ) . $acoda_shortcode_id .' ';
				$categories = preg_replace( "/&#?[a-z0-9]+;/i", '', $categories );
			}							
		}

		if( !empty( $filter_tags ) )
		{
			$post_tags = wp_get_post_tags( get_the_ID() );
			
			foreach( $post_tags as $tag )
			{
				$tag = $tag->name;
				$categories .= str_replace( ' ', '', $tag ) . $acoda_shortcode_id .' ';
				$categories = preg_replace( "/&#?[a-z0-9]+;/i", '', $categories );
			}				
		}
	
		
		if( !empty( $taxonomy_tags ) )
		{				
			foreach( $taxonomy_tags as $tax_id )
			{			
				$terms = $tax_id['terms'];
				$term_slug = '';
				
			
				$term_name = '';
				$term_name = wp_get_post_terms( get_the_ID(), $tax_id['taxonomy'] );
			
				if( !empty( $term_name ) )
				{
					foreach( $term_name as $term )
					{
						$term_slug = $term->name;
										
						$term_slug = acoda_replace_chars( $term_slug );
						
						$categories .= str_replace( ' ', '', $term_slug ) . $acoda_shortcode_id .' ';
						$categories = preg_replace( "/&#?[a-z0-9]+;/i", '', $categories );			
					}
				}
				
			}	
		}			
		
		// Product Price
		if( !empty( $product_price ) && class_exists( 'woocommerce' ) )
		{
			//$_product = wc_get_product( get_the_ID() );
			
			$_product = new WC_Product(  get_the_ID() );
			
			$acoda_product_price = get_woocommerce_currency_symbol() . $_product->get_regular_price();
			
			$variation_product = new WC_Product_Variable( get_the_ID() );
			
			$variations = $variation_product->get_available_variations();
			
			if( !empty( $variations ) )
			{
				$variation_product_id = $variations [0]['variation_id'];
			
				$variation_product = new WC_Product_Variation( $variation_product_id );

				if( $variation_product->get_regular_price() !='' )
				{
					$acoda_product_price = get_woocommerce_currency_symbol() . $variation_product->get_regular_price();
				}
			}
		}



		// Post Category
		if( !empty( $post_category ) )
		{
			$cats = get_the_category( get_the_ID() );
			
			if ( !empty( $cats ) ) 
			{
				$acoda_post_category = '<a href="'. esc_url( get_category_link( $cats[0]->term_id ) ) .'"><span class="post_category metadata">' . esc_html( $cats[0]->name ) . '</span></a>';
			}			
		}	

		// Post Author
		if( !empty( $post_author ) )
		{
			$author_id		= get_post_field( 'post_author', get_the_ID() );
			$author_name	= get_the_author_meta( 'display_name', $author_id );
			$author_url	= get_author_posts_url( $author_id );
			$acoda_post_author = '<a href="'. $author_url .'"><span class="post_author metadata">'. get_avatar( $author_id, 40 ) . $author_name . ( !empty( $post_date ) ? '&nbsp;-&nbsp;' : '' ) .'</span></a>';
		}	

		// Post Date
		if( !empty( $post_date ) )
		{
			$meta_date_format = acoda_settings('meta_date_format_single');
			$acoda_post_date  =  '<span class="date metadata">'. get_the_time( $meta_date_format ) .'</span>';
		}				
		
		/* ------------------------------------
		
		:: CUSTOM FIELD DATA *END*
		
		------------------------------------ */   
		
		$do_not_duplicate[] = get_the_ID();
		
		$postcount++;
		$data_id++;
	
		/* ------------------------------------
		:: GET SLIDER FRAME
		------------------------------------ */			
			
		if(	$acoda_show_slider == 'stageslider' )
		{
			require( get_template_directory() .'/lib/inc/stage-gallery-frame.php' ); // STAGE
		}
		elseif( $acoda_show_slider == 'gridgallery' )
		{
			require( get_template_directory() .'/lib/inc/grid-gallery-frame.php' ); // GRID
		}
		elseif( $acoda_show_slider == 'groupslider' )
		{
			require( get_template_directory() .'/lib/inc/group-gallery-frame.php' ); // GROUP SLIDER
		}		

		$z++;
		
		if( $z == $load_limit && !empty( $load_ajax ) )
		{
			if( $acoda_show_slider == 'groupslider' )
			{
				if( $postcount != '0' ) 
				{				
					$output .= '</div><!--  / row -->';
				}
			}	

			if( $acoda_show_slider == 'gridgallery' )
			{
				//$output .= '</div>';
			}			
					
			break;
		}			
	
	endwhile;
	

	/* ------------------------------------
	
	:: GROUP SLIDER ONLY 
	
	------------------------------------ */
	
	if( $acoda_show_slider == 'groupslider' )
	{
		if( $postcount != "0" ) 
		{
			$postcount = "0"; // CHECK NEEDS END TAG 
			$output .= '</div><!--  / row -->';
		} 
	}
	
	/* ------------------------------------
	
	:: GRID ONLY 
	
	------------------------------------ */

	if( $acoda_show_slider == 'gridgallery' )
	{
		$output .= '</div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();