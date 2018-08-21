<?php

	/* ------------------------------------
	:: CAROUSEL SLIDER
	------------------------------------*/

	class WPBakeryShortCode_carousel_slider extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

		protected function content( $atts, $content = null )
		{
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			extract( $atts );			
			
			$img_size = 'full';
		 
			// slider image width / height	
			$acoda_imgwidth = "1000";
			
			// timeout
			if( !empty($timeout) )
			{
				$acoda_stagetimeout = $timeout;
				$acoda_poststagetimeout = esc_attr($timeout);
			} 
			else
			{
				$acoda_stagetimeout = "10";
			}	
			
			$acoda_imageeffect = '';
		
			$acoda_lightbox = $lightbox; 	
		
			$acoda_groupgridcontent = ( !empty( $content_type ) ) ? $content_type : '';
		
			$acoda_slidesetid = $slidesetid;
	
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
			 
			
			/* ------------------------------------
			:: SET VARIABLES
			------------------------------------*/
			
	
			$acoda_shortcode_id 	= uniqid();
			$acoda_show_slider	= 'carousel';
			$acoda_slidesetid 		= esc_attr($slidesetid);
			$acoda_images_attach	= esc_attr($images_attach);
			$acoda_loop 			= esc_attr($loop);		
			$acoda_lightbox 		= esc_attr($lightbox);		
	
			// Ajax
			$load_value = 3;
		
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
		
			// Excerpt
			$acoda_galleryexcerpt = ( !empty( $excerpt ) ) ? $excerpt : '55';
	
			$attributes = 'content:'. $acoda_groupgridcontent .'|excerpt:'. $acoda_galleryexcerpt . '|lightbox:'. $acoda_lightbox . '|img_size:'. $img_size. '|imageeffect:'. $acoda_imageeffect. '|hover_effect:'. $hover_effect;	
			
			$output = '';
			 
			$output .= '<div id="acoda-carousel-'. esc_attr( $acoda_shortcode_id ) .'" class="'. ( !empty( $load_ajax ) ? 'acoda-ajax-container ' : '' ) .'zoomflow carousel" data-type="'. esc_attr( $acoda_show_slider ) .'" data-timeout="'. esc_attr( $acoda_stagetimeout ) .'" data-ratio="'. esc_attr( $ratio ) .'" '. ( !empty( $load_ajax ) ? 'data-load-method="'. esc_attr( $load_ajax ) .'" data-source="'. esc_attr( $acoda_datasource ) .'" data-attributes="'. esc_attr( $attributes ) .'" data-query="'. esc_attr( $query ) .'" data-ajaxurl="'. esc_url( admin_url() ) .'admin-ajax.php"' : '' ) .'>';
			$output .= '<div class="items-wrap">';
			$output .= '<div class="items">';
		   
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
		
			$output .= '</div>';
			$output .= '</div>';
			$output .= '<div class="dynamic-frame" data-offset="'. esc_attr( $load_limit ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $load_value ) .'"></div>';
			$output .= '</div><!-- / zoomflow -->';
		
			wp_enqueue_script('zoomflow', get_template_directory_uri().'/js/zoomflow.min.js', false, array('jquery'), true );	  
			wp_enqueue_style('zoomflow-styles', get_template_directory_uri().'/css/zoomflow/zoomflow.css' );	  	
	
			return $output;
		}
	}

	/* ------------------------------------
	:: Carousel MAP	
	------------------------------------*/

	vc_map( array(
		"base"		=> "carousel_slider",
		"name"		=> esc_html__("3d Carousel Slider", 'dynamix'),
		"class"		=> "carousel",
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
			acoda_common_options( 'content' ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Title Size', 'dynamix' ),
				'param_name' => 'title_size',
				"value" => array( 
					esc_html__("Normal", 'dynamix') => '',
					esc_html__("Small", 'dynamix') => 'small',
					esc_html__("Medium", 'dynamix') => 'medium',
					esc_html__("Large", 'dynamix') => 'large',
				),					
				"dependency" => Array('element' => "content_type", 'value' => array('titleimage','textimage','titleoverlay','titletextoverlay') ),
				"description" => esc_html__("Set the Caption Title size.", 'dynamix')
			),				
			acoda_common_options( 'timeout' ),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Lightbox", 'dynamix'),
				"param_name" => "lightbox",
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'yes',
				)
			),			
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__( 'Ratio', 'dynamix'),
				"param_name" => "ratio",
				"value" => array(
					"16:9" => "16:9",
					"4:3" => "4:3",
					"1:1" => "1:1",
				)
			),										
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("CSS Classes", 'dynamix'),
				"param_name" => "class",
				"description" => esc_html__("Add an optional CSS classes.", 'dynamix')
			),					
		)		
	) );