<?php

	/* ------------------------------------
	:: BLOCK QUOTE
	------------------------------------*/

	class WPBakeryShortCode_Blockquote extends WPBakeryShortCode {
		protected  $predefined_atts = array(
					  'type' => '',
					  'align' => '',
					  'width' => '',
					  'stars' => '',
					  'css_animation' => '' 
					);
		public function content( $atts, $content = null ) {
			$type = $align = $width = $css_animation = $blockwidth = $css_class = $output = '';
			extract(shortcode_atts(array(
				  'type' => 'blockquote_quotes',
				  'align' => '',
				  'width' => '',
				  'stars' => '',
				  'css_animation' => '' 
			), $atts));


			$css_class = $this->getCSSAnimation($css_animation);
		
			if( $width !='' )
			{ 
				$blockwidth='style="width:100%;max-width:'. $width .'"'; 
			}
		 
			$output .= '<div class="blockquote-wrap ' . $type .' '. $align .' '. $css_class .'" '.$blockwidth.'>';
			$output .= '<blockquote class="quotes">' . $content . '</blockquote>';  
			
			$output .= '<div class="stars-wrap">';
			
			
			if( !empty( $stars ) )
			{
				if( $stars == 'one' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
				}
				else if( $stars == 'onehalf' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o-half" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
				}
				else if( $stars == 'two' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
				}	
				else if( $stars == 'twohalf' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o-half" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
				}	
				else if( $stars == 'three' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
				}	
				else if( $stars == 'threehalf' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o-half" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
				}	
				else if( $stars == 'four' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
				}
				else if( $stars == 'fourhalf' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o-half" aria-hidden="true"></i>';
				}	
				else if( $stars == 'five' )
				{
					$output .= '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
				}					
			}
			
			$output .= '</div>';
			$output .= '</div>';
			
			return $output;
		}
	}
	

	/* ------------------------------------
	:: BLOCK QUOTE MAP 
	------------------------------------*/

	vc_map( array(
		"name"		=> __("Testimonial", "dynamix"),
		"base"		=> "blockquote",
		"class"		=> "wpb_controls_top_right",
		"icon"		=> "icon-quote",
		"controls"	=> "full",
		"category"  => __('Content', 'dynamix'),
		"params"	=> array(
			array(
				"type" => "dropdown",
				"heading" => __("Type", "dynamix"),
				"param_name" => "type",
				"value" => array(
					__('Quotes', "dynamix") => 'blockquote_quotes',
					__('Line', "dynamix") => 'blockquote_line', 

				),
			),
			array(
				"type" => "dropdown",
				"heading" => __("Align", "dynamix"),
				"param_name" => "align",
				"value" => array(
					__('Left', "dynamix") => 'left',
					__('Center', "dynamix") => 'center', 
					__('Right', "dynamix") => 'right', 

				),
			),
			vc_map_add_css_animation(),				
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => __("Quote", "dynamix"),
				"param_name" => "content",
				"value" => "",
			),
			array(
				"type" => "dropdown",
				"heading" => __("Add Stars", "dynamix"),
				"param_name" => "stars",
				"value" => array(
					"No Stars" => '',
					'1 Star'  => 'one', 
					'1.5 Stars'  => 'onehalf', 
					'2 Stars'  => 'two', 	
					'2.5 Stars'  => 'twohalf', 
					'3 Stars'  => 'three', 		
					'3.5 Stars'  => 'threehalf', 
					'4 Stars'  => 'four', 
					'4.5 Stars'  => 'fourhalf', 
					'5 Stars'  => 'five', 		
				),
			),			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Width", "dynamix"),
				"param_name" => "width",
				"value" => "",
				"description" => __("Add optional width setting.", "dynamix")
			),			
		),
	));	