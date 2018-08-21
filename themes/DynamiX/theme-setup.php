<?php 

	/* ------------------------------------
	:: REGISTER NAVIGATION MENUS
	------------------------------------ */

	add_theme_support( 'nav-menus' );
	
	register_nav_menus( array(
		'mainnav' => esc_html__( 'Main Navigation', 'dynamix' ),
		'mobilenav' => esc_html__( 'Mobile Navigation', 'dynamix' ),
	) );

	/* ------------------------------------
	:: REGISTER WIDGET AREAS
	------------------------------------ */

	add_action( 'widgets_init', 'acoda_widgets_init' );
	
	function acoda_widgets_init()
	{	
		global $dynamix_options;
		
		$sidebars_num		= ( !empty( $dynamix_options['sidebars_num'] ) ) ? $dynamix_options['sidebars_num'] : '2';
		$dockpanel_num		= ( !empty( $dynamix_options['dockpanel_num'] ) ) ? $dynamix_options['dockpanel_num'] : '2';
		$get_footer_num 	= ( acoda_settings('footer_columns_num') !='' ) ? acoda_settings('footer_columns_num') : '4';
		$widget_tag			= ( !empty( $dynamix_options['widget_tag'] ) ) ? $dynamix_options['widget_tag'] : 'h4';
		
	
		// Sidebar Columns
		$i = 1;
			
		while( $i <= $sidebars_num )
		{
			register_sidebar(
			array(
				'name'=>'Sidebar '.$i,
				'id'=>'sidebar'.$i,
				'before_title' => '<'. $widget_tag .' class="widget-title-wrap"><span class="widget-title">',
				'after_title' => '</span></'. $widget_tag .'>',
			));
			$i++;
		}

	
		// Menu Dock Panel
		register_sidebar(
		array(
			'name' => 'Docked Menu Panel',
			'id' => 'dockedmenupanel',
			'description' => esc_html__('Add widgets to appear below the Menu within the Dock Bar.','dynamix'),
			'before_title' => '<'. $widget_tag .' class="widget-title-wrap"><span class="widget-title">',
			'after_title' => '</span></'. $widget_tag .'>',
		));	
	
		// Header Panel		
		register_sidebar(
		array(
			'name' => 'Header Ad Area',
			'id' => 'headerpanel',
			'description' => esc_html__('Add widgets to appear below the header.','dynamix'),
			'before_title' => '<'. $widget_tag .' class="widget-title-wrap"><span class="widget-title">',
			'after_title' => '</span></'. $widget_tag .'>',
		));	
	
		// Footer Columns
		$i = 1;
			
		while( $i <= $get_footer_num )
		{
			register_sidebar(
			array(
				'name'=>'Footer Column '.$i,
				'id'=>'footer'.$i,
				'description' => 'Widgets in this area will be shown in Footer column '.$i.'.',
				'before_title' => '<'. $widget_tag .' class="widget-title-wrap"><span class="widget-title">',
				'after_title' => '</span></'. $widget_tag .'>',
			));
			
			$i++;
		}	
		
	
		// Dockbar Columns
		$i = 1;
			
		while( $i <= $dockpanel_num )
		{
			register_sidebar(
			array(
				'name'=>'Dock Panel '.$i,
				'id'=>'dockpanel'.$i,
				'before_title' => '<'. $widget_tag .' class="widget-title-wrap"><span class="widget-title">',
				'after_title' => '</span></'. $widget_tag .'>',
			));
			$i++;
		}		
	}

	/* ------------------------------------
	:: TGM PLUGIN SETUP
	------------------------------------ */

	
	add_action( 'tgmpa_register', 'acoda_register_required_plugins', 999 );

	function acoda_register_required_plugins() {		
	 
		/**
		 * Array of plugin arrays. Required keys are name, slug and required.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			array(
				'name'                  => 'Visual Composer', // The plugin name
				'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/js_composer.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '5.5.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),	
			array(
				'name'                  => 'Acoda Post Blocks', // The plugin name
				'slug'                  => 'acoda-post-blocks', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/acoda-post-blocks.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),			
			array(
				'name'                  => 'Acoda Typewriter', // The plugin name
				'slug'                  => 'acoda-typewriter', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/acoda-typewriter.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => 'Acoda Gigatools', // The plugin name
				'slug'                  => 'acoda-gigatools', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/acoda-gigatools.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),			
			array(
				'name'                  => 'Acoda Counters', // The plugin name
				'slug'                  => 'acoda-counters', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/acoda-counters.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => 'Visual Composer Clipboard', // The plugin name
				'slug'                  => 'vc_clipboard', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/clipboard-wordpress-plugin.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '3.2.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),			
			array(
				'name'                  => 'Acoda Pricing Tables', // The plugin name
				'slug'                  => 'ultimate-pricing-tables', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/ultimate-pricing-tables.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.8.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),						
			array(
				'name'                  => 'Portfolio Post Type', // The plugin name
				'slug'                  => 'portfolio-post-type', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/portfolio-post-type.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),				
			array(
				'name'                  => 'Revolution Slider', // The plugin name
				'slug'                  => 'revslider', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/revslider.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '5.4.7.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => 'Contact Form 7', // The plugin name
				'slug'                  => 'contact-form-7', // The plugin slug (typically the folder name)
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),	
			array(
				'name'                  => 'WooCommerce', // The plugin name
				'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),															
		);
	 
	
		$config = array(
			'domain'            => 'dynamix',           // Text domain - likely want to be the same as your theme.
			'default_path'      => '',                           // Default absolute path to pre-packaged plugins
			'menu'              => 'install-required-plugins',   // Menu slug
			'has_notices'       => true,                         // Show admin notices or not
			'is_automatic'      => true,            // Automatically activate plugins after installation or not
			'message'           => '',               // Message to output right before the plugins table
			'strings'           => array(
				'page_title'                                => esc_html__( 'Install Required Plugins', 'dynamix' ),
				'menu_title'                                => esc_html__( 'Install Plugins', 'dynamix' ),
				'installing'                                => esc_html__( 'Installing Plugin: %s', 'dynamix' ), // %1$s = plugin name
				'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', 'dynamix' ),
				'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: <span class="highlight-admin-text"> %1$s</span>.', 'This theme requires the following plugins: <span class="highlight-admin-text">%1$s</span>.', 'dynamix' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: <span class="highlight-admin-text"> %1$s</span>.', 'This theme recommends the following plugins: <span class="highlight-admin-text">%1$s</span>.', 'dynamix' ), // %1$s = plugin name(s)
				'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'dynamix' ), // %1$s = plugin name(s)
				'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: <span class="highlight-admin-text">%1$s</span>.', 'The following required plugins are currently inactive: <span class="highlight-admin-text">%1$s</span>.', 'dynamix' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: <span class="highlight-admin-text">%1$s</span>.', 'The following recommended plugins are currently inactive: <span class="highlight-admin-text">%1$s</span>.', 'dynamix' ), // %1$s = plugin name(s)
				'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'dynamix' ), // %1$s = plugin name(s)
				'notice_ask_to_update'                      => _n_noop( '<h3>Update Required</h3><span class="highlight-admin-text">%1$s</span> needs to be updated to ensure maximum compatibility with this theme.<p></p><a href="http://docs.acoda.com/you/2016/03/10/updating-installing-theme-plugins/" target="_blank" class="button button-primary">How to Update Plugins</a><p></p>', '<h3>Update Required</h3><span class="highlight-admin-text">%1$s</span> needs to be updated to ensure maximum compatibility with this theme.<p></p><a href="http://docs.acoda.com/you/2016/03/10/updating-installing-theme-plugins/" target="_blank" class="button button-primary">How to Update Plugins</a><p></p>', 'dynamix' ), // %1$s = plugin name(s)
				'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'dynamix' ), // %1$s = plugin name(s)
				'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'dynamix' ),
				'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'dynamix' ),
				'return'                                    => esc_html__( 'Return to Required Plugins Installer', 'dynamix' ),
				'plugin_activated'                          => esc_html__( 'Plugin activated successfully.', 'dynamix' ),
				'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', 'dynamix' ) // %1$s = dashboard link
			)
		);
	 
		tgmpa( $plugins, $config );
	 
	}		
	

	/* ------------------------------------
	:: VISUAL COMPOSER
	------------------------------------  */	
	
	add_action( 'vc_before_init', 'acoda_vcSetAsTheme' );
	
	function acoda_vcSetAsTheme() 
	{
		vc_set_as_theme();
	}
	
	function acoda_classes_for_vc_row_and_vc_column($class_string, $tag)
	{
		if ($tag=='vc_row' || $tag=='vc_row_inner')
		{
			$class_string = str_replace('vc_row-fluid', 'row', $class_string);
		}
	  
		return $class_string;
	}
	
	// Filter to Replace default css class for vc_row shortcode and vc_column
	add_filter('vc_shortcodes_css_class', 'acoda_classes_for_vc_row_and_vc_column', 10, 2);	
	

	/* ------------------------------------
	:: WOOCOMMERCE CSS + FUNCTIONS
	------------------------------------ */
	
	define('WOOCOMMERCE_USE_CSS', false);

	function acoda_woocommerce_style()
	{
		if ( class_exists( 'woocommerce' ) )
		{
			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
	
			wp_enqueue_style( 'acoda-woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'acoda_woocommerce_style', 1000 );	
	
	//add_filter( 'woocommerce_show_page_title', function() { return false; } );

	if( acoda_settings('woocomtitle_position') != 'content' )
	{
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	}

	add_filter( 'woocommerce_output_related_products_args', 'acoda_cross_products_args' );
	
	function acoda_cross_products_args( $args ) {
	 
		$args['posts_per_page'] = 4; // 4 related products
		$args['columns'] = 4; // arranged in 2 columns
		return $args;
	}	

	add_filter('woocommerce_cross_sells_total', 'acoda_woocommerce_cross_sale_count');
	add_filter('woocommerce_cross_sells_columns', 'acoda_woocommerce_cross_sale_count');
	
	// Remove Product Description Title
	//add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
	
	function remove_product_description_heading() 
	{
		return '';
	}
	
	function acoda_woocommerce_cross_sale_count( $value )
	{
		return 4;
	}
	
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' , 10);

	add_action( 'woocommerce_before_single_product_summary', 'acoda_image_open_wrap', 2);
	add_action( 'woocommerce_before_single_product_summary',  'acoda_close_image_div', 20);
	
	function acoda_image_open_wrap()
	{		
		if( acoda_settings('woocomtitle_position') == 'content' )
		{
			echo "\n\t\t\t" . '<div id="sub-tabs">';
					   
			// Woocommerce Breadcrumb
			if ( function_exists( 'woocommerce_breadcrumb' ) )
			{ 
				woocommerce_breadcrumb('delimiter=<span class="subbreak"><i class="fal fa-angle-right"></i></span>&wrap_before=<div class="breadcrumb">&wrap_after=</div>');
			}

			echo "\n\t\t\t" . '</div>';
		}			
		echo "<div class='row'>";
		echo "<div class='columns large-6'>";
	}



	add_action( 'woocommerce_before_single_product_summary', 'acoda_summary_open_wrap', 25);
	add_action( 'woocommerce_after_single_product_summary',  'acoda_close_summary_div', 3);
	
	function acoda_summary_open_wrap()
	{
		echo "<div class='columns large-6'>";
	}	
	
	function acoda_close_image_div()
	{
		echo "</div>";
	}

	function acoda_close_summary_div()
	{
		if( true == acoda_settings("share_product") )
		{
			$acoda_socialicons = 'yes';
				
			echo "\n". '<div class="product-social-icons">';
			echo "\n". '<div class="heading-font">'. esc_html__('Share This','dynamix') .'</div>';
	
			echo acoda_share_post();
			
			echo "\n". '</div>';
			echo "\n". '</div>';
		}		
		
		echo "</div>";
		echo "</div>";
	}	

	add_action( 'woocommerce_before_shop_loop_item_title', 'acoda_woocommerce_thumbnail', 10);
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );	
	add_filter( 'woocommerce_show_page_title' , 'acoda_woocommerce_hide_page_title' );
	add_action( 'woocommerce_shop_loop_item_title', 'acoda_loop_product_title', 10 );
	
	function acoda_loop_product_title($html)
	{
		echo '<h3 class="product-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></h3>';
	}	


	function acoda_woocommerce_hide_page_title() 
	{
		return false;
	}

	function acoda_woocommerce_single_product_image_html($html)
	{
		$html = str_replace('data-rel="prettyPhoto', 'rel="lightbox', $html);
		$html = str_replace('class="zoom', 'class="lightbox', $html);
		$html = str_replace('class="woocommerce-main-image zoom', 'class="lightbox', $html);

		return $html;
	}
	
	add_filter('woocommerce_single_product_image_html', 'acoda_woocommerce_single_product_image_html', 99, 1); // single image
	add_filter('woocommerce_single_product_image_thumbnail_html', 'acoda_woocommerce_single_product_image_html', 99, 1); // thumbnails	
	
	add_filter('loop_shop_columns', 'acoda_woocommerce_loop_columns');
	if (!function_exists('loop_columns')) 
	{
		function acoda_woocommerce_loop_columns() 
		{
			return 3; // 3 products per row
		}
	}

	function acoda_woocommerce_thumbnail( $value )
	{
		global $product;
		$add_to_cart_url = $product->add_to_cart_url();
		$add_to_cart_text = $product->add_to_cart_text();
		$product_url = get_the_permalink();
	
		echo "<div class='product_thumbnail_wrap'>";
			
			echo woocommerce_get_product_thumbnail();
			
			echo '<div class="acoda_product_wrap"><a href="'. esc_url( $product_url ) .'" class="action-icons link-icon"></a></div>';				
			
		echo "</div>";
	}	

	// Custom Cart Widget
	add_action( 'widgets_init', 'acoda_woocommerce_cart_widget', 15 );
	 
	function acoda_woocommerce_cart_widget() 
	{ 
	  if ( class_exists( 'WC_Widget_Cart' ) )
	  {
		unregister_widget( 'WC_Widget_Cart' );
		include_once( get_template_directory() . '/widgets/class-acoda-widget-cart.php' );
		register_widget( 'acoda_WC_Widget_Cart' );
	  }
	}

	/* ------------------------------------
	:: WOOCOMMERCE
	------------------------------------ */

	add_theme_support( 'woocommerce' );	

	add_filter('add_to_cart_fragments', 'acoda_woo_header_add_to_cart_fragment');
	
	function acoda_woo_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		
		ob_start();	?>
	 
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e('View your shopping cart', 'dynamix'); ?>">
			<span class="shop-cart-itemnum">
				<?php echo esc_html( sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'dynamix'), $woocommerce->cart->cart_contents_count) ); ?> - 
			</span>
			 <?php echo esc_html( $woocommerce->cart->get_cart_total() ); ?>
			
		</a>
		<?php
	
		$fragments['a.cart-contents'] = ob_get_clean();
	
		return $fragments;
	}

	/* ------------------------------------
	:: BBPRESS
	------------------------------------ */

	add_theme_support( 'bbpress' );
	
	// Breadcrumb Separator
	function acoda_bbp_breadcrumb_separator()
	{
		$sep = ' <span class="subbreak"><i class="fal fa-angle-right"></i></span> ';
		return $sep;
	}
	
	add_filter('bbp_breadcrumb_separator', 'acoda_bbp_breadcrumb_separator');

	// Blank Function
	add_filter( 'bbp_get_single_forum_description', 'acoda_bbp_return_blank' );
	add_filter( 'bbp_get_single_topic_description', 'acoda_bbp_return_blank' );
		
	function acoda_bbp_return_blank()
	{
		return '';
	}
	
	// Subscribe Link
	function acoda_bbp_subscribe_icon ( $args = array() )
	{
		$args['before'] = '';
		$args['subscribe'] = '<i class="fal fa-envelope"></i>'. esc_html('Subscribe', 'dynamix' );
		$args['unsubscribe'] = '<i class="fal fa-envelope"></i>'. esc_html( 'Unsubscribe', 'dynamix' );		
		
		return $args;
	}

	add_filter ('bbp_before_get_user_subscribe_link_parse_args','acoda_bbp_subscribe_icon') ;

	// Favorite Link
	function acoda_bbp_favorite_icon ( $args = array() )
	{
		$args['before'] = '';
		$args['favorite'] =  '<i class="fal fa-star"></i >'. esc_html('Favorite',  'dynamix' );
		$args['favorited'] = '<i class="fal fa-star"></i>'. esc_html('Favorited',  'dynamix' );
		
		return $args;
	}

	add_filter ('bbp_before_get_user_favorites_link_parse_args','acoda_bbp_favorite_icon') ;	

	// Admin Links
	function acoda_bbp_topic_admin_link( $args = array() )
	{
		$args['sep'] = '';		
		
		return $args;
	}
	
	add_filter( 'bbp_before_get_topic_admin_links_parse_args', 'acoda_bbp_topic_admin_link' );	

	// Admin Links
	function acoda_bbp_reply_admin_link( $args = array() )
	{
		$args['sep'] = '';		
		
		return $args;
	}
	
	add_filter( 'bbp_before_get_reply_admin_links_parse_args', 'acoda_bbp_reply_admin_link' );	

	// Tags
	function acoda_bbp_tags_icon( $args = array() )
	{
		$args['before'] = '<div class="bbp-topic-tags"><p><i class="fal fa-tag"></i>&nbsp;';		
		
		return $args;
	}
	
	add_filter( 'bbp_before_get_topic_tag_list_parse_args', 'acoda_bbp_tags_icon' );				
	

	/* ------------------------------------
	:: CUSTOM EXCERPT
	------------------------------------ */
	
	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt', 999  );
	add_filter( 'get_the_excerpt', 'acoda_custom_excerpt', 999  );	
			
	function acoda_custom_excerpt( $text = '' )
	{
		$raw_excerpt = $text;
		if ( '' == $text ) {
			$text = get_the_content('');
			$text = apply_filters('the_content', $text);
			$excerpt_length = apply_filters('excerpt_length', 50 );
			$excerpt_more = apply_filters('excerpt_more', '...' . '...');
			$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
			$text = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $text);  # strip shortcodes, keep shortcode content
			$text = '<p>'. $text .'</p>';
		}
		return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	}	

	/* ------------------------------------
	:: READ MORE
	------------------------------------ */
	
	add_filter('excerpt_more', 'acoda_readmore' );
	add_filter( 'the_content_more_link', 'acoda_readmore' );
	
	function acoda_readmore()
	{
		return '<a class="read-more" href="' . esc_url( get_permalink() ) . '">'. esc_html__( 'Continue reading', 'dynamix' ) .' <i class="fal fa-angle-right"></i></a>';
	}		
	
	/* ------------------------------------
	:: FONT ICONS
	------------------------------------ */	

	add_action( 'vc_base_register_front_css', 'vc_iconpicker_base_register_css_acoda' );
	add_action( 'vc_base_register_admin_css', 'vc_iconpicker_base_register_css_acoda' );	
	
	function vc_iconpicker_base_register_css_acoda() 
	{
		wp_register_style( 'nucleo-glyph', get_template_directory_uri() .'/css/font-icons/nucleo/glyph/css/nucleo-glyph.css', false );
		wp_register_style( 'nucleo-outline', get_template_directory_uri() .'/css/font-icons/nucleo/outline/css/nucleo-outline.css', false );
	}

	add_action( 'vc_backend_editor_enqueue_js_css', 'vc_iconpicker_editor_jscss_acoda_icons' );
	add_action( 'vc_frontend_editor_enqueue_js_css', 'vc_iconpicker_editor_jscss_acoda_icons' );

	function vc_iconpicker_editor_jscss_acoda_icons() 
	{
		wp_enqueue_style( 'nucleo-glyph' );	
		wp_enqueue_style( 'nucleo-outline' );		
	}		
		
	add_action( 'vc_enqueue_font_icon_element', 'vc_acoda_icons' );

	function vc_acoda_icons( $font ) 
	{
		switch ( $font ) {
			case 'fontawesome':
				wp_enqueue_style( 'font-awesome' );
				break;				
			case 'nucleo_glyph':
				wp_enqueue_style( 'nucleo-glyph' );
				break;
			case 'nucleo_outline':
				wp_enqueue_style( 'nucleo-outline' );
				break;				
			case 'typicons':
				wp_enqueue_style( 'vc_typicons' );
				break;
			case 'entypo':
				wp_enqueue_style( 'vc_entypo' );
				break;
			case 'linecons':
				wp_enqueue_style( 'vc_linecons' );
				break;
			case 'monosocial':
				wp_enqueue_style( 'vc_monosocialiconsfont' );
				break;
			default:
				do_action( 'vc_enqueue_font_icon_element', $font ); // hook to custom do enqueue style
		}
	}			
	

	// HEX TO RGB
	function acoda_html2rgb($color)
	{
		if ($color[0] == '#')
		{
			$color = substr($color, 1);
		}
		
		if (strlen($color) == 6)
		{
			list($r, $g, $b) = array(
				$color[0].$color[1],
				$color[2].$color[3],
				$color[4].$color[5]
			);
		}
		elseif (strlen($color) == 3)
		{
			list($r, $g, $b) = array(
				$color[0].$color[0],
				$color[1].$color[1],
				$color[2].$color[2]
			);
		}
		else
		{
			return false;
		}
	
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
	
		return $r.','.$g.','.$b;
	}

	function acoda_adjust_brightness($hex, $steps) 
	{
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max(-255, min(255, $steps));
	
		// Normalize into a six character long hex string
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3) {
			$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
		}
	
		// Split into three parts: R, G and B
		$color_parts = str_split($hex, 2);
		$return = '#';
	
		foreach ($color_parts as $color) {
			$color   = hexdec($color); // Convert to decimal
			$color   = max(0,min(255,$color + $steps)); // Adjust color
			$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
		}
	
		return $return;
	}	


	// SOCIAL LINK CONVERSION
	function acoda_social_link($socialitem)
	{ 
		$permalink = '';
		
		if( is_page() || is_single() ) 
		{
			$permalink = get_permalink();
		}
		elseif( is_category() )
		{
			$category = get_the_category();
			$permalink = get_category_link( $category[0] );
		}
		
		$title = get_the_title();
		$url = esc_url( home_url('/') );
	
		$find = array('[get_permalink]','[get_the_title]','[get_blogurl]');
		$replace = array( $permalink, $title, $url );
		$socialitem = str_replace($find,$replace, $socialitem);
	
		return htmlspecialchars ( $socialitem );
	}

	

	// BUILD SKIN PRESETS
	function acoda_skin_presets()
	{ 
		require get_template_directory() .'/lib/admin/skin-presets.php'; // skin data
		$skin_data_ids  = maybe_unserialize(get_option('skins_'. ACODA_THEME_PREFIX .'_ids'));
	 
		if( !empty($skin_data_ids) )
		{
			foreach( $skin_preset_ids as $skin_preset_id => $value )
			{
				if ( !preg_match("/\b". $skin_preset_id ."\b/", $skin_data_ids) )
				{
					delete_option( 'skins_'. ACODA_THEME_PREFIX .'_ids' );
					update_option( 'skins_'. ACODA_THEME_PREFIX .'_ids', $skin_data_ids . $skin_preset_id .',' );							

					$skin_settings = json_decode($value, true);
					
					if( $skin_settings !== false )
					{
						update_option( ACODA_THEME_PREFIX .'_'. $skin_preset_id,$skin_settings );			
					}					
				}
			}
		}
		else // no previous skin data present
		{ 		
			foreach( $skin_preset_ids as $skin_preset_id => $value )
			{
				$skin_data_ids .= $skin_preset_id .',';	

				$skin_settings = json_decode($value, true);

				if( $skin_settings !== false )
				{
					update_option( ACODA_THEME_PREFIX .'_'. $skin_preset_id,$skin_settings );			
				}			
			}
	 
			update_option( 'skins_'. ACODA_THEME_PREFIX .'_ids', $skin_data_ids);	
		}
		
		if( get_option('acoda_dynamix_skin') == '' )
		{
			update_option('acoda_dynamix_skin', 'Classic');
		}
	} 


	/* ------------------------------------
	:: TINYMCE EXTENSION
	------------------------------------ */
 
	function acoda_mce_editor_buttons( $buttons ) {
	   array_unshift( $buttons, 'styleselect' );
	   return $buttons;
	}
	
	add_filter('mce_buttons', 'acoda_mce_editor_buttons');
	
	function acoda_mce_before_init( $init ) {
	
		$style_formats = array(  
			array(  
				'title' => 'Text Link Color',  
				'inline' => 'span',  
				'classes' => 'acoda_link_color',
			), 
			array(  
				'title' => 'Text Link Hover Color',  
				'inline' => 'span',  
				'classes' => 'acoda_link_hover_color',
			), 			
			array(  
				'title' => 'Highlight Link Color',  
				'inline' => 'span',  
				'classes' => 'highlight one',
			),
			array(  
				'title' => 'Highlight Link Hover Color',  
				'inline' => 'span',  
				'classes' => 'highlight two',
			),			
			array(  
				'title' => 'Highlight Shaded',  
				'inline' => 'span',  
				'classes' => 'highlight three',
			),
			array(  
				'title' => 'Highlight Black',  
				'inline' => 'span',  
				'classes' => 'highlight four',
			), 			
			array(  
				'title' => 'Light Font Weight',  
				'inline' => 'span',  
				'classes' => 'light-font-weight',
			),	
			array(  
				'title' => 'Heavy Font Weight',  
				'inline' => 'span',  
				'classes' => 'heavy-font-weight',
			),			
			array(  
				'title' => 'Drop Cap',  
				'inline' => 'span',  
				'classes' => 'dropcap',
			),			 			 						
			array(  
				'title' => 'Medium Text',  
				'inline' => 'span',  
				'classes' => 'medium-text',
			),
			array(  
				'title' => 'Big Text',  
				'inline' => 'span',  
				'classes' => 'big-text',
			),
			array(  
				'title' => 'Large Text',  
				'inline' => 'span',  
				'classes' => 'large-text',
			),			
			array(  
				'title' => 'Extra Large Text',  
				'inline' => 'span',  
				'classes' => 'xlarge-text',
			),
			array(  
				'title' => 'Supersize Text',  
				'inline' => 'span',  
				'classes' => 'supersize-text',
			),
			array(  
				'title' => 'Text Shadow',  
				'inline' => 'span',  
				'classes' => 'text-shadow',
			),
			array(  
				'title' => 'White Text',  
				'inline' => 'span',  
				'classes' => 'white-text',
			)							
		);  

	   $init['style_formats'] = json_encode( $style_formats );
	   return $init;
	}
	
	add_filter('tiny_mce_before_init', 'acoda_mce_before_init');	 
	 
	
	/* ------------------------------------
	:: acoda tinymce shortcodes							      
	--------------------------------------- */

	add_action( 'admin_init', 'acoda_add_tinymce' );
	
	function acoda_add_tinymce()
	{
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) )
		{
			add_filter( 'mce_external_plugins', 'acoda_add_tinymce_plugin' );
			add_filter( 'mce_buttons', 'acoda_add_tinymce_button' );
		}
    }

    // inlcude the js for tinymce
    function acoda_add_tinymce_plugin( $plugin_array )
	{
        $plugin_array['acoda_shortcodes'] = get_template_directory_uri() . '/lib/admin/js/tinymce/tinymce_shortcodes.js';
        return $plugin_array;
    }

    // Add the button key for address via JSs
    function acoda_add_tinymce_button( $buttons )
	{
        array_push( $buttons, 'acoda_shortcodes' );
        return $buttons;
    }

	add_editor_style();
	
	

	/* ------------------------------------
	:: OPTIONS UPDATE
	------------------------------------ */
	
	update_option( 'acoda_theme', 'DynamiX' );
	
	// Update 5.0 Customizer Options
	if( get_option( 'dynamix_theme' ) != '7' && is_admin() && get_option( 'themeva' ) != '' )
	{
		$pre_options = get_option( 'themeva' );
		$options = get_option( 'dynamix_options' );

		
		if( !empty( $pre_options['max_sitewidth'] ) )
		{
			$options['max_site_width'] = $pre_options['max_sitewidth'];
		}
		
		if( !empty( $pre_options['pagelayout'] ) )
		{
			$options['pagelayout'] = $pre_options['pagelayout'];
		}	
		
		if( !empty( $pre_options['sidebars_num'] ) )
		{
			$options['sidebars_num'] = $pre_options['sidebars_num'];
		}	
		
		if( !empty( $pre_options['header_height'] ) )
		{
			$options['header_height'] = $pre_options['header_height'];
		}	
		
		if( !empty( $pre_options['branding_url'] ) )
		{
			$options['branding_url']['url'] = $pre_options['branding_url'];
		}	
		
		if( !empty( $pre_options['branding_2x'] ) )
		{
			$options['branding_2x']['url'] = $pre_options['branding_2x'];
		}
		
		if( !empty( $pre_options['branding_alignment'] ) )
		{
			if( $pre_options['branding_alignment'] == 'center' )
			{
				$options['header_style'] = 'stacked';
				$options['branding_alignment_stacked'] = $pre_options['branding_alignment'];
			}
			else
			{
				$options['header_style'] = 'inline';
				$options['branding_alignment_inline'] = $pre_options['branding_alignment'];				
			}
		}
		
		if( !empty( $pre_options['menu_alignment'] ) )
		{
			if( $pre_options['menu_alignment'] == 'center' )
			{
				$options['header_style'] = 'stacked';
				$options['menu_alignment_stacked'] = $pre_options['menu_alignment'];
			}
			else
			{
				$options['header_style'] = 'inline';
				$options['menu_alignment_inline'] = $pre_options['menu_alignment'];				
			}
		}	
		
		if( !empty( $pre_options['footer_columns_num'] ) )
		{
			$options['footer_columns_num'] = $pre_options['footer_columns_num'];
		}	
		
		if( !empty( $pre_options['arhlayout'] ) )
		{
			$options['bloglayout'] = $pre_options['arhlayout'];
		}	
		
		if( !empty( $pre_options['archcolone'] ) )
		{
			$options['blogcolone'] = $pre_options['archcolone'];
		}	
		
		if( !empty( $pre_options['archcoltwo'] ) )
		{
			$options['blogcoltwo'] = $pre_options['archcoltwo'];
		}			
		
		if( !empty( $pre_options['portfoliopage'] ) )
		{
			$options['portfoliopage'] = $pre_options['portfoliopage'];
		}			
		
		// Update Options
		update_option( 'dynamix_options', $options );		

		// Skin
		if( get_option('default_skin') != '' )
		{
			update_option( 'acoda_dynamix_skin', get_option('default_skin') );
		}		
	
		
		$args = array(
			'posts_per_page'   => -1,
			'post_type' => 'any',
			'suppress_filters' => true 
		);

		$posts_array = new WP_Query( $args );
		
		

		 while($posts_array->have_posts()) : $posts_array->the_post();
		 
			if( get_post_meta( get_the_ID(), '_cmb_displaytitle', true ) != '')
			{
				update_post_meta( get_the_ID(), 'displaytitle', false );
			}

			if( get_post_meta( get_the_ID(), '_cmb_pagetitle', true ) != '')
			{
				update_post_meta( get_the_ID(), 'pagetitle', get_post_meta( get_the_ID(), '_cmb_pagetitle', true ) );
			}	

			if( get_post_meta( get_the_ID(), '_cmb_pagesubtitle', true ) != '')
			{
				update_post_meta( get_the_ID(), 'pagesubtitle', get_post_meta( get_the_ID(), '_cmb_pagesubtitle', true ) );
			}
		
			if( get_post_meta( get_the_ID(), '_cmb_hidebreadcrumbs', true ) != '')
			{
				update_post_meta( get_the_ID(), 'breadcrumb', 0 );
			}		
		
			if( get_post_meta( get_the_ID(), '_cmb_layout', true ) != '')
			{
				update_post_meta( get_the_ID(), 'pagelayout', get_post_meta( get_the_ID(), '_cmb_layout', true ) );
			}	
		
			if( get_post_meta( get_the_ID(), '_cmb_sidebar_one', true ) != '')
			{
				update_post_meta( get_the_ID(), 'sidebarone', get_post_meta( get_the_ID(), '_cmb_sidebar_one', true ) );
			}
		
			if( get_post_meta( get_the_ID(), '_cmb_sidebar_two', true ) != '')
			{
				update_post_meta( get_the_ID(), 'sidebartwo', get_post_meta( get_the_ID(), '_cmb_sidebar_two', true ) );
			}	
		
			if( get_post_meta( get_the_ID(), '_cmb_customskin', true ) != '')
			{
				update_post_meta( get_the_ID(), 'theme_skin', get_post_meta( get_the_ID(), '_cmb_customskin', true ) );
			}		
		
		endwhile;
			
		
		
		// Skin Settings	
		$skin_ids = explode(',', rtrim( get_option('skins_'. ACODA_THEME_PREFIX .'_ids'), ',' ) );
		
		foreach( $skin_ids as $skin_id )
		{
			$pre_skin = get_option( 'skin_data_'. $skin_id );
			$new_skin = array();
			
			$skin_preset_ids = array(
				'Classic',
				'Couture',
				'Horizon',
				'Lakeside',
				'Rising',	
			);		
			
			
			if ( ! array_key_exists( $skin_id, $skin_preset_ids ))
  			{
				// General 	
				if( !empty( $pre_skin['layer5_color_opt_pri'] ) )
				{
					$new_skin['body_color']['color'] = $pre_skin['layer5_color_opt_pri'];
				}

				if( !empty( $pre_skin['skin_id_background_font_color'] ) )
				{
					$new_skin['body_font_color']['color'] = $pre_skin['skin_id_background_font_color'];
				}	

				if( !empty( $pre_skin['skin_id_background_link_color'] ) )
				{
					$new_skin['body_link_color']['color'] = $pre_skin['skin_id_background_link_color'];
				}	

				if( !empty( $pre_skin['skin_id_background_linkhover_color'] ) )
				{
					$new_skin['body_link_color_hover']['color'] = $pre_skin['skin_id_background_linkhover_color'];
				}				

				// Header 	
				if( !empty( $pre_skin['layer1_color_opt_pri'] ) )
				{
					$new_skin['header_color']['color'] = $pre_skin['layer1_color_opt_pri'];
				}

				if( !empty( $pre_skin['skin_id_header_font_color'] ) )
				{
					$new_skin['header_font']['color'] = $pre_skin['skin_id_header_font_color'];
				}	

				if( !empty( $pre_skin['skin_id_header_link_color'] ) )
				{
					$new_skin['header_link_color']['color'] = $pre_skin['skin_id_header_link_color'];
				}	

				if( !empty( $pre_skin['skin_id_header_linkhover_color'] ) )
				{
					$new_skin['header_link_color_hover']['color'] = $pre_skin['skin_id_header_linkhover_color'];
				}	
				
				// Submenu
				if( !empty( $pre_skin['skin_id_submenu_link_color'] ) )
				{
					$new_skin['submenu_link_color']['color'] = $pre_skin['skin_id_submenu_link_color'];
				}			
				else
				{
					$new_skin['submenu_link_color']['color'] = $pre_skin['skin_id_background_font_color'];
				}

				// Transparent Header 				
				if( !empty( $pre_skin['skin_id_floatingheader_font_color'] ) )
				{
					$new_skin['transparent_header_font_color']['color'] = $pre_skin['skin_id_floatingheader_font_color'];
					$new_skin['transparent_header_link_color']['color'] = $pre_skin['skin_id_floatingheader_font_color'];
				}	

				if( !empty( $pre_skin['skin_id_floatingheader_linkhover_color'] ) )
				{
					$new_skin['transparent_header_link_hover_color']['color'] = $pre_skin['skin_id_floatingheader_linkhover_color'];
				}				

				// Footer 	
				if( !empty( $pre_skin['layer3_color_opt_pri'] ) )
				{
					$new_skin['footer_color']['color'] = $pre_skin['layer3_color_opt_pri'];
				}

				if( !empty( $pre_skin['skin_id_footer_font_color'] ) )
				{
					$new_skin['footer_font']['color'] = $pre_skin['skin_id_footer_font_color'];
				}	

				if( !empty( $pre_skin['skin_id_footer_link_color'] ) )
				{
					$new_skin['footer_link_color']['color'] = $pre_skin['skin_id_footer_link_color'];
				}	

				if( !empty( $pre_skin['skin_id_footer_linkhover_color'] ) )
				{
					$new_skin['footer_link_color_hover']['color'] = $pre_skin['skin_id_footer_linkhover_color'];
				}
				
				// Preset Skins
				if( $skin_id == 'Green' )
				{
					$new_skin['header_color']['color'] = $new_skin['footer_color']['color'] = '#26C4BF';
					$new_skin['subheader_font']['color']  = $pre_skin['skin_id_background_font_color'];
					$new_skin['subheader_link_color']['color']  = $pre_skin['skin_id_background_link_color'];
				}
				
				if( $skin_id == 'Blue' )
				{
					$new_skin['header_color']['color'] = $new_skin['footer_color']['color'] = '#5AA1E3';
					$new_skin['subheader_font']['color']  = $pre_skin['skin_id_background_font_color'];
					$new_skin['subheader_link_color']['color']  = $pre_skin['skin_id_background_link_color'];
				}
				
				if( $skin_id == 'MidnightBlue' )
				{
					$new_skin['header_color']['color'] = $new_skin['footer_color']['color'] = '#27292F';
					$new_skin['subheader_font']['color']  = $pre_skin['skin_id_background_font_color'];
					$new_skin['subheader_link_color']['color']  = $pre_skin['skin_id_background_link_color'];
				}
				
				if( $skin_id == 'Orange' )
				{
					$new_skin['header_color']['color'] = $new_skin['footer_color']['color'] = '#F99463';
					$new_skin['subheader_font']['color']  = $pre_skin['skin_id_background_font_color'];
					$new_skin['subheader_link_color']['color']  = $pre_skin['skin_id_background_link_color'];
				}	
				
				if( $skin_id == 'Red' )
				{
					$new_skin['header_color']['color'] = $new_skin['footer_color']['color'] = '#E25755';
					$new_skin['subheader_font']['color']  = $pre_skin['skin_id_background_font_color'];
					$new_skin['subheader_link_color']['color']  = $pre_skin['skin_id_background_link_color'];
				}			

				// Update Skin
				if( !empty( $new_skin ) )
				{
					update_option( ACODA_THEME_PREFIX .'_'. $skin_id, $new_skin );
				}	
			}
		}
		
		update_option( 'dynamix_theme', '7' );
	
	}		