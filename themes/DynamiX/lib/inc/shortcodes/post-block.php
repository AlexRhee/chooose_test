<?php

	/* ------------------------------------
	:: GRID GALLERY
	------------------------------------*/	
	
	class WPBakeryShortCode_postgallery_grid extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

		protected function content( $atts, $content = null )
		{
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			extract( $atts );
	
			if( !empty( $load_ajax ) )
			{
				if( $load_ajax == 'scroll_load' )
				{
					wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), true );
				}
				
				wp_enqueue_script(	 'acoda-loadposts', get_template_directory_uri() . '/js/load-ajax.js',array( 'jquery' ), true );		
			}
			
			$acoda_groupgridcontent = ( !empty( $content_type ) ) ? $content_type : '';
			
			$acoda_gridfilter = $filtering;
		
			if( empty($columns) )
			{
				$acoda_gridcolumns = "3"; // Set default 3 Columns
			}
			else
			{
				$acoda_gridcolumns = $columns;
			}
			
			$columnpadding = $columnpadding;
			$acoda_imageeffect = $imageeffect;
			$acoda_lightbox = $lightbox;
	
			// Hover Effect
			$hover_effect = '';
			
			if( $acoda_groupgridcontent == "titleoverlay" || $acoda_groupgridcontent == "titletextoverlay" )
			{				
				if( $acoda_imageeffect == 'round' || $acoda_imageeffect == 'frame round' || $acoda_imageeffect == 'round shadow' || $acoda_imageeffect == 'round blackwhite' )
				{
					if( !empty( $hover_effect_circle ) )
					{
						$hover_effect = $hover_effect_circle;
					}
					else
					{
						$hover_effect = 'effect3 top_to_bottom';
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
						$hover_effect = 'effect5 from_top_and_bottom';
					}				
				}
		
				if( !empty( $hover_effect ) )
				{
					wp_enqueue_style('ihover', get_template_directory_uri().'/css/ihover.min.css',false,null );
				}	
			}			
		
			// Excerpt
			if( !empty($excerpt) )
			{
				$acoda_galleryexcerpt = $excerpt;
			}
			else
			{
				$acoda_galleryexcerpt = "55";
			}
		
			$output = $attributes = $query = '';
			
			/* ------------------------------------
			:: SET VARIABLES
			------------------------------------*/
			
			$acoda_shortcode_id = uniqid();
			$acoda_show_slider = 'gridgallery';
			$acoda_slidesetid = $slidesetid;
			$acoda_images_attach = $images_attach;
			$acoda_loop = $loop;
			
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
	
			$class = '';
	
			if( $acoda_gridfilter == 'click' )
			{
				$class .= ' click filter';
			}
			elseif( $acoda_gridfilter == 'search' )
			{
				$class .= ' search filter';
			}
			
			if( !empty( $text_align ) )
			{
				$class .= ' text_align_'. $text_align;
			}
			
			if( $acoda_groupgridcontent == "textoverlay_static" || $acoda_groupgridcontent == "titleoverlay_static" )
			{
				$class .= ' overlay_content';
			}
			
			if( !empty( $hover_icons ) )
			{
				$class .= ' action_icons_'. $hover_icons;
			}


			if( !empty( $hover_overlay ) )
			{
				$class .= ' action_overlay_'. $hover_overlay;
			}


			if( $acoda_groupgridcontent == "textimage" || $acoda_groupgridcontent == "titleimage" )
			{
				$class .= ' static_content';
			}			
			
			
			
			$attributes = 'content:'. $acoda_groupgridcontent .'|excerpt:'. $acoda_galleryexcerpt . '|lightbox:'. $acoda_lightbox . '|img_size:'. $img_size. '|imageeffect:'. $acoda_imageeffect. '|hover_effect:'. $hover_effect.'|title_size:'. $title_size.'|gallery_id:'.$acoda_shortcode_id. '|product_price:'. $product_price. '|post_date:'. $post_date. '|post_author:'. $post_author;		
			
			/* ------------------------------------
			:: SET VARIABLES *END*
			------------------------------------*/
		
			$output .= '<div id="grid-'. esc_attr( $acoda_shortcode_id ) .'" '. ( !empty( $load_ajax ) ? 'data-load-method="'. esc_attr( $load_ajax ) .'" data-grid-columns="'. esc_attr( $acoda_gridcolumns ) .'" data-type="'. esc_attr( $acoda_show_slider ) .'" data-source="'. esc_attr( $acoda_datasource ) .'" data-attributes="'. esc_attr( $attributes ) .'" data-query="'. esc_attr( $query ) .'" data-ajaxurl="'. esc_url( admin_url() ) .'admin-ajax.php"' : '' ) .' class="'. ( !empty( $load_ajax ) ? 'acoda-ajax-container ' : '' ) .'gallery-wrap grid-gallery fluid-gutter acoda-skin '. esc_attr( $columnpadding .' '. ( !empty( $masonry ) ? 'masonry' : '' ) .' '. $class ) .'">';	
		
			$postcount = 0;
		
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
	
			if( !empty( $load_ajax ) )
			{
				$output .= '<div class="acoda-ajax-loading"></div>';
			}
	
			if( $load_ajax == 'click_load' )
			{
				$output .= '<div class="button-wrap acoda-ajax-loaddata wpb_regularsize aligncenter"><div class="button link_color vc_btn_rounded inherit"><a>'. esc_html__('Load More', 'dynamix' ) .'</a></div></div>';
			}
		
			$output .= '<div class="clear"></div>';
			$output .= '</div><!-- /gallery-wrap -->';
	
			if( $acoda_gridfilter == 'click' || $acoda_gridfilter == 'search' || !empty( $masonry ) ) 
			{
				wp_enqueue_script('jquery-isotope', get_template_directory_uri().'/js/jquery.isotope.min.js',false,array('jquery'),true );
			}
		
			return $output;		
		}
	}

	/* ------------------------------------
	:: GRID GALLERY MAP
	------------------------------------*/

	vc_map( array(
		"base"		=> "postgallery_grid",
		"name"		=> esc_html__("Grid Gallery", 'dynamix'),
		"class"		=> "grid",
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
			/*array(
				"type" => "dropdown",
				"heading" => esc_html__("Hover Effect", 'dynamix'),
				"param_name" => "hover_effect_circle",
				"value" => array( 
					esc_html__("Default", 'dynamix') => '',
					esc_html__("Fade + Slide Text ( From Bottom ) + Animate Text", 'dynamix') => 'effect13 bottom_to_top'	,
					esc_html__("Fade + Slide Text ( From Left ) + Animate Text", 'dynamix') => 'effect13 from_left_and_right'	,
					esc_html__("Spin + Slide", 'dynamix') => 'effect2 left_to_right',
					esc_html__("Slide + Shrink", 'dynamix') => 'effect3 left_to_right',
					esc_html__("Slide + Fade", 'dynamix') => 'circle effect4 top_to_bottom',
					esc_html__("Roll Right + Fade", 'dynamix') => 'effect9 left_to_right',
					esc_html__("Spin + Fade", 'dynamix') => 'effect11 bottom_to_top',
					esc_html__("Fade + Fold Down", 'dynamix') => 'effect14 top_to_bottom'	,
					esc_html__("Flip Image Top", 'dynamix') => 'effect18 bottom_to_top',
					esc_html__("Flip Image Down", 'dynamix') => 'effect18 top_to_bottom',
					esc_html__("Flip Image Left", 'dynamix') => 'effect18 right_to_left',
					esc_html__("Flip Image Right", 'dynamix') => 'effect18 left_to_right',

				),
				"description" => wp_kses( __( "<strong>Note:</strong> Requires a \"Content\" option to contain Text or Title.", 'dynamix'), wp_kses_allowed_html() ),
				"dependency" => Array('element' => 'imageeffect', 'value' => array('round','frame round','round shadow','round blackwhite')),
				"group" => esc_html__('Hover Effects', 'dynamix')
			),*/	
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
			acoda_common_options( 'columns' ),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Masonry", 'dynamix'),
				"param_name" => "masonry",
				"value" => array( 
					esc_html__("Disabled", 'dynamix') => '',
					esc_html__("Normal", 'dynamix') => 'masonry',
					esc_html__("Large Featured", 'dynamix') => 'masonry_style_1',				
				),
			),		
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