<?php

	/* ------------------------------------
	
	:: Attach Images
	
	------------------------------------ */

	$postcount = $post_count = $data_id = $z = $video_id = 0;
	$acoda_blackwhite = $acoda_slidearray = '';

	
	if( empty($acoda_shortcode_id) ) $acoda_shortcode_id = ''; // if is shortcode assign ID.

	// Get Image ID's
	$images_ids = empty( $acoda_images_attach ) ? array() : explode( ',', trim( $acoda_images_attach ) );

			
	// Count Slides
	$post_count = count($images_ids);
	
	// Ajax Settings
	if( !empty( $load_ajax ) )
	{
		$load_limit = ( !empty( $load_limit ) ? $load_limit : get_option('posts_per_page') );
		$load_value = ( !empty( $load_value ) ? $load_value : ( !empty( $acoda_gridcolumns ) ? $acoda_gridcolumns : 1 ) );		
	}	
	
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

	// Categories & Timeouts	
	foreach( $images_ids as $img_id )
	{			
		// Get Image Meta Data Attachment ID
		$attachment_meta = acoda_attachment_data( $img_id, 'image' );
			
		$filter_tags = get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_media-tags', true );		
		$filter_tags = explode( ",", $filter_tags );
						
		foreach( $filter_tags as $filter_tag )
		{
			$category_array[] = $filter_tag; // Enter Categories into an Array
		}			

		$acoda_slidetimeout 	= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_gallery-slide-timeout', true );		

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
	}
	

	/* ------------------------------------
	:: GRID ONLY
	------------------------------------ */

	if( $acoda_show_slider == 'gridgallery' )
	{
		if( !empty( $acoda_gridfilter) ) 
		{		
			$output .= '<div class="splitter-wrap">';
			
			// Click Filter
			if( !empty( $category_array ) && $acoda_gridfilter == 'click' )
			{
				$category_array = array_unique( $category_array );
				asort( $category_array );		
									
				$output .= '<ul class="splitter '. ( !empty( $acoda_shortcode_id ) ? esc_attr( "id-".$acoda_shortcode_id ) : '' ) .'">';
				$output .= '<li>';
				$output .= '<span class="filter-text">'. esc_html__('Filter By: ', 'dynamix' ) .'</span>';
				$output .= '<ul>';
				$output .= '<li class="segment-1 selected-1 active"><a href="#" data-value="all">'. esc_html__('All', 'dynamix' ) .'</a></li>';
	
				$catcount = 2;
								
				foreach( $category_array as $catname ) // Get category ID Array
				{ 
					if( !empty( $catname ) )
					{
						$output .= '<li class="segment-'. esc_attr( $catcount ) .'"><a href="#'. esc_attr( str_replace(' ','', $catname ) ) .'" data-value="'. esc_attr( str_replace(' ','', $catname ) . $acoda_shortcode_id ) .'">'. esc_html( $catname ) .'</a></li>';
					}
									
					$catcount++; 
				}
				$output .= '</ul>';
			}
			// Search Filter
			elseif( $acoda_gridfilter == 'search' )
			{
				$output .= '<input type="text" class="search-filter" placeholder="'. esc_attr__('Start Searching...', 'dynamix' ) .'">';
			}
			
			$output .= '</li>';
			$output .= '</ul>';
			$output .= '</div>';
		} 
		
		$output .='<div class="dynamic-frame row clearfix" '. ( !empty( $load_ajax ) ? 'data-offset="'. esc_attr( $load_limit ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $load_value ) .'"' : '' ) .'>';

		if( !empty( $masonry ) )
		{
			$output .= "\n\t". '<div class="grid-sizer columns large-'. 12 / esc_attr( $acoda_gridcolumns ) .'"></div>';
		}			
	}

	/* ------------------------------------
	:: GET INDIVIDUAL SLIDE DATA
	------------------------------------ */
	
	// Slide Set ID Array Check
	foreach( $images_ids as $img_id )
	{
		$acoda_disablegallink=
		$acoda_movieurl=
		$acoda_previewimgurl=
		$acoda_imgzoomcrop=
		$acoda_stagegallery=
		$acoda_cssclasses=
		$acoda_displaytitle=
		$acoda_altlink=
		$acoda_videotype=
		$acoda_videoautoplay=
		$acoda_posttitle=
		$acoda_description=
		$acoda_slidetimeout = 
		$acoda_transitions =
		$img = 
		$img_full_src =
		$ratio = '';

		// Get Attached / Post Image Data
		$img = acoda_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size ) );

		// Get Image Meta Data Attachment ID
		$attachment_meta = acoda_attachment_data( $img_id, 'image' );
		
		$acoda_movieurl		= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_gallery-video-url', true );
		$acoda_posttitle		= $attachment_meta['title'];
		$acoda_description	= $attachment_meta['description'];		
		$acoda_altlink			= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_gallery-link-url', true ); 
		$acoda_disablegallink = ( empty( $acoda_altlink ) ) ? false : true;
		
		$acoda_slidetimeout	= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_gallery-slide-timeout', true );
		$acoda_cssclasses		= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_gallery-slide-classes', true );
		$tags_array			= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_media-tags', true );		
		$acoda_videotype		= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_media-embed', true );	
		$ratio					= get_post_meta( $img_id, '_'. ACODA_THEME_PREFIX .'_media-ratio', true );		

		if( !empty( $acoda_videotype ) && empty( $acoda_movieurl ) )
		{
			$acoda_videotype = '';
		}		
			
		// Assign unique video ID
		$video_id = $img_id + $data_id;
	
		$postcount++;
		$data_id++;	
			
		/* ------------------------------------		
		:: GRID ONLY	
		------------------------------------ */
	
		$categories = '';
			
		// Enter Categories into an Array
		if( !empty( $tags_array ) )
		{
			$tags_array = str_replace(" ", "", $tags_array );		
			$tags_array = explode(',', $tags_array);
				
			foreach($tags_array as $tag)
			{
				$categories .= $tag.$acoda_shortcode_id.',';
			}
				
			$replace_arr = array(' ',',');
			$replace_with= array('_',' '); 
				
			$categories = str_replace( $replace_arr, $replace_with, $categories );
		}
						
		/* ------------------------------------
		:: GET SLIDER FRAME
		------------------------------------ */			
				
		if(	$acoda_show_slider == 'stageslider' || $acoda_show_slider == 'carousel' )
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
	
		/* ------------------------------------
		:: / GET SLIDER FRAME
		------------------------------------ */				
				
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
	}
	
	/* ------------------------------------
	:: GET INDIVIDUAL SLIDE DATA *END*
	------------------------------------ */	
	
	
	/* ------------------------------------
	:: GROUP SLIDER ONLY 
	------------------------------------ */
	
	if( $acoda_show_slider == 'groupslider' )
	{
		if( $postcount != '0' ) 
		{
			$postcount = '0'; // CHECK NEEDS END TAG 
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