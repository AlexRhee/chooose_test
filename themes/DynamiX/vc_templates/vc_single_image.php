<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $onclick
 * @var $img_size
 * @var $external_img_size
 * @var $caption
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $css_animation
 * @var $style
 * @var $external_style
 * @var $border_color
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Single_image
 */

	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
	extract( $atts );
	
	$default_src = $img_full_src = vc_asset_url( 'vc/no_image.png' );
	
	// backward compatibility. since 4.6
	if ( empty( $onclick ) && isset( $img_link_large ) && 'yes' === $img_link_large ) {
		$onclick = 'img_link_large';
	} else if ( empty( $atts['onclick'] ) && ( ! isset( $atts['img_link_large'] ) || 'yes' !== $atts['img_link_large'] ) ) {
		$onclick = 'custom_link';
	}
	
	if ( 'external_link' === $source ) {
		$style = $external_style;
	}
	
	$border_color = ( !empty( $border_color ) ) ? ' vc_box_border_' . $border_color : '';

	// Hover Effect
	$hover_effect = '';
	
	$circle_styles_array = array( 'vc_box_circle_2', 'vc_box_border_circle_2', 'vc_box_outline_circle_2', 'vc_box_shadow_circle_2', 'vc_box_shadow_border_circle_2' );
	$normal_styles_array = array( '', 'vc_box_rounded', 'vc_box_rounded', 'vc_box_border', 'vc_box_outline', 'vc_box_shadow', 'vc_box_shadow_border', 'vc_box_shadow_3d', 'vc_box_circle', 'vc_box_border_circle', 'vc_box_outline_circle', 'vc_box_shadow_circle', 'vc_box_shadow_border_circle' );
		
	if( in_array( $style, $circle_styles_array ) )
	{
		if( !empty( $hover_effect_circle ) )
		{
			$hover_effect = 'circle effect '. $hover_effect_circle;
		}
	}
	if( in_array( $style, $normal_styles_array ) )
	{
		if( !empty( $hover_effect_square ) )
		{
			$hover_effect = 'square effect '. $hover_effect_square;
		}			
	}

	$img = false;
	
	switch ( $source ) {
		case 'media_library':
		case 'featured_image':
	
			if ( 'featured_image' === $source ) {
				$post_id = get_the_ID();
				if ( $post_id && has_post_thumbnail( $post_id ) ) {
					$img_id = get_post_thumbnail_id( $post_id );
				} else {
					$img_id = 0;
				}
			} else {
				$img_id = preg_replace( '/[^\d]/', '', $image );
			}

			if ( preg_match( '/_circle$/', $style ) ) {
				$style .= ' rounded_style';
			}			
	
			// set rectangular
			if ( preg_match( '/_circle_2$/', $style ) ) {
				$style = preg_replace( '/_circle_2$/', '_circle', $style );
				$img_size = $this->getImageSquareSize( $img_id, $img_size );
			}
	
			if ( ! $img_size ) {
				$img_size = 'medium';
			}
	
			$img = wpb_getImageBySize( array(
				'attach_id' => $img_id,
				'thumb_size' => $img_size,
				'class' => 'vc_single_image-img'
			) );
	
			// don't show placeholder in public version if post doesn't have featured image
			if ( 'featured_image' === $source ) {
				if ( ! $img && 'page' === vc_manager()->mode() ) {
					return;
				}
			}

			// Full Image URL
			$img_full_src = wp_get_attachment_image_src( $img_id, 'full');
			$img_full_src = $img_full_src[0];			
	
			break;
	
		case 'external_link':
			$dimensions = vcExtractDimensions( $external_img_size );
			$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
	
			$custom_src = $custom_src ? esc_attr( $custom_src ) : $default_src;
	
			$img = array(
				'thumbnail' => '<img class="vc_single_image-img" ' . esc_attr( $hwstring ) . ' src="' . esc_url( $custom_src ) . '" />'
			);
			
			$img_full_src = $custom_src;
			
			break;
	
		default:
			$img = false;
	}
	
	if ( ! $img ) {
		$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . esc_url( $default_src ) . '" />';
	}
	
	$el_class = $this->getExtraClass( $el_class );

	
	// backward compatibility. will be removed in 4.7+
	if ( ! empty( $atts['img_link'] ) ) {
		$link = $atts['img_link'];
		if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link ) ) {
			$link = 'http://' . $link;
		}
	}
	
	// backward compatibility
	if ( in_array( $link, array( 'none', 'link_no' ) ) ) {
		$link = '';
	}
	
	$a_attrs = array();
	
	switch ( $onclick ) {
		
		case 'img_link_large':
	
			if ( 'external_link' === $source ) {
				$link = $custom_src;
			} else {
				$link = wp_get_attachment_image_src( $img_id, 'large' );
				$link = $link[0];
			}
	
			break;
	
		case 'custom_link':
			// $link is already defined
			break;
				
	
		case 'zoom':
			wp_enqueue_script( 'vc_image_zoom' );
	
			if ( 'external_link' === $source ) {
				$large_img_src = $custom_src;
			} else {
				$large_img_src = wp_get_attachment_image_src( $img_id, 'large' );
				if ( $large_img_src ) {
					$large_img_src = $large_img_src[0];
				}
			}
	
			$img['thumbnail'] = str_replace( '<img ', '<img data-vc-zoom="' . esc_url( $large_img_src ) . '" ', $img['thumbnail'] );
	
			break;
	}
	
	
	// Lightbox
	$link_output = '';
			
	if( $lightbox == "enable" || !empty( $link ) )
	{							
		// Split Icon Space
		$split = '';
															
		if( $lightbox == "enable" && !empty( $link ) ) $split = 'split';
									
		// Set Link + Lightbox
		if( $lightbox == "enable" )
		{ 
			$lightbox_type = $lightbox_url = '';
									
			if( !empty($media_url) )
			{
				$lightbox_url = $media_url;
				$lightbox_type = 'fal fa-play';
			}
			else
			{
				$lightbox_url = $img_full_src;
				$lightbox_type = 'fal fa-expand';
			}
											
			$link_output .= '<a href="'. esc_url( $lightbox_url ) .'" class="lightbox action-icons lightbox-icon '. esc_attr( $split ) .'"><i class="'. esc_attr( $lightbox_type ) .'"></i></a>';
		}
			
		if( !empty( $link ) )
		{ 
			$link_output .= '<a href="'. esc_url( $link ) .'" class="action-icons link-icon '. esc_attr( $split ) .'" target="'. esc_attr( $img_link_target ) .'" ><i class="fal fa-plus"></i></a>';
		}
	}	
	
	$class_to_filter = 'wpb_single_image wpb_content_element vc_align_' . $alignment . ' ' . $this->getCSSAnimation( $css_animation );
	$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
	
	if ( in_array( $source, array( 'media_library', 'featured_image' ) ) && 'yes' === $add_caption )
	{
		$post 		= get_post( $img_id );
		$title		= $post->post_title;
		$caption	= $post->post_excerpt;
		
		if( empty( $caption ) )
		{
			$caption = $post->post_content; 	
		}
	} 
	else if ( 'external_link' === $source || ( 'custom' === $add_caption && '' !== $caption ) )
	{
		$add_caption = 'yes';
	}
	
	$html = '';
		
	if ( 'yes' === $add_caption && ( '' !== $caption || '' !== $title  ) && empty( $hover_effect ) )
	{	
		$html = '
			<figure class="vc_figure">
				' . $html . '
				<figcaption class="vc_figure-caption">'. ( !empty( $title ) ? '<h3  '. ( !empty( $title_size ) ? 'class="caption-title-'. esc_attr( $title_size ) .'"' : '' ) .'>'.  esc_html( $title ) .'</h3>' : '' ) . ( !empty( $caption ) ? do_shortcode( wpautop( $caption ) ) : '' ) . '</figcaption>
			</figure>
		';
	}
	elseif( !empty( $hover_effect ) && ( !empty( $caption ) || !empty( $title ) ) )
	{
		wp_enqueue_style('ihover', get_template_directory_uri().'/css/ihover.min.css',false,null );
	}		


	// Paroller 
	$paroller_data = '';

	if( $paroller == 'horizontal' || $paroller == 'vertical'  )
	{
		wp_enqueue_script('jquery-paroller', get_template_directory_uri().'/js/jquery.paroller.min.js',array( 'jquery' ), true );
		$paroller_data = 'data-paroller-factor="'. ( !empty( $paroller_factor ) ? $paroller_factor : '-0.1' ) .'" data-paroller-type="foreground" data-paroller-direction="'. $paroller .'"';
	}
	
	$output = '';
	$output .= '<div class="'. ( $link_icon == 'disable' ? 'disable_link_icon ' : '' ) . esc_attr( trim( $css_class ) ) . ( !empty( $hover_effect ) && ( !empty( $title ) || !empty( $caption ) ) ? ' hover-effect' : '' ) .'" >';
	$output .= '<div class="wpb_wrapper '. ( $paroller == 'horizontal' || $paroller == 'vertical' ? 'paroller' : '' ) .' vc_single_image-wrapper ' . $style . ' ' . $border_color . '" '. $paroller_data .'>';
	$output .= '<div class="container">';
	$output .= '<div class="gridimg-wrap '. ( !empty( $hover_effect ) && ( !empty( $caption ) || !empty( $title ) ) ? 'ih-item '.$hover_effect : 'static' ) .'">';
	$output .= '<div class="img '. ( 'vc_box_shadow_3d' === $style ? 'vc_box_shadow_3d_wrap' : '' ) .'">';	

	// Action Hover 
	if( !empty( $hover_effect ) && ( $lightbox == "yes" || !empty( $link ) || !empty( $caption ) || !empty( $title ) ) )
	{
		$output .= '<span class="action-hover"></span>';
	}		
	
	$output .= $img['thumbnail'];

	if( empty( $hover_effect ) && ( !empty( $lightbox ) || !empty( $link ) ) )
	{
		$output .= $link_output;
	}	
	
	$output .= '</div>';

	if( !empty( $hover_effect ) && ( !empty( $title ) || !empty( $caption ) ) )
	{
		$output .= "\n\t\t\t".'<div class="info">';
		$output .= "\n\t\t\t\t".'<div class="info-back">';
		$output .= "\n\t\t\t\t\t".'<div class="info-holder">';

		if( !empty( $title ) )
		{
			if( !empty( $link ) )
			{ 
				$output .= "\n\t\t\t\t\t". ( !empty( $title ) ? '<h3 '. ( !empty( $title_size ) ? 'class="caption-title-'. esc_attr( $title_size ) .'"' : '' ) .'><a href="'. esc_url( $link ) .'" target="'. esc_attr( $img_link_target ) .'">'. esc_html( $title ) .'</a></h3>' : '' );
			}
			else
			{
				$output .= "\n\t\t\t\t\t". ( !empty( $title ) ? '<h3 '. ( !empty( $title_size ) ? 'class="caption-title-'. esc_attr( $title_size ) .'"' : '' ) .'>'. esc_html( $title ) .'</h3>' : '' );
			}
		}

		if( !empty( $caption ) )
		{		
			$output .= "\n\t\t\t\t\t". ( !empty( $caption ) ? ''. do_shortcode( wpautop( $caption ) ) .'' : '' );
		}
		
		if( !empty( $hover_effect ) && !empty( $link_output ) )
		{
			$output .= '<div class="lightbox-wrap">';
			$output .= $link_output;
			$output .= '</div>';	
		}
		
		$output .= "\n\t\t\t\t\t".'</div>';
		$output .= "\n\t\t\t\t".'</div>';
		$output .= "\n\t\t\t".'</div>';
	}	
	
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= $html;
	$output .= '</div>';
	
	echo $output;