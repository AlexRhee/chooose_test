<?php

/* ------------------------------------
:: ROW SHAPES
------------------------------------*/



	class WPBakeryShortCode_rowShape extends WPBakeryShortCode { // WPBakeryShortCode_ PREFIX REQUIRED 

		protected function content( $atts, $content = null )
		{
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			extract( $atts );
				
			$output = $transform = $mode = '';
			
			$viewbox_width = '100';
			$width = '100%';
		
			$el_class = $this->getExtraClass($el_class);
			
			$height = str_replace( 'px', '', $height );

			if( 'rowshape_1' === $type )
			{
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="0,100 100,100 100,0  "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="0,0 100,0 100,100  "/>';
				}
			}
			elseif( 'rowshape_2' === $type )
			{
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,100 0,100 0,0 "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,0 0,0 0,100 "/>';
				}				
			}
			elseif( 'rowshape_3' === $type )
			{
				$viewbox_width = '200';
				
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<path fill="'. esc_attr( $color ) .'" d="M100,1c54.9,0,99.4,44.2,100,99H0C0.6,45.2,45.1,1,100,1z"/>';
				}
				else
				{				
					$polygon = "\n\t\t". '<path fill="'. esc_attr( $color ) .'" d="M100,99c54.9,0,99.4-44.2,100-99H0C0.6,54.8,45.1,99,100,99z"/>';
				}
			}
			elseif( 'rowshape_4' === $type )
			{
				$viewbox_width = '200';
				
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<path fill="'. esc_attr( $color ) .'" d="M200,100V0h0c-0.5,54.8-45.1,99-100,99C45.1,99,0.6,54.8,0,0h0l0,100H200z" />';
				}
				else
				{
					$polygon = "\n\t\t". '<path fill="'. esc_attr( $color ) .'" d="M0,0v100h0C0.6,45.2,45.1,1,100,1c54.9,0,99.4,44.2,100,99h0V0H0z"/>';
				}
			}
			elseif( 'rowshape_5' === $type )
			{
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,100 50,0 0,100  "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,0 50,100 0,0  "/>';
				}
			}	
			elseif( 'rowshape_6' === $type )
			{
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="50,99.8 50.1,99.8 100,0 100,100 0,100 0,0  "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="50,0.2 49.9,0.2 0,100 0,0 100,0 100,100"/>';
				}
			}				
			elseif( 'rowshape_7' === $type )
			{
				$mode 	= 'static';
				$viewbox_width = $width = '100';
				
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,100 50,0 0,100  "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,0 50,100 0,0  "/>';
				}
			}	
			elseif( 'rowshape_8' === $type )
			{
				$mode 	= 'static-wide';
				$viewbox_width = $width = '3000'; 
				
				if( $position == 'bottom' )
				{
	
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="3000,100 3000,0 1549.5,0 1500,99 1450.5,0 0,0 0,100  "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="3000,0 3000,100 1549.5,100 1500,1 1450.5,100 0,100 0,0  "/>';
				}
			}									
			elseif( 'rowshape_9' === $type )
			{
				$width = $height;
				
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,100 50,0 0,100  "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="100,0 50,100 0,0  "/>';
				}
			}				
			elseif( 'rowshape_10' === $type )
			{				
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="80,100 80,100 0,0 0,100 100,100 100,30 "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="80,0 80,0 0,100 0,0 100,0 100,70 "/>';
				}
			}
			elseif( 'rowshape_11' === $type )
			{				
				if( $position == 'bottom' )
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="20,100 20,100 100,0 100,100 0,100 0,30 "/>';
				}
				else
				{
					$polygon = "\n\t\t". '<polygon fill="'. esc_attr( $color ) .'" points="20,0 20,0 100,100 100,0 0,0 0,70 "/>';
				}
			}							
			
			$output .= "\n\t". '<div class="row-shape-wrap '. esc_attr( $position .' '. $mode .' '. $transform ) . ( !empty( $shadow ) ? ' shadow' : '' ) .' " style="height:'. esc_attr( $height ) .'px">';
			
			$flexishape_id = uniqid();
			
			if( "static" === $mode || "static-wide" === $mode ) 
			{
				$output .= "\n\t". '<svg id="flexishape-'. esc_attr( $flexishape_id ) .'" x="0px" y="0px" fill="'. esc_attr( $color ) .'" viewBox="0 0 '. esc_attr( $viewbox_width ).' 100" width="'. esc_attr( $width ) .'px" height="'. esc_attr( $height ) .'px" preserveAspectRatio="none">';
				$output .= $polygon;	
			}
			else
			{		
				$output .= '<svg width="100%" height="'. esc_attr( $height ) .'px">';
				$output .= '<defs>';
				$output .= '<pattern id="flexishape-'. esc_attr( $flexishape_id ) .'" preserveAspectRatio="none" patternUnits="userSpaceOnUse" x="0" y="0" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'0px" viewBox="0 0 '. esc_attr( $viewbox_width ) .' 1000">';
			
				$output .= $polygon;	
			
				$output .= '</pattern>';
				$output .= '</defs>';
				$output .= '<rect x="0" y="0" width="100%" height="'. esc_attr( $height ) .'px" fill="url(#flexishape-'. esc_attr( $flexishape_id ) .')"></rect>';
			}
			
			$output .= "\n\t". '</svg>';
			$output .= "\n\t".'</div>';

			return $output;
		}
	}

	function acoda_row_shapes()
	{	
		wp_enqueue_script(
			'acoda-row-shapes',
			get_template_directory_uri().'/js/row-shapes.min.js',
			false,
			array(
				'jquery',
				'acoda-script'
			),
			true
		);
	}
		
	add_action( 'wp_enqueue_scripts', 'acoda_row_shapes' );

	/* ------------------------------------
	:: TESTIMONIALS MAP
	------------------------------------*/	

	vc_map( array(
		"name"		=> esc_html__("FlexiShape", 'dynamix'),
		"base"		=> "rowshape",
		"show_settings_on_create" => true,
		"content_element" => true,
		"icon" => get_template_directory_uri() . '/images/acoda.png',
		"category"  => esc_html__('Content', 'dynamix'),
		"params"	=> array(	
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Shape Type", 'dynamix'),
				"param_name" => "type",
				"value" => array(
					esc_html__('Slant Left', 'dynamix') => 'rowshape_1',
					esc_html__('Slant Right', 'dynamix') => 'rowshape_2',
					esc_html__('Curved', 'dynamix') => 'rowshape_3',
					esc_html__('Curved Inverted', 'dynamix') => 'rowshape_4',
					esc_html__('Pointed', 'dynamix') => 'rowshape_5',
					esc_html__('Pointed Inverted', 'dynamix') => 'rowshape_6',
					esc_html__('Arrow', 'dynamix') => 'rowshape_7',
					esc_html__('Arrow Inverted', 'dynamix') => 'rowshape_8',
					esc_html__('Jagged', 'dynamix') => 'rowshape_9',		
					esc_html__('Peak Left', 'dynamix') => 'rowshape_10',	
					esc_html__('Peak Right', 'dynamix') => 'rowshape_11',					
				),
			),	
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Position", 'dynamix'),
				"param_name" => "position",
				"value" => array(
					esc_html__('Top', 'dynamix') => 'top',
					esc_html__('Bottom', 'dynamix') => 'bottom', 
				),
			),		
			array(
			  "type" => "colorpicker",
			  "heading" => esc_html__('Color', 'dynamix'),
			  "param_name" => "color",
			),									
			array(
				"type" => "textfield",
				"heading" => esc_html__("Height", 'dynamix'),
				"param_name" => "height",
				"value" => "80",
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Drop Shadow', 'dynamix' ),
				'param_name' => 'shadow',
				"value" => array(
					esc_html__( 'Enable', 'dynamix' ) => 'enable',
				),
			),			
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", 'dynamix'),
				"param_name" => "el_class",
				"value" => "",
				"description" => esc_html__("Add custom CSS classes to the above field.", 'dynamix')
			)
		),
	) );