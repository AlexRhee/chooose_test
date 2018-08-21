<?php

	/* ------------------------------------
	:: GROUP SLIDER
	------------------------------------*/
		  
	class WPBakeryShortCode_postgallery_slider extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

		protected function content( $atts, $content = null )
		{
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			extract( $atts );		  

			// Hover Effect
			$hover_effect = '';		  
		
			$acoda_groupgridcontent 	= ( !empty( $content_type ) ) ? $content_type : '';	
			$acoda_gridcolumns 		= ( !empty( $columns ) ? $columns : 3 );	
			$acoda_imageeffect 		= esc_attr($imageeffect);
			$acoda_lightbox 			= esc_attr($lightbox);
	
			// Ajax
			$load_value 	= $acoda_gridcolumns;
			$load_limit 	= $load_value * 2;
			
			if( $acoda_groupgridcontent == "titleoverlay" || $acoda_groupgridcontent == "titletextoverlay" )
			{
				if( $acoda_imageeffect == 'round' || $acoda_imageeffect == 'frame round' )
				{
					if( !empty( $hover_effect_circle ) )
					{
						$hover_effect = $hover_effect_circle;
					}
					else
					{
						$hover_effect = 'effect20 top_to_bottom';
					}
				}
				else
				{
					if( !empty( $hover_effect_square ) )
					{
						$hover_effect = $hover_effect_square;
					}
					else
					{
						$hover_effect = 'effect6 from_top_and_bottom';
					}				
				}
		
				if( !empty( $hover_effect ) )
				{
					wp_enqueue_style('ihover', get_template_directory_uri().'/css/ihover.min.css',false,null );
				}	
			}	
	
			$acoda_class 			= esc_attr($class);
			$acoda_imgalign 		= ( !empty( $image_align ) ? 'imgalign-'. $image_align : '' );
			$acoda_slidercolumns	= ( !empty( $columns ) ? $columns : '3' );
		
		
			// Set effect
			if( !empty( $animation ) )
			{
				$acoda_effect = $animation;
			}
			else
			{
				$acoda_effect = 'scrollHorz';
			}
			 
			// Tween
			$acoda_tween = "easeInOutExpo";
		
			// Excerpt
			if( !empty($excerpt) )
			{
				$acoda_galleryexcerpt = esc_attr($excerpt);
			}
			else
			{
				$acoda_galleryexcerpt = "55";
			}
		
		
			$output = '';
			
			/* ------------------------------------
			:: SET SOURCE VARIABLES
			------------------------------------*/
			
			$acoda_shortcode_id = uniqid();
			$acoda_show_slider = 'groupslider';
			$acoda_slidesetid = esc_attr($slidesetid);
			$acoda_images_attach = esc_attr($images_attach);
			$acoda_loop = esc_attr($loop);
	
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

			
			if( !empty( $text_align ) )
			{
				$acoda_class .= ' text_align_'. $text_align;
			}

			if( !empty( $hover_icons ) )
			{
				$acoda_class .= ' disable_icons';
			}			
			
			if( $acoda_groupgridcontent == "textoverlay_static" || $acoda_groupgridcontent == "titleoverlay_static" )
			{
				$acoda_class .= ' overlay_content';
			}					
			
			/* ------------------------------------
			:: SET VARIABLES *END*
			------------------------------------*/
			
			$attributes = 'content:'. $acoda_groupgridcontent .'|excerpt:'. $acoda_galleryexcerpt . '|lightbox:'. $acoda_lightbox . '|img_size:'. $img_size. '|imageeffect:'. $acoda_imageeffect. '|hover_effect:'. $hover_effect.'|title_size:'. $title_size.'|gallery_id:'.$acoda_shortcode_id. '|product_price:'. $product_price. '|post_date:'. $post_date. '|post_author:'. $post_author;		
		
			$output .= '<div id="group-slider-'. esc_attr( $acoda_shortcode_id ) .'" class="'. ( !empty( $load_ajax ) ? 'acoda-ajax-container ' : '' ) .'gallery-wrap group-slider shortcode loading '. esc_attr( $acoda_class ) .' nav-'. esc_attr( $navigation ) .' acoda-skin clearfix" data-groupslider-fx="'. esc_attr( $acoda_effect ) .'" data-type="'. esc_attr( $acoda_show_slider ) .'" '. ( !empty( $load_ajax ) ? 'data-grid-columns="'. esc_attr( $acoda_gridcolumns ) .'" data-load-method="'. esc_attr( $load_ajax ) .'" data-source="'. esc_attr( $acoda_datasource ) .'" data-attributes="'. esc_attr( $attributes ) .'" data-query="'. esc_attr( $query ) .'" data-ajaxurl="'. esc_url( admin_url() ) .'admin-ajax.php"' : '' ) .'>';
			$output .= '<div class="group-slider '. esc_attr( $acoda_imgalign ) .'" '. ( !empty( $min_height ) ? 'style="min-height:'. esc_attr( $min_height ) .'px"' : '' ).'>';
			
			/* ------------------------------------
			:: LOAD DATA SOURCE
			------------------------------------*/
		
			if( $acoda_datasource == "data-4" )
			{
				//include(get_template_directory() .'/lib/inc/classes/slideset-class.php');		
			}
			elseif( $acoda_datasource == "data-9" )
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
		
		
			$postcount = 0;
		
			$output .= '</div><!-- / groupslider -->';
			
	
			if( $navigation != "disabled" && $post_count > $acoda_slidercolumns )
			{
				$output .= '<div class="slidernav-left">';
				$output .= '<div class="slidernav"><a href="#"></a></div>';
				$output .= '</div>';
				$output .= '<div class="slidernav-right">';
				$output .= '<div class="slidernav"><a href="#"></a></div>';
				$output .= '</div>';
			}
			
			$output .= '<div class="dynamic-frame" data-offset="'. esc_attr( $load_limit ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $load_value ) .'">';
			$output .= '<input name="group-slider-'. esc_attr( $acoda_shortcode_id ) .'_timeout" class="timeout" value="'. esc_attr( $timeout ) .'" type="hidden" />';
			$output .= '</div>';
			$output .= '</div><!-- / gallery-wrap -->';
		

			wp_enqueue_script('jquery-cycle', get_template_directory_uri().'/js/jquery.cycle.plugin.min.js',false,array('jquery'),true ); 
			wp_enqueue_script('touch-gestures', get_template_directory_uri().'/js/touch.gestures.min.js',false,array('jquery'),true );
			wp_enqueue_script('acoda-group-slider', get_template_directory_uri().'/js/group.slider.min.js',false,array('jquery-cycle'),true );	
			
			return $output;	
		}
	}

	/* ------------------------------------
	:: GROUP GALLERY MAP
	------------------------------------*/

	vc_map( array(
		"base"		=> "postgallery_slider",
		"name"		=> esc_html__("Group Slider", 'dynamix'),
		"class"		=> "group",
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
			acoda_common_options( 'content' ),
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
				'type' => 'dropdown',
				'group' => esc_html__('Text', 'dynamix'),
				'heading' => esc_html__( 'Text Align', 'dynamix' ),
				'param_name' => 'text_align',
				"value" => array( 
					esc_html__("Center", 'dynamix') => '',
					esc_html__("Left", 'dynamix') => 'left',
					esc_html__("Right", 'dynamix') => 'right',
					esc_html__("Justify", 'dynamix') => 'justify',
				),					
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','text') ),
			),
			array(
				'type' => 'dropdown',
				'group' => esc_html__('Text', 'dynamix'),
				'heading' => esc_html__( 'Vertical Align', 'dynamix' ),
				'param_name' => 'text_vertical_align',
				"value" => array( 
					esc_html__("Middle", 'dynamix') => 'middle',
					esc_html__("Bottom", 'dynamix') => 'bottom',		
					esc_html__("Top", 'dynamix') => 'top',
				),					
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','text') ),
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
			array(
				"type" => "textfield",
				'group' => esc_html__('Images', 'dynamix'),
				"class" => "",
				"heading" => esc_html__("Image Size", 'dynamix'),
				"param_name" => "img_size",
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','image') ),
				"value" => "large",
				"description" => esc_html__("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'medium' size.", 'dynamix')
			),			
			acoda_common_options( 'imageeffect' ),
			array(
				"type" => "checkbox",
				"class" => "",
				'group' => esc_html__('Images', 'dynamix'),
				"heading" => esc_html__("Lightbox", 'dynamix'),
				"param_name" => "lightbox",
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay','textoverlay_static','titleoverlay_static','image') ),
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'yes',
				)
			),				
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Hover Effect", 'dynamix'),
				"param_name" => "hover_effect_square",
				"value" => array( 
					esc_html__("Default", 'dynamix') => '',
					esc_html__("Zoom Image + Slide Text ( From Top )", 'dynamix') => 'effect6 from_top_and_bottom',
					esc_html__("Zoom Image + Slide Text ( From Left )", 'dynamix') => 'effect6 from_left_and_right',
					esc_html__("Zoom Image + Text", 'dynamix') => 'effect7'	,					
					esc_html__("Flip Image Top", 'dynamix') => 'effect9 bottom_to_top',
					esc_html__("Flip Image Bottom", 'dynamix') => 'effect9 top_to_bottom',
					esc_html__("Flip Image Left", 'dynamix') => 'effect9 right_to_left',
					esc_html__("Flip Image Right", 'dynamix') => 'effect9 left_to_right',
					esc_html__("Slide Image + Horizontal", 'dynamix') => 'effect10 right_to_left',
					esc_html__("Slide Image + Vertical", 'dynamix') => 'effect10 top_to_bottom',
					esc_html__("3d Rotate Vertical", 'dynamix') => 'effect15 bottom_to_top'	,
					esc_html__("3d Rotate Horizontal", 'dynamix') => 'effect15 right_to_left',
				),
				"description" => wp_kses( __( "<strong>Note:</strong> Requires a \"Content\" option to contain Text or Title.", 'dynamix'), wp_kses_allowed_html() ),
				"dependency" => Array('element' => 'content_type' /*, 'not_empty' => true*/, 'value' => array('titletextoverlay','titleoverlay')),
				"group" => esc_html__('Hover Effects', 'dynamix')
			),		
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Hover Action", 'dynamix'),
				"param_name" => "hover_effect_static",
				"value" => array( 
					esc_html__("None", 'dynamix') => 'static',
					esc_html__("Reveal Image", 'dynamix') => 'reveal',
				),
				"description" => wp_kses( __( "<strong>Note:</strong> Requires a \"Content\" option to contain Text or Title.", 'dynamix'), wp_kses_allowed_html() ),
				"dependency" => Array('element' => 'content_type' /*, 'not_empty' => true*/, 'value' => array('textoverlay_static','titleoverlay_static')),
				"group" => esc_html__('Hover Effects', 'dynamix')
			),		
			acoda_common_options( 'timeout' ),
			acoda_common_options( 'columns' ),
			acoda_common_options( 'columnpadding' ),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Ajax Lazy Load", 'dynamix'),
				"param_name" => "load_ajax",
				"value" => array( 
					esc_html__("Disabled", 'dynamix') => '',
					esc_html__("Scroll to Load", 'dynamix') => 'scroll_load',
					esc_html__("Click to Load", 'dynamix') => 'click_load',				
				),
				"description" => esc_html__("Load Gallery content in via Ajax ( Reduces page load time ).", 'dynamix'),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Minimum Slider Height", 'dynamix'),
				"param_name" => "min_height",
				"value" => "",
				"description" => esc_html__("Enter a height to prevent the Slider from adjusting height when using different sized images.", 'dynamix')
			),	
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__( 'Navigation', 'dynamix'),
				"param_name" => "navigation",
				"value" => array(
					'Static Arrows' => 'arrowstatic',
					'Arrows on Hover' => 'arrowhover',
					'Disable Navigation' => 'disabled'
				)
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
				"heading" => esc_html__("Slides Per Ajax Load", 'dynamix'),
				"param_name" => "load_value",
				"value" => "",
				"description" => esc_html__("Enter how many Slides you wish to load in.", 'dynamix'),
				"dependency" => Array('element' => 'load_ajax', 'not_empty' => true ),
			),						
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Animated Filtering", 'dynamix'),
				"param_name" => "filtering",
				"value" => array( 
					esc_html__("Disabled", 'dynamix') => '',
					esc_html__("Click to Filter", 'dynamix') => 'click',
					esc_html__("Search Filter", 'dynamix') => 'search',				
				),
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