<?php

	/* ------------------------------------
	:: STAGE SLIDER
	------------------------------------*/
	
	class WPBakeryShortCode_postgallery_image extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

		protected function content( $atts, $content = null )
		{
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			extract( $atts );

			/* ------------------------------------
			:: SET VARIABLES
			------------------------------------*/
		
			$acoda_stagetimeout	= '';
			$acoda_shortcode_id 	= uniqid();
			$acoda_show_slider	= 'stageslider';
			$acoda_slidesetid 		= esc_attr($slidesetid);
			$acoda_images_attach	= esc_attr($images_attach);
			$acoda_loop 			= esc_attr($loop);		
			$acoda_lightbox 		= esc_attr($lightbox);
			
			// Ajax
			$load_value = 1;
		
			// Data Source
			$acoda_datasource = ( empty( $data_source  ) ) ? 'data-10' : $data_source;
	
			if( $acoda_datasource == "data-4" )
			{
				$query = $slidesetid;
			}
			elseif( $acoda_datasource == "data-9" )
			{
				$query = $acoda_images_attach;
			}	
			elseif( $acoda_datasource == "data-10" )
			{
				$query = $acoda_loop;
			}			
			
			$acoda_galleryexcerpt = ( !empty( $excerpt ) ) ? $excerpt : '55';
			$acoda_animation = ( !empty( $animation ) ) ? $animation : 'fade';
			$acoda_tween = ( !empty( $tween ) ) ? $tween : 'linear';
	
			$acoda_imageeffect = esc_attr($imageeffect);
			
			$acoda_groupgridcontent = ( !empty( $content_type ) ) ? $content_type : '';
						
			if( !empty($timeout) )
			{
				$acoda_stagetimeout = esc_attr($timeout);
			}
	
			$hover_effect = '';
					
			// Hover Effect
			if( $acoda_groupgridcontent == "titleoverlay" || $acoda_groupgridcontent == "titletextoverlay" )
			{
				$hover_effect = 'effect6 from_top_and_bottom';
			}			
	
			if( !empty( $hover_effect ) )
			{
				wp_enqueue_style('ihover', get_template_directory_uri().'/css/ihover.min.css',false,null );
			}			
			
			$attributes = 'content:'. $acoda_groupgridcontent .'|excerpt:'. $acoda_galleryexcerpt . '|lightbox:'. $acoda_lightbox . '|img_size:'. $img_size. '|imageeffect:'. $acoda_imageeffect . '|hover_effect:'. $hover_effect;	
		
			$output = '';
						
			$output .= '<div id="id-'. esc_attr( $acoda_shortcode_id ) .'" class="'. ( !empty( $load_ajax ) ? 'acoda-ajax-container ' : '' ) .'gallery-wrap '. esc_attr( $acoda_imageeffect ) .' nav-'. esc_attr( $navigation ) .' stage shortcode id-'. esc_attr( $acoda_shortcode_id ) .'" data-type="'. esc_attr( $acoda_show_slider ) .'" '. ( !empty( $ratio ) ? 'data-ratio="'. esc_attr( $ratio ) .'"' : '' ) .' data-stage-nav="'. esc_attr( $navigation ) .'" data-stage-effect="'. esc_attr( $acoda_animation ) .'" data-stage-easing="'. esc_attr( $acoda_tween ) .'" '. ( !empty( $load_ajax ) ? 'data-load-method="'. esc_attr( $load_ajax ) .'" data-source="'. esc_attr( $acoda_datasource ) .'" data-attributes="'. esc_attr( $attributes ) .'" data-query="'. esc_attr( $query ) .'" data-ajaxurl="'. esc_url( admin_url() ) .'admin-ajax.php"' : '' ) .'>';
				
			if( strpos( $navigation, "bullet" ) !== false ) 
			{			
				$output .= '<div class="control-wrap">';
				$output .= '<div class="control-panel">';
				$output .= '</div><!-- / control-panel -->';
				$output .= '</div><!-- / control-wrap -->';
			} 		
			 
			$output .= '<div class="stage-slider '. ( !empty( $image_fit ) ? esc_attr( 'fit-image-'. $image_fit ) : '' ) .'" '. ( !empty( $height ) && $ratio == 'custom' ? 'style="height:'. esc_attr( $height ) .'px"' : '' ) .'>';
			
	
			/* ------------------------------------
			:: LOAD DATA SOURCE
			------------------------------------*/		
		
			if( $acoda_datasource == "data-9" )
			{
				include(get_template_directory() .'/lib/inc/classes/attach-images-class.php');		
			}	
			elseif( $acoda_datasource == "data-10" )
			{
				include(get_template_directory() .'/lib/inc/classes/post-loop-class.php');		
			}			
		
			/* ------------------------------------
			:: LOAD DATA SOURCE *END*
			------------------------------------*/ 
		
			$slidenum_chk = $postcount;
			if( !empty($post_count) ) $slidenum_chk = $post_count;
		
			$output .= '</div><!-- / stageslider -->';
	
			if( strpos( $navigation, "arrow" ) !== false )
			{
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
			} 
	
			$output .= '<div class="dynamic-frame clearfix" data-offset="'. esc_attr( $load_limit ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $load_value ) .'">';
			$output .= '<input name="'. esc_attr( $acoda_shortcode_id ) .'_timeout_array" class="timeout_array" value="'. esc_attr( $acoda_slidearray ) .'" type="hidden" />';
			$output .= '<input name="'. esc_attr( $acoda_shortcode_id ) .'_timeout" class="timeout" value="'. esc_attr( $acoda_stagetimeout ) .'" type="hidden" />';
			$output .= '</div>';
			$output .= '</div><!-- / gallery-wrap -->';
		
			wp_enqueue_script('jquery-cycle', get_template_directory_uri().'/js/jquery.cycle.plugin.min.js',false,array('jquery'),true );	
			wp_enqueue_script('touch-gestures', get_template_directory_uri().'/js/touch.gestures.min.js',false,array('jquery'),true );
			wp_enqueue_script('acoda-stage-slider', get_template_directory_uri().'/js/stage.slider.min.js',false,array('jquery-cycle'),true );			
				
			return $output;
		
		}
	}

	/* ------------------------------------
	:: STAGE
	------------------------------------*/

	vc_map( array(
		"base"		=> "postgallery_image",
		"name"		=> esc_html__("Stage Slider", 'dynamix'),
		"class"		=> "stage",
		"controls"	=> "edit_popup_delete",
		"icon" => get_template_directory_uri() . '/images/acoda.png',
		"category"  => esc_html__('Gallery', 'dynamix'),
		"params"	=> array(				
			acoda_common_options( 'datasource' ),
			acoda_common_options( 'data-9' ),
			acoda_common_options( 'data-10' ),
			acoda_common_options( 'excerpt' ),				
			acoda_common_options( 'data-4' ),
			array(
				"type" => "textfield",
				"class" => "",
				'group' => esc_html__('Text', 'dynamix'),
				"heading" => esc_html__("Excerpt", 'dynamix'),
				"param_name" => "excerpt",
				"value" => "",
				"description" => esc_html__("Default 240.", 'dynamix'),
				"dependency" => Array('element' => 'data_source' /*, 'not_empty' => true*/, 'value' => array('data-10'))
			),			
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Read More Link', 'dynamix' ),
				'param_name' => 'read_more',
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'enable',
				),
				"dependency" => Array('element' => 'data_source' /*, 'not_empty' => true*/, 'value' => array('data-10')),
				"group" => esc_html__('Text', 'dynamix')
			),			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Ajax Lazy Load", 'dynamix'),
				"param_name" => "load_ajax",
				"value" => array( 
					esc_html__("Disabled", 'dynamix') => '',
					esc_html__("Enable", 'dynamix') => 'auto_load',	
				),
				"description" => esc_html__("Load Gallery content in via Ajax ( Reduces page load time ).", 'dynamix'),
			),		
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Lazy Load Initial Limit", 'dynamix'),
				"param_name" => "load_limit",
				"value" => "",
				"description" => esc_html__("Enter how many slides you wish to display on initial load.", 'dynamix'),
				"dependency" => Array('element' => 'load_ajax', 'not_empty' => true ),
			),			
			array(
				"type" => "textfield",
				"class" => "",
				'group' => esc_html__('Images', 'dynamix'),
				"heading" => esc_html__("Image Size", 'dynamix'),
				"param_name" => "img_size",
				"value" => "full",
				"description" => esc_html__("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'large' size.", 'dynamix')
			),		
			array(
				"type" => "dropdown",
				"class" => "",
				'group' => esc_html__('Images', 'dynamix'),
				"heading" => esc_html__( 'Image Fit', 'dynamix'),
				"param_name" => "image_fit",
				"value" => array(
					'Default' => '',
					'Cover' => 'cover',
					'Contain' => 'contain',
				),
				"description" => esc_html__("Select how the image fits within the Slider. 'Default' allows for images to be set individually.", 'dynamix')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				'group' => esc_html__('Images', 'dynamix'),
				"heading" => esc_html__( 'Height', 'dynamix'),
				"param_name" => "ratio",
				"value" => array(
					'Custom' => 'custom',
					'21:9' => '21:9',
					'16:9' => '16:9',
					'4:3' => '4:3',
					"1:1" => "1:1",
					'9:21' => '9:21',
					'9:16' => '9:16',
					'3:4' => '3:4',					
				),
				"description" => esc_html__("Select how the image fits within the Slider. 'Default' allows for images to be set individually.", 'dynamix')
			),			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Custom Height", 'dynamix'),
				"param_name" => "height",
				"value" => "",
				"dependency" => Array('element' => "ratio", 'value' => array('custom') ),
				"description" => esc_html__("Set a height for the Gallery, default is 400.", 'dynamix')
			),						
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__( 'Content', 'dynamix'),
				"param_name" => "content_type",
				"value" => array(
					esc_html__( 'Text on Hover + Image', 'dynamix') => 'titletextoverlay',
					esc_html__( 'Title on Hover + Image', 'dynamix') => 'titleoverlay',	
					esc_html__( 'Text Overlay + Image', 'dynamix') => 'textoverlay_static',	
					esc_html__( 'Title Overlay + Image', 'dynamix') => 'titleoverlay_static',					
					esc_html__( 'Image Only', 'dynamix') => 'image',
					esc_html__( 'Text Only', 'dynamix') => 'text',
				)
			),
			array(
				'type' => 'dropdown',
				'group' => esc_html__('Text', 'dynamix'),
				'heading' => esc_html__( 'Title Tag', 'dynamix' ),
				'param_name' => 'title_tag',
				"value" => array( 
					esc_html__("Div", 'dynamix') => 'div',
					esc_html__("Bold", 'dynamix') => 'strong',
					esc_html__("H2", 'dynamix') => 'h2',
					esc_html__("h3", 'dynamix') => 'h3',
					esc_html__("h4", 'dynamix') => 'h4',
					esc_html__("h5", 'dynamix') => 'h5',
					esc_html__("h6", 'dynamix') => 'h6',
				),					
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','text') ),
				"description" => esc_html__("Set the Caption Title size.", 'dynamix')
			),		
			array(
				'type' => 'dropdown',
				'group' => esc_html__('Text', 'dynamix'),
				'heading' => esc_html__( 'Title Size', 'dynamix' ),
				'param_name' => 'title_size',
				"value" => array( 
					esc_html__("Normal", 'dynamix') => '',
					esc_html__("Small", 'dynamix') => 'small',
					esc_html__("Medium", 'dynamix') => 'medium',
					esc_html__("Large", 'dynamix') => 'large',
				),					
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','text') ),
				"description" => esc_html__("Set the Caption Title size.", 'dynamix')
			),
			array(
				'type' => 'dropdown',
				'group' => esc_html__('Text', 'dynamix'),
				'heading' => esc_html__( 'Text Size', 'dynamix' ),
				'param_name' => 'text_size',
				"value" => array( 
					esc_html__("Normal", 'dynamix') => '',
					esc_html__("Small", 'dynamix') => 'small',
					esc_html__("Medium", 'dynamix') => 'medium',
					esc_html__("Large", 'dynamix') => 'large',
				),					
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','text') ),
				"description" => esc_html__("Set the Caption Title size.", 'dynamix')
			),			
			array(
				"type" => "colorpicker",
				'group' => esc_html__('Text', 'dynamix'),
				"heading" => esc_html__('Title Color', 'dynamix'),
				"param_name" => "title_color",
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','text') ),
				"value" => ''
			),
			array(
				"type" => "colorpicker",
				'group' => esc_html__('Text', 'dynamix'),
				"heading" => esc_html__('Text Color', 'dynamix'),
				"param_name" => "text_color",
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','text') ),
				"value" => ''
			),		
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Post Author', 'dynamix' ),
				'param_name' => 'post_author',
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'enable',
				),
				"dependency" => Array('element' => 'data_source' /*, 'not_empty' => true*/, 'value' => array('data-10')),
				"group" => esc_html__('Text', 'dynamix')
			),	
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Post Date', 'dynamix' ),
				'param_name' => 'post_date',
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'enable',
				),
				"dependency" => Array('element' => 'data_source' /*, 'not_empty' => true*/, 'value' => array('data-10')),
				"group" => esc_html__('Text', 'dynamix')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Product Price', 'dynamix' ),
				'description' => esc_html__( 'WooCommerce Only', 'dynamix' ),
				'param_name' => 'product_price',
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'enable',
				),
				"dependency" => Array('element' => 'data_source' /*, 'not_empty' => true*/, 'value' => array('data-10')),
				"group" => esc_html__('Text', 'dynamix')
			),			
			acoda_common_options( 'timeout' ),
			acoda_common_options( 'imageeffect' ),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__( 'Animation Type', 'dynamix'),
				"param_name" => "animation",
				"value" => array(
					esc_html__( 'Fade', 'dynamix' ) => 'fade',
					esc_html__( 'Zoom', 'dynamix' ) => 'fadeZoom',
				)
			),		
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__( 'Navigation', 'dynamix' ),
				"param_name" => "navigation",
				"value" => array(
					esc_html__( 'Arrows on Hover', 'dynamix' ) => 'arrowhover',
					esc_html__( 'Static Arrows', 'dynamix' ) => 'arrowstatic',
					esc_html__( 'Bullet Navigation', 'dynamix' ) => 'bullet',
					esc_html__( 'Arrows on Hover + Bullet', 'dynamix' ) => 'bulletarrowhover',
					esc_html__( 'Static Arrows + Bullet', 'dynamix' ) => 'bulletarrowstatic',	
					esc_html__( 'Disable Navigation', 'dynamix' ) => 'disabled'
				)
			),			
			array(
				"type" => "checkbox",
				"class" => "",
				'group' => esc_html__('Images', 'dynamix'),
				"heading" => esc_html__("Lightbox", 'dynamix'),
				"param_name" => "lightbox",
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'yes',
				)
			),		
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Overlay", 'dynamix'),
				"param_name" => "hover_overlay",
				"value" => array( 
					esc_html__("Enable", 'dynamix') => 'enable',
					esc_html__("Disable", 'dynamix') => 'disable',			
				),
				"group" => esc_html__('Hover Effects', 'dynamix')
			),
			array(
				"type" => "colorpicker",
				'group' => esc_html__('Hover Effects', 'dynamix'),
				"heading" => esc_html__('Overlay Color', 'dynamix'),
				"param_name" => "overlay_color",
				"dependency" => Array('element' => 'hover_overlay', 'value' => 'enable' ),
				"value" => 'rgba(0,0,0,0.8)'
			),			
			array(
				"type" => "dropdown",
				"group" => esc_html__('Hover Effects', 'dynamix'),
				"heading" => esc_html__("Action Icons", 'dynamix'),
				"param_name" => "hover_icons",
				"value" => array( 
					esc_html__("Enable", 'dynamix') => 'enable',
					esc_html__("Disable", 'dynamix') => 'disable',				
				),
			),		
			array(
				"type" => "colorpicker",
				'group' => esc_html__('Hover Effects', 'dynamix'),
				"heading" => esc_html__('Action Icons Color', 'dynamix'),
				"param_name" => "hover_icons_color",
				"dependency" => Array('element' => 'hover_icons', 'value' => 'enable' ),
				"value" => '#ffffff'
			),			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("CSS Classes", 'dynamix'),
				"param_name" => "class",
				"value" => "",
				"description" => esc_html__("Add an optional CSS classes.", 'dynamix')
			),					
		)		
	) );