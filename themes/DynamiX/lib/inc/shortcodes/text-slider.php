<?php

/* ------------------------------------
:: TEXT SLIDER
------------------------------------*/

	class WPBakeryShortCode_TextSlide extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

		public function content( $atts, $content = null ) {
			$output = '';

			$output .= "\n\t\t\t". '<div class="text-slide clearfix">'. do_shortcode( $content ) .'</div>';
	
			return $output;
		}

		public function mainHtmlBlockParams($width, $i) {
			return 'data-element_type="'.$this->settings["base"].'" class=" wpb_'.$this->settings['base'].'"'.$this->customAdminBlockParams();
		}
		public function containerHtmlBlockParams($width, $i) {
			return 'class="wpb_column_container vc_container_for_children"';
		}
		protected function outputTitle($title) {
			return  '';
		}
	
		public function customAdminBlockParams() {
			return '';
		}
	
	}

	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_TextSlider extends WPBakeryShortCodesContainer { // WPBakeryShortCode_ PREFIX REQUIRED 

			protected function content( $atts, $content = null ) {
	
				$align = $navigation = $effect = $timeout = $el_class = $el_position = '';
				//
				extract(shortcode_atts(array(
					'width' => '',
					'el_class' => '',
					'effect' => 'scrollHorz',
					'timeout' => '',
					'navigation' => 'disabled',
				), $atts));
				
				$output = '';
		
				$el_class = $this->getExtraClass($el_class);
	
				$output .= "\n\t".'<div id="textslider-'. esc_attr( uniqid() ) .'" class="textslider-wrap gallery-wrap '. esc_attr( $width .' '. $el_class .' nav-'. $navigation ) .' clearfix" data-effect="'. esc_attr( $effect ) .'" data-timeout="'. esc_attr( $timeout ) .'">';
				$output .= "\n\t\t".'<div class="textslider-slides clearfix">'. do_shortcode( $content ) .'</div>';

				if( $navigation != "disabled" )
				{
					$output .= '<div class="slidernav-wrap">';
					$output .= '<div class="slidernav-left">';
					$output .= '<div class="slidernav">';
					$output .= '<a class="poststage-prev nav-prev"></a>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="slidernav-right">';
					$output .= '<div class="slidernav">';
					$output .= '<a class="poststage-next nav-next"></a>';
					$output .= '</div>';
					$output .= '</div>';	
					$output .= '</div>';	
				} 	
				
				$output .= "\n\t".'</div>';

				wp_enqueue_script('jquery-cycle', get_template_directory_uri().'/js/jquery.cycle.plugin.min.js',false,array('jquery'),true );	
				wp_enqueue_script('acoda-textslider', get_template_directory_uri().'/js/text-slider.min.js',false,array('jquery-cycle'),true );					
				
				return $output;
			}
		}
	}


	/* ------------------------------------
	:: Text Slider MAP
	------------------------------------*/	

	vc_map( array(
		"name"		=> esc_html__("Text Slider", 'dynamix'),
		"base"		=> "textslider",
		"show_settings_on_create" => false,
		"icon" => get_template_directory_uri() . '/images/acoda.png',
		"content_element" => true,
		"as_parent" => array('only' => 'textslide'), // Use only|except attributes 
		"category"  => esc_html__('Content', 'dynamix'),
		"params"	=> array(	
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Width", 'dynamix'),
				"param_name" => "width",
				"value" => array(
					esc_html__('100%', 'dynamix') => 'width_100',
					esc_html__('75%', 'dynamix') => 'width_75', 
					esc_html__('50%', 'dynamix') => 'width_50', 
				),
			),	
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Effect", 'dynamix'),
				"param_name" => "effect",
				"value" => array(
					esc_html__('Slide', 'dynamix') => 'scrollHorz',
					esc_html__('Fade', 'dynamix') => 'fade', 
				),
			),							
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Auto-Slide", 'dynamix'),
				"param_name" => "timeout",
				"value" => array(
					esc_html__('1 Second', 'dynamix') => '1000',
					esc_html__('3 Seconds', 'dynamix') => '3000',
					esc_html__('5 Seconds', 'dynamix') => '5000',
					esc_html__('10 Seconds', 'dynamix') => '10000', 
					esc_html__('20 Seconds', 'dynamix') => '20000',
					esc_html__('30 Seconds', 'dynamix') => '30000', 
					esc_html__('Disable', 'dynamix') => '-1', 
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__( 'Navigation', 'dynamix'),
				"param_name" => "navigation",
				"value" => array(
					esc_html__( 'Disable Navigation', 'dynamix' ) => 'disabled',				
					esc_html__( 'Static Arrows', 'dynamix' ) => 'arrowstatic',
					esc_html__( 'Arrows on Hover', 'dynamix' ) => 'arrowhover',
				)
			),			
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dynamix'),
				"param_name" => "el_class",
				"value" => "",
				"description" => esc_html__("Add custom CSS classes to the above field.", 'dynamix')
			)
		),
	  "js_view" => 'VcColumnView'
	) );
	
	
	vc_map( array(
		"name"		=> esc_html__("Text Slide", 'dynamix'),
		"base"		=> "textslide",
		"content_element" => true,
		"as_child" => array('only' => 'textslider'), // Use only|except attributes 
		"params"	=> array(			
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"heading" => esc_html__("Content", 'dynamix'),
				"param_name" => "content",
				"value" => "",
			),	
		)
	) );