<?php
$output = $el_class = $bg_image = $bg_color = $bg_slider = $bg_video = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $background_css = $background_image = $css_parallax_style = $slider_images = $slider_animation = $slider_timeout = $after_output = $flex_row = $output = $before_output = '';


	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
	
	// Extract Atts
	extract( $atts );
	
	wp_enqueue_script( 'wpb_composer_front_js' );
	
	$el_class = $this->getExtraClass($el_class) . $this->getCSSAnimation( $css_animation );
	
	$css_classes = array(
		'vc_row',
		'wpb_row', //deprecated
		'vc_row-fluid',
		'vc_row-parent',
		$el_class,
		vc_shortcode_custom_css_class( $css ),
	);

	$wrapper_attributes = array();
	// build attributes for wrapper
	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}
	
	if ( ! empty( $full_width ) ) {
		
	
		$wrapper_attributes[] = 'data-vc-full-width="true"';
		$wrapper_attributes[] = 'data-vc-full-width-init="false"';
		
		if ( 'stretch_row_content' === $full_width ) {
			$wrapper_attributes[] = 'data-vc-stretch-content="true"';
			$css_classes[] = ' stretch_row_content stretch_content';
		} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
			$wrapper_attributes[] = 'data-vc-stretch-content="true"';
			$css_classes[] = ' stretch_content vc_row-no-padding';
		}
		$after_output .= '<div class="vc_row-full-width"></div>';
	}
	

	// Background Position
	if( !empty( $h_position ) || !empty( $v_position ) )
	{
		$h_position = ( !empty( $h_position ) ? $h_position : 'center' );
		$v_position = ( !empty( $v_position ) ? $v_position : 'center' );
		
		$css_classes[] = 'bg_position_'. $h_position .'_'. $v_position;	
	}
	
	// Row Height
	if( !empty( $full_height ) )
	{
		$flex_row = true;
		$css_classes[] = ' custom_height '. $full_height;
	}
	
	if ( ! empty( $equal_height ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-equal-height';
	}
	
	if ( ! empty( $flex_row ) ) {
		$css_classes[] = 'vc_row-flex';
	}
	
	// Custom Row
	if( !empty( $bg_video ) || !empty( $bg_slider ) || !empty( $parallax ) || !empty( $background_css ) || !empty( $inherit_shaded_color ) )
	{
		$css_classes[] = ' custom-row';
	}
	
	// Skin Shaded Background
	if( $inherit_shaded_color == 'enable' )
	{
		$css_classes[] = ' custom-row-inherit';
	}
	
	$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
	
	$wrapper_attributes[] = $style;
	
	// Anchor Links
	if( !empty( $anchor_link ) )
	{
		$css_classes[] = 'link_anchor anchor-'.$anchor_link;		
		$wrapper_attributes[] = ' data-anchor-link="'. $anchor_link .'"';
	}
	
	// Parallax
	if ( ! empty( $parallax ) )
	{
		/*wp_enqueue_script( 'vc_jquery_skrollr_js' );
		$parallax_attributes[] = 'data-vc-parallax="1.35"'; // parallax speed
		$parallax_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;*/
		if ( strpos( $parallax, 'fade' ) !== false )
		{
			$css_classes[] = 'parallax-fade';
		}
	
		
		preg_match_all('/background(-image)??\s*?:.*?url\(["|\']??(.+)["|\']??\)/', $css, $matches, PREG_SET_ORDER);
		
		if( isset( $matches[0][2] ) )
		{
			$parallax_image_src = $matches[0][2];	
		}
		
		if( isset( $matches[0][0] ) )
		{
			$css = str_replace( $matches[0][0] . ' !important;', '', $css );
		}
		
		if( !empty( $parallax_image_src ) )
		{
			wp_enqueue_script( 'acoda-parallax', get_template_directory_uri().'/js/parallax-background.min.js', false, array('jquery'), true );
			$css_classes[] = 'acoda-parallax';
			$wrapper_attributes[] = 'data-parallax-direction="down" data-parallax-bg-position="'. $h_position .' ' . $v_position . '" data-parallax-speed="0.3" data-parallax-bg-image="' . esc_attr( $parallax_image_src ) . '"';		
		}
	}
	
	// Vertical Content Placement
	if( ! empty( $content_placement ) )
	{
		$css_classes[] =  ' vc_row-o-content-' . $content_placement; 
	}
	else
	{
		$css_classes[] =  ' vc_row-o-content-middle'; 
	}
	
	if( $slider_imgeffect == 'enable' )
	{
		$css_classes[] =  ' blackwhite_effect'; 
	}
	
	$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	
	$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>'; // escaped above


	// Video
	if( !empty( $bg_video ) )
	{
		if(strpos( $bg_video, 'youtube') > 0) 
		{
			$acoda_videotype = 'youtube';
		}
		elseif(strpos( $bg_video, 'vimeo') > 0) 
		{
			$acoda_videotype = 'vimeo';
		} 
		else 
		{
			$acoda_videotype = 'oembed';
		}

		$acoda_movieurl = $bg_video;
		$acoda_videoautoplay = $acoda_loop = '1';
		
		$output .= '<div class="video-wrap">';
		
		include(get_template_directory() .'/lib/inc/classes/video-class.php');
		
		$output .= '</div>';
		
		//$output .= '<div class="video-wrap">'. do_shortcode('[video src="'. esc_url( $bg_video ) .'" autoplay="on" loop="on" ]') .'</div>';
	}
	
	if( !empty( $slider_images ) )
	{
		$slider = '[postgallery_image data_source="data-9" images_attach="'. esc_attr( $slider_images ) .'" image_fit="cover" content_type="image" '. ( $slider_imgeffect == 'enable' ? 'imageeffect="blackwhite"' : '' ) .' timeout="'. esc_attr( $slider_timeout ) .'" animation="'. 		$slider_animation .'" navigation="disabled" lightbox="yes" ]';
		$output .= '<div class="row-slider-wrap">'. do_shortcode( $slider ) .'</div>';
	}
	
	// Overlay Color
	if( !empty( $overlay_color ) || !empty( $bg_video ) )
	{
		$output .= '<div class="overlay-wrap" style="background-color:'. esc_attr( $overlay_color ) .'"></div>';
	}
	
	$output .= wpb_js_remove_wpautop($content);	

	$output .= '</div>'. $after_output;
	
	echo $output;