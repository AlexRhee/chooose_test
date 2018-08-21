<?php
	if ( ! defined( 'ABSPATH' ) ) {
		die( '-1' );
	}
	
	/**
	 * Shortcode attributes
	 * @var $atts
	 * @var $el_class
	 * @var $width
	 * @var $css
	 * @var $offset
	 * @var $content - shortcode content
	 * Shortcode class
	 * @var $this WPBakeryShortCode_VC_Column_Inner
	 */
	$el_class = $width = $css = $offset = $column_icon = '';
	$output = '';
	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
	
		// Row Icon
		if ( ! empty( $atts['add_icon'] ) ) 
		{
			if ( empty( $atts['i_type'] ) ) 
			{
				$atts['i_type'] = 'fontawesome';
			}
	
			$data = vc_map_integrate_parse_atts( $this->shortcode, 'vc_icon', $atts, 'i_' );
	
			if ( $data ) 
			{
				$icon = visual_composer()->getShortCode( 'vc_icon' );
				
				if ( is_object( $icon ) ) 
				{
					$column_icon = '<div class="column-icon-wrap '. $atts['add_icon'] .' '. ( !empty( $atts['i_on_border'] ) ? 'on_border' : '' ) .'"><div class="vc_cta3-icons">' . $icon->render( array_filter( $data ) ) . '</div></div>';
				}
			}
		}	
	
	extract( $atts );

	$width = wpb_translateColumnWidthToSpan( $width );
	$width = vc_column_offset_class_merge( $offset, $width );
	
	$el_class = $this->getExtraClass($el_class) . $this->getCSSAnimation( $css_animation );
	
	$css_classes = array(
		$el_class,
		'wpb_column',
		'vc_column_container',
		$width,
	);
	
	if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
		$css_classes[]='vc_col-has-fill';
	}
	
	$wrapper_attributes = array();
	
	$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	
	$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
	$output .= '<div class="vc_column-inner ' . ( !empty( $atts['add_icon'] ) ?  'has-icon '. esc_attr( $atts['add_icon'] ) . ' ' . ( !empty( $atts['i_on_border'] )  ? 'icon_on_border ' : '' )  : '' ) . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '">';
	$output .=  $column_icon;		
	$output .= '<div class="wpb_wrapper">';
	$output .= wpb_js_remove_wpautop( $content );
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	
	echo $output;
