<?php

/* ------------------------------------
:: SOCIAL ICONS
------------------------------------*/

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	
		class WPBakeryShortCode_Socialicon extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

			protected function content( $atts, $content = null )
			{
				$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
				extract( $atts );
		
				$output = '';
				
				// Get Social Icons
				$get_social_icons = acoda_settings('socialicons');
	
				foreach( $get_social_icons as $social_icon => $value )
				{
	
					
					if( $value['id'] == $name )
					{					
						if( empty( $url ) )
						{
							$social_defaultlink = acoda_social_icon_data( $value['id'] );
							$sociallink = ( ! empty( $social_defaultlink ) ? acoda_social_link( $social_defaultlink ) : '' );
						}
						else
						{
							$sociallink = ( ! empty( $url ) ? acoda_social_link( $url ) : '' );
						}				

						// Check for lightbox attribute
						$popup = '';

						if( strpos( $sociallink , 'popup=yes' ) !== false ) 
						{
							$sociallink = str_replace( 'popup=yes', '', $sociallink );
							$popup = 'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600")';
						}		


						$icon_name = '';
						$icon_name = strtolower( str_replace('.','',$value['name'] ) );
						$icon_id = str_replace(' ','-',$icon_name );


						//if( $icon_name == 'vimeo' ) $icon_name = 'vimeo-square';
						//if( $icon_name == 'email' ) $icon_name = 'envelope';
						//if( $icon_name == 'google' ) $icon_name = 'google-plus';

						$output .= "\n\t\t". '<li class="dock-tab social-'. esc_attr( $icon_id ) .'">';

						$output .= "\n\t\t\t". '<a href="'. esc_url( str_replace(' ', '%20', $sociallink) ) .'" rel="nofollow" title="'. esc_attr( $value['name'] ) .'" '. ( !empty( $popup ) ? 'data-test="test" onclick="'. esc_js( $popup ) .'"' : '' ) .' target="_blank"><i class="social-icon fab fa-lg fa-'. esc_attr( $icon_name ) .'"></i></a>';

						$output .= "\n\t\t". '</li>';
					}
						
				}
		
				return $output;
			}
	
			public function mainHtmlBlockParams($width, $i) {
				return 'data-element_type="'. esc_attr( $this->settings["base"] ) .'" class=" wpb_'. esc_attr( $this->settings['base'] ) .'"'. esc_attr( $this->customAdminBlockParams() );
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

	
		class WPBakeryShortCode_Socialwrap extends WPBakeryShortCodesContainer {

			protected function content( $atts, $content = null )
			{
				$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
				extract( $atts );
				
				$output = '';
		
				$el_class = $this->getExtraClass($el_class);
	
				if( $share_icon == 'yes' )
				{
					$output .= "\n\t".'<div class="socialicons init '. esc_attr( $size .' '. $align .' '. $el_class ) .' clearfix">';
					$output .= "\n\t\t".'<ul>';
					$output .= "\n\t\t\t".'<li class="dock-tab"><a class="socialinit" href="#"><i class="fal fa-share-alt fa-lg"></i></a></li>';
					$output .= "\n\t\t".'</ul>';
					$output .= "\n\t".'</div>';
					$output .= "\n\t".'<div class="socialicons '. esc_attr( $align.' '. $el_class ) .' toggle">';
					$output .= "\n\t\t".'<ul class="clearfix">';
					$output .= "\n\t\t\t". do_shortcode( $content );
					$output .= "\n\t\t".'</ul>';
					$output .= "\n\t".'</div>';
				}
				else
				{
					$output .= "\n\t".'<div class="socialicons display '. esc_attr( $size .' '.$align.' '. $el_class ) .' clearfix">';
					$output .= "\n\t\t".'<ul>';
					$output .= "\n\t\t\t". do_shortcode( $content );
					$output .= "\n\t\t".'</ul>';
					$output .= "\n\t".'</div>';
					$output .= "\n\t".'<div class="clear"></div>';				
				}
	
				return $output;
			}
		}
	}


	/* ------------------------------------
	:: SOCIAL ICONS MAP
	------------------------------------*/	

	vc_map( array(
		"name"		=> esc_html__("Social Icons", 'dynamix'),
		"base"		=> "socialwrap",
		"show_settings_on_create" => false,
		"icon" => get_template_directory_uri() . '/images/acoda.png',
		"content_element" => true,
		"as_parent" => array('only' => 'socialicon'), // Use only|except attributes 
		"category"  => esc_html__('Social', 'dynamix'),
		"wrapper_class" => "clearfix social_wrap",
		"params"	=> array(
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Share Icon", 'dynamix'),
				"param_name" => "share_icon",
				"value" =>  array(
					esc_html__('Enable', 'dynamix') => "yes", 
				)
			),	
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Size", 'dynamix'),
				"param_name" => "size",
				"value" => array(
					esc_html__('Normal', 'dynamix') => 'medium',
					esc_html__('Large', 'dynamix') => 'large', 
				),
			),				
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Align", 'dynamix'),
				"param_name" => "align",
				"value" => array(
					esc_html__('Left', 'dynamix') => 'left',
					esc_html__('Center', 'dynamix') => 'center', 
					esc_html__('Right', 'dynamix') => 'right', 

				),
			),							
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dynamix'),
				"param_name" => "el_class",
				"value" => "",
				"description" => esc_html__("Add custom CSS classes. Use color for social icons in color.", 'dynamix')
			)
		),
	  "js_view" => 'VcColumnView'
	) );
	
	
	// Get Social Icons
	$get_social_icons = ( acoda_settings('socialicons') != '' ? acoda_settings('socialicons') : '');
	
	if( !empty( $get_social_icons ) )
	{
		foreach( $get_social_icons as $social_icon => $value )
		{
			$social_icons[ $value['name'] ] = $value['id'];
		}

		vc_map( array(
			"name"		=> esc_html__("Social Icon", 'dynamix'),
			"base"		=> "socialicon",
			"content_element" => true,
			"as_child" => array('only' => 'socialwrap'), // Use only|except attributes 
			"params"	=> array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Social Icon", 'dynamix'),
					"holder" => "h4",
					"param_name" => "name",
					"value" => $social_icons,
					"description" => esc_html__("Select color of the toggle icon.", 'dynamix')
				),				
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link URL", 'dynamix'),
					"param_name" => "url",
					"value" => "",
					"description" => esc_html__("Optional Link URL", 'dynamix')
				),	
			)
		) );
	}