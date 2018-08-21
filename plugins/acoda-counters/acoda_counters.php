<?php
/*
Plugin Name: ACODA Counters
Plugin URI: http://acoda.com/
Description: Animated Counters for Values & Dates. 
Version: 1.0.1
Author: ACODA
Author URI: http://acoda.com/
License: Copyright of ACODA LIMITED
*/


// don't load directly
if (!defined('ABSPATH')) die('-1');

class ACODACountersClass {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'acoda_counter', array( $this, 'renderAcodaCounters' ) );

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
            "name" => __("Counters", 'acoda_counters'),
            "description" => __("Animated Counters for Values & Dates.", 'acoda_counters'),
            "base" => "acoda_counter",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/ACODA.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "acoda_counters_my_class"
            "category" => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/acoda_counters.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/acoda_counters_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					"type" => "dropdown",
					"heading" => __("Counter Type", "js_composer"),
					"param_name" => "type",
					"value" => array(
						"Value" => 'value', 
						"Date" => 'date', 
					),
				),	
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Start Value", 'acoda_counters'),
                  "param_name" => "start_value",
                  "description" => __("Enter start value.", 'acoda_counters'),
					"std" => '0',
					'save_always' => true,
					"dependency" => Array('element' => 'type', 'value' => array('value')),
 				),
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("End Value", 'acoda_counters'),
                  "param_name" => "end_value",
                  "description" => __("Enter end value.", 'acoda_counters'),
					"std" => '5',
					'save_always' => true,
					"dependency" => Array('element' => 'type', 'value' => array('value')),
 				),	
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Format", 'acoda_counters'),
                  "param_name" => "value_format",
                  "description" => __("Enter end value.", 'acoda_counters'),
					"std" => "I've had %V glasses of water today.",
					'save_always' => true,
					"dependency" => Array('element' => 'type', 'value' => array('value')),
 				),		
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Speed", 'acoda_counters'),
                  "param_name" => "speed",
					'save_always' => true,
                  "description" => __("Higher the number, the faster the count speed.", 'acoda_counters'),
					"dependency" => Array('element' => 'type', 'value' => array('value')),
					"std" => '10',
				),	
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Steps", 'acoda_counters'),
                  "param_name" => "steps",
					'save_always' => true,
                  "description" => __("Number of steps per count.", 'acoda_counters'),
					"dependency" => Array('element' => 'type', 'value' => array('value')),
					"std" => '1',
				),					
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Date", 'acoda_counters'),
                  "param_name" => "date",
					'save_always' => true,
                  "description" => __("Enter a date in the future past.", 'acoda_counters'),
					"dependency" => Array('element' => 'type', 'value' => array('date')),
					"std" => '06/31/2020 23:59:59',
				),			
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Remaining Time Format", 'acoda_counters'),
                  "param_name" => "remaining_format",
                  "description" => __("Enter Time Remaining Format.", 'acoda_counters'),
					"std" => "%Y YEARS %O MONTHS %D DAYS %H HOURS %M MINUTES %S SECONDS TO LAUNCH",
					'save_always' => true,
					"dependency" => Array('element' => 'type', 'value' => array('date')),
 				),	
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Elapsed Time Format", 'acoda_counters'),
                  "param_name" => "elapsed_format",
                  "description" => __("Enter Time Elapsed Format.", 'acoda_counters'),
					"std" => "%Y YEARS %O MONTHS %D DAYS %H HOURS %M MINUTES %S SECONDS SINCE LAUNCH",
					'save_always' => true,
					"dependency" => Array('element' => 'type', 'value' => array('date')),
 				),																									
              array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => __("Font Color", 'acoda_counters'),
                  "param_name" => "font_color",
                  "description" => __("Choose font color", 'acoda_counters')
              ),
				array(
					"type" => "dropdown",
					"heading" => __("Formatting", "js_composer"),
					"param_name" => "align",
					"value" => array(
						'Center' => "center", 
						'Left' => "left", 
						'Right' => "right"
					),
				),	
				array(
					"type" => "dropdown",
					"heading" => __("Formatting", "js_composer"),
					"param_name" => "tag",
					"value" => array(
						'Paragraph' => "p", 
						'Heading 1' => "h1", 
						'Heading 2' => "h2", 
						'Heading 3' => "h3", 
						'Heading 4' => "h4", 
					),
				),	
				array(
					"type" => "dropdown",
					"heading" => __("Font Size", "js_composer"),
					"param_name" => "font_size",
					"value" => array(
						'Normal' => "", 
						'Medium' => "medium", 
						'Large' => "large", 
						'Larger' => "larger", 
						'Extra Large' => "xlarge", 
						'Supersize' => "supersize", 
					),
				),								  
            )
        ) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
	
	public function renderAcodaCounters( $atts, $content = null ) {
	
		$atts = vc_map_get_attributes( 'acoda_counter', $atts );
		extract( $atts );		
		
	 	$output = $counter = '';
		
		$output .= '<div class="acoda-counter-wrap'. ( !empty( $font_size ) ? ' '. $font_size : '' ) . ( !empty( $align ) ? ' '. $align : '' ) .'">';
		$output .= '<div class="acoda-counter-inner">';
		$output .= '<'. $tag .' class="format" '. ( !empty( $font_color ) ? 'style="color:'. $font_color .';"' : '' ) .'>';
		
		if( 'value' == $type )
		{
			$counter = '<span class="acoda-counter '. $type .'" data-type="'. $type .'" data-speed="'. $speed .'" data-tick="'. $steps .'" data-start="'. $start_value .'" data-end="'. $end_value .'">'. $start_value .'</span>';
			$output .= '<span>' . str_replace( '%V', $counter, $value_format ) .'</span>';
		}
		else if( 'date' == $type )
		{
			$output .= '<span class="acoda-counter '. $type .'" data-type="'. $type .'" data-date="'. $date .'" data-remaining-format="'. $remaining_format .'" data-elapsed-format="'. $elapsed_format .'">'. $remaining_format .'</span>';
		}

		$output .= '</'. $tag .'>';
		$output .= '</div>';
		$output .= '</div>';
	   
		return $output;
	}

    /*
    Load plugin css and javascript files which you may need on front end
    */
	public function loadCssAndJs() {
		wp_register_style( 'acoda_counters_style', plugins_url('assets/acoda_counters.min.css', __FILE__) );
		wp_enqueue_style( 'acoda_counters_style' );
		wp_enqueue_script( 'countid', plugins_url('assets/countid.min.js', __FILE__), array('jquery') );
		wp_enqueue_script( 'acoda_counters_js', plugins_url('assets/acoda_counters.min.js', __FILE__), array('countid') );			
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
	public function showVcVersionNotice() {
		$plugin_data = get_plugin_data(__FILE__);
		echo '
		<div class="updated">
			<p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'acoda_counters'), $plugin_data['Name']).'</p>
		</div>';
	}
}

// Finally initialize code
new ACODACountersClass();