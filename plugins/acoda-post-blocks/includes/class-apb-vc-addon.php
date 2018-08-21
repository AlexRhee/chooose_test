<?php
/**
 * Acoda Post Widget
 *
 * @package   acoda_post_widget
 * @author    Acoda	
 * @license   GPL-2.0+
 * @link      http://acoda.com/
 * @copyright 2017 Acoda Ltd
 */

/**
 * Register post types and taxonomies.
 *
 * @package acoda_post_widget
 * @author  Acoda
 */
 
 
class acoda_post_widget_vc {
	
	protected $query = false;
	protected $loop_args = array();
	
    function __construct() {	
		
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ), 101 );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'acoda_post_widget', array( $this, 'render_acoda_post_widget' ) );

        // Register CSS and JS
        //add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }
	
	
	private static $column_width = '1/1';
	
	static function vc_set_column_width($column_width) 
	{
		self::$column_width = $column_width;
	}	
		
	static function vc_get_column_width() 
	{
		return self::$column_width;
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
		
		
		
		// Create multi dropdown param type
		vc_add_shortcode_param( 'dropdown_multi', 'dropdown_multi_settings_field' );
		
		function dropdown_multi_settings_field( $param, $value ) {
		   $param_line = '';
		   $param_line .= '<select size="6" multiple name="'. esc_attr( $param['param_name'] ).'" class="wpb_vc_param_value wpb-input wpb-select '. esc_attr( $param['param_name'] ).' '. esc_attr($param['type']).'">';
		   foreach ( $param['value'] as $text_val => $val ) {
			   if ( is_numeric($text_val) && (is_string($val) || is_numeric($val)) ) {
							$text_val = $val;
						}
						$text_val = __($text_val, "apb");
						$selected = '';

						if(!is_array($value)) {
							$param_value_arr = explode(',',$value);
						} else {
							$param_value_arr = $value;
						}

						if ($value!=='' && in_array($val, $param_value_arr)) {
							$selected = ' selected="selected"';
						}
						$param_line .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
					}
		   $param_line .= '</select>';

		   return  $param_line;
		}		

	

		$categories = get_categories( 'hide_empty=0' );
		$categories_array = array('-- Show All --'=> '');

		foreach ( $categories as $category )
		{
			$categories_array[$category->cat_name] = $category->term_id;
		}


		$args = array( 'public' => true );
		$post_types = get_post_types( $args, 'names' );	

		$post_type_array = array('-- Show All --'=> '');

		foreach ( $post_types as $post_type )
		{
			$post_type_array[$post_type] = $post_type;
		}
				
		
        vc_map( array(
            "name" => __("Acoda Post Block", 'apb'),
            "description" => __("Acoda Product Reviews Addon For Visual Composer.", 'apb'),
            "base" => "acoda_post_widget",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/acoda.png', __FILE__), // 
            "category" => __('Content', 'apb'),
            "params" => array(
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Title", 'apb'),
                  "param_name" => "title",
 				),	
				array(
					"type" => "dropdown",
					"heading" => __("Title Tag", "apb"),
					"param_name" => "block_title_tag",
					"value" => array(
						'div' => "div", 
						'strong' => "bold", 
						'h2' => "h2",  
						'h3' => "h3",  
						'h4' => "h4",  
						'h5' => "h5",
						'h6' => "h6",
					),
				),			
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => __("Title Background", 'product-reviews'),
					"param_name" => "title_background",
					"dependency" => Array('element' => 'title' , 'not_empty' => true ),
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => __("Title Color", 'product-reviews'),
					"param_name" => "title_color",
					"dependency" => Array('element' => 'title' , 'not_empty' => true ),
				),			
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("Title URL", 'apb'),
                  "param_name" => "title_link",
 				),			
				array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => __("CSS Classes", 'apb'),
                  "param_name" => "class",
 				),				
				array(
					"type" => "dropdown",
					"group" => "Display",
					"holder" => "div",
					"heading" => __("Layout", "apb"),
					"param_name" => "layout",
					"value" => array(
						'Block 1' => "block_1", 
						'Block 2' => "block_2",  
						'Block 3' => "block_3",  
						'Block 4' => "block_4",  
						'Block 5' => "block_5",
						'Block 6' => "block_6",
					),
				),	
				/*array(
                  "type" => "textfield",
                  "class" => "",
				  "group" => "Display",
                  "heading" => __("Featured Image Size:", 'apb'),
                  "param_name" => "featuredimg_size",
				  "value" => "apb_wide",
				  "description" => __("Choose from apb_standard, apb_wide or WordPress image sizes.", "apb"),
 				),	*/			
				array(
					"type" => "dropdown",
					"group" => "Display",
					"heading" => __("Post Title Tag", "apb"),
					"param_name" => "title_tag",
					"value" => array(
						'div' => "div", 
						'strong' => "bold", 
						'h2' => "h2",  
						'h3' => "h3",  
						'h4' => "h4",  
						'h5' => "h5",
						'h6' => "h6",
					),
				),		
				array(
					"type" => "checkbox",
					"group" => "Display",
					"class" => "",
					"heading" => __("Show Category", "apb"),
					"param_name" => "show_cats",
					"value" => array(
						'Enable' => 'true',
					),
				),			
				array(
					"type" => "checkbox",
					"class" => "",
					"group" => "Display",
					"heading" => __("Show Date", "apb"),
					"param_name" => "show_date",
					"value" => array(
						'Enable' => 'true',
					),
				),
				/*array(
                  "type" => "textfield",
                  "class" => "",
				  "group" => "Display",
                  "heading" => __("Date Format", 'apb'),
                  "param_name" => "date_format",
				  "value" => get_option('date_format') . ' ' . get_option('time_format'),
				  "dependency" => Array('element' => 'show_date', 'value' => array('true')),
 				),	*/						
				array(
					"type" => "checkbox",
					"class" => "",
					"group" => "Display",
					"heading" => __("Show Author", "apb"),
					"param_name" => "show_author",
					"value" => array(
						'Enable' => 'true',
					),
				),
				array(
					"type" => "checkbox",
					"class" => "",
					"group" => "Display",
					"heading" => __("Show Comment Count", "apb"),
					"param_name" => "show_comments",
					"value" => array(
						'Enable' => 'true',
					),
				),
				array(
					"type" => "dropdown",
					"heading" => __("Excerpt:", "apb"),
					 "group" => "Display",
					"param_name" => "excerpt",
					"value" => array(
						__('Featured Post', 'apb') => "featured", 
						__('All Posts', 'apb') => "all", 
						__('Disable', 'apb') => "disable", 
					),
				),			
				array(
                  "type" => "textfield",
                  "class" => "",
				  "group" => "Display",
                  "heading" => __("Excerpt Length", 'apb'),
                  "param_name" => "excerpt_length",
				  "value" => '150',
				  "dependency" => Array('element' => 'excerpt', 'value' => array('featured','all')),
 				),	
				array(
                  "type" => "textfield",
                  "class" => "",
				  "group" => "Display",
                  "heading" => __("Title Length", 'apb'),
                  "param_name" => "title_length",
 				),				
				array(
					"type" => "dropdown_multi",
					"group" => "Filter",
					"heading" => esc_html__("Categories:", 'apb'),
					"param_name" => "cats",
					"value" => $categories_array,
					"std" => ' ',
				),	
				array(
                  "type" => "textfield",
				  "group" => "Filter",
                  "class" => "",
                  "heading" => __("Filter By Tags ( Comma Separated ):", 'apb'),
                  "param_name" => "tags"
 				),				
				array(
                  "type" => "textfield",
				  "group" => "Filter",
                  "class" => "",
                  "heading" => __("Offset Posts By:", 'apb'),
                  "param_name" => "offset",
				  "value" => '0'
 				),		
				array(
                  "type" => "textfield",
				  "group" => "Filter",
                  "class" => "",
                  "heading" => __("Number of Posts:", 'apb'),
                  "param_name" => "number",
				  "value" => get_option('posts_per_page') 
 				),			
				array(
					"type" => "dropdown",
					"heading" => __("Order by:", "apb"),
					 "group" => "Filter",
					"param_name" => "orderby",
					"value" => array(
						__('Published Date', 'apb') => "date", 
						__('Title', 'apb') => "title", 
						__('Comment Count', 'apb') => "comment_count",  
						__('Random', 'apb') => "rand",  
						__('Custom Field', 'apb') => "meta_value",  
						__('Menu Order', 'apb') => "menu_order",
					),
				),	
				array(
					"type" => "dropdown",
					"heading" => __("Order:", "apb"),
					 "group" => "Filter",
					"param_name" => "order",
					"value" => array(
						__('Descending', 'apb') => "DESC", 
						__('Ascending', 'apb') => "ASC", 
					),
				),	
				array(
					"type" => "dropdown_multi",
					"group" => "Filter",
					"heading" => esc_html__("Post Types:", 'apb'),
					"param_name" => "types",
					"value" => $post_type_array,
					"std" => ' ',
				),		
				array(
                  "type" => "textfield",
                  "class" => "",
				   "group" => "Filter",
                  "heading" => __("Show custom fields (comma separated):", 'apb'),
                  "param_name" => "meta_key"
 				),	
				array(
					"type" => "dropdown",
					"heading" => __("Ajax Filtering:", "apb"),
					 "group" => "Ajax",
					"param_name" => "ajax_filter",
					"value" => array(
						__('Disabled', 'apb') => "disabled", 
						__('Categories', 'apb') => "categories", 
					),
				),	
				array(
					"type" => "textfield",
					"class" => "",
					"group" => "Ajax",
					"heading" => __("Filter Text:", 'apb'),
					"param_name" => "filter_text",
					"value" => __('More', 'apb'),
					"dependency" => Array('element' => 'ajax_filter', 'value' => array('categories')),
				),			
				array(
					"type" => "dropdown",
					"heading" => __("Ajax Pagination:", "apb"),
					 "group" => "Ajax",
					"param_name" => "ajax_pagination",
					"value" => array(
						__('Disabled', 'apb') => "disabled", 
						__('Prev / Next Buttons', 'apb') => "prevnext", 
					),
				),				
            )
        ) );
    }	
	
	
	
    
    /*
    Shortcode logic how it should be rendered
    */
	

	
	public function render_acoda_post_widget( $atts, $content = null ) {
			
		
		$atts = vc_map_get_attributes( 'acoda_post_widget', $atts );
		extract( $atts );	
	
		
		$before_posts = $after_posts = $custom_fields = $output = '';
		
		global $current_post_id,$post;
	
		$args = array(
			'posts_per_page' => $number,
			'order' => $order,
			'offset' => $offset,
			'post_status' => 'publish',
			'orderby' => $orderby,
			'cat' => $cats,
			'tag__in' => $tags,
			//'post__not_in' => array( $post_id ),
			'post_type' => $types
		);
		
		if ($orderby === 'meta_value') {
			$args['meta_key'] = $meta_key;
		}		

		$apb_query = new WP_Query($args);
		
		$found_posts = $apb_query->found_posts;
		$post_count = $apb_query->post_count;
		
		$column_width = acoda_post_widget_vc::vc_get_column_width();

		if( function_exists('acoda_settings') )
		{
			$page_layout = acoda_settings('pagelayout');
		}
		else
		{
			$page_layout = 'none';
		}		

		$attributes = array(
			'show_cats' => $show_cats,
			'title_tag' => $title_tag,
			'show_date' => $show_date,
			//'date_format' => $date_format,
			'show_author' => $show_author,
			'show_comments' => $show_comments,
			'excerpt_length' => $excerpt_length,
			'title_length' => $title_length,
			'column_width' => $column_width,
			'page_layout' => $page_layout
			//'show_readmore' => $show_readmore
		);			

		$pagination_type = 'click_load';

		$output .= '<div class="apb-wrap abp-vc-addon apb-'. esc_attr( $layout ) .'" id="apb-'. uniqid() .'" data-block="'. esc_attr( $layout ) .'" data-query="'. esc_attr( json_encode( $args ) ) .'" data-post-count="'. esc_attr( $found_posts ) .'" data-post-offset="'. esc_attr( $offset ) .'"  data-attributes="'. esc_attr( json_encode( $attributes ) ) .'" data-pagination-type="'. esc_attr( $pagination_type ) .'" data-ajaxurl="'. esc_url( admin_url() ) .'admin-ajax.php">';				

		if ( $title || $ajax_filter !== 'disabled' ) 
		{
			$output .=  '<div class="apb-title-wrap" '. ( !empty( $title_background ) ? 'style="border-bottom: 2px solid '. esc_attr( $title_background ) .'"' : '' ) .'>';
			
			if ( $title )
			{	
				$style = '';

				if( !empty( $title_background ) )
				{
					$style .= 'background-color:'. esc_attr( $title_background ) .';';
				}

				if( !empty( $title_color ) )
				{
					$style .= 'color:'. esc_attr( $title_color ) .';';
				}			

				$output .=  '<'. $block_title_tag .' class="apb-title '. ( !empty( $title_background ) ? 'background' : '' ) .'" '. ( !empty( $style ) ? 'style="'. esc_attr( $style ) .'"' : '' ) .'>';
				
				if ( $title_link ) echo '<a '. ( !empty( $title_color ) ? 'style="color:'. esc_attr( $title_color ) .'"' : '' ) .' href="'. esc_url( $title_link ) .'">';
				
				$output .= $title;
				
				if ( $title_link ) echo '</a>';
				
				$output .=  '</'. $block_title_tag .'>';
			}

			if ( $ajax_filter !== 'disabled' )
			{
				$category_args = array(
				  'orderby' => 'name',
				);

				$categories = get_categories($category_args);
				
				
				$cat_count = count($categories);	
				$x = 1;
				
				$output .=  '<div class="apb-ajax-filter dropdown '. ( $cat_count <= 2 ? 'apb-mobile' : '' ) .'">';
				$output .=  '<span class="cats">'. esc_html( $filter_text ) .' <span class="chevron"><i class="acoda-icon-arrow-down"></i></span></span>';
				
				$output .=  '<ul>';
				
				$output .=  '<li class="apb-mobile"><a href="#" data-cat-id="">'. esc_html( __('All', 'apb') ) .'</a></li>';

				$cat_array = explode(',',$cats);
				
				foreach ($categories as $category) 
				{
					if( !in_array( $category->term_id, $cat_array ) )
					{
						$output .=  '<li class="'. ( ( $x <= 2 ? 'apb-mobile' : '' ) ) .'"><a href="#" data-cat-id="'. esc_attr( $category->term_id ) .'">'. esc_html( $category->name ) .'</a></li>';
						$x++;
					}
				} 
				
				wp_reset_query();

				$output .=  '</ul>';			
				$output .=  '</div>';
				
				$y = 1;
				
				$output .=  '<div class="apb-ajax-filter inline">';
				$output .=  '<ul>';
				
				$output .=  '<li><a href="#" data-cat-id="">'. esc_html( __('All', 'apb') ) .'</a></li>';
				
				foreach ($categories as $category) 
				{
					if( $y <= 2 )
					{
						if( !in_array( $category->term_id, $cat_array ) )
						{						
							$output .=  '<li><a href="#" data-cat-id="'. esc_attr( $category->term_id ) .'">'. esc_html( $category->name ) .'</a></li>';
						}
						else
						{
							$y--;
						}
					}
					$y++;
				} 				
				
				$output .=  '</ul>';
				$output .=  '</div>';
				
			}

			$output .=  '</div>';
		}			
		
		$output .= '<div class="apb-inner-wrap">';
		
		$column_width = acoda_post_widget_vc::vc_get_column_width();

		switch ($layout) 
		{
			case "block_1":
				include 'block_1.php';
				break;
			case "block_2":
				include 'block_2.php';
				break;
			case "block_3":
				include 'block_3.php';
				break;	
			case "block_4":
				include 'block_4.php';
				break;	
			case "block_5":
				include 'block_5.php';
				break;	
			case "block_6":
				include 'block_6.php';
				break;					
			default:
				include 'block_1.php';
		}

		$output .= '</div>';
		
		if( $ajax_pagination !== 'disabled' )
		{
			$output .= '<div class="apb-pagination-wrap">';
			$output .= '<a class="apb-pagination not-active prev" data-action="prev"><i class="acoda-icon-arrow-left"></i></a>';
			$output .= '<a class="apb-pagination '. ( $found_posts <= $number ? 'not-active' : '' ) .' next" data-action="next"><i class="acoda-icon-arrow-right"></i></a>';
			$output .= '</div>';		
		}
		
		$output .= '<div class="apb-preloader"><div class="spinner-layer"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';	
		$output .= '</div>';
		
		wp_reset_query();
		
		return $output;
	}


	
    /*
    Load plugin css and javascript files which you may need on front end
    */
	public function loadCssAndJs() {
		//wp_register_style( 'acoda_post_widget', plugins_url('assets/css/apb-styles.min.css', __FILE__) );
		//wp_enqueue_style( 'acoda_post_widget' );		
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
	public function showVcVersionNotice() {
		$plugin_data = get_plugin_data(__FILE__);
		echo '
		<div class="updated">
			<p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'apb'), $plugin_data['Name']).'</p>
		</div>';
	}
}


// Finally initialize code
new acoda_post_widget_vc();