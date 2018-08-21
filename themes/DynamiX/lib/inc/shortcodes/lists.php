<?php

	/* ------------------------------------
	:: LISTS
	------------------------------------*/
	

	class WPBakeryShortCode_list extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

		protected function content( $atts, $content = null )
		{
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			extract( $atts );
	
			$unicode_class = $custom_css = $id = '';
			
			if( $style == 'orb' ) $style = 'bullet';
			
			$id = uniqid();
			
			if( $style == 'custom' && !empty($unicode) )
			{
				$unicode_class = 'list-'. $unicode;
	
	
				wp_enqueue_style( 'acoda-custom-styles-list-'. $id,	 get_template_directory_uri() . '/css/custom-styles.css', false, null );
				
				$custom_css .= "
					.list.list-". $id .".{$unicode_class} li:before {
					 content: '\\{$unicode}';
					}
				";
				
				if( !empty( $custom_color ) && $color == 'custom' )
				{
					$custom_css .= "
						.list.list-". $id .".{$unicode_class} li:before {
						 color: ". $custom_color .";
						}
					";				
				}
				
				wp_add_inline_style( 'acoda-custom-styles-list-'. $id, $custom_css );			
			}
			else if( !empty( $custom_color ) && $color == 'custom' )
			{
				
				
				wp_enqueue_style( 'acoda-custom-styles-list-'. $id,	 get_template_directory_uri() . '/css/custom-styles.css', false, null );
				
				$custom_css .= "
					.list.list-". $id . ".". $style ." li:before {
					 color: ". $custom_color .";
					}
				";				
				
				wp_add_inline_style( 'acoda-custom-styles-list-'. $id, $custom_css );					
			}
	
			return '<div class="list list-'. esc_attr( $id ) .' '. esc_attr( $size ) .' '. esc_attr($style) .' '. esc_attr( str_replace( '-lite','',  $color .' '. $unicode_class ) ) .'">'. wp_kses_post( $content ) .'</div>';
		}
	}

	/* ------------------------------------
	:: LISTS MAP 	
	------------------------------------*/

	vc_map( array(
		"name"		=> esc_html__("List", 'dynamix'),
		"base"		=> "list",
		"class"		=> "wpb_controls_top_right",
		"icon" => get_template_directory_uri() . '/images/acoda.png',
		"controls"	=> "full",
		"category"  => esc_html__('Content', 'dynamix'),
		"params"	=> array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Style", 'dynamix'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Bullet', 'dynamix') => 'bullet', 
					esc_html__('Arrow', 'dynamix') => 'arrow',
					esc_html__('Check', 'dynamix') => 'check', 
					esc_html__('Cross', 'dynamix') => 'cross', 
					esc_html__('Custom', 'dynamix') => 'custom', 
				),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__("Unicode Character", 'dynamix'),
				"param_name" => "unicode",
				"dependency" => Array('element' => 'style' /*, 'not_empty' => true*/, 'value' => array('custom')),
				"description" => wp_kses( __("Add <a href='//fortawesome.github.io/Font-Awesome/icon/coffee/' target='_blank'>Font Awesome</a> <strong>Unicode</strong> Character: e.g. <strong>F0F4</strong>", 'dynamix'), array( 'strong','a' ) )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Color", 'dynamix'),
				"param_name" => "color",
				"value" => array(
					esc_html__('Normal', 'dynamix') => '', 
					esc_html__('Link Color', 'dynamix') => 'link_color',
					esc_html__('Custom', 'dynamix') => 'custom', 
				),
				"description" => esc_html__("Select color of the icon.", 'dynamix')
			),			
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Custom Color", 'dynamix'),
				"param_name" => "custom_color",
				"dependency" => Array('element' => 'color' /*, 'not_empty' => true*/, 'value' => 'custom' ),
				"value" => "",
			),	
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Size", 'dynamix'),
				"param_name" => "size",
				"value" => array(
					esc_html__('Normal', 'dynamix') => '', 
					esc_html__('Medium', 'dynamix') => 'medium',
					esc_html__('Large', 'dynamix') => 'large', 
				),
				"description" => esc_html__("Select size of the icon.", 'dynamix')
			),										
		   array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Text", 'dynamix'),
				"param_name" => "content",
				"value" => "<ul><li>List Item</li><li>List Item</li><li>List Item</li></ul>",
			),		
		),
	));