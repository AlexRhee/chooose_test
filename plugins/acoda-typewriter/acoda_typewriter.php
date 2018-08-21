<?php
/*
Plugin Name: ACODA Typewriter
Plugin URI: http://acoda.com/
Description: Animate text with cool effects. 
Version: 1.1.3
Author: ACODA
Author URI: http://acoda.com/
License: Copyright of ACODA LIMITED
*/

/*
This example/starter plugin can be used to speed up Visual Composer plugins creation process.
More information can be found here: http://kb.wpbakery.com/index.php?title=Category:Visual_Composer
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

class ACODATypewriterClass {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'acoda_typewriter', array( $this, 'renderAcodaTypewriter' ) );

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
            "name" => __("Typewriter", 'acoda_typewriter'),
            "description" => __("Animate text with cool effects.", 'acoda_typewriter'),
            "base" => "acoda_typewriter",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/ACODA.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "acoda_typewriter_my_class"
            "category" => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/acoda_typewriter.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/acoda_typewriter_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					"type" => "dropdown",
					"heading" => __("Animate Type", "js_composer"),
					"param_name" => "type",
					"value" => array(
						"Rotate 3d" => 'rotate-3d', 
						"Typing" => 'typing', 
					),
				),	
				array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Lead Text", 'acoda_typewriter'),
                  "param_name" => "lead_text",
                  "description" => __("Enter text which appears before the 'Animated Text'.", 'acoda_typewriter')
 				),
              array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => __("Font Color", 'acoda_typewriter'),
                  "param_name" => "font_color",
                  "description" => __("Choose font color", 'acoda_typewriter')
              ),
				array(
					"type" => "dropdown",
					"heading" => __("Align", "js_composer"),
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
					"heading" => __("Font Weight", "js_composer"),
					"param_name" => "font_weight",
					"value" => array(
						'Default' => "", 
						'Normal' => "normal", 
						'Bold' => "bold", 
						'Lighter' => "lighter", 
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
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Duration", 'acoda_typewriter'),
                  "param_name" => "duration",
				  	"value" => 	"5000",
                  "description" => __("The duration of time each word displays for. 5000 = 5 seconds.", 'acoda_typewriter')
 				),
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Delay", 'acoda_typewriter'),
                  "param_name" => "delay",
				  	"value" => 	"100",
                  "description" => __("The delay between each word animation. 1000 = 1 second.", 'acoda_typewriter')
 				),	
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Pause", 'acoda_typewriter'),
                  "param_name" => "pause",
				  	"value" => 	"5000",
                  "description" => __("The pause time at the end of all word animations. 5000 = 5 seconds.", 'acoda_typewriter')
 				),																	  
              array(
                  "type" => "textarea",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Text to Animate", 'acoda_typewriter'),
                  "param_name" => "animated_text",
					'save_always' => true,
                  "value" => __("I\nLOVE\nTHIS\nTYPEWRITER", 'acoda_typewriter'),
                  "description" => __("Enter a new line for each word", 'acoda_typewriter')
              ),
            )
        ) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
	
	public function renderAcodaTypewriter( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => '',
			'align' => 'center',
			'lead_text' => '',
			'tag' => 'p',
			'font_size' => '',
			'font_color' => '',
			'duration' => '5000',
			'delay' => '100',
			'pause' => '5000',
			'animated_text' => '',
			'font_weight' => ''
		), $atts ) );
	 
	 	$output = '';
		
		$output .= '<div class="acoda-writer-wrap'. ( !empty( $lead_text ) ? ' lead-text' : '' ) . ( !empty( $font_size ) ? ' '. $font_size : '' ) . ( !empty( $align ) ? ' '. $align : '' ) .'">';
		$output .= '<div class="acoda-writer-inner">';
		$output .= '<'. $tag .' class="format '. $font_weight .'-weight" '. ( !empty( $font_color ) ? 'style="color:'. $font_color .';"' : '' ) .'>';
		
		if( !empty( $lead_text ) )
		{
			$output .= '<span class="lead-text">'. esc_attr( $lead_text ) .'</span>';
		}
		
		$output .= '<span class="acoda-writer '. $type .'" data-type="'. $type .'" data-duration="'. $duration .'" data-delay="'. $delay .'" data-pause="'. $pause .'">&nbsp;';
	
		$animated_text = str_replace( '<br />', '', $animated_text );
			
		
		$elements = explode( "\n", $animated_text );
			
		foreach( $elements as $element )
		{		
			$wrapped = $characterspan = '';

			$len = mb_strlen($element, get_bloginfo('charset') );
			$characters = array();
			
			for ($i = 0; $i < $len; $i++) 
			{
				$characters[] = mb_substr($element, $i, 1, get_bloginfo('charset') );
			}			
			
			foreach( $characters as $character )
			{			
				if(  $character == ' ' )
				{
					$character = "&nbsp;";
				}
				
				$characterspan .= '<span class="hide">'. $character .'</span>';
			}	
					
			$words = explode( '<span class="hide">&nbsp;</span>', $characterspan );
						
			$wordcount = count( $words );
			$i = 1;
						
			foreach( $words as $word )
			{		
				if( $i != $wordcount )
				{
					$wrapped .= '<span class="word">'. $word .'<span class="hide">&nbsp;</span></span>';
				}
				else
				{
					$wrapped .= '<span class="word">'. $word .'</span>';
				}
				
				$i++;
			}				
			
			$output .= '<span class="element">'. $wrapped .'</span>';		
			
		}
		
		$output .= '&nbsp;</span>';
		$output .= '</'. $tag .'>';
		$output .= '</div>';
		$output .= '</div>';
	   
		return $output;
	}

    /*
    Load plugin css and javascript files which you may need on front end
    */
	public function loadCssAndJs() {
		wp_register_style( 'acoda_typewriter_style', plugins_url('assets/acoda_typewriter.min.css', __FILE__) );
		wp_enqueue_style( 'acoda_typewriter_style' );
		wp_enqueue_script( 'acoda_typewriter_js', plugins_url('assets/acoda_typewriter.min.js', __FILE__), array('jquery') );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
	public function showVcVersionNotice() {
		$plugin_data = get_plugin_data(__FILE__);
		echo '
		<div class="updated">
			<p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'acoda_typewriter'), $plugin_data['Name']).'</p>
		</div>';
	}
}

// Finally initialize code
new ACODATypewriterClass();