<?php

/* ------------------------------------
:: CONFIGURE SLIDE
------------------------------------*/
	
	// Reset the ratio
	$ratio = 'normal';
		
	$acoda_gallery_postformat = ( !empty( $acoda_gallery_postformat ) ) ? $acoda_gallery_postformat : '';

	// Lightbox
	$lightbox = '';
							
    $output .= "\n\t". '<div class="panel">';

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
			$content_display = 'static';
			
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
	
			$output .= "\n\t\t\t". '<div class="container '. esc_attr( $mediatype .' '. $acoda_imageeffect .' '.$acoda_cssclasses ) .'">';
			$output .= "\n\t\t\t\t". '<div class="gridimg-wrap '. esc_attr( $acoda_blackwhite .' '. $content_display ) .' '. ( $acoda_lightbox == "yes" || $acoda_disablegallink != false || !empty( $content_display ) ? 'effect' : '' ) .'">';							
			$output .= "\n\t\t\t\t\t". '<div class="inner-wrap">';		
			
			if( $acoda_groupgridcontent != "text" )
			{
				$output .= "\n\t\t\t\t\t\t". '<div class="img">';

				// Action Hover 
				if( $hover_overlay != 'disable' && ( $acoda_lightbox == "yes" || $acoda_disablegallink != false || $acoda_groupgridcontent == "titleoverlay" || $acoda_groupgridcontent == "titletextoverlay" || $acoda_groupgridcontent == "titleoverlay_static" || $acoda_groupgridcontent == "textoverlay_static" ) )
				{
					$output .= '<span class="action-hover" '. ( !empty( $overlay_color ) ? 'style="background-color:'. $overlay_color .';"' : '' ) .'></span>';
				}			

				if( $acoda_groupgridcontent != "textonly" )
				{
					if( !empty( $acoda_videotype ) && $acoda_lightbox != 'yes'  ) // Video
					{
						include(get_template_directory() .'/lib/inc/classes/video-class.php');
					}
					elseif( !empty( $img['thumbnail'] ) ) // Image
					{ 											
						if(preg_match('/(?i)msie [4-8]/',$_SERVER['HTTP_USER_AGENT']))
						{
							$output .= $img['thumbnail'];
						}
						else
						{
							$output .= "\n". '<div class="image-wrapper '. esc_attr( $acoda_cssclasses ) .'" style="background-image: url('. esc_url( $img['src'] ) .');"></div>';
						}							

						// Product Price  
						if(class_exists('WPSC_Query') || class_exists('Woocommerce')   && $acoda_datasource=='data-5')
						{ 
							if( !empty( $acoda_productprice ) ) $output .= '<span class="productprice">'. esc_html( $acoda_productprice ) .'</span>';
						} 

						if( !empty( $lightbox ) && ( $acoda_groupgridcontent != "titleoverlay" && $acoda_groupgridcontent != "titletextoverlay" ) )
						{
							$output .= $lightbox;
						}								
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
				if( !empty( $acoda_description ) && ( $acoda_groupgridcontent == "textimage" || $acoda_groupgridcontent == "titletextoverlay" || $acoda_groupgridcontent == "textoverlay_static" || $acoda_groupgridcontent == "text" ) )
				{					
					$output .= "\n\t\t". '<p class="caption clear '. ( !empty( $text_size ) ? esc_attr( $text_size ) : '' ) .'">';
					
					$output .= wp_kses_post( do_shortcode( $acoda_description ) );
					
					if( $read_more == 'enable' )
					{
						$output .= acoda_readmore();
					}
					
					$output .= '</p>';
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
		
	$output .= "\n\t\t". '</div><!--  / panel-inner -->';
	$output .= "\n\t". '</div><!--  / panel -->';
	
	