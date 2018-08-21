<?php
/*
Plugin Name: ACODA Gigatools VC Add-on
Plugin URI: http://acoda.com/
Description: Gigatool Event Addon For Visual Composer. 
Version: 1.0
Author: ACODA
Author URI: http://acoda.com/
License: Copyright of ACODA LIMITED
*/


// don't load directly
if (!defined('ABSPATH')) die('-1');

class ACODAGigatoolsClass {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'acoda_gigatools', array( $this, 'renderAcodaGigatools' ) );

        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }
 
    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }
 
        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            "name" => __("Gigatools Events", 'acoda_gigatool'),
            "description" => __("Gigatools Addon For Visual Composer.", 'acoda_gigatools'),
            "base" => "acoda_gigatools",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/ACODA.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "acoda_gigatools_my_class"
            "category" => __('Content', 'acoda_gigatools'),
            "params" => array(
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Gigatools Username", 'acoda_gigatools'),
                  "param_name" => "username",
					'save_always' => true,
 				),
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Number of Gigs to Show", 'acoda_gigatools'),
                  "param_name" => "number",
					"std" => '5',
					'save_always' => true,
 				),	
				array(
					"type" => "dropdown",
					"heading" => __("Alignment", "acoda_gigatools"),
					"param_name" => "align",
					"value" => array(
						'Center' => "center", 
						'Left' => "left", 
						'Right' => "right"
					),
				),																																	
				array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => __("Title Color", 'acoda_gigatools'),
                  "param_name" => "title_color",
                  "description" => __("Choose font color", 'acoda_gigatools')
				),
				array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => __("Title Hightlight Color", 'acoda_gigatools'),
                  "param_name" => "title_highlight_color",
				),					
				array(
					"type" => "dropdown",
					"heading" => __("Title Formatting", "acoda_gigatools"),
					"param_name" => "title_tag",
					"std" => 'h4',
					"value" => array(
						'Paragraph' => "p", 
						'Heading 2' => "h2", 
						'Heading 3' => "h3", 
						'Heading 4' => "h4",
						'Heading 5' => "h5", 
						'Heading 6' => "h6", 
					),
				),	
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Title Font Size", 'acoda_gigatools'),
					"param_name" => "title_size",
					'save_always' => true,
					"description" => __("Use px, em, rem, %", 'acoda_gigatools')
 				),
				array(
					"type" => "dropdown",
					"heading" => __("Date", "acoda_gigatools"),
					"param_name" => "date",
					"value" => array(
						'Display' => "enable", 
						'Hide' => "disable", 
					),
				),	
				array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => __("Date Color", 'acoda_gigatools'),
                  "param_name" => "date_color",
				  "dependency" => Array('element' => 'date' /*, 'not_empty' => true*/, 'value' => array('enable')),
				),		
				array(
					"type" => "dropdown",
					"heading" => __("Date Formatting", "acoda_gigatools"),
					"param_name" => "date_tag",
					"dependency" => Array('element' => 'date' /*, 'not_empty' => true*/, 'value' => array('enable')),		
					"std" => 'p',
					"value" => array(
						'Paragraph' => "p", 
						'Heading 4' => "h4",
						'Heading 5' => "h5", 
						'Heading 6' => "h6", 
					),
				),	
				array(
					"type" => "textfield",
                  	"class" => "",
					"heading" => __("Date Font Size", 'acoda_gigatools'),
					"param_name" => "date_size",
					'save_always' => true,
					"description" => __("Use px, em, rem, %", 'acoda_gigatools')
 				),	
				array(
					"type" => "dropdown",
					"heading" => __("Description", "acoda_gigatools"),
					"param_name" => "description",
					"value" => array(
						'Display' => "enable", 
						'Hide' => "disable", 
					),
				),		
				array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => __("Description Color", 'acoda_gigatools'),
                  "param_name" => "description_color",
				  "dependency" => Array('element' => 'description' /*, 'not_empty' => true*/, 'value' => array('enable')),
				),																								  
            )
        ) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
	
	public function renderAcodaGigatools( $atts, $content = null ) {
	
		$atts = vc_map_get_attributes( 'acoda_gigatools', $atts );
		extract( $atts );	
		
		$output = $title_style = $desc_style = $date_style = '';
		
		if( !empty( $username ) )
		{	
			$output .= '<div class="acoda-gigatools-wrap' . ( !empty( $align ) ? ' '. $align : '' ) .'">';
			$output .= '<div class="acoda-gigatools-inner">';
			
			$xml = 'https://gigs.gigatools.com/user/'. $username .'.rss';
			$xmlDoc = simplexml_load_file( $xml );
			$xx = 1;
		
			$x = $xmlDoc->channel->item;
			
			// Title Style
			if( !empty( $title_color ) )
			{
				$title_style .=  'color:'. $title_color .';';
			}

			if( !empty( $title_size ) )
			{
				$title_style .=  'font-size:'. $title_size .';';
			}	

			// Date Style
			if( !empty( $date_color ) )
			{
				$date_style .=  'color:'. $date_color .';';
			}

			if( !empty( $date_size ) )
			{
				$date_style .=  'font-size:'. $date_size .';';
			}		

			// Description Style
			if( !empty( $description_color ) )
			{
				$desc_style .=  'color:'. $description_color .';';
			}				
			
			for ($i=0; $i<= $number; $i++) 
			{
				$item_title	= $x[$i]->title;
				$item_link	= $x[$i]->link;
				$item_desc	= $x[$i]->description;
				
				if( !empty( $item_title ) )
				{
					$output .= '<div class="acoda-gigatools-item">'; 
					
					$rr_items = explode(":", $item_title);
	
					if( 'disable' !== $date )
					{
						$output .= '<'. esc_attr( $date_tag ) .' class="date" '. ( !empty( $date_style ) ? 'style="'.  esc_attr( $date_style ) .'"' : '' ) .'>' . $rr_items[0] . '</'. esc_attr( $date_tag ) .'>';
					}
					
					$output .= '<'.  esc_attr( $title_tag ) .' class="format" '. ( !empty( $title_style ) ? 'style="'.  esc_attr( $title_style ) .'"' : '' ) .'>';
					
					if( !empty( $item_link ) )
					{
						$output .= '<a target="_blank" href="'. esc_url( $item_link ) .'" '. ( !empty( $title_style ) ? 'style="'.  esc_attr( $title_style ) .'"' : '' ) .'>'. ( !empty( $title_highlight_color ) ? '<span class="highlight" style="background-color:'.  esc_attr( $title_highlight_color ) .';box-shadow: 10px 0 0 '.  esc_attr( $title_highlight_color ) .', -10px 0 0 '.   esc_attr( $title_highlight_color ) .';">'. $rr_items[1] .'</span>' : $rr_items[1]  ) .'</a>';	
					}
					else
					{
						$output .= ( !empty( $title_highlight_color ) ? '<span class="highlight" style="background-color:'.  esc_attr( $title_highlight_color ) .';box-shadow: 10px 0 0 '.  esc_attr( $title_highlight_color ) .', -10px 0 0 '.  esc_attr( $title_highlight_color ) .';">'. $rr_items[1] .'</span>' : $rr_items[1]  );
					}			
					 
					$output .='</'.  esc_attr( $title_tag ) .'>';
					
					if( !empty( $item_desc ) && 'disable' !== $description )
					{
						$output .= '<p class="description" '. ( !empty( $desc_style ) ? 'style="'.  esc_attr( $desc_style ) .'"' : '' ) .'>' . $item_desc . '</p>';
					}
					
					$output .= '</div>';
				}
				
				$xx++;
			}
				
			$output .= '</div>';
			$output .= '</div>';
			
		}
		else
		{
			$output .= '<div class="acoda-gigatools-wrap">'. __("Username Required!", "acoda_gigatools") .'</div>';
		}
	   
		return $output;
	}

    /*
    Load plugin css and javascript files which you may need on front end
    */
	public function loadCssAndJs() {
		wp_register_style( 'acoda_gigatools_style', plugins_url('assets/acoda_gigatools.min.css', __FILE__) );
		wp_enqueue_style( 'acoda_gigatools_style' );		
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
	public function showVcVersionNotice() {
		$plugin_data = get_plugin_data(__FILE__);
		echo '
		<div class="updated">
			<p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'acoda_gigatools'), $plugin_data['Name']).'</p>
		</div>';
	}
}

// Finally initialize code
new ACODAGigatoolsClass();