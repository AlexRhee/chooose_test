<?php 

/* ------------------------------------
:: CONFIGURE SLIDE
------------------------------------*/


	// Check if CSS classes contains masonry wide option	
	$masonry_wide = ( strpos($acoda_cssclasses, 'masonry_wide') !== false && $masonry == 'masonry' ) ? 'enable' : '';


	$max_width = ( !empty( $img['width'] ) ) ? 'style="max-width:'. $img['width'] .'px"' : '';
	
	// Check if postformat enabled
	if( empty( $acoda_gallery_postformat ) ) $acoda_gallery_postformat = ''; 

	// Set columns
	if( $acoda_gridcolumns == '5' )
	{
		$columns = '2_4';
	}
	else
	{
		$columns = 12 / $acoda_gridcolumns;
	}
	
	if( $masonry_wide == 'enable' )
	{
		$columns = $columns * 2;
	}

	$columns = ( strpos($acoda_cssclasses, 'masonry_fullwidth') !== false && !empty( $masonry )  ) ? '12' : $columns;

	// Conigure Masonry Style
	if( $masonry == 'masonry_style_1' )
	{		
		if ( ( $postcount - 1 ) % ( $acoda_gridcolumns + 1 ) == 0 ) 
		{
			 $columns = 12;
		}		
	}

	if( $masonry == 'masonry_style_2' )
	{		
		if ( ( $postcount - 1 ) % ( $acoda_gridcolumns + 1 ) == 0 ) 
		{
			 $columns = 6;
		}		
		else
		{
			 $columns = 3;
		}
	}


	if( $paroller_type == 'individual' && ( $paroller == 'horizontal' || $paroller == 'vertical' ) )
	{
		$paroller_factor = str_replace( '-','', $paroller_factor );
				
		$dir = ( $postcount % 2 == 0 ? '' : '-' );
	
		$paroller_data = 'data-paroller-factor="'. ( !empty( $paroller_factor ) ? $dir.$paroller_factor : '-0.1' ) .'" data-paroller-type="foreground" data-paroller-direction="'. $paroller .'"';
	}
			
    $output .= "\n\t". '<div class="panel block '. ( $paroller == 'horizontal' || $paroller == 'vertical' ? ' paroller' : '' ) .' columns acoda-animate-in large-'. esc_attr( $columns ) .' '. ( !empty($categories) ? esc_attr( $categories ) : '' ) .'" data-id="id-'. esc_attr( $data_id ) .'" '. $paroller_data .'>';

    $output .= "\n\t\t". '<div class="panel-inner">';
    
		if( $acoda_gallery_postformat == 'yes' )
		{		
   			ob_start();
			get_template_part( 'content', get_post_format() );
			$output .= ob_get_contents();
			ob_end_clean();
    	}
		else
		{						
			
			
			$content_display = 'ih-item static';
			
			// Hover Effect
 			if( ( !empty( $acoda_posttitle ) || !empty( $acoda_description ) ) && ( $acoda_groupgridcontent == "titleoverlay" || $acoda_groupgridcontent == "titletextoverlay" ) )
			{
				$content_display = 'ih-item '. ( $acoda_imageeffect == 'round' || $acoda_imageeffect == 'frame round' || $acoda_imageeffect == 'round shadow' || $acoda_imageeffect == 'round blackwhite' ? 'circle ' : 'square ' ) . $hover_effect;
			}

			// Media Type
			$mediatype = '';
				
			if( !empty( $acoda_videotype ) && !empty( $acoda_movieurl ) && $acoda_lightbox != "yes" ) 
			{
				$mediatype = 'videotype';
				$acoda_blackwhite = '';
				
				if( !empty( $hover_effect ) && $acoda_groupgridcontent != 'image' )
				{
					$acoda_groupgridcontent = 'image';
					$content_display = 'static';
				}
			}			
			
	
	
			$output .= "\n\t\t\t". '<div class="container '. esc_attr( $mediatype .' '. $acoda_imageeffect .' '.$acoda_cssclasses ) .'" '. esc_attr( $max_width ) .'>';
			$output .= "\n\t\t\t\t". '<div class="gridimg-wrap '. esc_attr( $acoda_blackwhite .' '. $content_display . ' vert-'. $text_vertical_align ) .' '. $hover_effect_static .'-hover ' . ( $acoda_lightbox == "yes" || $acoda_disablegallink != false || !empty( $content_display ) ? 'effect' : '' ) .'">';							
			$output .= "\n\t\t\t\t\t". '<div class="inner-wrap">';		
			
			if( $acoda_groupgridcontent != "text" )
			{
				$output .= "\n\t\t\t\t\t\t". '<div class="img">';

				// Action Hover 
				if( $hover_overlay != 'disable' && ( $acoda_lightbox == "yes" || $acoda_disablegallink != false || $acoda_groupgridcontent == "titleoverlay" || $acoda_groupgridcontent == "titletextoverlay" || $acoda_groupgridcontent == "titleoverlay_static" || $acoda_groupgridcontent == "textoverlay_static" ) )
				{
					if( $hover_overlay == 'gradient' )
					{
						$output .= '<span class="action-hover" '. ( !empty( $overlay_color ) ? 'style="background: linear-gradient('. $overlay_color .' 50%,'. $overlay_color_sec .')"' : '' ) .'></span>';
					}
					else
					{
						$output .= '<span class="action-hover" '. ( !empty( $overlay_color ) ? 'style="background-color:'. $overlay_color .';"' : '' ) .'></span>';
					}
				}			

				if( $acoda_groupgridcontent != "text" )
				{								
					if( !empty( $acoda_videotype ) && !empty( $acoda_movieurl ) && $acoda_lightbox != "yes"  ) // Video
					{

						include(get_template_directory() .'/lib/inc/classes/video-class.php');
					}
					elseif( !empty( $img['thumbnail'] ) ) // Image
					{ 					
						$output .= $img['thumbnail'];
					}
				}						

				// Lightbox
				$lightbox = '';

				if( $hover_icons != 'disable' && ( $acoda_lightbox == "yes" || $acoda_disablegallink != false ) )
				{							
					// Split Icon Space
					$split = '';

					if( $acoda_lightbox == "yes" && $acoda_disablegallink != false ) $split = 'split';

					// Set Link + Lightbox
					if( $acoda_lightbox == "yes" )
					{ 
						$lightbox_url = $lightbox_type = '';

						if( !empty($acoda_movieurl) )
						{
							$lightbox_url = $acoda_movieurl; 
							$lightbox_type = 'fal fa-play';
						}
						else
						{
							$lightbox_url  = $img['img_full_src'];
							$lightbox_type = 'fal fa-expand';
						}

						$lightbox .= '<a href="'. esc_url( $lightbox_url ) .'" rel="lightbox['. esc_attr( $acoda_shortcode_id ) .']" data-title="'. esc_attr( $acoda_posttitle ) .'" data-caption="'. esc_attr( $acoda_description ) .'" class="action-icons lightbox-icon '. $split .'"><i class="'.  esc_attr( $lightbox_type ) .'" '. ( !empty( $hover_icons_color ) ? 'style="color:'. $hover_icons_color .'"' : '' ) .'></i></a>';
					}

					if( $acoda_disablegallink != false )
					{ 
						$lightbox .= '<a href="'. esc_url( $acoda_altlink ) .'" class="action-icons link-icon '. esc_attr( $split ) .'"><i class="fal fa-plus" '. ( !empty( $hover_icons_color ) ? 'style="color:'. $hover_icons_color .'"' : '' ) .'></i></a>';
					}
				}

				if( !empty( $lightbox ) && ( $acoda_groupgridcontent != "titleoverlay" && $acoda_groupgridcontent != "titletextoverlay" ) && $acoda_show_slider != 'stageslider' )
				{
					$output .= $lightbox;
				}			

				$output .= "\n\t\t\t\t\t\t". '</div>';	
			}
			
			if( $acoda_groupgridcontent == "textimage" || $acoda_groupgridcontent == "titleimage"  )
			{
				$output .= "\n\t\t\t\t\t". '</div>';			
				$output .= "\n\t\t\t\t". '</div><!-- / gridimg-wrap -->';				
			}			

			if( $acoda_groupgridcontent != "image" && ( !empty( $acoda_posttitle ) || !empty( $acoda_description ) ) )
			{				
				$output .= "\n\t\t\t".'<div class="info '. esc_attr( $acoda_cssclasses ) .'" '. ( !empty( $text_color ) ? 'style="color:'. $text_color .'"' : '' ) .'>';
				$output .= "\n\t\t\t\t".'<div class="info-back">';		
				$output .= "\n\t\t\t\t\t".'<div class="info-holder">';	

		
				// Post Category		
				if( !empty( $acoda_post_category ) )
				{
					$output .= $acoda_post_category;
				}
				
				// Title
				if( $acoda_disablegallink != false )
				{ 							
					$output .= "\n\t\t". '<'. $title_tag .' class="caption-title '. ( !empty( $title_size ) ? esc_attr( $title_size ) : '' ) .'" '. ( !empty( $title_color ) ? 'style="color:'. $title_color .'"' : '' ) .'><a href="'. esc_url( $acoda_altlink ) .'">'. esc_html( $acoda_posttitle ) .'</a></'. $title_tag .'>';
				}
				else
				{
					$output .= "\n\t\t". '<'. $title_tag .' class="caption-title '. ( !empty( $title_size ) ? esc_attr( $title_size ) : '' ) .'" '. ( !empty( $title_color ) ? 'style="color:'. $title_color .'"' : '' ) .'>'. esc_html( $acoda_posttitle ) .'</'. $title_tag .'>';
				}
				
				// Post Author
				if( !empty( $acoda_post_author ) || !empty( $acoda_post_date ) || !empty( $acoda_product_price )  )
				{		
					$output .= '<p class="meta-wrap clearfix">';
					
					if( !empty( $acoda_post_author ) )
					{
						$output .= $acoda_post_author;
					}				

					// Post Date
					if( !empty( $acoda_post_date ) )
					{
						$output .= $acoda_post_date;
					}					

					// Product Price  
					if( !empty( $acoda_product_price ) )
					{ 
						$output .= '<span class="productprice metadata">'. esc_html( $acoda_product_price ) .'</span>';
					} 	
					
					$output .= '</p>';
				}
				
		
				// Description
				if( !empty( $acoda_description ) && ( $acoda_groupgridcontent == "textimage" || $acoda_groupgridcontent == "titletextoverlay" ||  $acoda_groupgridcontent == "textoverlay_static" || $acoda_groupgridcontent == "text" ) )
				{					
					$output .= "\n\t\t". '<p class="caption clear '. ( !empty( $text_size ) ? esc_attr( $text_size ) : '' ) .'">'. wp_kses_post( do_shortcode( $acoda_description ) ) .'</p>';
					
					if( $read_more == 'enable' )
					{
						$output .= acoda_readmore();
					}
				}			
					
				
				if( !empty( $lightbox ) && ( $acoda_groupgridcontent == "titleoverlay" || $acoda_groupgridcontent == "titletextoverlay" || ( $acoda_show_slider == 'stageslider' && $acoda_groupgridcontent != "titleoverlay" && $acoda_groupgridcontent != "titletextoverlay"  ) ) )
				{
					$output .= '<div class="lightbox-wrap">';
					$output .= $lightbox;
					$output .= '</div>';
				}
				
				$output .= "\n\t\t\t\t\t".'</div>';
				$output .= "\n\t\t\t\t".'</div>';
				$output .= "\n\t\t\t".'</div>';
			}	
		
			if( $acoda_groupgridcontent != "textimage" && $acoda_groupgridcontent != "titleimage"  )
			{
				$output .= "\n\t\t\t\t\t". '</div>';			
				$output .= "\n\t\t\t\t". '</div><!-- / gridimg-wrap -->';				
			}

			$output .= "\n\t\t\t". '</div><!-- / container -->';
		}  
		
	$output .= "\n\t\t". '</div>';
	$output .= "\n\t". '</div>';

	if( $postcount == $acoda_gridcolumns && empty( $masonry ) )
	{ 
		$postcount = 0;
		$output .= "\n\t". '<div class="clear"></div> ';
    }