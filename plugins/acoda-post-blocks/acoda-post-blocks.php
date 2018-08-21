<?php
/**
 * Acoda Post Blocks
 *
 * @package   acoda_post_blocks
 * @author    Acoda	
 * @license   GPL-2.0+
 * @link      http://acoda.com/
 * @copyright 2017 Acoda Ltd
 *
 * @wordpress-plugin
 * Plugin Name: Acoda Post Blocks
 * Plugin URI:  http://acoda.com/
 * Description: Enables a product review post type and taxonomies.
 * Version:     0.1
 * Author:      Acoda
 * Author URI:  http://acoda.com/
 * Text Domain: apb
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */



if ( !class_exists( 'WP_Widget_Acoda_Posts' ) ) {

  class WP_Widget_Acoda_Posts extends WP_Widget {

    function __construct() {

		$widget_options = array(
		'classname' => 'widget_acoda_posts',
		'description' => __( 'Displays list of posts with an array of options', 'apb' )
		);

		$control_options = array(
		'width' => 450
		);

		parent::__construct(
		'sticky-posts',
		__( 'Acoda Post Block', 'apb' ),
		$widget_options,
		$control_options
		);

		$this->alt_option_name = 'widget_acoda_posts';

		add_action('save_post', array(&$this, 'flush_widget_cache'));
		add_action('deleted_post', array(&$this, 'flush_widget_cache'));
		add_action('switch_theme', array(&$this, 'flush_widget_cache'));
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_scripts'));

		if (apply_filters('apb_enqueue_styles', true) && !is_admin()) {
			add_action('wp_enqueue_scripts', array(&$this, 'enqueue_theme_scripts'));
		}

		if ( function_exists( 'add_image_size' ) ) 
		{ 
			add_image_size( 'apb-featured', 412, 232, true ); 
			//add_image_size( 'apb-featured-wide', 412, 232, true ); 
			add_image_size( 'apb-thumbnail', 100, 70, true ); 
		}

		load_plugin_textdomain('apb', false, basename( dirname( __FILE__ ) ) . '/languages' );

		// Visual Composer Addon.
		if ( defined( 'WPB_VC_VERSION' ) ) {
		   require plugin_dir_path( __FILE__ ) . 'includes/class-apb-vc-addon.php';
		}		

    }

    function enqueue_admin_scripts() {
      wp_enqueue_style('apb_admin_styles', plugins_url('assets/css/apb-admin.min.css', __FILE__));
	  wp_enqueue_style( 'wp-color-picker' );	
      wp_enqueue_script('apb_admin_scripts', plugins_url('assets/js/apb-admin.min.js', __FILE__), array('jquery','wp-color-picker'), null, true);
		
		
    }

    function enqueue_theme_scripts() {
      wp_enqueue_style('apb_styles', plugins_url('assets/css/apb-styles.min.css', __FILE__));
	  // Acoda Font Icons
	  wp_enqueue_style('acoda-font-icons', plugins_url('assets/css/acoda-icon-font/styles.css', __FILE__));
      wp_enqueue_script('apb_ajax', plugins_url('assets/js/apb-ajax.js', __FILE__), array('jquery'), null, true);
		
    }

    function widget( $args, $instance ) {

      global $post;

      if ( is_object( $post ) ) {
        $current_post_id = $post->ID;
      } else {
        $current_post_id = 0;
      }

      $cache = wp_cache_get( 'widget_acoda_posts', 'widget' );

      if ( !is_array( $cache ) )
        $cache = array();

      if ( isset( $cache[$args['widget_id']] ) ) {
        echo $cache[$args['widget_id']];
        return;
      }

      ob_start();
      extract( $args );

      $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
      $title_link = $instance['title_link'];
      $class = $instance['class'];
	  $title_color = $instance['title_color'];
	  $title_background = $instance['title_background'];
      $number = empty($instance['number']) ? -1 : $instance['number'];
	  $offset = empty($instance['offset']) ? 0 : $instance['offset'];
      $types = empty($instance['types']) ? 'any' : explode(',', $instance['types']);
      $cats = empty($instance['cats']) ? '' : explode(',', $instance['cats']);
      $tags = empty($instance['tags']) ? '' : $instance['tags'];
      $atcat = $instance['atcat'] ? true : false;
      //$thumb_style = $instance['thumb_style'];
	  //$thumb_align = $instance['thumb_align'];	
      $attag = $instance['attag'] ? true : false;
      $excerpt_length = $instance['excerpt_length'];
	  $title_length = $instance['title_length'];	
		
      $sticky = $instance['sticky'];
      $order = $instance['order'];
      $orderby = $instance['orderby'];
      $meta_key = $instance['meta_key'];
      $custom_fields = $instance['custom_fields'];

      // Sticky posts
      if ($sticky == 'only') {
        $sticky_query = array( 'post__in' => get_option( 'sticky_posts' ) );
      } elseif ($sticky == 'hide') {
        $sticky_query = array( 'post__not_in' => get_option( 'sticky_posts' ) );
      } else {
        $sticky_query = null;
      }

      // If $atcat true and in category
      if ($atcat && is_category()) {
        $cats = get_query_var('cat');
      }

      // If $atcat true and is single post
      if ($atcat && is_single()) {
        $cats = '';
        foreach (get_the_category() as $catt) {
          $cats .= $catt->term_id.' ';
        }
        $cats = str_replace(' ', ',', trim($cats));
      }

      // If $attag true and in tag
      if ($attag && is_tag()) {
        $tags = get_query_var('tag_id');
      }

      // If $attag true and is single post
      if ($attag && is_single()) {
        $tags = '';
        $thetags = get_the_tags();
        if ($thetags) {
            foreach ($thetags as $tagg) {
                $tags .= $tagg->term_id . ' ';
            }
        }
        $tags = str_replace(' ', ',', trim($tags));
      }

      // Excerpt more filter
      $new_excerpt_more = create_function('$more', 'return "...";');
      add_filter('excerpt_more', $new_excerpt_more);

      // Excerpt length filter
      $new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");
      if ( $instance['excerpt_length'] > 0 ) add_filter('excerpt_length', $new_excerpt_length);

      if( $class ) {
        $before_widget = str_replace('class="', 'class="'. $class . ' ', $before_widget);
      }

      echo $before_widget;

		
	  // Get Current Post ID
	
	  $url = explode('?', 'http://'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );
				
	  $post_id = ( isset($_GET['page_id'] ) ? esc_attr( $_GET['page_id'] ) : url_to_postid( esc_url( $url[0] ) ) );	
		  
		// Product Review
		if ( get_post_type() == 'product-review' && is_single() ) { // Post type name
			
	  		global $cat_id;
		
	  		echo '<p class="widget-title-wrap review-link"><span class="widget-title"><a href="'. get_the_permalink( $cat_id ) .'"><i class="fa fa-caret-left" aria-hidden="true"></i> Back to Review</a></span></p>';

				$terms = get_the_terms( $post->ID, 'product_review_category' );
				
				foreach($terms as $term) 
				{
					$category = $term->term_taxonomy_id;
					$title = 'More '. $term->name .' Reviews';
				}				
				
				
				$args = array(
					'post_type' => 'product-review',
					'order' => 'ASC',
					'posts_per_page' => '-1',
					'tax_query' => array(
						array(
							'taxonomy' => 'product_review_category',
							'field' => 'id',
							'terms' => $category
						)
					)
				);			
		}
		else
		{
		  $args = array(
			'posts_per_page' => $number,
			'order' => $order,
			'offset' => $offset,
			'post_status' => 'publish',
			'orderby' => $orderby,
			'cat' => $cats,
			'tag__in' => $tags,
			'post__not_in' => array( $post_id ),
			'post_type' => $types
		  );			
		}
	  



      if ($orderby === 'meta_value') {
        $args['meta_key'] = $meta_key;
      }

      if (!empty($sticky_query)) {
        $args[key($sticky_query)] = reset($sticky_query);
      }

      $args = apply_filters('apb_wp_query_args', $args, $instance, $this->id_base);	

      $apb_query = new WP_Query($args);

	$found_posts = $apb_query->found_posts;
	$post_count = $apb_query->post_count;	
		
	$column_width = 'widget';

	// Define Vars
	$layout = $instance['layout'];
	$show_cats = $instance['show_cats'];
	$title_tag = $instance['title_tag'];
	$ajax_filter = $instance['ajax_filter'];	
	$ajax_pagination = $instance['ajax_pagination'];
	$show_date = $instance['show_date'];
	//$date_format = $instance['date_format'];
	$filter_text = $instance['filter_text'];
	$show_author = $instance['show_author'];
	$show_comments = $instance['show_comments'];
	$excerpt_length = $instance['excerpt_length'];
	$title_length = $instance['title_length'];
	$show_readmore = $instance['show_readmore'];
	$before_posts = format_to_edit($instance['before_posts']);
	$after_posts = format_to_edit($instance['after_posts']);	
		
	$attributes = array(
		'show_cats' => $instance['show_cats'],
		'title_tag' => $instance['title_tag'],
		'ajax_filter' => $instance['ajax_filter'],	
		'ajax_pagination' => $instance['ajax_pagination'],
		'show_date' => $instance['show_date'],
		//'date_format' => $instance['date_format'],
		'show_author' => $instance['show_author'],
		'show_comments' => $instance['show_comments'],
		'excerpt_length' => $instance['excerpt_length'],
		'title_length' => $instance['title_length'],
		'column_width' => 'widget',
		'page_layout' => ''
	);

	if( $layout == 'layout_2')
	{
		$placeholder_img = plugins_url( 'assets/no_image_square.jpg', __FILE__ );
	}
	else
	{
		$placeholder_img = plugins_url( 'assets/no_image.jpg', __FILE__ );
	}
		
	$pagination_type = 'click_load';

	$output = '';

	$output .= '<div class="apb-wrap apb-'. esc_attr( $layout ) .'" id="apb-'. uniqid() .'" data-block="'. esc_attr( $layout ) .'" data-query="'. esc_attr( json_encode( $args ) ) .'" data-post-count="'. esc_attr( $found_posts ) .'" data-post-offset="'. esc_attr( $offset ) .'"  data-attributes="'. esc_attr( json_encode( $attributes ) ) .'" data-pagination-type="'. esc_attr( $pagination_type ) .'" data-ajaxurl="'. esc_url( admin_url() ) .'admin-ajax.php">';
		


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
			
			$block_tag = 'div';
			
			if( function_exists('acoda_settings') )
			{
				$block_tag = acoda_settings('widget_tag');
			}
			
			$output .=  '<'. $block_tag .' class="apb-title '. ( !empty( $title_background ) ? 'background' : '' ) .'" '. ( !empty( $style ) ? 'style="'. esc_attr( $style ) .'"' : '' ) .'>';
			if ( $title_link ) echo '<a '. ( !empty( $title_color ) ? 'style="color:'. esc_attr( $title_color ) .'"' : '' ) .' href="'. esc_url( $title_link ) .'">';
			$output .=  $title;
			if ( $title_link ) echo '</a>';
			$output .=  '</'. $block_tag .'>';
		}

		if ( $ajax_filter !== 'disabled' )
		{
			$output .=  '<div class="apb-ajax-filter dropdown">';
			$output .=  '<span class="cats">'.  esc_html( $filter_text ) .' <span class="chevron"><i class="acoda-icon-arrow-down"></i></span></span>';

			$output .=  '<ul>';

			$category_args = array(
			  'orderby' => 'name',
			);

			$categories = get_categories($category_args);
			

			foreach ($categories as $category) 
			{
				if( is_array( $cats ) )
				{
					if( !in_array( $category->term_id, $cats )  )
					{					
						$output .=  '<li><a href="#" data-cat-id="'. esc_attr( $category->term_id ) .'">'. esc_html( $category->name ) .'</a></li>';
					}
				}
				else
				{
					$output .=  '<li><a href="#" data-cat-id="'. esc_attr( $category->term_id ) .'">'. esc_html( $category->name ) .'</a></li>';
				}
			} 

			wp_reset_query();

			$output .=  '</ul>';			
			$output .=  '</div>';
		}

		$output .=  '</div>';
	}			
		
	$output .= '<div class="apb-inner-wrap">';
		
	switch ($layout) 
	{
		case "block_1":
			include 'includes/block_1.php';
			break;
		case "block_2":
			include 'includes/block_2.php';
			break;
		case "block_3":
			include 'includes/block_3.php';
			break;	
		case "block_4":
			include 'includes/block_4.php';
			break;	
		case "block_5":
			include 'includes/block_5.php';
			break;				
		default:
			include 'includes/block_1.php';
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
		
	echo $output;

	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();

	echo $after_widget;

	if ($cache) {
		$cache[$args['widget_id']] = ob_get_flush();
	}
		wp_cache_set( 'widget_acoda_posts', $cache, 'widget' );
    }

    function update( $new_instance, $old_instance ) {
      $instance = $old_instance;

      $instance['title'] = strip_tags( $new_instance['title'] );
      $instance['class'] = strip_tags( $new_instance['class']);
      $instance['title_link'] = strip_tags( $new_instance['title_link'] );
	  $instance['title_color'] = strip_tags( $new_instance['title_color'] );
	  $instance['title_background'] = strip_tags( $new_instance['title_background'] );	
      $instance['number'] = strip_tags( $new_instance['number'] );
	  $instance['offset'] = strip_tags( $new_instance['offset'] );
      $instance['types'] = (isset( $new_instance['types'] )) ? implode(',', (array) $new_instance['types']) : '';
      $instance['cats'] = (isset( $new_instance['cats'] )) ? implode(',', (array) $new_instance['cats']) : '';
      $instance['tags'] = (isset( $new_instance['tags'] )) ? implode(',', (array) $new_instance['tags']) : '';
      $instance['atcat'] = isset( $new_instance['atcat'] );
      $instance['attag'] = isset( $new_instance['attag'] );
      $instance['show_date'] = isset( $new_instance['show_date'] );
	  $instance['title_tag'] = strip_tags( $new_instance['title_tag'] );
	  $instance['ajax_filter'] = strip_tags ( $new_instance['ajax_filter'] );	
	  $instance['ajax_pagination'] = strip_tags ( $new_instance['ajax_pagination'] );		
      $instance['show_author'] = isset( $new_instance['show_author'] );
      $instance['show_comments'] = isset( $new_instance['show_comments'] );
      $instance['show_readmore'] = isset( $new_instance['show_readmore']);
      $instance['excerpt_length'] = strip_tags( $new_instance['excerpt_length'] );
	  $instance['title_length'] = strip_tags( $new_instance['title_length'] );	
	  $instance['filter_text'] = strip_tags( $new_instance['filter_text'] );
      $instance['sticky'] = $new_instance['sticky'];
      $instance['order'] = $new_instance['order'];
      $instance['orderby'] = $new_instance['orderby'];
      $instance['meta_key'] = $new_instance['meta_key'];
      $instance['show_cats'] = isset( $new_instance['show_cats'] );
      $instance['custom_fields'] = strip_tags( $new_instance['custom_fields'] );
      $instance['layout'] = strip_tags( $new_instance['layout'] );	


      if (current_user_can('unfiltered_html')) {
        $instance['before_posts'] =  $new_instance['before_posts'];
        $instance['after_posts'] =  $new_instance['after_posts'];
      } else {
        $instance['before_posts'] = wp_filter_post_kses($new_instance['before_posts']);
        $instance['after_posts'] = wp_filter_post_kses($new_instance['after_posts']);
      }

      $this->flush_widget_cache();

      $alloptions = wp_cache_get( 'alloptions', 'options' );
      if ( isset( $alloptions['widget_acoda_posts'] ) )
        delete_option( 'widget_acoda_posts' );

      return $instance;

    }

    function flush_widget_cache() {

      wp_cache_delete( 'widget_acoda_posts', 'widget' );

    }

	function form( $instance ) {

	// Set default arguments
	$instance = wp_parse_args( (array) $instance, array(
	'title' => __('Acoda Posts', 'apb'),
	'class' => '',
	'title_link' => '' ,
	'title_background' => '#000000',
	'title_color' => '#FFFFFF',
	'number' => '5',
	'offset' => '',
	'types' => 'post',
	'cats' => '',
	'tags' => '',
	'atcat' => false,
	'attag' => false,
	'excerpt_length' => 100,
	'title_length' => '',
	'filter_text' => 'All',
	'order' => 'DESC',
	'orderby' => 'date',
	'meta_key' => '',
	'sticky' => 'show',
	'show_cats' => false,
	'title_tag' => 'div',
	'ajax_filter' => 'disabled',
	'ajax_pagination' => 'disabled',		
	'show_date' => false,
	'date_format' => get_option('date_format') . ' ' . get_option('time_format'),
	'show_author' => false,
	'show_comments' => false,
	'show_readmore' => false,
	'custom_fields' => '',
	'layout' => 'block_1',
	'before_posts' => '',
	'after_posts' => ''
	) );

	// Or use the instance
	$layout = $instance['layout'];	
	$title  = strip_tags($instance['title']);
	$class  = strip_tags($instance['class']);
	$title_link  = strip_tags($instance['title_link']);
		
	$title_background  = strip_tags($instance['title_background']);
	$title_color  = strip_tags($instance['title_color']);	
				
	$number = strip_tags($instance['number']);
	$offset = strip_tags($instance['offset']);
	$types  = $instance['types'];
	$cats = $instance['cats'];
	$tags = $instance['tags'];
	$atcat = $instance['atcat'];
	$attag = $instance['attag'];
	$excerpt_length = strip_tags($instance['excerpt_length']);
	$title_length = strip_tags($instance['title_length']);
	$filter_text = strip_tags($instance['filter_text']); 
	$order = $instance['order'];
	$orderby = $instance['orderby'];
	$meta_key = $instance['meta_key'];
	$sticky = $instance['sticky'];
	$show_cats = $instance['show_cats'];
	$title_tag = $instance['title_tag'];
	$ajax_pagination = $instance['ajax_pagination'];	
	$ajax_filter = $instance['ajax_filter'];			
	$show_date = $instance['show_date'];
	$show_author = $instance['show_author'];
	$show_comments = $instance['show_comments'];
	$show_readmore = $instance['show_readmore'];	
	$custom_fields = strip_tags($instance['custom_fields']);
	$before_posts = format_to_edit($instance['before_posts']);
	$after_posts = format_to_edit($instance['after_posts']);

	// Let's turn $types, $cats, and $tags into an array if they are set
	if (!empty($types)) $types = explode(',', $types);
	if (!empty($cats)) $cats = explode(',', $cats);

	// Count number of post types for select box sizing
	$cpt_types = get_post_types( array( 'public' => true ), 'names' );
	if ($cpt_types) {
	foreach ($cpt_types as $cpt ) {
	  $cpt_ar[] = $cpt;
	}
	$n = count($cpt_ar);
	if($n > 6) { $n = 6; }
	} else {
	$n = 3;
	}

	// Count number of categories for select box sizing
	$cat_list = get_categories( 'hide_empty=0' );
	if ($cat_list) {
	foreach ($cat_list as $cat) {
	  $cat_ar[] = $cat;
	}
	$c = count($cat_ar);
	if($c > 6) { $c = 6; }
	} else {
	$c = 3;
	}

	// Count number of tags for select box sizing
	$tag_list = get_tags( 'hide_empty=0' );
	if ($tag_list) {
	foreach ($tag_list as $tag) {
	  $tag_ar[] = $tag;
	}
	$t = count($tag_ar);
	if($t > 6) { $t = 6; }
	} else {
	$t = 3;
	}

				
      ?>

      <div class="apb-tabs">
        <a class="apb-tab-item active" data-toggle="apb-tab-general"><?php _e('General', 'apb'); ?></a>
        <a class="apb-tab-item" data-toggle="apb-tab-display"><?php _e('Display', 'apb'); ?></a>
        <a class="apb-tab-item" data-toggle="apb-tab-filter"><?php _e('Filter', 'apb'); ?></a>
        <a class="apb-tab-item" data-toggle="apb-tab-ajax"><?php _e('Ajax', 'apb'); ?></a>
      </div>

      <div class="apb-tab apb-tab-general">

        <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'apb' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'title_link' ); ?>"><?php _e( 'Title URL', 'apb' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title_link' ); ?>" name="<?php echo $this->get_field_name( 'title_link' ); ?>" type="text" value="<?php echo $title_link; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'CSS class', 'apb' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" type="text" value="<?php echo $class; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('before_posts'); ?>"><?php _e('Before posts', 'apb'); ?>:</label>
          <textarea class="widefat" id="<?php echo $this->get_field_id('before_posts'); ?>" name="<?php echo $this->get_field_name('before_posts'); ?>" rows="5"><?php echo $before_posts; ?></textarea>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('after_posts'); ?>"><?php _e('After posts', 'apb'); ?>:</label>
          <textarea class="widefat" id="<?php echo $this->get_field_id('after_posts'); ?>" name="<?php echo $this->get_field_name('after_posts'); ?>" rows="5"><?php echo $after_posts; ?></textarea>
        </p>

      </div>

      <div class="apb-tab apb-hide apb-tab-display">

        <p>
          <label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout', 'apb'); ?>:</label>
          <select name="<?php echo $this->get_field_name('layout'); ?>" id="<?php echo $this->get_field_id('layout'); ?>" class="widefat">
            <option value="block_1"<?php if( $layout == 'block_1') echo ' selected'; ?>><?php _e('Block 1', 'apb'); ?></option>
            <option value="block_2"<?php if( $layout == 'block_2') echo ' selected'; ?>><?php _e('Block 2', 'apb'); ?></option>
            <option value="block_3"<?php if( $layout == 'block_3') echo ' selected'; ?>><?php _e('Block 3', 'apb'); ?></option>
            <option value="block_4"<?php if( $layout == 'block_4') echo ' selected'; ?>><?php _e('Block 4', 'apb'); ?></option>
          </select>
        </p>
             

        <p>
          <label for="<?php echo $this->get_field_id( 'title_background' ); ?>"><?php _e( 'Title Background Color', 'apb' ); ?>:</label>
          <input class="widefat apb-color-field" id="<?php echo $this->get_field_id( 'title_background' ); ?>" name="<?php echo $this->get_field_name( 'title_background' ); ?>" type="text" value="<?php echo $title_background; ?>" />
        </p>  
        
        <p>
          <label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php _e( ' Title text color', 'apb' ); ?>:</label>
          <input class="widefat apb-color-field" id="<?php echo $this->get_field_id( 'title_color' ); ?>" name="<?php echo $this->get_field_name( 'title_color' ); ?>" type="text" value="<?php echo $title_color; ?>" />
        </p>            
      
       <p>
          <label for="<?php echo $this->get_field_id('title_tag'); ?>"><?php _e('Post Title Tag', 'apb'); ?>:</label>
          <select name="<?php echo $this->get_field_name('title_tag'); ?>" id="<?php echo $this->get_field_id('title_tag'); ?>" class="widefat">
            <option value="div"<?php if( $title_tag == 'div') echo ' selected'; ?>><?php _e('Div', 'apb'); ?></option>
            <option value="strong"<?php if( $title_tag == 'strong') echo ' selected'; ?>><?php _e('Bold', 'apb'); ?></option>
            <option value="h2"<?php if( $title_tag == 'h2') echo ' selected'; ?>><?php _e('h2', 'apb'); ?></option>
            <option value="h3"<?php if( $title_tag == 'h3') echo ' selected'; ?>><?php _e('h3', 'apb'); ?></option>
            <option value="h4"<?php if( $title_tag == 'h4') echo ' selected'; ?>><?php _e('h4', 'apb'); ?></option>
            <option value="h5"<?php if( $title_tag == 'h5') echo ' selected'; ?>><?php _e('h5', 'apb'); ?></option>
            <option value="h6"<?php if( $title_tag == 'h6') echo ' selected'; ?>><?php _e('h6', 'apb'); ?></option>
      
          </select>
        </p>                 
              
        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" <?php checked( (bool) $show_date, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show published date', 'apb' ); ?></label>
        </p>                   

        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" type="checkbox" <?php checked( (bool) $show_author, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show post author', 'apb' ); ?></label>
        </p>
        
        <p>
          <input class="checkbox trigger" id="<?php echo $this->get_field_id( 'show_comments' ); ?>" name="<?php echo $this->get_field_name( 'show_comments' ); ?>" type="checkbox" <?php checked( (bool) $show_comments, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_comments' ); ?>"><?php _e( 'Show comments count', 'apb' ); ?></label>
        </p>       

        <p>
          <input type="checkbox" class="checkbox trigger" id="<?php echo $this->get_field_id('show_cats'); ?>" name="<?php echo $this->get_field_name('show_cats'); ?>" <?php checked( (bool) $show_cats, true ); ?> />
          <label for="<?php echo $this->get_field_id('show_cats'); ?>"> <?php _e('Show post categories', 'apb'); ?></label>
        </p>
        
        <p>
          <label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e( 'Excerpt length (in characters)', 'apb' ); ?>:</label>
          <input class="widefat" type="number" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" value="<?php echo $excerpt_length; ?>" min="-1" />
        </p>
        
        <p>
          <label for="<?php echo $this->get_field_id('title_length'); ?>"><?php _e( 'Title length (in characters)', 'apb' ); ?>:</label>
          <input class="widefat" type="number" id="<?php echo $this->get_field_id('title_length'); ?>" name="<?php echo $this->get_field_name('title_length'); ?>" value="<?php echo $title_length; ?>" min="-1" />
        </p>        
		  

        <p>
          <label for="<?php echo $this->get_field_id( 'custom_fields' ); ?>"><?php _e( 'Show custom fields (comma separated)', 'apb' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'custom_fields' ); ?>" name="<?php echo $this->get_field_name( 'custom_fields' ); ?>" type="text" value="<?php echo $custom_fields; ?>" />
        </p>

      </div>

      <div class="apb-tab apb-hide apb-tab-filter">

        <p>
          <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts', 'apb' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>" min="-1" />
        </p>
             
        
        <p>
          <label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Offset By', 'apb' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="number" value="<?php echo $offset; ?>" />
        </p>          
       
        <p>
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('atcat'); ?>" name="<?php echo $this->get_field_name('atcat'); ?>" <?php checked( (bool) $atcat, true ); ?> />
          <label for="<?php echo $this->get_field_id('atcat'); ?>"> <?php _e('Show posts only from current category', 'apb');?></label>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e( 'Categories', 'apb' ); ?>:</label>
          <select name="<?php echo $this->get_field_name('cats'); ?>[]" id="<?php echo $this->get_field_id('cats'); ?>" class="widefat" style="height: auto;" size="<?php echo $c ?>" multiple>
            <option value="" <?php if (empty($cats)) echo 'selected="selected"'; ?>><?php _e('&ndash; Show All &ndash;') ?></option>
            <?php
            $categories = get_categories( 'hide_empty=0' );
            foreach ($categories as $category ) { ?>
              <option value="<?php echo $category->term_id; ?>" <?php if(is_array($cats) && in_array($category->term_id, $cats)) echo 'selected="selected"'; ?>><?php echo $category->cat_name;?></option>
            <?php } ?>
          </select>
        </p>


        <p>
          <label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php _e( 'Filter by Tags (comma separated)', 'apb' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" type="text" value="<?php echo $tags; ?>" />
        </p>          
        
        <p>
          <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order by', 'apb'); ?>:</label>
          <select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat">
            <option value="date"<?php if( $orderby == 'date') echo ' selected'; ?>><?php _e('Published Date', 'apb'); ?></option>
            <option value="title"<?php if( $orderby == 'title') echo ' selected'; ?>><?php _e('Title', 'apb'); ?></option>
            <option value="comment_count"<?php if( $orderby == 'comment_count') echo ' selected'; ?>><?php _e('Comment Count', 'apb'); ?></option>
            <option value="rand"<?php if( $orderby == 'rand') echo ' selected'; ?>><?php _e('Random'); ?></option>
            <option value="meta_value"<?php if( $orderby == 'meta_value') echo ' selected'; ?>><?php _e('Custom Field', 'apb'); ?></option>
            <option value="menu_order"<?php if( $orderby == 'menu_order') echo ' selected'; ?>><?php _e('Menu Order', 'apb'); ?></option>
          </select>
        </p>

        <p<?php if ($orderby !== 'meta_value') echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id( 'meta_key' ); ?>"><?php _e('Custom field', 'apb'); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id('meta_key'); ?>" name="<?php echo $this->get_field_name('meta_key'); ?>" type="text" value="<?php echo $meta_key; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'apb'); ?>:</label>
          <select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
            <option value="DESC"<?php if( $order == 'DESC') echo ' selected'; ?>><?php _e('Descending', 'apb'); ?></option>
            <option value="ASC"<?php if( $order == 'ASC') echo ' selected'; ?>><?php _e('Ascending', 'apb'); ?></option>
          </select>
        </p>        

        <p>
          <label for="<?php echo $this->get_field_id('types'); ?>"><?php _e( 'Post types', 'apb' ); ?>:</label>
          <select name="<?php echo $this->get_field_name('types'); ?>[]" id="<?php echo $this->get_field_id('types'); ?>" class="widefat" style="height: auto;" size="<?php echo $n ?>" multiple>
            <option value="" <?php if (empty($types)) echo 'selected="selected"'; ?>><?php _e('&ndash; Show All &ndash;') ?></option>
            <?php
            $args = array( 'public' => true );
            $post_types = get_post_types( $args, 'names' );
            foreach ($post_types as $post_type ) { ?>
              <option value="<?php echo $post_type; ?>" <?php if(is_array($types) && in_array($post_type, $types)) { echo 'selected="selected"'; } ?>><?php echo $post_type;?></option>
            <?php } ?>
          </select>
        </p>

      </div>
      
      <div class="apb-tab apb-hide apb-tab-ajax">
      
       <p>
          <label for="<?php echo $this->get_field_id('ajax_filter'); ?>"><?php _e('Ajax Filtering', 'apb'); ?>:</label>
          <select name="<?php echo $this->get_field_name('ajax_filter'); ?>" id="<?php echo $this->get_field_id('ajax_filter'); ?>" class="widefat">
            <option value="disabled"<?php if( $ajax_filter == 'disabled') echo ' selected'; ?>><?php _e('Disabled', 'apb'); ?></option>
            <option value="categories"<?php if( $ajax_filter == 'categories') echo ' selected'; ?>><?php _e('Categories', 'apb'); ?></option>
          </select>
        </p>  
        
        <p>
          <label for="<?php echo $this->get_field_id('filter_text'); ?>"><?php _e( 'Filter Text', 'apb' ); ?>:</label>
          <input class="widefat" type="text" id="<?php echo $this->get_field_id('filter_text'); ?>" name="<?php echo $this->get_field_name('filter_text'); ?>" value="<?php echo $filter_text; ?>" min="-1" />
        </p>           
        
       <p>
          <label for="<?php echo $this->get_field_id('ajax_pagination'); ?>"><?php _e('Ajax Pagination', 'apb'); ?>:</label>
          <select name="<?php echo $this->get_field_name('ajax_pagination'); ?>" id="<?php echo $this->get_field_id('ajax_pagination'); ?>" class="widefat">
            <option value="disabled"<?php if( $ajax_pagination == 'disabled') echo ' selected'; ?>><?php _e('Disabled', 'apb'); ?></option>
            <option value="prevnext"<?php if( $ajax_pagination == 'prevnext') echo ' selected'; ?>><?php _e('Prev / Next Buttons', 'apb'); ?></option>
          </select>
        </p>            
      
      </div>     


      <?php if ( $instance ) { ?>

        <script>

          jQuery(document).ready(function($){


            var show_readmore = $("#<?php echo $this->get_field_id( 'show_readmore' ); ?>");
            var show_readmore_wrap = $("#<?php echo $this->get_field_id( 'show_readmore' ); ?>").parents('p');
            var show_date = $("#<?php echo $this->get_field_id( 'show_date' ); ?>");
            var order = $("#<?php echo $this->get_field_id('orderby'); ?>");
            var meta_key_wrap = $("#<?php echo $this->get_field_id( 'meta_key' ); ?>").parents('p');
            var layout = $("#<?php echo $this->get_field_id('layout'); ?>");
			var show_cats = $("#<?php echo $this->get_field_id('show_cats'); ?>");  
			var show_author = $("#<?php echo $this->get_field_id('show_author'); ?>");
		    var show_date = $("#<?php echo $this->get_field_id('show_date'); ?>");
		    var show_comments = $("#<?php echo $this->get_field_id('show_comments'); ?>");	  
	
			 
            // Show or hide custom field meta_key value on order change
            order.change(function(){
              if ($(this).val() === 'meta_value') {
                meta_key_wrap.show('fast');
              } else {
                meta_key_wrap.hide('fast');
              }
            });

          });

        </script>

      <?php

      }

    }

  }
	function apb_thumbnail( $featured, $show_cats, $arr, $type = '' )
	{
		$output = '';
		
		$output .= '<div class="apb-image">';
		$output .= '<a href="'. get_the_permalink() .'">';


			$thumb_size = ( $featured === true ? ( !empty( $type) ? $type : 'apb-featured' ) : 'apb-thumbnail' );
	
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );

			$url 	= $image[0];
			$width 	= $image[1];
			$height = $image[2];	

			$alt = strtr(get_the_title(), $arr );  

			if( empty( $url ) )
			{
				$url = $placeholder_img;
			}

			$output .= '<img src="'. $url .'" alt="'. $alt .'" width="'. $width .'" height="'. $height .'" class="attachment-thumbnail size-thumbnail wp-post-image" />';


		$output .= '</a>';



		$categories = get_the_category();
		if ($show_cats && $categories) :
		$output .= '<span class="post-cats link_color_hover"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">'. esc_html( $categories[0]->name ) .'</a></span>';
		endif;


		$output .= '</div>';	
		return $output;
	}
	
	function apb_custom_fields( $custom_fields )
	{
		$output = '';
		$custom_field_name = explode(',', $custom_fields);
		foreach ($custom_field_name as $name) { 
			$name = trim($name);
			$custom_field_values = get_post_meta($post->ID, $name, true);
			if ($custom_field_values) {
				$output .= '<p class="post-meta post-meta-'.$name.'">';
				if (!is_array($custom_field_values)) {
					$output .= $custom_field_values;
				} else {
					$last_value = end($custom_field_values);
					foreach ($custom_field_values as $value) {
						$output .= $value;
						if ($value != $last_value) $output .= ', ';
					}
				}
				$output .= '</p>';
			}
		} 		
		
		return $output;
	}
	
	function apb_title( $title_tag, $arr, $title_length ) 
	{
		$output = '';
		$output .= '<'. $title_tag .' class="post-title">';
		$output .= '<a href="'. get_the_permalink() .'">';
		
		$apb_title = strtr(get_the_title(), $arr );
		
		if( !empty( $title_length) ) {
			$apb_title = apb_excerpt( $title_length,  $apb_title, 'title' );
		}
		
		$output .= $apb_title;
		$output .=	'</a>';
		$output .= '</'. $title_tag .'>';
		
		return $output;
	}
	
	function apb_author( $show_date )
	{
		$output = '';
		$output .= '<span class="post-author"><strong>'. get_the_author_posts_link() .'</strong>'. ( $show_date == true  ? '&nbsp;-&nbsp;' : '' ) .'</span>';
		return $output;
	}
	
	function apb_date() 
	{
		$output = '';
		$output .= '<span class="post-date">'.  get_the_time('F j, Y') .'</span>';
		return $output;
	}

	function apb_comments()
	{
		$output = '';
		$output .= '<span class="post-comments">';
		$output .= '<i class="fal fa-comment acoda_link_color"></i> ';
		$output .= get_comments_number(__('0', 'apb'), __('1', 'apb'), __('%', 'apb'));
		$output .= '</span>';
		return $output;
	}
	
	function apb_excerpt( $charlength, $excerpt, $type = '' )
	{
		$charlength++;
		$output = '';

		if ( mb_strlen( $excerpt ) > $charlength ) 
		{
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

			if ( $excut < 0 ) 
			{
				$output .= mb_substr( $subex, 0, $excut );
			} 
			else 
			{
				$output .= $subex;
			}

			$output .= '...';
		}
		else 
		{
			$output .= $excerpt;
		}
		
		if( $type == 'title' ) {
 			return  $output;	
		}
		else {
			return '<p class="post-excerpt">'. $output .'</p>';	
		}
	}		
	
	function apb_ajaxdata()
	{
		global $is_widget;

		$query 		 = ( !empty( $_POST['query'] ) ? $_POST['query'] : '' );
		$filter	 	 = ( !empty( $_POST['filter'] ) ? $_POST['filter'] : '' );
		$layout		 = ( !empty( $_POST['type'] ) ? $_POST['type'] : '' );
		$attributes  = ( !empty( $_POST['attributes'] ) ? $_POST['attributes'] : '' );
		$ajax_action = ( !empty( $_POST['ajax_action'] ) ? $_POST['ajax_action'] : '' );

		$args = json_decode(stripslashes($query), true);
		$attributes = json_decode(stripslashes($attributes), true);
		

		if( $ajax_action == 'next' )
		{
			$offset 		= $args['offset'];
			$posts_per_page = $args['posts_per_page'];

			$args['offset'] = $post_offset = $offset + $posts_per_page;
		}

		if( $ajax_action == 'prev' )
		{
			$offset 		= $args['offset'];
			$posts_per_page = $args['posts_per_page'];

			if( $offset != 0 )
			{
				$args['offset'] = $post_offset = $offset - $posts_per_page;
			}
		}	
		
		if( $ajax_action == 'category' )
		{
			
			$args['cat'] = ( !empty( $filter ) ? array( $filter ) : '' );
			$args['offset'] = 0;
		}			
		

		$apb_query = new WP_Query($args);
		
		$found_posts = $apb_query->found_posts;
		$post_count = $apb_query->post_count;

		// Define Vars
		//$layout = $attributes['layout'];
		$show_cats = $attributes['show_cats'];
		$title_tag = $attributes['title_tag'];
		$ajax_pagination = $attributes['ajax_pagination'];
		$ajax_filter = $attributes['ajax_filter'];
		$show_date = $attributes['show_date'];
		//$date_format = $attributes['date_format'];
		$show_author = $attributes['show_author'];
		$show_comments = $attributes['show_comments'];
		$excerpt_length = $attributes['excerpt_length'];
		$title_length = $attributes['title_length'];
		$column_width = $attributes['column_width'];
		$page_layout =  $attributes['page_layout'];
		

		$pagination_type = 'click_load';
		
		$output = '';
		
		$args = json_encode($args);
		
		switch ($layout) 
		{
			case "block_1":
				include 'includes/block_1.php';
				break;
			case "block_2":
				include 'includes/block_2.php';
				break;
			case "block_3":
				include 'includes/block_3.php';
				break;	
			case "block_4":
				include 'includes/block_4.php';
				break;	
			case "block_5":
				include 'includes/block_5.php';
				break;				
			default:
				include 'includes/block_1.php';
		}	
		
		$results = array(
			 'output' => $output,
			 'query' => $args,
			 'found_posts' => $found_posts,
			 'post_count' => $post_count,
			 'post_offset' => $post_offset,
			 'posts_per_page' => $posts_per_page,
		);
		
		//echo $output;
		
		echo json_encode($results, true);
		
		die();

	}

	add_action( 'wp_ajax_nopriv_apb_ajaxdata', 'apb_ajaxdata' );
	add_action( 'wp_ajax_apb_ajaxdata', 'apb_ajaxdata' );	
	
	
  function init_wp_widget_acoda_posts() {
    register_widget( 'WP_Widget_Acoda_Posts' );
  }

  add_action( 'widgets_init', 'init_wp_widget_acoda_posts' );
}
