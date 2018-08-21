<?php
/*
Plugin Name: ACODA Pricing Table ( VC )
Description: ACODA Pricing Table For Visual Composer
Author: ACODA
Version: 1.8.1
Author URI: http://codecanyon.net/user/-ACODA-/portfolio
*/
if (!class_exists( 'themeva_vc_pricing_table' ) ) {
	

    class themeva_vc_pricing_table {

		
		function __construct() {
			// We safely integrate with VC with this hook
			add_action( 'init', array( $this, 'acoda_vc_pricing_table' ) );
		}		
			
       public function acoda_vc_pricing_table() {

			$dir = plugin_dir_path( __FILE__ );
			
			require_once $dir . '/inc/themeva_vc_pricing_table_shortcode.php';
    
			vc_map( array(
			  "name" => __("Ultimate Pricing Table", "js_composer"),
			  "base" => "t_pricing_table",
			  "show_settings_on_create" => false,
			  "is_container" => true,
			  "icon" => plugins_url( 'img/pricing-table.png', __FILE__ ),
			  "admin_enqueue_css" => array(plugins_url('css/admin.css', __FILE__)),
			  "admin_enqueue_js" => array(plugins_url('js/pricingtable.js', __FILE__)),
			  'default_content' => '
			  [t_plan title="Plan" width="1/4"]<ul><li>List Item</li><li>List Item</li></ul>[/t_plan]
			  [t_plan title="Plan" width="1/4"]<ul><li>List Item</li><li>List Item</li></ul>[/t_plan]
			  [t_plan title="Featured Plan" featured="true" color="green" width="1/4"]<ul><li>List Item</li><li>List Item</li></ul>[/t_plan]
			  [t_plan title="Plan" width="1/4"]<ul><li>List Item</li><li>List Item</li></ul>[/t_plan]
			  ',				  
			  "category" => __('Content', 'js_composer'),
			  "params" => array(
				array(
					"type" => "checkbox",
					"class" => "",
					"heading" => __("Padding", "js_composer"),
					"param_name" => "padding",
					"value" =>  array(
						__('Enable', "js_composer") => "true", 
					)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Animation", "js_composer"),
					"param_name" => "animation",
					"value" =>  array(
						__('3d Rotate', "js_composer") => "", 
						__('Zoom', "js_composer") => "zoom", 
						__('Disable', "js_composer") => "disable", 
					),
					"description" => __("Disable Pricing Plan Animation on rollover.", "js_composer")
				),		
				array(
					"type" => "dropdown",
					"heading" => __("Title Size", "js_composer"),
					"param_name" => "title_size",
					"value" => array(
						'Normal' => "", 
						'Medium' => "medium",	
						'Large' => "large",	
						'Larger' => "larger",																																																			
					)
				),	
				array(
					"type" => "dropdown",
					"heading" => __("Subtitle Size", "js_composer"),
					"param_name" => "subtitle_size",
					"value" => array(
						'Normal' => "", 
						'Medium' => "medium",	
						'Large' => "large",	
						'Larger' => "larger",																																																			
					)
				),					
				array(
					"type" => "dropdown",
					"heading" => __("Plan Style", "js_composer"),
					"param_name" => "plan_style",
					"value" => array(
						'Square' => "", 
						'Rounded' => "rounded",																																							
					)
				),							
				array(
				  "type" => "textfield",
				  "heading" => __("Extra class name", "js_composer"),
				  "param_name" => "el_class",
				  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
				),
			  ),
			  'js_view' => 't_PricingTableView'
			) );
			
			vc_map( array(
			  "name" => __("Plan Section", "js_composer"),
			  "base" => "t_plan",
			  "content_element" => false, 
			  "params" => array(
					array(
						"type" => "textfield",
						"heading" => __("Title", "js_composer"),
						"param_name" => "title",
						"holder" => "h3",
						"value" => "",
						"description" => __("Enter the text <strong>BLANK</strong> to create a blank spacer area.", "js_composer")
					),
					array(
						"type" => "textfield",
						"heading" => __("Sub Title", "js_composer"),
						"param_name" => "subtitle",
						"holder" => "h4",
						"value" => "",
						"description" => __("Enter the text <strong>BLANK</strong> to create a blank spacer area.", "js_composer")
					),					
					array(
						"type" => "dropdown",
						"heading" => __("Plan Color", "js_composer"),
						"param_name" => "color",
						"value" => array(
							'Select Color' => "", 
							'Blue' => "blue", 
							'Green' => "green", 
							'Grey' => "grey",
							'Orange' => "orange", 
							'Blue' => "blue", 
							'Pink' => "pink",
							'Purple' => "purple", 		
							'Red' => "red", 		
							'Yellow' => "yellow",
							'Custom Color' => "custom",																																							
						),
						"group" => __('Design Options', 'js_composer')
					),
					array(
						"type" => "colorpicker",
						"heading" => __("Title Background Color", "js_composer"),
						"param_name" => "title_background",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),	
					array(
						"type" => "colorpicker",
						"heading" => __("Title Color", "js_composer"),
						"param_name" => "title_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),
					array(
						"type" => "colorpicker",
						"heading" => __("Subtitle Color", "js_composer"),
						"param_name" => "subtitle_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),					
					array(
						"type" => "colorpicker",
						"heading" => __("Background Color", "js_composer"),
						"param_name" => "background_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),										
					array(
						"type" => "colorpicker",
						"heading" => __("Text Color", "js_composer"),
						"param_name" => "text_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),	
					array(
						"type" => "colorpicker",
						"heading" => __("Border Color", "js_composer"),
						"param_name" => "border_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),
					array(
						"type" => "colorpicker",
						"heading" => __("Button Color", "js_composer"),
						"param_name" => "button_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),
					array(
						"type" => "colorpicker",
						"heading" => __("Button Border Color", "js_composer"),
						"param_name" => "button_border_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),	
					array(
						"type" => "colorpicker",
						"heading" => __("Button Text Color", "js_composer"),
						"param_name" => "button_text_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),		
					array(
						"type" => "colorpicker",
						"heading" => __("Button Background Color", "js_composer"),
						"param_name" => "button_background_color",
						"value" => "",
						"dependency" => Array('element' => 'color', 'value' => array('custom')),
						"group" => __('Design Options', 'js_composer')
					),																				
					array(
						"type" => "dropdown",
						"heading" => __("Border Style", "js_composer"),
						"param_name" => "border_style",
						"value" => array(
							'Solid' => "", 
							'Dotted' => "dotted",
							'Dashed' => "dashed", 
							'Double' => "double",	
							'None' => "none",																																								
						),
						"group" => __('Design Options', 'js_composer')
					),																														
					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Featured Plan", "js_composer"),
						"param_name" => "featured",
						"value" =>  array(
							__('Enable', "js_composer") => "true", 
						)
					),
					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Shadow Effect", "js_composer"),
						"param_name" => "shadow",
						"value" =>  array(
							__('Enable', "js_composer") => "true", 
						),
						"group" => __('Design Options', 'js_composer')
					),													
					array(
						"type" => "textfield",
						"heading" => __("Price", "js_composer"),
						"param_name" => "price",
						"value" => "",
						"description" => __("Enter the text <strong>BLANK</strong> to create a blank spacer area.", "js_composer")
					),
					array(
						"type" => "textfield",
						"heading" => __("Currency", "js_composer"),
						"param_name" => "currency",
						"value" => "",
						"description" => __("E.g. $", "js_composer")
					),					
					array(
						"type" => "textfield",
						"heading" => __("Per", "js_composer"),
						"param_name" => "per",
						"value" => "",
						"description" => __("E.g. / mo", "js_composer")
					),					
					array(
						"type" => "textarea_html",
						"holder" => "div",
						"class" => "",
						"heading" => __("Content", "js_composer"),
						"param_name" => "content",
						"value" => __("<ul><li>List Item</li><li>List Item</li><li>List Item</li></ul>", "js_composer"),
					),	
					array(
						"type" => "textfield",
						"heading" => __("Button Text", "js_composer"),
						"param_name" => "button_text",
						"value" => "",
					),
					array(
						"type" => "textfield",
						"heading" => __("Button Link", "js_composer"),
						"param_name" => "button_link",
						"value" => "",
					),
					array(
						"type" => "dropdown",
						"heading" => __("Button Shape", "js_composer"),
						"param_name" => "button_shape",
						"value" => array(
							__("Square", "js_composer") => "square", 
							__("Rounded", "js_composer") => "rounded",
							__("Round", "js_composer") => "round"
						),
					),					
					array(
						"type" => "dropdown",
						"heading" => __("Link Target", "js_composer"),
						"param_name" => "target",
						"value" => array(
							__("Same window", "js_composer") => "_self", 
							__("New window", "js_composer") => "_blank"
						),
					),	
					array(
						"type" => "textfield",
						"heading" => __("Icon", "js_composer"),
						"param_name" => "icon",
						"value" => "",
						"description" => __("See Font Awesome <a href=\"http://fortawesome.github.io/Font-Awesome/icons/\" target=\"_blank\">Icons</a> : Enter Icon Name e.g.<strong> fa-compass</strong>", 	"js_composer")
					),	
					array(
						"type" => "colorpicker",
						"heading" => __("Icon Color", "js_composer"),
						"param_name" => "icon_color",
						"value" => "",
						"group" => __('Design Options', 'js_composer')
					),
					array(
						"type" => "colorpicker",
						"heading" => __("Icon Background Color", "js_composer"),
						"param_name" => "icon_background",
						"value" => "",
						"group" => __('Design Options', 'js_composer')
					),									
				),
				'js_view' => 'VcColumnView'
			));	
       }
    }

    function themeva_vc_pricing_table_notice(){
      $plugin_data = get_plugin_data(__FILE__);
      echo '
      <div class="updated">
        <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=-ACODA-" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'js_composer'), $plugin_data['Name']).'</p>
      </div>';
    }
    if (!defined('ABSPATH')) die('-1');
    if (!defined('WPB_VC_VERSION')) {add_action('admin_notices', 'themeva_vc_pricing_table_notice'); return;}

    new themeva_vc_pricing_table();
}