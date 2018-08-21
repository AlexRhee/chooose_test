<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "dynamix_options";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

	function AcodaAdminFont() {
		// Uncomment this to remove elusive icon from the panel completely
		wp_deregister_style( 'redux-elusive-icon' );
		wp_deregister_style( 'redux-elusive-icon-ie7' );
	 
		wp_register_style(
			'fontawesome',
			get_template_directory_uri() .'/css/font-icons/fontawesome/css/fontawesome-all.min.css',
			array(),
			time(),
			'all'
		);  
		wp_enqueue_style( 'fontawesome' );
	}
	
	
	add_action( 'redux/page/'. $opt_name .'/enqueue', 'AcodaAdminFont' );	

	// Add Acoda Admin CSS
	function AcodaAdminCSS() {
	  wp_dequeue_style( 'redux-admin-css' );
	  wp_register_style(
		'acoda-admin-css',
		get_template_directory_uri() . '/lib/admin/assets/css/acoda-redux-admin.css',
		array( 'farbtastic' ),
		time(),
		'all'
	  );    
	  wp_enqueue_style('acoda-admin-css');
				
	}

	function AcodaAdminScript() {
	 
		wp_register_script(
			'acoda-redux-admin',
			get_template_directory_uri() . '/lib/admin/assets/js/acoda-redux-admin.js',
			array(),
			time(),
			'all'
		);  
		
		$demo_data = acoda_demo_data();
		
		$data_array = array(
			'opt_name' => 'dynamix_options', 
			'default_skin' => 'Classic',
			'demo_data' => $demo_data
		);
		
	
		
		wp_localize_script( 'acoda-redux-admin', 'acoda_redux', $data_array );		
		wp_enqueue_script( 'acoda-redux-admin' );
	}	
	
	add_action( 'redux/page/'. $opt_name .'/enqueue', 'AcodaAdminCSS' );	
	add_action( 'redux/page/'. $opt_name .'/enqueue', 'AcodaAdminScript' );

    $args = array(
        'opt_name' => $opt_name,
        'use_cdn' => TRUE,
        'display_name' => $theme->get( 'Name' ),
		'dev_mode' => FALSE,
		'page_slug' => 'dynamix_options',
        'display_version' => $theme->get( 'Version' ),
        'page_title' => 'DynamiX',
        'update_notice' => FALSE,
		'metaboxes_save_defaults' => FALSE,
        'admin_bar' => TRUE,
        'menu_type' => 'submenu',
		'page_priority' => 4,
        'menu_title' => 'Theme Options',
        'allow_sub_menu' => TRUE,
        'customizer' => TRUE,
		//'async_typography' => TRUE,
		'disable_tracking' => TRUE,
        'default_mark' => '*',
        'hints' => array(
            'icon_position' => 'right',
            'icon_color' => 'lightgray',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
		'default_mark' => '',
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
		'show_options_object' => false,
        'database' => 'options',
		'menu_icon' =>  get_template_directory_uri() . '/lib/admin/assets/images/acoda-16x16.png',
        'transient_time' => '3600',
        'network_sites' => TRUE,
		'templates_path' => dirname(__FILE__).'/acoda-redux-templates/panel',
    );

    Redux::setArgs( $opt_name, $args );


	if ( ! class_exists( 'Acoda_Redux_Custom_Fields' ) ) {
		require_once( dirname( __FILE__ ) . '/class-acoda-redux-addons.php' );
		new Acoda_Redux_Addons();
	}

	function acoda_demo_data()
	{
		$allowed_tags = wp_kses_allowed_html();

		// Demo Data
		$demo_data = array( 
			'message' =>  wp_kses( __('WARNING:||It\'s best to install demos on a fresh install of WordPress. This will install pages / posts and replace current Skin / Theme Options. DO NOT refresh the page, unless exceeds 5 minutes.||ACTIVATE PLUGINS:||Please ensure the following plugins are active before installing the demo.||To install plugins, goto Appearance / Install Plugins.||', 'dynamix'), $allowed_tags ),
			'wait' =>  wp_kses( __('<span class="dashicons dashicons-info"></span> <strong>Please wait</strong>, this may take a few minutes. Depending on your server, If this is not complete after 5 minutes, you may need to click re-click the "Install" button once more.', 'dynamix'), $allowed_tags ),	
			'demos' => array(			
				'apparel' => array(
					'name' => 'Apparel',
					'reqplugins' => 'WPBakery Page Builder|Contact Form 7|WooCommerce',
					'url' => 'http://dynamix.acoda.com/apparel/'
				),			
				'classic' => array(
					'name' => 'Classic',
					'reqplugins' => 'WPBakery Page Builder|Revolution Slider|Contact Form 7|Portfolio|ACODA Typewriter|ACODA Counters|Acoda Pricing Table|WooCommerce',
					'url' => 'http://dynamix.acoda.com/classic/'
				),
				'capture' => array(
					'name' => 'Capture',
					'reqplugins' => 'WPBakery Page Builder|Contact Form 7',
					'url' => 'http://dynamix.acoda.com/capture/'
				),	
				'founder' => array(
					'name' => 'Founder',
					'reqplugins' => 'WPBakery Page Builder|Contact Form 7|Acoda Pricing Table',
					'url' => 'http://dynamix.acoda.com/founder/'
				),				
				'horizon' => array(
					'name' => 'Horizon',
					'reqplugins' => 'WPBakery Page Builder|Revolution Slider|Contact Form 7',
					'url' => 'http://dynamix.acoda.com/horizon/'
				),
				'couture' => array(
					'name' => 'Couture',
					'reqplugins' => 'WPBakery Page Builder|Contact Form 7',
					'url' => 'http://dynamix.acoda.com/couture/'
				),
				'lakeside' => array(
					'name' => 'Lakeside',
					'reqplugins' => 'WPBakery Page Builder|Revolution Slider|Contact Form 7',
					'url' => 'http://dynamix.acoda.com/lakeside/',
				),	
				'rising' => array(
					'name' => 'Rising',
					'reqplugins' => 'WPBakery Page Builder|Revolution Slider|Contact Form 7|WooCommerce|Awesome Twitter Feeds',
					'url' => 'http://dynamix.acoda.com/rising/'
				),
				'techbyte' => array(
					'name' => 'Techbyte',
					'reqplugins' => 'WPBakery Page Builder|Acoda Post Blocks',
					'url' => 'http://dynamix.acoda.com/techbyte/'
				),	
				'wanderlust' => array(
					'name' => 'Wanderlust',
					'reqplugins' => 'WPBakery Page Builder|Acoda Post Blocks|Contact Form 7',
					'url' => 'http://dynamix.acoda.com/wanderlust/'
				),	
				'xesign' => array(
					'name' => 'Xesign',
					'reqplugins' => 'WPBakery Page Builder|Contact Form 7',
					'url' => 'http://dynamix.acoda.com/xesign/'
				),				
			)
		);
		
		return $demo_data;
	}

	
	function acoda_skin_update() {
		
		$skin = ( !empty( $_POST['skin'] ) ? $_POST['skin'] : '' );
		update_option( 'acoda_dynamix_skin', $skin );
		
		
		die();
	}

	add_action( 'wp_ajax_nopriv_acoda_skin_update', 'acoda_skin_update' );
	add_action( 'wp_ajax_acoda_skin_update', 'acoda_skin_update' );	

	function acoda_skin_new() {
		
		$skin = ( !empty( $_POST['skin'] ) ? $_POST['skin'] : '' );
		
		update_option( 'acoda_dynamix_skin', $skin );
		update_option( 'skins_'. get_option('acoda_theme') .'_ids', get_option('skins_'. get_option('acoda_theme') .'_ids') . $skin . ',' ); 
		
		die();
	}

	add_action( 'wp_ajax_nopriv_acoda_skin_new', 'acoda_skin_new' );
	add_action( 'wp_ajax_acoda_skin_new', 'acoda_skin_new' );		

	function acoda_skin_duplicate() {
		
		$duplicate_skin = get_option( 'acoda_dynamix_skin' );
		$acoda_skin = get_option( 'dynamix_'. $duplicate_skin );
		
		$skin = ( !empty( $_POST['skin'] ) ? $_POST['skin'] : '' );
		
		$acoda_skin['opt_name'] = 'dynamix_'. $skin;
		
		update_option( 'dynamix_'. $skin, $acoda_skin );
		update_option( 'acoda_dynamix_skin', $skin );
		
		update_option( 'skins_'. get_option('acoda_theme') .'_ids', get_option('skins_'. get_option('acoda_theme') .'_ids') . $skin . ',' ); 
		
		die();
	}

	add_action( 'wp_ajax_nopriv_acoda_skin_duplicate', 'acoda_skin_duplicate' );
	add_action( 'wp_ajax_acoda_skin_duplicate', 'acoda_skin_duplicate' );		
		
	function acoda_skin_delete() {
		
		$delete_skin = ( !empty( $_POST['skin'] ) ? $_POST['skin'] : '' );
		
		if( !empty( $delete_skin ) )
		{
			delete_option( 'dynamix_'. $delete_skin );
			
			$skin_ids = str_replace( $delete_skin.',','', get_option( 'skins_'. get_option('acoda_theme') .'_ids' ) );
			update_option( 'skins_'. get_option('acoda_theme') .'_ids', $skin_ids  ); 
		
			$skin_array = explode(',', $skin_ids );
			
			// Set Default
			if( $delete_skin == get_option( 'acoda_dynamix_skin') )
			{
				if( $delete_skin == 'Classic' )
				{
					$skin = $skin_array[0];
				}
				else
				{
					$skin = 'Classic';
				}
				
				update_option( 'acoda_dynamix_skin', $skin );
			}
			else
			{
				$skin = get_option( 'acoda_dynamix_skin');
			}
			
			echo $skin;
		}
		
		die();
	}

	add_action( 'wp_ajax_nopriv_acoda_skin_delete', 'acoda_skin_delete' );
	add_action( 'wp_ajax_acoda_skin_delete', 'acoda_skin_delete' );			
		


	$acoda_skin = get_option('acoda_dynamix_skin');

	if( !empty( $acoda_skin ) )
	{
		$skin = ( !empty( $acoda_skin ) ? $acoda_skin : 'Classic');	

		$skin_ids = explode(',', rtrim( get_option('skins_'. get_option('acoda_theme') .'_ids'), ',' ) );

		$skin_id_array = array();

		foreach( $skin_ids as $skin_id )
		{
			$skin_id_array[$skin_id] = $skin_id;
		}		


		add_action( 'redux/page/dynamix_'. $skin .'/enqueue', 'AcodaAdminCSS' );
		add_action( 'redux/page/dynamix_'. $skin .'/enqueue', 'AcodaAdminFont' );
		add_action( 'redux/page/dynamix_'. $skin .'/enqueue', 'AcodaAdminScript' );

		$argsSkin = array(
			'opt_name' => 'dynamix_'. $skin,
			'use_cdn' => TRUE,
			'display_name' => 'Skin Editor',
			'dev_mode' => FALSE,
			'disable_tracking' => TRUE,
			'class' => 'acoda-skin-customizer',
			'page_slug' => 'dynamix_'. $skin,
			'display_version' => $skin,
			'page_title' => 'Skin Editor',
			'update_notice' => TRUE,
			'admin_bar' => TRUE,
			'menu_type' => 'submenu',
			'page_priority' => 4,
			'menu_title' => 'Skin Editor',
			'allow_sub_menu' => TRUE,
			'async_typography' => TRUE,
			'customizer' => TRUE,
			'default_mark' => '*',
			'hints' => array(
				'icon_position' => 'right',
				'icon_color' => 'lightgray',
				'icon_size' => 'normal',
				'tip_style' => array(
					'color' => 'light',
				),
				'tip_position' => array(
					'my' => 'top left',
					'at' => 'bottom right',
				),
				'tip_effect' => array(
					'show' => array(
						'duration' => '500',
						'event' => 'mouseover',
					),
					'hide' => array(
						'duration' => '500',
						'event' => 'mouseleave unfocus',
					),
				),
			),
			'output' => TRUE,
			'output_tag' => TRUE,
			'default_mark' => '',
			'settings_api' => TRUE,
			'cdn_check_time' => '1440',
			'compiler' => TRUE,
			'page_permissions' => 'manage_options',
			'save_defaults' => TRUE,
			'show_import_export' => TRUE,
			'show_options_object' => false,
			'database' => 'options',
			'menu_icon' =>  get_template_directory_uri() . '/lib/admin/assets/images/acoda-16x16.png',
			'transient_time' => '3600',
			'network_sites' => TRUE,
			'templates_path' => dirname(__FILE__).'/acoda-redux-templates/panel',
		);

		Redux::setArgs( 'dynamix_'. $skin, $argsSkin );
		
		function acoda_skin_classes( $type )
		{
			switch( $type )
			{		
				case 'body_element_color':

					$css = '
					.skinset-background input[type],
					.skinset-background select,
					.skinset-background textarea,
					.skinset-background pre,
					.skinset-background code';

					if( class_exists( 'bbPress' ) )
					{
						$css .='
						.skinset-background #bbpress-forums .hentry,
						.skinset-background #bbpress-forums .bbp-header,
						.skinset-background #bbpress-forums .bbp-body .bbp-meta,
						.skinset-background div.bbp-template-notice, 
						.skinset-background div.indicator-hint,
						.skinset-background .bbp-pagination-links a,
						.skinset-background .bbp-pagination-links span.current,
						';				
					}	

					if( class_exists( 'woocommerce' ) )
					{
						$css .='
						.skinset-background .woocommerce-error,
						.skinset-background .woocommerce-info,
						.skinset-background #payment div.payment_box,
						.skinset-background .woocommerce-tabs li,
						.skinset-background .woocommerce-message,
						.skinset-background #reviews #comments ol.commentlist li .comment-text,
						';
					}


					$css .= '	
					.skinset-background table thead tr,	
					.skinset-background table tr:nth-child(even),
					.skinset-background fieldset legend,
					.skinset-background input.input-text,
					.skinset-background .frame .gridimg-wrap .img,
					.skinset-background .wpb_video_widget.frame,
					.skinset-background .row.custom-row-inherit,
					.skinset-background .splitter ul li.active,
					.skinset-background nav.pagination .page-numbers,
					.skinset-background .wpb_call_to_action,
					.skinset-background .vc_progress_bar .vc_single_bar,
					.skinset-background .zoomflow .controlsCon > .arrow-left,
					.skinset-background .zoomflow .controlsCon > .arrow-right,	
					.skinset-background .gallery-caption,
					.skinset-background .socialicons ul li a,
					.skinset-background span.tooltip,
					.skinset-background .comments-value,
					.skinset-background #content.boxed article.hentry,
					.skinset-background .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-background .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-flat,
					.skinset-background .vc_icon_element-background.vc_icon_element-background-color-skin_element,
					.skinset-background .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-background .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-background .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-tab>a,
					.skinset-background .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-background .vc_tta-color-shaded_color.vc_tta-accordion.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels,
					.skinset-background .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-background .vc_message_box-3d.vc_color-shaded_color,
					.skinset-background .vc_message_box-3d.vc_color-shaded_color,
					.skinset-background .vc_message_box-solid.vc_color-shaded_color,
					.skinset-background .vc_message_box-standard.vc_color-shaded_color,
					.skinset-background .vc_message_box-solid-icon.vc_color-shaded_color .vc_message_box-icon,
					.skinset-background .screen-reader-text:focus,
					.skinset-background .select2-container--default .select2-selection--single
					';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;

				// Body Element Color Border
				case 'body_element_color_border':			

					$css = '
					.skinset-background #payment div.payment_box:after,
					.skinset-background .woocommerce-tabs ul.tabs li.active:after,
					.skinset-background .type-topic .bbp-meta:before,
					.skinset-background #reviews #comments ol.commentlist li .comment-text:after,
					.skinset-background .comments-value:after,
					.skinset-background .single_variation_wrap .single_variation:after
					';				

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;						

				break;

				// Body Element Border
				case 'body_element_border':

					$css = '
					.skinset-background input[type],
					.skinset-background select,
					.skinset-background textarea,
					.skinset-background pre,
					.skinset-background code';

					if( class_exists( 'bbPress' ) )
					{
						$css .='
						.skinset-background #bbpress-forums .hentry,
						.skinset-background #bbpress-forums .bbp-header,
						.skinset-background li.bbp-body .hentry,
						.skinset-background .type-topic .bbp-meta:after,
						.skinset-background #bbpress-forums .bbp-body .bbp-meta,
						.skinset-background div.bbp-template-notice, 
						.skinset-background div.indicator-hint,
						.skinset-background #bbpress-forums code,
						.skinset-background #bbpress-forums .bbp-forums-list,
						.skinset-background .bbp-pagination-links a,
						.skinset-background .bbp-pagination-links span.current,						
						';
					}	
								

					if( class_exists( 'woocommerce' ) )
					{
						$css .='
						.skinset-background .shop-cart .shopping-cart-wrapper,				
						.skinset-background #payment ul.payment_methods,
						.skinset-background table.shop_table td,
						.skinset-background table.shop_table tfoot td,
						.skinset-background table.shop_table,
						.skinset-background table.shop_table tfoot th,
						.skinset-background .cart-collaterals .cart_totals table,
						.skinset-background .cart-collaterals .cart_totals tr td,
						.skinset-background .cart-collaterals .cart_totals tr th,
						.skinset-background #payment div.payment_box,
						.skinset-background #payment div.payment_box:before,
						.skinset-background .woocommerce form.login,
						.skinset-background .woocommerce-page form.login,
						.skinset-background form.checkout_coupon,
						.skinset-background .woocommerce form.register,
						.skinset-background .woocommerce-page form.register,
						.skinset-background ul.product_list_widget li,
						.skinset-background .quantity input.qty,
						.skinset-background .coupon #coupon_code,	
						.skinset-background .woocommerce-tabs ul.tabs li,
						.skinset-background .woocommerce-tabs ul.tabs li.active:before,
						.skinset-background #reviews #comments ol.commentlist li .comment-text,
						.skinset-background #reviews #comments ol.commentlist li .comment-text:before,
						.skinset-background .single_variation_wrap .single_variation:before,
						.skinset-background .woocommerce-message, 
						.skinset-background .woocommerce-error,
						.skinset-background .woocommerce-info,	
						';
					}			

					$css .='
					.skinset-background .dock-tab-wrapper .pointer,		
					.skinset-background .sub-header,
					.skinset-background legend,
					.skinset-background input.input-text,
					.skinset-background #content article.hentry,
					.skinset-background .frame .gridimg-wrap .img,
					.skinset-background .wpb_video_widget.frame,
					.skinset-background .wpb_call_to_action,
					.skinset-background img.avatar,
					.skinset-background .tagcloud a,
					.skinset-background .vc_sep_color_skin_element .vc_sep_line, 
					.skinset-background hr,
					.skinset-background #lang_sel_list li,
					.skinset-background .commentlist .children li.comment,
					.skinset-background .commentlist > li.comment,
					.skinset-background .splitter ul li.active,
					.skinset-background .vc_progress_bar .vc_single_bar,
					.skinset-background table tr,
					.skinset-background .gallery-caption,
					.skinset-background ul.post-metadata-wrap,
					.skinset-background .socialicons ul li a,
					.skinset-background nav.pagination .page-numbers,
					.skinset-background .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-background .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-outline,
					.skinset-background .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-background .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-background .vc_tta-tabs.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-tab>a,
					.skinset-background .vc_tta.vc_general.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-panels,
					.skinset-background .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::after,
					.skinset-background .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::before,
					.skinset-background .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-background .comments-wrapper .comments-wrap,
					.skinset-background .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-background .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-background .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-background .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-background .vc_message_box-outline.vc_color-shaded_color,
					.skinset-background .vc_message_box-standard.vc_color-shaded_color,
					.skinset-background .vc_message_box-solid-icon.vc_color-shaded_color,
					.skinset-background .vc_message_box-3d.vc_color-shaded_color,
					.skinset-background .wpb_wrapper .vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-outline.vc_icon_element-background-color-skin_element,
					.skinset-background .select2-container--default .select2-selection--single';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;						

				case 'body_button_color':

					$css = '
					.skinset-background button,
					.skinset-background #container  input[type="button"],
					.skinset-background submit,
					.skinset-background #container  input[type="submit"],
					.skinset-background #container a.button,
					.skinset-background button.button,
					.skinset-background .button-wrap .button.link_color a,
					.skinset-background input.button,
					.skinset-background #review_form #submit,
					.skinset-background #related_posts .related-post-cat a,
					.skinset-background .vc_toggle_title h4:before,
					.skinset-background.woocommerce-page span.onsale,
					.skinset-background #container .vc_tta-tabs.vc_tta-color-button_color .vc_tta-tab>a,				
					.skinset-background .vc_general.vc_btn3-color-link_color,
					.skinset-background .dir-nav-icon-two .page-animate-nav,
					.skinset-background .vc_toggle_color_button_color .vc_toggle_icon,
					.skinset-background .vc_toggle_simple.vc_toggle_color_button_color .vc_toggle_icon::after, 
					.skinset-background .vc_toggle_simple.vc_toggle_color_button_color .vc_toggle_icon::before,
					.skinset-background .vc_tta-color-button_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-background .vc_tta-color-button_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-background .vc_tta-tabs.vc_tta-color-button_color .vc_tta-panel-heading,
					.skinset-background .vc_message_box-3d.vc_color-button_color,
					.skinset-background .vc_message_box-3d.vc_color-button_color,
					.skinset-background .vc_message_box-solid.vc_color-button_color,
					.skinset-background .vc_message_box-standard.vc_color-button_color,
					.skinset-background .vc_message_box-solid-icon.vc_color-button_color .vc_message_box-icon,
					.skinset-background nav li.button_color a,
					.skinset-background nav.anchorlink-nav li a,
					.skinset-background .autototop a,	
					.skinset-background .dock-tab-wrapper .widget_shopping_cart a.button,
					.skinset-background .control-panel ul li a, 
					.skinset-background a.woocommerce-product-gallery__trigger:after';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;	

				case 'body_button_hover_color':

					$css = '
					.skinset-background button:hover,
					.skinset-background #container input[type="button"]:hover,
					.skinset-background submit:hover,
					.skinset-background #container input[type="submit"]:hover,
					.skinset-background #container a.button:hover,
					.skinset-background button.button:hover,
					.skinset-background input.button:hover,
					.skinset-background #review_form #submit:hover,
					.skinset-background #related_posts .related-post-cat a:hover,
					.skinset-background .button-wrap .button.link_color a:hover,
					.skinset-background #container .vc_tta-tabs.vc_tta-color-button_color .vc_tta-tab>a:hover,
					.skinset-background #container .vc_tta-tabs.vc_tta-color-button_color .vc_tta-tab.vc_active>a,
					.skinset-background .vc_toggle_color_button_hover_color .vc_toggle_icon, 
					.skinset-background .vc_toggle_color_button_hover_color .vc_toggle_icon,				
					.skinset-background .vc_general.vc_btn3-color-link_color:focus,
					.skinset-background .vc_general.vc_btn3-color-link_color:hover,
					.skinset-background .dir-nav-icon-two .page-animate-nav:hover,
					.skinset-background .vc_tta-color-button_color .vc_tta-panels .vc_tta-panel-body,
					.skinset-background .vc_tta-color-button_color.vc_tta-accordion .vc_tta-panel.vc_active .vc_tta-panel-heading,
					.skinset-background .vc_tta-color-button_color.vc_tta-accordion .vc_tta-panel.vc_active .vc_tta-panel-body,
					.skinset-background .dock-tab-wrapper .widget_shopping_cart a.button:hover,
					.skinset-background .dock-tab-wrapper .widget_shopping_cart a.button:hover,
					.skinset-background nav li.button_color:hover a,
					.skinset-background a:hover.woocommerce-product-gallery__trigger:after,
					.skinset-background .autototop a:hover,	
					.skinset-background .control-panel ul li:hover a,
					.skinset-background .control-panel ul li.activeSlide a, 
					.skinset-background nav.anchorlink-nav li a:hover,
					.skinset-background nav.anchorlink-nav li a.waypoint_active,
					.skinset-background .vc_tta-tabs.vc_tta-color-button_color .vc_active .vc_tta-panel-heading';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;	

				case 'transparent_header_link_color':

					$css = '
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li > a,
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li > .dropmenu-icon,
					#header-wrap.transparent.skinset-header h1 a,
					#header-wrap.transparent.skinset-header .logo a,
					#header-wrap.transparent.skinset-header .headerpanel-widgets .textwidget a,
					#header-wrap.transparent.skinset-header .dock-panel > li > a';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;					

				case 'transparent_header_link_hover_color':

					$css = '
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li:hover > a,
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li > a.waypoint_active,
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li:hover > .dropmenu-icon,
					#header-wrap.transparent.skinset-header h1 a:hover,
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li.current-menu-item > a,
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li.current_page_item > a,
					#header-wrap.transparent.skinset-header #acoda-tabs #acoda_dropmenu > li.current-menu-ancestor > a,
					#header-wrap.transparent.skinset-header .headerpanel-widgets .textwidget a:hover,
					#header-wrap.transparent.skinset-header .dock-panel > li > a:hover';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;	

				case 'dockbar_element_color':

					$css = '
					.skinset-dockbar input[type],
					.skinset-dockbar select,
					.skinset-dockbar textarea,
					.skinset-dockbar pre,
					.skinset-dockbar code,
					.skinset-dockbar table thead tr,	
					.skinset-dockbar table tr:nth-child(even),
					.skinset-dockbar fieldset legend,
					.skinset-dockbar input.input-text,
					.skinset-dockbar .frame .gridimg-wrap .img,
					.skinset-dockbar .wpb_video_widget.frame,
					.skinset-dockbar .row.custom-row-inherit,
					.skinset-dockbar .splitter ul li.active,
					.skinset-dockbar nav.pagination .page-numbers,
					.skinset-dockbar .wpb_call_to_action,
					.skinset-dockbar .vc_progress_bar .vc_single_bar,
					.skinset-dockbar .zoomflow .controlsCon > .arrow-left,
					.skinset-dockbar .zoomflow .controlsCon > .arrow-right,	
					.skinset-dockbar .gallery-caption,
					.skinset-dockbar .socialicons ul li a,
					.skinset-dockbar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-dockbar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-flat,
					.skinset-dockbar .vc_icon_element-dockpanel.vc_icon_element-dockpanel-color-skin_element,
					.skinset-dockbar .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-dockbar .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-dockbar .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-tab>a,
					.skinset-dockbar .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-dockbar .vc_tta-color-shaded_color.vc_tta-accordion.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels,
					.skinset-dockbar .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-dockbar .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-dockbar .vc_message_box-3d.vc_color-shaded_color,
					.skinset-dockbar .vc_message_box-3d.vc_color-shaded_color,
					.skinset-dockbar .vc_message_box-solid.vc_color-shaded_color,
					.skinset-dockbar .vc_message_box-standard.vc_color-shaded_color,
					.skinset-dockbar .vc_message_box-solid-icon.vc_color-shaded_color .vc_message_box-icon,
					.skinset-dockbar .screen-reader-text:focus,
					.skinset-dockbar .select2-container--default .select2-selection--single
					';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;				

				case 'dockbar_element_border':

					$css = '
					.skinset-dockbar input[type],
					.skinset-dockbar select,
					.skinset-dockbar textarea,
					.skinset-dockbar pre,
					.skinset-dockbar code,
					.skinset-dockbar legend,
					.skinset-dockbar input.input-text,
					.skinset-dockbar .frame .gridimg-wrap .img,
					.skinset-dockbar .wpb_video_widget.frame,
					.skinset-dockbar .wpb_call_to_action,
					.skinset-dockbar img.avatar,
					.skinset-dockbar .tagcloud a,
					.skinset-dockbar .vc_sep_color_skin_element .vc_sep_line, 
					.skinset-dockbar hr,
					.skinset-dockbar #lang_sel_list li,
					.skinset-dockbar .splitter ul li.active,
					.skinset-dockbar .vc_progress_bar .vc_single_bar,
					.skinset-dockbar table tr,
					.skinset-dockbar .gallery-caption,
					.skinset-dockbar ul.post-metadata-wrap,
					.skinset-dockbar .socialicons ul li a,
					.skinset-dockbar nav.pagination .page-numbers,
					.skinset-dockbar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-dockbar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-outline,
					.skinset-dockbar .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-dockbar .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-dockbar .vc_tta-tabs.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-tab>a,
					.skinset-dockbar .vc_tta.vc_general.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-panels,
					.skinset-dockbar .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::after,
					.skinset-dockbar .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::before,
					.skinset-dockbar .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-dockbar .comments-wrapper .comments-wrap,
					.skinset-dockbar .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-dockbar .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-dockbar .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-dockbar .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-dockbar .vc_message_box-outline.vc_color-shaded_color,
					.skinset-dockbar .vc_message_box-standard.vc_color-shaded_color,
					.skinset-dockbar .vc_message_box-solid-icon.vc_color-shaded_color,
					.skinset-dockbar .vc_message_box-3d.vc_color-shaded_color,
					.skinset-dockbar .wpb_wrapper .vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-outline.vc_icon_element-dockpanel-color-skin_element,
					.skinset-dockbar .select2-container--default .select2-selection--single';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;					

				case 'dockbar_panel_element_color':

					$css = '
					.skinset-dockpanel input[type],
					.skinset-dockpanel select,
					.skinset-dockpanel textarea,
					.skinset-dockpanel pre,
					.skinset-dockpanel code,
					.skinset-dockpanel table thead tr,	
					.skinset-dockpanel table tr:nth-child(even),
					.skinset-dockpanel fieldset legend,
					.skinset-dockpanel input.input-text,
					.skinset-dockpanel .frame .gridimg-wrap .img,
					.skinset-dockpanel .wpb_video_widget.frame,
					.skinset-dockpanel .row.custom-row-inherit,
					.skinset-dockpanel .splitter ul li.active,
					.skinset-dockpanel nav.pagination .page-numbers,
					.skinset-dockpanel .wpb_call_to_action,
					.skinset-dockpanel .vc_progress_bar .vc_single_bar,
					.skinset-dockpanel .zoomflow .controlsCon > .arrow-left,
					.skinset-dockpanel .zoomflow .controlsCon > .arrow-right,
					.skinset-dockpanel .gallery-caption,
					.skinset-dockpanel .socialicons ul li a,
					.skinset-dockpanel .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-dockpanel .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-flat,
					.skinset-dockpanel .vc_icon_element-dockpanel.vc_icon_element-dockpanel-color-skin_element,
					.skinset-dockpanel .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-dockpanel .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-dockpanel .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-tab>a,
					.skinset-dockpanel .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-dockpanel .vc_tta-color-shaded_color.vc_tta-accordion.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels,
					.skinset-dockpanel .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-dockpanel .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-dockpanel .vc_message_box-3d.vc_color-shaded_color,
					.skinset-dockpanel .vc_message_box-3d.vc_color-shaded_color,
					.skinset-dockpanel .vc_message_box-solid.vc_color-shaded_color,
					.skinset-dockpanel .vc_message_box-standard.vc_color-shaded_color,
					.skinset-dockpanel .vc_message_box-solid-icon.vc_color-shaded_color .vc_message_box-icon,
					.skinset-dockpanel .screen-reader-text:focus,
					.skinset-dockpanel .select2-container--default .select2-selection--single
					';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;				

				case 'dockbar_panel_element_border':

					$css = '
					.skinset-dockpanel input[type],
					.skinset-dockpanel select,
					.skinset-dockpanel textarea,
					.skinset-dockpanel pre,
					.skinset-dockpanel code,
					.skinset-dockpanel legend,
					.skinset-dockpanel input.input-text,
					.skinset-dockpanel .frame .gridimg-wrap .img,
					.skinset-dockpanel .wpb_video_widget.frame,
					.skinset-dockpanel .wpb_call_to_action,
					.skinset-dockpanel img.avatar,
					.skinset-dockpanel .tagcloud a,
					.skinset-dockpanel .vc_sep_color_skin_element .vc_sep_line, 
					.skinset-dockpanel hr,
					.skinset-dockpanel #lang_sel_list li,
					.skinset-dockpanel .splitter ul li.active,
					.skinset-dockpanel .vc_progress_bar .vc_single_bar,
					.skinset-dockpanel table tr,
					.skinset-dockpanel .gallery-caption,
					.skinset-dockpanel ul.post-metadata-wrap,
					.skinset-dockpanel .socialicons ul li a,
					.skinset-dockpanel nav.pagination .page-numbers,
					.skinset-dockpanel .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-dockpanel .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-outline,
					.skinset-dockpanel .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-dockpanel .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-dockpanel .vc_tta-tabs.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-tab>a,
					.skinset-dockpanel .vc_tta.vc_general.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-panels,
					.skinset-dockpanel .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::after,
					.skinset-dockpanel .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::before,
					.skinset-dockpanel .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-dockpanel .comments-wrapper .comments-wrap,
					.skinset-dockpanel .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-dockpanel .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-dockpanel .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-dockpanel .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-dockpanel .vc_message_box-outline.vc_color-shaded_color,
					.skinset-dockpanel .vc_message_box-standard.vc_color-shaded_color,
					.skinset-dockpanel .vc_message_box-solid-icon.vc_color-shaded_color,
					.skinset-dockpanel .vc_message_box-3d.vc_color-shaded_color,
					.skinset-dockpanel .wpb_wrapper .vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-outline.vc_icon_element-dockpanel-color-skin_element,
					.skinset-dockpanel .select2-container--default .select2-selection--single';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;				

				case 'sidebar_element_color':

					$css = '
					.skinset-sidebar input[type],
					.skinset-sidebar select,
					.skinset-sidebar textarea,
					.skinset-sidebar pre,
					.skinset-sidebar code,
					.skinset-sidebar table thead tr,	
					.skinset-sidebar table tr:nth-child(even),
					.skinset-sidebar fieldset legend,
					.skinset-sidebar input.input-text,
					.skinset-sidebar .frame .gridimg-wrap .img,
					.skinset-sidebar .wpb_video_widget.frame,
					.skinset-sidebar .row.custom-row-inherit,
					.skinset-sidebar .splitter ul li.active,
					.skinset-sidebar nav.pagination .page-numbers,
					.skinset-sidebar .wpb_call_to_action,
					.skinset-sidebar .vc_progress_bar .vc_single_bar,
					.skinset-sidebar .zoomflow .controlsCon > .arrow-left,
					.skinset-sidebar .zoomflow .controlsCon > .arrow-right,	
					.skinset-sidebar .gallery-caption,
					.skinset-sidebar .socialicons ul li a,
					.skinset-sidebar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-sidebar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-flat,
					.skinset-sidebar .vc_icon_element-sidebar.vc_icon_element-sidebar-color-skin_element,
					.skinset-sidebar .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-sidebar .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-sidebar .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-tab>a,
					.skinset-sidebar .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-sidebar .vc_tta-color-shaded_color.vc_tta-accordion.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels,
					.skinset-sidebar .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-sidebar .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-sidebar .vc_message_box-3d.vc_color-shaded_color,
					.skinset-sidebar .vc_message_box-3d.vc_color-shaded_color,
					.skinset-sidebar .vc_message_box-solid.vc_color-shaded_color,
					.skinset-sidebar .vc_message_box-standard.vc_color-shaded_color,
					.skinset-sidebar .vc_message_box-solid-icon.vc_color-shaded_color .vc_message_box-icon,
					.skinset-sidebar .screen-reader-text:focus,
					.skinset-sidebar .select2-container--default .select2-selection--single
					';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;				

				case 'sidebar_element_border':

					$css = '
					.skinset-sidebar input[type],
					.skinset-sidebar select,
					.skinset-sidebar textarea,
					.skinset-sidebar pre,
					.skinset-sidebar code,
					.skinset-sidebar legend,
					.skinset-sidebar input.input-text,
					.skinset-sidebar .frame .gridimg-wrap .img,
					.skinset-sidebar .wpb_video_widget.frame,
					.skinset-sidebar .wpb_call_to_action,
					.skinset-sidebar img.avatar,
					.skinset-sidebar .tagcloud a,
					.skinset-sidebar .vc_sep_color_skin_element .vc_sep_line, 
					.skinset-sidebar hr,
					.skinset-sidebar #lang_sel_list li,
					.skinset-sidebar .splitter ul li.active,
					.skinset-sidebar .vc_progress_bar .vc_single_bar,
					.skinset-sidebar table tr,
					.skinset-sidebar .gallery-caption,
					.skinset-sidebar .socialicons ul li a,
					.skinset-sidebar nav.pagination .page-numbers,
					.skinset-sidebar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-sidebar .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-outline,
					.skinset-sidebar .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-sidebar .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-sidebar .vc_tta-tabs.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-tab>a,
					.skinset-sidebar .vc_tta.vc_general.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-panels,
					.skinset-sidebar .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::after,
					.skinset-sidebar .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::before,
					.skinset-sidebar .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-sidebar .comments-wrapper .comments-wrap,
					.skinset-sidebar .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-sidebar .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-sidebar .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-sidebar .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-sidebar .vc_message_box-outline.vc_color-shaded_color,
					.skinset-sidebar .vc_message_box-standard.vc_color-shaded_color,
					.skinset-sidebar .vc_message_box-solid-icon.vc_color-shaded_color,
					.skinset-sidebar .vc_message_box-3d.vc_color-shaded_color,
					.skinset-sidebar .wpb_wrapper .vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-outline.vc_icon_element-sidebar-color-skin_element,
					.skinset-sidebar .select2-container--default .select2-selection--single';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;		

				case 'footer_element_color':

					$css = '
					.skinset-footer input[type],
					.skinset-footer select,
					.skinset-footer textarea,
					.skinset-footer pre,
					.skinset-footer code,
					.skinset-footer table thead tr,	
					.skinset-footer table tr:nth-child(even),
					.skinset-footer fieldset legend,
					.skinset-footer input.input-text,
					.skinset-footer .frame .gridimg-wrap .img,
					.skinset-footer .wpb_video_widget.frame,
					.skinset-footer .row.custom-row-inherit,
					.skinset-footer .splitter ul li.active,
					.skinset-footer nav.pagination .page-numbers,
					.skinset-footer .wpb_call_to_action,
					.skinset-footer .vc_progress_bar .vc_single_bar,
					.skinset-footer .zoomflow .controlsCon > .arrow-left,
					.skinset-footer .zoomflow .controlsCon > .arrow-right,	
					.skinset-footer .gallery-caption,
					.skinset-footer .socialicons ul li a,
					.skinset-footer .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-footer .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-flat,
					.skinset-footer .vc_icon_element-footer.vc_icon_element-footer-color-skin_element,
					.skinset-footer .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-footer .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-footer .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-tab>a,
					.skinset-footer .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-footer .vc_tta-color-shaded_color.vc_tta-accordion.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels,
					.skinset-footer .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-footer .vc_tta-color-shaded_color.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-footer .vc_message_box-3d.vc_color-shaded_color,
					.skinset-footer .vc_message_box-3d.vc_color-shaded_color,
					.skinset-footer .vc_message_box-solid.vc_color-shaded_color,
					.skinset-footer .vc_message_box-standard.vc_color-shaded_color,
					.skinset-footer .vc_message_box-solid-icon.vc_color-shaded_color .vc_message_box-icon,
					.skinset-footer .screen-reader-text:focus,
					.skinset-footer .select2-container--default .select2-selection--single
					';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;				

				case 'footer_element_border':

					$css = '
					.skinset-footer input[type],
					.skinset-footer select,
					.skinset-footer textarea,
					.skinset-footer pre,
					.skinset-footer code,
					.skinset-footer legend,
					.skinset-footer input.input-text,
					.skinset-footer .frame .gridimg-wrap .img,
					.skinset-footer .wpb_video_widget.frame,
					.skinset-footer .wpb_call_to_action,
					.skinset-footer img.avatar,
					.skinset-footer .tagcloud a,
					.skinset-footer .vc_sep_color_skin_element .vc_sep_line, 
					.skinset-footer hr,
					.skinset-footer #lang_sel_list li,
					.skinset-footer .splitter ul li.active,
					.skinset-footer .vc_progress_bar .vc_single_bar,
					.skinset-footer table tr,
					.skinset-footer .gallery-caption,
					.skinset-footer .socialicons ul li a,
					.skinset-footer nav.pagination .page-numbers,
					.skinset-footer .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-classic,
					.skinset-footer .vc_cta3.vc_cta3-color-skin_element.vc_cta3-style-outline,
					.skinset-footer .wpb_single_image .vc_single_image-wrapper.vc_box_border, 
					.skinset-footer .wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,
					.skinset-footer .vc_tta-tabs.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-tab>a,
					.skinset-footer .vc_tta.vc_general.vc_tta-color-shaded_color.vc_tta-style-outline .vc_tta-panels,
					.skinset-footer .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::after,
					.skinset-footer .vc_tta.vc_tta-style-outline.vc_tta-color-shaded_color .vc_tta-panel-body::before,
					.skinset-footer .vc_tta-tabs.vc_tta-color-shaded_color .vc_tta-panel-heading,
					.skinset-footer .comments-wrapper .comments-wrap,
					.skinset-footer .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-footer .vc_tta-color-shaded_color.vc_tta-style-classic.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-footer .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
					.skinset-footer .vc_tta-color-shaded_color.vc_tta-style-outline.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
					.skinset-footer .vc_message_box-outline.vc_color-shaded_color,
					.skinset-footer .vc_message_box-standard.vc_color-shaded_color,
					.skinset-footer .vc_message_box-solid-icon.vc_color-shaded_color,
					.skinset-footer .vc_message_box-3d.vc_color-shaded_color,
					.skinset-footer .wpb_wrapper .vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-outline.vc_icon_element-footer-color-skin_element,
					.skinset-footer .select2-container--default .select2-selection--single';

					$css = str_replace( array("\r", "\n", "\t" ), '', $css );
					return $css;				

				break;						

			}
		}		
		
		// Skin Options
		Redux::setSection( 'dynamix_'. $skin, array(
			'title' => __( 'Skin Editor', 'dynamix' ),
			'id'    => 'theme_skins',
			'icon'  => 'fal fa-paint-brush',
			'class' => 'theme-skin',
			'fields'     => array(																									
				array(
					'id'       => 'theme_skin',
					'type'     => 'select',
					'subtitle'     => __('Choose which skin you wish to apply to your site.', 'dynamix'),
					'title'    => __('Apply Skin to Site', 'dynamix'), 
					'options' => $skin_id_array,
				),					
			)		
		) );		

		Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Body', 'dynamix' ),
			'heading' => __( 'Body Background', 'dynamix' ),
			'id'    => 'body_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-browser',
			'fields'     => array(			
				array(
					'id'        =>  'main_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the Body background color.',
					'output'    => array('background-color' => '.skinset-main'),
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),				
				array(
					'id'       => 'main_image',
					'type'     => 'media', 
					'url'      => true,
					'title'    => __('Background Image', 'dynamix'),
					'compiler'    => array('background-image' => '.skinset-main'),
					'subtitle' => __('Set a Background Image.', 'dynamix'),
				),		
				array(
					'id'       => 'main_image_position',
					'type'     => 'select',
					'title'    => __('Image Position', 'dynamix'), 
					'options' => array(
						'center center' => 'Center Center',
						'center top' => 'Center Top',
						'center bottom' => 'Center Bottom',					
						'left top' => 'Left Top',
						'left center' => 'Left Center',
						'left bottom' => 'Left Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right Center',
						'right bottom' => 'Right Bottom',					
					),

					'output'    => array('background-position' => '.skinset-main'),
					'default'  => 'center center',				
				),	
				array(
					'id'       => 'main_image_size',
					'type'     => 'select',
					'title'    => __('Image Size', 'dynamix'), 
					'options' => array(
						'auto' => 'Auto',
						'cover' => 'Cover',
						'contain' => 'Contain',
					),	
					'output'    => array('background-size' => '.skinset-main'),
					'default'  => 'no-repeat',
				),			
				array(
					'id'       => 'main_image_repeat',
					'type'     => 'select',
					'title'    => __('Image Repeat', 'dynamix'), 
					'options' => array(
						'repeat' => 'Repeat',
						'repeat-x' => 'Repeat X',
						'repeat-y' => 'Repeat Y',
						'no-repeat' => 'No Repeat',
					),	
					'output'    => array('background-position' => '.skinset-main'),
					'default'  => 'no-repeat',
				),					
			)		
		) );	
			  		

	   Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Typography', 'dynamix' ),
			'heading' => __( 'Body Typography', 'dynamix' ),
			'id'    => 'typography_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-font',
			'fields'     => array(										
				array(
					'id'          => 'body_typography',
					'type'        => 'typography', 
					'title'       => __('Body Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-background'),
					'text-align'	  => false,
					'color'		  => false,
					'word-spacing' => true,
					'line-height' => true,
					'font-size'	  => true, 
					'letter-spacing'	  => true,
					'default'     => array(
						'font-weight'  => '300', 
						'font-family' => 'Roboto', 
						'google'      => true,
					),
				),		
				array(
					'id'        =>  'body_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => 'Set the Body Font Color.',
					'output'    => array('color' => '.skinset-background,.skinset-background h1>a,.skinset-background h2>a,.skinset-background h3>a,.skinset-background h4>a,.skinset-background h5>a,.skinset-background h6>a'),
					'default'   => array(
							'color'     => '#202f33',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'        =>  'body_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Body Link Color.',
					'output'    => array(
						'color' => '.skinset-background a,.skinset-background .text_linkcolor,.skinset-background #container [class*="acoda_link_color"],.skinset-background .comments-list .icon,.list.link_color li:before',
						'border-color' => '.skinset-background #container [class*="acoda_link_color-border"],.spinner-layer,.skinset-background #container [class*="acoda_link_color-border"],.skinset-background [class*="acoda_link_color-border"] .vc_sep_line',
						'background-color' => '.skinset-background #container [class*="acoda_link_color-bg"],.skinset-background ul.dock-panel li.dock-tab .items-count,.skinset-background ul.products li.product .onsale,span.highlight.one'	   
					),
					'default'   => array(
							'color'     => '#7AA93C',
							'alpha'     => 1
					),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'        =>  'body_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Body Link Hover Color.',
					'output'    => array(
						'color' => '.skinset-background a:hover,.skinset-background #container [class*="acoda_link_hover_color"]',
						'background-color' => '.skinset-background #container [class*="acoda_link_hover_color-bg"]',
						'border-color' => '.acoda-posts-widget .post-comments:after,.skinset-background #container [class*="acoda_link_hover_color-border"],.skinset-background [class*="acoda_link_hover_color-border"] .vc_sep_line'
					),   
					'default'   => array(
							'color'     => '#7AA93C',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'   => 'body_content_links_info',
					'type' => 'info',
					'title' => __('Page & Post Content Links', 'dynamix')
				),	   
				array(
					'id'        =>  'body_content_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Content Area Link Color.',
					'output'    => array(
						'color' => '.skinset-background .entry p > a,.skinset-background .entry .text_linkcolor, .skinset-background #container .entry [class*="acoda_link_color"]',
						'border-color' => '.skinset-background #container .entry [class*="acoda_link_color-border"]',
						'background-color' => '.skinset-background #container .entry [class*="acoda_link_color-bg"]'
					),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'        =>  'body_content_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Content Area Link Hover Color.',
					'output'    => array(
						'color' => '.skinset-background .entry a:hover,.skinset-background #container .entry [class*="acoda_link_hover_color"]',
						'border-color' => '.skinset-background #container .entry [class*="acoda_link_hover_color-border"]',
						'background-color' => '.skinset-background #container .entry [class*="acoda_link_hover_color-bg"]'	   
					),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   

				),
				array(
					'id'        =>  'body_content_link_underline_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Underline Color', 'dynamix'),
					'subtitle'  => 'Set the Content Area Link Underline Color.',	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'   => 'body_metadata_links_info',
					'type' => 'info',
					'title' => __('Metadata Typography', 'dynamix')
				),	   
				array(
					'id'          => 'body_metadata_typography',
					'type'        => 'typography', 
					'title'       => __('Metadata Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the Metadata areas.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array( 'color' => '.skinset-background .post-metadata-wrap,.skinset-background .post-metadata-wrap a,.skinset-background .comment-meta a'),
					'text-align'	  => false,
					'color'		  => false,
					'font-size'	  => true,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),	
				array(
					'id'        =>  'body_metadata_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => __('Set the Metadata Hover Color.', 'dynamix'),
					'output'    => array('color' => '.skinset-background .post-metadata-wrap,.skinset-background .post-metadata-wrap a,.skinset-background .comment-meta a'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   

				),		   
				array(
					'id'        =>  'body_metadata_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => __('Set the Metadata Hover Color.', 'dynamix'),
					'output'    => array('color' => '.skinset-background .post-metadata-wrap a:hover'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   

				),	   
				array(
					'id'   => 'body_headings_info',
					'type' => 'info',
					'title' => __('Headings Typography', 'dynamix')
				),			
				array(
					'id'          => 'h1_typography',
					'type'        => 'typography', 
					'title'       => __('H1 Heading Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the H1 Tag.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#container h1'),
					'text-align'	  => false,
					'color'		  => false,
					'font-size'	  => true,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'h1_font_color',
		   			'title'       => __('H1 Heading Color', 'dynamix'),
					'type'      => 'color_rgba',
					'output'    => array('color' => '.skinset-background h1,.skinset-background h1 a'),
					'default'   => array(
							'color'     => '#202f33',
							'alpha'     => 1
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'          => 'h2_typography',
					'type'        => 'typography', 
					'title'       => __('H2 Heading Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the H2 Tag.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#container h2'),
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,
					'font-size'	  => true,
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'h2_font_color',
		   			'title'       => __('H2 Heading Color', 'dynamix'),
					'type'      => 'color_rgba',
					'output'    => array('color' => '.skinset-background h2,.skinset-background h2 a'),
					'default'   => array(
							'color'     => '#202f33',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'          => 'h3_typography',
					'type'        => 'typography', 
					'title'       => __('H3 Heading Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the H3 Tag.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#container h3,#container .heading-font'),
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,
					'font-size'	  => true,
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'h3_font_color',
		   			'title'       => __('H3 Heading Color', 'dynamix'),
					'type'      => 'color_rgba',
					'output'    => array('color' => '.skinset-background h3,.skinset-background h3 a'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),					
				array(
					'id'          => 'h4_typography',
					'type'        => 'typography', 
					'title'       => __('H4 Heading Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the H4 Tag.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#container h4'),
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,
					'font-size'	  => true,
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'h4_font_color',
		   			'title'       => __('H4 Heading Color', 'dynamix'),
					'type'      => 'color_rgba',
					'output'    => array('color' => '.skinset-background h4,.skinset-background h4 a'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'          => 'h5_typography',
					'type'        => 'typography', 
					'title'       => __('H5 Heading Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the H5 Tag.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#container h5'),
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,
					'font-size'	  => true,
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'h5_font_color',
		   			'title'       => __('H5 Heading Color', 'dynamix'),
					'type'      => 'color_rgba',
					'output'    => array('color' => '.skinset-background h5,.skinset-background h5 a'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'          => 'h6_typography',
					'type'        => 'typography', 
					'title'       => __('H6 Heading Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the H6 Tag.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#container h6'),
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,
					'font-size'	  => true,
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'h6_font_color',
		   			'title'       => __('H6 Heading Color', 'dynamix'),
					'type'      => 'color_rgba',
					'output'    => array('color' => '.skinset-background h6,.skinset-background h6 a'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),																																																													
			)		
		) );			

	   Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Dock Bar', 'dynamix' ),
			'id'    => 'dockbar_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-window-alt',
			'fields'     => array(						
				array(
					'id'        =>  'dockbar_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the Dock Bar background color.',
					'output'    => array('background-color' => '#container .dock-panel-wrap.skinset-dockbar'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   

				),				
				array(
					'id'       => 'dockbar_image',
					'type'     => 'media', 
					'url'      => true,
					'title'    => __('Background Image', 'dynamix'),
					'compiler'    => array('background-image' => '#container .dock-panel-wrap.skinset-dockbar'),
					'subtitle' => __('Set a Background Image.', 'dynamix'),
				),		

				array(
					'id'       => 'dockbar_image_position',
					'type'     => 'select',
					'title'    => __('Image Position', 'dynamix'), 
					'options' => array(
						'center center' => 'Center Center',
						'center top' => 'Center Top',
						'center bottom' => 'Center Bottom',					
						'left top' => 'Left Top',
						'left center' => 'Left Center',
						'left bottom' => 'Left Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right Center',
						'right bottom' => 'Right Bottom',					
					),
					'output'    => array('background-position' => '#container .dock-panel-wrap.skinset-dockbar'),
					'default'  => 'center center',				
				),	
				array(
					'id'       => 'dockbar_image_repeat',
					'type'     => 'select',
					'title'    => __('Image Repeat', 'dynamix'), 
					'options' => array(
						'repeat' => 'Repeat',
						'repeat-x' => 'Repeat X',
						'repeat-y' => 'Repeat Y',
						'no-repeat' => 'No Repeat',
					),	
					'output'    => array('background-position' => '#container .dock-panel-wrap.skinset-dockbar'),
					'default'  => 'no-repeat',
				),		
				array( 
					'id'       => 'dockbar-border',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Add a Border to the Dockbar area.', 'dynamix'),
					'output'   => array('#container .dock-panel-wrap.skinset-dockbar'),
					'all'	   => false,
				),
				array(
					'id'   => 'info_dockbar_text',
					'type' => 'info',
					'title' => __('Dock Bar Typography', 'dynamix')
				),		
				array(
					'id'          => 'dockbar_font',
					'type'        => 'typography', 
					'title'       => __('Dockbar Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-dockbar.acoda-skin'),
					'units'       => false,
					'text-align'	  => true,
					'color'		  => false,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 	   
				),	
				array(
					'id'        =>  'dockbar_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Font Color.',
					'output'    => array(
						'color' => '.skinset-dockbar.acoda-skin'
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),		   
				array(
					'id'        =>  'dockbar_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Link Color.',
					'output'    => array(
						'color' => '.skinset-dockbar.acoda-skin a'
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'        =>  'dockbar_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Dockbar Link Hover Color.',
					'output'    => array('color' => '.skinset-dockbar.acoda-skin a:hover'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'   => 'info_dockbar_icons',
					'type' => 'info',
					'title' => __('Dock Bar Icons', 'dynamix')
				),		
				array(
					'id'          => 'dockbar_typography',
					'type'        => 'typography', 
					'title'       => __('Icon Font Size', 'dynamix'),
					'google'      => false, 
					'font-backup' => false,
					'output'      => array('.skinset-dockbar.acoda-skin .dock-tab > a i'),
					'text-align'	  => false,
					'color'		  => false,
		   			'font-family' => false,
		   			'font-weight' => false,
		   			'font-style' => false,
					'word-spacing' => false,
					'text-transform' => false,	
					'line-height' => false,
					'font-size'	  => true, 
					'letter-spacing'	  => false,
					'default'   => array(
							'font-size'     => '1rem',
					),			   
				),		   
				array(
					'id'        =>  'dockbar_icon_color',
					'type'      => 'color_rgba',
					'title'       => __('Icon Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Icon Color.',
					'output'    => array(
						'color' => '.skinset-dockbar.acoda-skin .dock-tab > a i'
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'        =>  'dockbar_icon_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Icon Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Icon Hover Color.',
					'output'    => array('color' => '.skinset-dockbar.acoda-skin .dock-tab > a:hover i'),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	   
				array(
					'id'        =>  'dockbar_icon_background_color',
					'type'      => 'color_rgba',
					'title'       => __('Icon Background Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Icon Background Color.',
					'output'    => array(
						'background-color' => '.skinset-dockbar.acoda-skin .dock-tab > a i'
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'        =>  'dockbar_icon_background_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Icon Hover Background Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Icon Hover Background Color.',
					'output'    => array(
						'background-color' => '.skinset-dockbar.acoda-skin .dock-tab > a:hover i'
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),		   
				array(
					'id'   => 'dockbar_elements_info',
					'type' => 'info',
					'title' => __('Dock Bar Form Fields, Tables & Elements', 'dynamix')
				),
				array(
					'id'        =>  'dockbar_element_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'output'    => array(
						'background-color' => acoda_skin_classes('dockbar_element_color') ,
					),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   

				),	
				array(
					'id'        =>  'dockbar_element_border_color',
					'type'      => 'color_rgba',
					'title'       => __('Border Color', 'dynamix'),
					'output'    => array('border-color' => acoda_skin_classes('dockbar_element_border') ),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'        =>  'dockbar_element_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'output'    => array('color' => acoda_skin_classes('dockbar_element_color') ),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	   
				array(
					'id'   => 'info_dockbar_windows',
					'type' => 'info',
					'title' => __('Dock Flyout Windows', 'dynamix')
				),		
				array(
					'id'        =>  'dockbar_panel_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Flyout Window Background Color.',
					'output'    => array(
						'background-color' => '#container .background-wrap.skinset-dockpanel',
						'border-color' => '#container .dock-panel-wrap .dock-tab-wrapper span.pointer:before',

					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),		   
				),		   
				array(
					'id'        =>  'dockbar_panel_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Font Color.',
					'output'    => array(
						'color' => '.background-wrap.skinset-dockpanel,.dock-panel-wrap .dock-tab-wrapper span.pointer:before '
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),			
				array(
					'id'        =>  'dockbar_panel_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Dock Bar Link Color.',
					'output'    => array(
						'color' => '#container .background-wrap.skinset-dockpanel a'
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	
				array(
					'id'        =>  'dockbar_panel_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Dockbar Flyout Link Hover Color.',
					'output'    => array('color' => '#container .background-wrap.skinset-dockpanel a:hover'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),	   
				array(
					'id'   => 'dockbar_panel_elements_info',
					'type' => 'info',
					'title' => __('Dock Flyout Windows Form Fields, Tables & Elements', 'dynamix')
				),
				array(
					'id'        =>  'dockbar_panel_element_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'output'    => array(
						'background-color' => acoda_skin_classes('dockbar_panel_element_color') ,
					),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	    			   
				),	
				array(
					'id'        =>  'dockbar_panel_element_border_color',
					'type'      => 'color_rgba',
					'title'       => __('Border Color', 'dynamix'),
					'output'    => array('border-color' => acoda_skin_classes('dockbar_panel_element_border') ),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'        =>  'dockbar_panel_element_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'output'    => array('color' => acoda_skin_classes('dockbar_panel_element_color') ),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),		   

			)
		) );			

		Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Header', 'dynamix' ),
			'id'    => 'header_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-window-maximize',
			'fields'     => array(						
				array(
					'id'        =>  'header_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the header background color.',
					'output'    => array('background-color' => '#header-wrap,#container #header-wrap #header.stuck'),
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),				
				array(
					'id'       => 'header_image',
					'type'     => 'media', 
					'url'      => true,
					'title'    => __('Background Image', 'dynamix'),
					'compiler'    => array('background-image' => '#header-wrap,#container #header-wrap #header.stuck'),
					'subtitle' => __('Set a Background Image.', 'dynamix'),
				),		
				array(
					'id'       => 'header_image_featured',
					'type'     => 'switch',
					'title'    => __('Use Post / Page Featured Image', 'dynamix'), 
					'subtitle'     => __('Choose to use the Page or Post Featured Image as a Background Image. The "Background Image" option is used when no Featured Image is set.', 'dynamix'),
					'default'  => false,
				),		
				array(
					'id'       => 'header_parallax',
					'type'     => 'switch',
					'title'    => __('Enable Parallax', 'dynamix'), 
					'default'  => true,
				),			
				array(
					'id'       => 'header_image_position',
					'type'     => 'select',
					'title'    => __('Image Position', 'dynamix'), 
					'options' => array(
						'center center' => 'Center Center',
						'center top' => 'Center Top',
						'center bottom' => 'Center Bottom',					
						'left top' => 'Left Top',
						'left center' => 'Left Center',
						'left bottom' => 'Left Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right Center',
						'right bottom' => 'Right Bottom',					
					),
					'output'    => array('background-position' => '#header-wrap, #container #header-wrap #header.stuck'),
					'default'  => 'center center',				
				),	
				array(
					'id'       => 'header_image_repeat',
					'type'     => 'select',
					'title'    => __('Image Repeat', 'dynamix'), 
					'options' => array(
						'repeat' => 'Repeat',
						'repeat-x' => 'Repeat X',
						'repeat-y' => 'Repeat Y',
						'no-repeat' => 'No Repeat',
					),	
					'output'    => array('background-repeat' => '#header-wrap'),
					'default'  => 'no-repeat',
				),	
				array(
					'id'        =>  'header_color_overlay',
					'type'      => 'color_rgba',
					'title'     => 'Overlay Color',
					'subtitle'  => 'Set the Header Overlay Color.',
					'output'    => array('background-color' => '.header-wrap-inner'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array( 
					'id'       => 'header-border',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Add a Border to the Header area.', 'dynamix'),
					'output'   => array('#header'),
					'all'	   => false,
					'default'  => array(
						'border-color'  => '#EEEEEE', 
						'border-style'  => 'solid', 
						'border-top'    => '0', 
						'border-right'  => '0', 
						'border-bottom' => '1px', 
						'border-left'   => '0'
					)
				),			
				array(
					'id'   => 'info_header_text',
					'type' => 'info',
					'title' => __('Typography', 'dynamix')
				),		
				array(
					'id'          => 'header_font',
					'type'        => 'typography', 
					'title'       => __('Header Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-header.acoda-skin'),
					'units'       => false,
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 		
				),		
				array(
					'id'        =>  'header_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => 'Set the Header Font Color.',
					'output'    => array(
						'color' => '.skinset-header.acoda-skin'
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'        =>  'header_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Header Link Color.',
					'output'    => array(
						'color' => '.skinset-header.acoda-skin a'
					),
					'default'   => array(
							'color'     => '#202F33',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'header_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Header Link Hover Color.',
					'output'    => array('color' => '.skinset-header.acoda-skin a:hover'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'   => 'info_header_sticky',
					'type' => 'info',
					'title' => __('Sticky Header ', 'dynamix')
				),				
				array(
					'id'        =>  'header_sticky_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the header background color for when the Header is sticky.',
					'output'    => array('background-color' => '#container #header-wrap #header.stuck'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'menu_sticky_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Link Color.',
					'output'    => array('color' => '#header.stuck .skinset-menu.acoda-skin .menu > li > a,.dock_layout_4 #header.stuck .dock-tab a,#header.stuck #header-logo #logo .logo a'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),								                     
				),	
				array(
					'id'        =>  'menu_sticky_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Link Hover Color.',
					'output'    => array('color' => '#header.stuck .skinset-menu.acoda-skin .menu > li:hover > a,#header.stuck .skinset-menu.acoda-skin .menu > li.current_page_ancestor > a,#header.stuck .skinset-menu.acoda-skin .menu > li.current-menu-ancestor > a,#header.stuck .skinset-menu.acoda-skin .menu > li.current-menu-item > a,#header.stuck .dock_layout_4 .skinset-dockbar.top_bar .dock-tab > a:hover,#header.stuck .skinset-menu.acoda-skin .menu > li > a.waypoint_active,.dock_layout_4 #header.stuck .dock-tab a:hover,#header.stuck #header-logo #logo .logo a:hover'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'   => 'info_header_transparent_logo',
					'type' => 'info',
					'title' => __('Transparent Floating Header', 'dynamix')
				),				
				array(
					'id'        =>  'transparent_header_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => 'Set the Transparent Header Font Color.',
					'output'    => array(
						'color' => '#header-wrap.transparent.skinset-header,#header-wrap.transparent.skinset-header h2,#header-wrap.transparent.skinset-header .headerpanel-widgets .textwidget',
					),									 
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'transparent_header_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Transparent Header Link Color.',
					'output'    => array(
						'color' => acoda_skin_classes('transparent_header_link_color') ,
					),									 
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'transparent_header_link_hover_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Transparent Header Link Hover Color.',
					'output'    => array(
						'color' => acoda_skin_classes('transparent_header_link_hover_color') ,
					),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
			)
		) );		

	   Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Logo', 'dynamix' ),
			'heading' => __( 'Logo Typography', 'dynamix' ),
			'id'    => 'logo_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-leaf',
			'fields'     => array(												
				array(
					'id'          => 'logo_typography',
					'type'        => 'typography', 
					'title'       => __('Logo Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for the Logo text.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#header-logo #logo .logo,#header-logo #logo .logo a,.dock-tab.dock-logo a'),
					'text-align'	  => false,
					'color'		  => false,
					'font-size'	  => true,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),
				array(
					'id'        =>  'logo_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Logo Font Color', 'dynamix'),
					'subtitle'  => 'Set the Logo Font Color.',
					'output'      => array( 'color' => '#header-logo #logo .logo,#header-logo #logo .logo a,.dock-tab.dock-logo a'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),								                     
				),		   
				array(
					'id'        =>  'logo_hover_color',
					'type'      => 'color_rgba',
					'title'       => __('Logo Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Logo Hover Color.',
					'output'    => array('color' => '#header-logo .logo a:hover'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),								                     
				),		   
				array(
					'id'          => 'tagline_typography',
					'type'        => 'typography', 
					'title'       => __('Tagline Typography', 'dynamix'),
					'subtitle'  => 'Set the Font Family for Logo Tagline.',
					'class'		=> 'disable-border disable-bottom-padding',
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('#header-logo .description'),
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,
					'font-size'	  => true,
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),			
				array(
					'id'        =>  'tagline_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Tagline Font Color', 'dynamix'),
					'subtitle'  => 'Set the Tagline Font Color.',
					'output'    => array('color' => '#header-logo .description'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),								                     
				),		   
			)		
		) );	


		Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Menu', 'dynamix' ),
			'id'    => 'menu_skin',
			'heading' => __( 'Main Menu', 'dynamix' ),
			'subsection'       => true,
			'icon'  => 'fal fa-bars',
			'fields'     => array(		
				array(
					'id'        =>  'menu_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Background Color.',
					'output'    => array('background-color' => '.skinset-menu.acoda-skin,.dock_layout_4 .skinset-dockbar.top_bar'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),		
				array( 
					'id'       => 'menu-border',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Add a Border to the Main Menu.', 'dynamix'),
					'output'   => array('#acoda_dropmenu'),
					'all'	   => false,
				),	
				array(
					'id'   => 'menu_items',
					'type' => 'info',
					'title' => __('Menu Items', 'dynamix')
				),		
				array(
					'id'          => 'menu_font',
					'type'        => 'typography', 
					'title'       => __('Menu Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-menu.acoda-skin, .skinset-menu.acoda-skin > *,.layout_top #header .menu-title.menu-item > a'),
					'units'       => false,
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'menu_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Link Color.',
					'output'    => array('color' => '.skinset-menu.acoda-skin a,.dock_layout_4 .skinset-dockbar.top_bar .dock-tab > a'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),								                     
				),	
				array(
					'id'        =>  'menu_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Link Hover Color.',
					'output'    => array('color' => '.skinset-menu.acoda-skin .menu li:hover > a, .skinset-menu.acoda-skin li.current_page_ancestor > a, .skinset-menu.acoda-skin li.current-menu-ancestor  > a, .skinset-menu.acoda-skin li.current-menu-item > a,.dock_layout_4 .skinset-dockbar.top_bar .dock-tab > a:hover,.skinset-menu.acoda-skin .menu li > a.waypoint_active, .dock_menu li > a.waypoint_active'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array( 
					'id'       => 'menu_item_border',
					'type'     => 'border',
					'title'    => __('Link Hover Border', 'dynamix'),
					'subtitle' => __('Add a Border to the top level Menu Items.', 'dynamix'),
					'output'   => array('#acoda_dropmenu > li:hover > a, #acoda_dropmenu > li.current_page_ancestor > a, #acoda_dropmenu > li.current-menu-item > a'),
					'all'		=> false,		
				),			
				array(
					'id'        =>  'menu_link_background_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link  Hover Background Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Link Background Hover Color.',
					'output'    => array('background-color' => '.skinset-menu.acoda-skin .menu li:hover > a, .skinset-menu.acoda-skin li.current_page_ancestor > a, .skinset-menu.acoda-skin li.current-menu-item > a'),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'menu_divider_color',
					'type'      => 'color_rgba',
					'title'       => __('Divider Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Divider Color.',
					'output'    => array('border-color' => '#acoda-tabs ul.menu li'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'   => 'menu_submenu',
					'type' => 'info',
					'title' => __('Submenu', 'dynamix')
				),	
				array(
					'id'        =>  'submenu_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'output'    => array(
						'background-color' => '.skinset-submenu.acoda-skin, .dock-menu-tabs.acoda-skin',
					),					                 
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'submenu_border_color',
					'type'      => 'color_rgba',
					'title'       => __('Border Color', 'dynamix'),
					'output'    => array('border-color' => '#container #acoda-tabs .skinset-submenu.acoda-skin,#container .dock-menu-tabs.acoda-skin'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'submenu_divider_color',
					'type'      => 'color_rgba',
					'title'       => __('Divider Color', 'dynamix'),
					'output'    => array('border-color' => '#container #acoda-tabs .skinset-submenu.acoda-skin li,#container .dock-menu-tabs.acoda-skin li'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),		
				array(
					'id'          => 'submenu_font',
					'type'        => 'typography', 
					'title'       => __('SubMenu Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-submenu.acoda-skin .infodock-innerwrap, .dock-menu-tabs.acoda-skin .infodock-innerwrap,.skinset-submenu.acoda-skin'),
					'units'       => false,
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 
				),		
				array(
					'id'        =>  'submenu_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'output'      => array( 'color' => '.skinset-submenu.acoda-skin, .dock-menu-tabs.acoda-skin'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'        =>  'submenu_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'output'    => array('color' => '.skinset-submenu.acoda-skin a, .dock-menu-tabs.acoda-skin a'),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'submenu_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'output'    => array('color' => '
					#container .skinset-submenu.acoda-skin a:hover,
					#container .skinset-submenu.acoda-skin li.current_page_ancestor > a,
					#container .skinset-submenu.acoda-skin li.current-menu-item > a,
					.dock-menu-tabs.acoda-skin a:hover,
					.dock-menu-tabs.acoda-skin li.current_page_ancestor > a,
					.dock-menu-tabs.acoda-skin li.current-menu-item > a'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),		
				array(
					'id'        =>  'submenu_link_background_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Background Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Menu Link Background Hover Color.',
					'output'    => array('background-color' => '
					#container .skinset-submenu.acoda-skin a:hover,
					#container .skinset-submenu.acoda-skin li.current_page_ancestor > a, 
					#container .skinset-submenu.acoda-skin li.current-menu-item > a,
					.dock-menu-tabs.acoda-skin a:hover,
					.dock-menu-tabs.acoda-skin li.current_page_ancestor > a, 
					.dock-menu-tabs.acoda-skin li.current-menu-item > a'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
			)		
		) );		 


		Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Title Area', 'dynamix' ),
			'id'    => 'subheader_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-h1',
			'fields'     => array(						
				array(
					'id'        =>  'subheader_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the Title Area background color.',
					'output'    => array('background-color' => '.intro-wrap'),
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),					            
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'subheader_overlay_color',
					'type'      => 'color_rgba',
					'title'     => 'Overlay Color',
					'subtitle'  => 'Set the Title Area Overlay color. Useful when setting a background image.',
					'output'    => array('background-color' => '.intro-wrap .overlay'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),		
				array(
					'id'       => 'subheader_image',
					'type'     => 'media', 
					'url'      => true,
					'title'    => __('Background Image', 'dynamix'),
					'compiler'    => array('background-image' => '.intro-wrap'),
					'subtitle' => __('Set a Background Image.', 'dynamix'),
				),	
				array(
					'id'       => 'subheader_image_featured',
					'type'     => 'switch',
					'title'    => __('Use Post / Page Featured Image', 'dynamix'), 
					'subtitle'     => __('Choose to use the Page or Post Featured Image as a Background Image. The "Background Image" option is used when no Featured Image is set.', 'dynamix'),
					'default'  => false,
				),
				array(
					'id'       => 'subheader_parallax',
					'type'     => 'switch',
					'title'    => __('Enable Parallax', 'dynamix'), 
					'default'  => true,
				),			
				array(
					'id'       => 'subheader_image_position',
					'type'     => 'select',
					'title'    => __('Image Position', 'dynamix'), 
					'options' => array(
						'center center' => 'Center Center',
						'center top' => 'Center Top',
						'center bottom' => 'Center Bottom',					
						'left top' => 'Left Top',
						'left center' => 'Left Center',
						'left bottom' => 'Left Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right Center',
						'right bottom' => 'Right Bottom',					
					),
					'output'    => array('background-position' => '.intro-wrap'),
					'default'  => 'center center',				
				),	
				array(
					'id'       => 'subheader_image_repeat',
					'type'     => 'select',
					'title'    => __('Image Repeat', 'dynamix'), 
					'options' => array(
						'repeat' => 'Repeat',
						'repeat-x' => 'Repeat X',
						'repeat-y' => 'Repeat Y',
						'no-repeat' => 'No Repeat',
					),	
					'output'    => array('background-position' => '.intro-wrap'),
					'default'  => 'no-repeat',
				),		
				array( 
					'id'       => 'subheader-border',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Add a Border to the Title area.', 'dynamix'),
					'output'   => array('.intro-wrap'),
					'all'	   => false,
					'default'  => array(
						'border-color'  => '#EEEEEE', 
						'border-style'  => 'solid', 
						'border-top'    => '0', 
						'border-right'  => '0', 
						'border-bottom' => '1px', 
						'border-left'   => '0'
					)
				),
				array(
					'id'   => 'info_subheader_text',
					'type' => 'info',
					'title' => __('Typography', 'dynamix')
				),		
				array(
					'id'          => 'subheader_font',
					'type'        => 'typography', 
					'title'       => __('Title Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array( 'color' => '#container .skinset-sub_header.acoda-skin,#container .skinset-sub_header.acoda-skin h1'),
					'units'       => false,
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 		
				),		
				array(
					'id'        =>  'subheader_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => 'Set the Title Color.',
					'output'    => array(
						'color' => '#container .skinset-sub_header.acoda-skin,#container .skinset-sub_header.acoda-skin h1'
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'        =>  'subheader_h1_color',
					'type'      => 'color_rgba',
					'title'       => __('H1 Title Color', 'dynamix'),
					'subtitle'  => 'Set the H1 Title Color.',
					'output'    => array(
						'color' => '#container .skinset-sub_header.acoda-skin h1'
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'subheader_h2_color',
					'type'      => 'color_rgba',
					'title'       => __('Subtitle Color', 'dynamix'),
					'subtitle'  => 'Set the Subtitle Color.',
					'output'    => array(
						'color' => '#container .skinset-sub_header.acoda-skin h2'
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'        =>  'subheader_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Title Area Link Color.',
					'output'    => array(
						'color' => '#container .skinset-sub_header.acoda-skin a'
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'subheader_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Title Area Link Hover Color.',
					'output'    => array('color' => '#container .skinset-sub_header.acoda-skin a:hover'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
			)
		) );	

	 
	   Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Buttons', 'dynamix' ),
			'heading' => __( 'Buttons', 'dynamix' ),
			'id'    => 'buttons_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-rectangle-wide',
			'fields'     => array(			
				array(
					'id'        =>  'body_button_color',
					'type'      => 'color_rgba',
					'title'     => 'Button Color',
					'subtitle'  => 'Set the default Button Color.',
					// See Notes below about these lines.
					'output'    => array(
						'background-color' => acoda_skin_classes('body_button_color') ,
					),
					'default'   => array(
							'color'     => 'transparent',
							'alpha'     => 1
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'body_button_text_color',
					'type'      => 'color_rgba',
					'title'     => 'Button Text Color',
					'subtitle'  => 'Set the default Button Text Color.',
					'output'    => array(
						'color' => acoda_skin_classes('body_button_color') ,
					),
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'        =>  'body_button_hover_color',
					'type'      => 'color_rgba',
					'title'     => 'Button Hover Color',
					'subtitle'  => 'Set the default Button Hover Color.',
					// See Notes below about these lines.
					'output'    => array(
						'background-color' => acoda_skin_classes('body_button_hover_color') ,
					),
					'default'   => array(
							'color'     => '#202F33',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'body_button_hover_text_color',
					'type'      => 'color_rgba',
					'title'     => 'Button Hover Text Color',
					'subtitle'  => 'Set the default Button Hover Text Color.',
					// See Notes below about these lines.
					'output'    => array(
						'color' => acoda_skin_classes('body_button_hover_color') ,
					),
					'default'   => array(
							'color'     => '#ccc',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),		
				array( 
					'id'       => 'body_button_border',
					'type'     => 'border',
					'title'    => __('Button Border', 'dynamix'),
					'subtitle' => __('Add a Border to Buttons.', 'dynamix'),
					'output'   => acoda_skin_classes('body_button_color'),
					'all'	   => false,
				),		
				array(
					'id'   => 'body_backtotop_info',
					'type' => 'info',
					'title' => __('Back to Top Button', 'dynamix')
				),		
				array(
					'id'        =>  'backtotop_button_color',
					'type'      => 'color_rgba',
					'title'     => 'Back to Top Button Color',
					'subtitle'  => 'Set the default Button Color.',
					// See Notes below about these lines.
					'output'    => array(
						'background-color' => '.skinset-background .autototop a',
					),
					'default'   => array(
							'color'     => 'transparent',
							'alpha'     => 1
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'backtotop_button_hover_color',
					'type'      => 'color_rgba',
					'title'     => 'Back to Top Button Hover Color',
					'subtitle'  => 'Set the default Button Hover Color.',
					// See Notes below about these lines.
					'output'    => array(
						'background-color' => '.skinset-background .autototop a:hover',
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),		
				array(
					'id'        =>  'backtotop_text_color',
					'type'      => 'color_rgba',
					'title'     => 'Back to Top Text Color',
					'subtitle'  => 'Set the default Button Text Color.',
					'output'    => array(
						'color' => '.skinset-background .autototop a',
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			

				array(
					'id'        =>  'backtotop_hover_text_color',
					'type'      => 'color_rgba',
					'title'     => 'Back to Top Hover Text Color',
					'subtitle'  => 'Set the default Button Hover Text Color.',
					// See Notes below about these lines.
					'output'    => array(
						'color' => '.skinset-background .autototop a:hover',
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),		
				array( 
					'id'       => 'backtotop_button_border',
					'type'     => 'border',
					'title'    => __('Back to Top Button Border', 'dynamix'),
					'output'   => '.skinset-background .autototop a',
					'all'	   => false,
				),			   
			)		
		) );
		
	   Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Form Fields', 'dynamix' ),
			'heading' => __( 'Form Fields', 'dynamix' ),
			'id'    => 'formfields_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-file-alt',
			'fields'     => array(	
				array(
					'id'        =>  'body_element_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'output'    => array(
						'background-color' => acoda_skin_classes('body_element_color') ,
						'border-color' => acoda_skin_classes('body_element_color_border'),
					),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'default'   => array(
							'color'     => '#f9f9f9',
							'alpha'     => 1
					),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'body_element_border_color',
					'type'      => 'color_rgba',
					'title'       => __('Border Color', 'dynamix'),
					'output'    => array('border-color' => acoda_skin_classes('body_element_border') ),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'default'   => array(
							'color'     => '#eee',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),
				array(
					'id'        =>  'body_element_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'output'    => array('color' => acoda_skin_classes('body_element_color') ),
					'default'   => array(
							'color'     => '#222',
							'alpha'     => 1
					),					                  
				),		   
			)		
		) );			

	  Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Sidebar', 'dynamix' ),
			'id'    => 'sidebar_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-window-maximize fa-rotate-90',
			'fields'     => array(						
				array(
					'id'        =>  'sidebar_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the sidebar background color.',
					'output'    => array('background-color' => '.skinset-sidebar'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),				
				array(
					'id'       => 'sidebar_image',
					'type'     => 'media', 
					'url'      => true,
					'title'    => __('Background Image', 'dynamix'),
					'compiler'    => array('background-image' => '.skinset-sidebar'),
					'subtitle' => __('Set a Background Image.', 'dynamix'),
				),		
				array(
					'id'       => 'sidebar_image_position',
					'type'     => 'select',
					'title'    => __('Image Position', 'dynamix'), 
					'options' => array(
						'center center' => 'Center Center',
						'center top' => 'Center Top',
						'center bottom' => 'Center Bottom',					
						'left top' => 'Left Top',
						'left center' => 'Left Center',
						'left bottom' => 'Left Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right Center',
						'right bottom' => 'Right Bottom',					
					),
					'output'    => array('background-position' => '.skinset-sidebar'),
					'default'  => 'center center',				
				),	
				array(
					'id'       => 'sidebar_image_repeat',
					'type'     => 'select',
					'title'    => __('Image Repeat', 'dynamix'), 
					'options' => array(
						'repeat' => 'Repeat',
						'repeat-x' => 'Repeat X',
						'repeat-y' => 'Repeat Y',
						'no-repeat' => 'No Repeat',
					),	
					'output'    => array('background-position' => '.skinset-sidebar'),
					'default'  => 'no-repeat',
				),		
				array( 
					'id'       => 'sidebar-border',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Add a Border to the Sidebar area.', 'dynamix'),
					'output'   => array('.skinset-sidebar'),
					'all'	   => false,
				),
				array(
					'id'   => 'info_sidebar_text',
					'type' => 'info',
					'title' => __('Typography', 'dynamix')
				),		
				array(
					'id'          => 'sidebar_typography',
					'type'        => 'typography', 
					'title'       => __('Sidebar Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-sidebar'),
					'text-align'	  => false,
					'color'		  => false,
					'word-spacing' => true,
					'text-transform' => true,	
					'line-height' => true,
					'font-size'	  => true, 
					'letter-spacing'	  => true,
				),
				array(
					'id'        =>  'sidebar_font_color',
					'type'      => 'color_rgba',
					'title'     => __('Font Color', 'dynamix'),
					'subtitle'  => __('Set the Sidebar Font Color.', 'dynamix'),
					'output'    => array('color' => '.skinset-sidebar'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),		  
				array(
					'id'        =>  'sidebar_link_color',
					'type'      => 'color_rgba',
					'title'     => __('Link Color', 'dynamix'),
					'subtitle'  => __('Set the Sidebar Link Color.', 'dynamix'),
					'output'    => array(
						'color' => '.skinset-sidebar.acoda-skin a'
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),	
				array(
					'id'        =>  'sidebar_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Sidebar Link Hover Color.',
					'output'    => array('color' => '.skinset-sidebar.acoda-skin a:hover,.skinset-sidebar.acoda-skin .widget ul li.current_page_item a'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),	  
				array(
					'id'          => 'sidebar_title_typography',
					'type'        => 'typography', 
					'title'       => __('Sidebar Widget Title Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-sidebar .widget-title,#container .skinset-sidebar .apb-title-wrap .apb-title'),
					'text-align'	  => false,
					'color'		  => false,
					'word-spacing' => true,
					'line-height' => true,
					'text-transform' => true,	
					'font-size'	  => true, 
					'letter-spacing'	  => true,
				),	  
				array(
					'id'        =>  'sidebar_widget_title_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Widget Title Color', 'dynamix'),
					'subtitle' => __('Set the Font Color for Widget Titles.', 'dynamix'),
					'output'    => array('color' => '.skinset-sidebar .widget-title,.skinset-sidebar .apb-title-wrap .apb-title' ),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),	
				array(
					'id'        =>  'sidebar_widget_title_color',
					'type'      => 'color_rgba',
					'title'       => __('Widget Title Background Color', 'dynamix'),
					'subtitle' => __('Set the Background Color for Widget Titles.', 'dynamix'),
					'output'    => array(
						'background-color' => '.skinset-sidebar .widget-title,.skinset-sidebar .apb-title-wrap .apb-title'
					),				                  
				),
				array( 
					'id'       => 'sidebar_widget_title_border_color',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Widget Title Border.', 'dynamix'),
					'output'   => array('.skinset-sidebar .widget-title-wrap,.skinset-sidebar .apb-title-wrap'),
					'all'	   => false,
				),		  
				array(
					'id'   => 'sidebar_elements_info',
					'type' => 'info',
					'title' => __('Form Fields, Tables & Elements', 'dynamix')
				),
				array(
					'id'        =>  'sidebar_element_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'output'    => array(
						'background-color' => acoda_skin_classes('sidebar_element_color') ,
					),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),	
				array(
					'id'        =>  'sidebar_element_border_color',
					'type'      => 'color_rgba',
					'title'       => __('Border Color', 'dynamix'),
					'output'    => array('border-color' => acoda_skin_classes('sidebar_element_border') ),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),
				array(
					'id'        =>  'sidebar_element_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'output'    => array('color' => acoda_skin_classes('sidebar_element_color') ),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),	  
			)
		) );	

		Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Footer', 'dynamix' ),
			'id'    => 'footer_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-window-maximize fa-rotate-180',
			'fields'     => array(						
				array(
					'id'        =>  'footer_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the footer background color.',
					'output'    => array('background-color' => '#footer-wrap'),
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),				
				array(
					'id'       => 'footer_image',
					'type'     => 'media', 
					'url'      => true,
					'title'    => __('Background Image', 'dynamix'),
					'subtitle' => __('Set a Background Image.', 'dynamix'),
				),			
				array(
					'id'       => 'footer_image_position',
					'type'     => 'select',
					'title'    => __('Image Position', 'dynamix'), 
					'options' => array(
						'center center' => 'Center Center',
						'center top' => 'Center Top',
						'center bottom' => 'Center Bottom',					
						'left top' => 'Left Top',
						'left center' => 'Left Center',
						'left bottom' => 'Left Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right Center',
						'right bottom' => 'Right Bottom',					
					),
					'output'    => array('background-position' => '#footer-wrap'),
					'default'  => 'center center',				
				),	
				array(
					'id'       => 'footer_image_repeat',
					'type'     => 'select',
					'title'    => __('Image Repeat', 'dynamix'), 
					'options' => array(
						'repeat' => 'Repeat',
						'repeat-x' => 'Repeat X',
						'repeat-y' => 'Repeat Y',
						'no-repeat' => 'No Repeat',
					),	
					'output'    => array('background-position' => '#footer-wrap'),
					'default'  => 'no-repeat',
				),	
				array(
					'id'        =>  'footer_color_overlay',
					'type'      => 'color_rgba',
					'title'     => 'Overlay Color',
					'subtitle'  => 'Set the	Footer Overlay Color.',
					'output'    => array('background-color' => '#footer-wrap .overlay'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array( 
					'id'       => 'footer-border',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Add a Border to the Footer area.', 'dynamix'),
					'output'   => array('#footer-wrap'),
					'all'	   => false,
					'default'  => array(
						'border-color'  => '#EEEEEE', 
						'border-style'  => 'solid', 
						'border-top'    => '0', 
						'border-right'  => '0', 
						'border-bottom' => '1px', 
						'border-left'   => '0'
					)
				),
				array(
					'id'   => 'info_footer_text',
					'type' => 'info',
					'title' => __('Typography', 'dynamix')
				),		
				array(
					'id'          => 'footer_font',
					'type'        => 'typography', 
					'title'       => __('Footer Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-footer.acoda-skin'),
					'units'       => false,
					'text-align'	  => false,
					'color'		  => false,
					'text-transform' => true,	   
					'line-height' => true, 
					'word-spacing' => true,
					'letter-spacing' => true, 		
				),	
				array(
					'id'        =>  'footer_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle'  => 'Set the Footer Font Color.',
					'output'    => array(
						'color' => '.skinset-footer.acoda-skin'
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),			
				array(
					'id'        =>  'footer_link_color',
					'type'      => 'color_rgba',
					'title'       => __('Link Color', 'dynamix'),
					'subtitle'  => 'Set the Footer Link Color.',
					'output'    => array(
						'color' => '.skinset-footer.acoda-skin a'
					),
					'default'   => array(
							'color'     => '#202F33',
							'alpha'     => 1
					),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'        =>  'footer_link_color_hover',
					'type'      => 'color_rgba',
					'title'       => __('Link Hover Color', 'dynamix'),
					'subtitle'  => 'Set the Footer Link Hover Color.',
					'output'    => array('color' => '.skinset-footer.acoda-skin a:hover'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array(
					'id'          => 'footer_title_typography',
					'type'        => 'typography', 
					'title'       => __('Footer Widget Title Typography', 'dynamix'),
					'google'      => true, 
					'font-backup' => true,
					'output'      => array('.skinset-footer .widget-title,#container .skinset-footer .apb-title-wrap .apb-title'),
					'text-align'	  => false,
					'color'		  => false,
					'word-spacing' => true,
					'line-height' => true,
					'text-transform' => true,	
					'font-size'	  => true, 
					'letter-spacing'	  => true,
				),	  
				array(
					'id'        =>  'footer_widget_title_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Widget Title Color', 'dynamix'),
					'subtitle' => __('Set the Font Color for Widget Titles.', 'dynamix'),
					'output'    => array('color' => '.skinset-footer .widget-title,.skinset-footer .apb-title-wrap .apb-title' ),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	  
				),	
				array(
					'id'        =>  'footer_widget_title_color',
					'type'      => 'color_rgba',
					'title'       => __('Widget Title Background Color', 'dynamix'),
					'subtitle' => __('Set the Background Color for Widget Titles.', 'dynamix'),
					'output'    => array(
						'background-color' => '.skinset-footer .widget-title,.skinset-footer .apb-title-wrap .apb-title'
					),				                  
				),
				array( 
					'id'       => 'footer_widget_title_border_color',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Widget Title Border.', 'dynamix'),
					'output'   => array('.skinset-footer .widget-title-wrap,.skinset-footer .apb-title-wrap'),
					'all'	   => false,
				),				
				array(
					'id'   => 'footer_elements_info',
					'type' => 'info',
					'title' => __('Form Fields, Tables & Elements', 'dynamix')
				),		
				array(
					'id'        =>  'footer_element_color',
					'type'      => 'color_rgba',
					'title'       => __('Background Color', 'dynamix'),
					'output'    => array(
						'background-color' => acoda_skin_classes('footer_element_color') ,
					),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   

				),	
				array(
					'id'        =>  'footer_element_border_color',
					'type'      => 'color_rgba',
					'title'       => __('Border Color', 'dynamix'),
					'output'    => array('border-color' => acoda_skin_classes('footer_element_border') ),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),	
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),
				array(
					'id'        =>  'footer_element_font_color',
					'type'      => 'color_rgba',
					'title'       => __('Font Color', 'dynamix'),
					'subtitle' => __('Set the Background Color for Form Fields, Tables & Elements.', 'dynamix'),
					'output'    => array('color' => acoda_skin_classes('footer_element_color') ),			
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),	   
				),		
				array(
					'id'   => 'info_lowerfooter',
					'type' => 'info',
					'title' => __('Lower Footer', 'dynamix')
				),		
				array(
					'id'        =>  'footer_lower_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the lower footer background color.',
					'output'    => array('background-color' => '#footer-wrap .lowerfooter-wrap'),		
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),				
				array(
					'id'          => 'footer_lower_font',
					'type'        => 'typography', 
					'title'       => __('Lower Footer Typography', 'dynamix'),
					'google'      => false, 
					'font-backup' => false,
					'output'      => array('#footer-wrap .lowerfooter-wrap'),
					'units'       => false,
					'font-family' => false,
			 		'font-style'  => false,
			  		'font-weight' => false,
					'text-align'  => false,
					'color'		  => true,
					'text-transform' => true,	   
					'line-height' => false, 
					'word-spacing' => false,
					'letter-spacing' => false, 		
				),	
			)
		) );		 



		Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Background', 'dynamix' ),
			'id'    => 'background_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-browser',
			'fields'     => array(			
				array(
					'id'        =>  'background_color',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the header background color.',
					'output'    => array('background-color' => '.skinset-background'),
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),				
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),				
				array(
					'id'       => 'background_image',
					'type'     => 'media', 
					'url'      => true,
					'title'    => __('Background Image', 'dynamix'),
					'compiler'    => array('background-image' => '.skinset-background'),
					'subtitle' => __('Set a Background Image.', 'dynamix'),
				),		
				array(
					'id'       => 'background_image_position',
					'type'     => 'select',
					'title'    => __('Image Position', 'dynamix'), 
					'options' => array(
						'center center' => 'Center Center',
						'center top' => 'Center Top',
						'center bottom' => 'Center Bottom',					
						'left top' => 'Left Top',
						'left center' => 'Left Center',
						'left bottom' => 'Left Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right Center',
						'right bottom' => 'Right Bottom',					
					),

					'output'    => array('background-position' => '.skinset-background'),
					'default'  => 'center center',				
				),	
				array(
					'id'       => 'background_image_size',
					'type'     => 'select',
					'title'    => __('Image Size', 'dynamix'), 
					'options' => array(
						'auto' => 'Auto',
						'cover' => 'Cover',
						'contain' => 'Contain',
					),	
					'output'    => array('background-size' => '.skinset-background'),
					'default'  => 'no-repeat',
				),				
				array(
					'id'       => 'background_image_repeat',
					'type'     => 'select',
					'title'    => __('Image Repeat', 'dynamix'), 
					'options' => array(
						'repeat' => 'Repeat',
						'repeat-x' => 'Repeat X',
						'repeat-y' => 'Repeat Y',
						'no-repeat' => 'No Repeat',
					),	
					'output'    => array('background-position' => '.skinset-background'),
					'default'  => 'no-repeat',
				),																																					
			)		
		) );	
		
		
		Redux::setSection('dynamix_'. $skin, array(
			'title' => __( 'Ad Area', 'dynamix' ),
			'heading' => __( 'Top Ad Area', 'dynamix' ),
			'id'    => 'ad_skin',
			'subsection'       => true,
			'icon'  => 'fal fa-newspaper',
			'fields'     => array(			
				array(
					'id'        =>  'ad_top_background',
					'type'      => 'color_rgba',
					'title'     => 'Background Color',
					'subtitle'  => 'Set the header background color.',
					'output'    => array('background-color' => '.skinset-ad'),
					'default'   => array(
							'color'     => '#fff',
							'alpha'     => 1
					),				
					'options'       => array(
						'clickout_fires_change' => true,
						'show_buttons' => false,
					),		
				),	
				array( 
					'id'       => 'ad_top_border',
					'type'     => 'border',
					'title'    => __('Border', 'dynamix'),
					'subtitle' => __('Add a Border to the Top Ad area.', 'dynamix'),
					'output'   => array('.skinset-ad'),
					'all'	   => false,
					'default'  => array(
						'border-color'  => '#EEEEEE', 
						'border-style'  => 'none', 
						'border-top'    => '0', 
						'border-right'  => '0', 
						'border-bottom' => '0', 
						'border-left'   => '0'
					)
				),			
			)		
		) );		
	}
	
	
	

	// Theme Options
    Redux::setSection( $opt_name, array(
        'title' => __( 'Documentation', 'dynamix' ),
		'heading' => __( 'Documentation & Support', 'dynamix' ),
        'id'    => 'documentation',
        'icon'  => 'fal fa-life-ring',		
    ) );
   
    Redux::setSection( $opt_name, array(
        'title' => __( 'Install Demos', 'dynamix' ),
        'id'    => 'demos',
        'icon'  => 'fal fa-images',		
    ) );


    Redux::setSection( $opt_name, array(
        'title' => __( 'Layout', 'dynamix' ),
        'id'    => 'layout',
        'icon'  => 'fal fa-browser',
        'fields'     => array(			
			array(
				'id'       => 'site_layout',
				'type'     => 'button_set',
				'title'    => __('Site Layout', 'dynamix'), 
				'subtitle'     => __('Choose between Wide or Boxed Layout.', 'dynamix'),
				'options' => array(
					'wide' => esc_html__('Wide', 'dynamix'),
					'boxed' => esc_html__('Boxed', 'dynamix'),
				),
				'default' => 'wide'
			),						
			array(
				'id' => 'max_site_width',
				'type' => 'text',
				'title' => __('Maximum Site Width', 'dynamix'),
				'subtitle' => __('Set the maximum site width. Enter any valid CSS unit, e.g. 1220px.', 'dynamix'),
				"default" => 1220,
			),	
			array(
				'id'             => 'site_margin',
				'type'           => 'spacing',
				'title' 		 => __('Site Margin', 'dynamix'),
				//'output'         => array('#container.layout-boxed,#container.layout-wide'),
				'mode'           => 'margin',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set a Margin for main site area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'margin-top'     => '0', 
					'margin-right'   => 'auto', 
					'margin-bottom'  => '0', 
					'margin-left'    => 'auto',
					'units'          => '', 
				)
			),		
			array(
				'id'       => 'body_width',
				'type'     => 'button_set',
				'title'    => __('Body Width', 'dynamix'), 
				'subtitle'     => __('Set the Width of the Body.', 'dynamix'),
				'options' => array(
					'wide' => esc_html__('Site Width', 'dynamix'),
					'fullwidth' => esc_html__('Browser Width', 'dynamix'),
				),
				'default'  => 'wide',
			),		
			array(
				'id'       => 'pagelayout',
				'type'     => 'image_select',
                'hint' => array(
                    'title'   => 'Hint Title',
                    'content' => 'Hint content about this field!'
                ),				
				'title'    => __('Default Page Layout', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding page option.', 'dynamix'),
				'options'  => array(
					'layout_one'      => array(
						'alt'   => '1 Column', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/1col.png'
					),
					'layout_two'      => array(
						'alt'   => '2 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/2cl.png'
					),
					'layout_three'      => array(
						'alt'   => '3 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cl.png'
					),					
					'layout_four'      => array(
						'alt'   => '2 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/2cr.png'
					),
					'layout_five'      => array(
						'alt'  => '3 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/3cr.png'
					),					
					'layout_six'      => array(
						'alt'   => '3 Column Middle', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cm.png'
					),
				),
				'default' => 'layout_one'		
			),
			array(
				'id' => 'max_page_width',
				'type' => 'text',
				'title' => __('Maximum Page Width', 'dynamix'),
				'subtitle' => __('Set the maximum Page Content width. Default is the "Site Width" value.', 'dynamix'),
				"default" => '',
				'required' => array( 
					array('pagelayout','equals',array( 'layout_one' ) ), 
				)			
			),		
			array(
				'id'       => 'pagepinsidebar',
				'type'     => 'button_set',
				'title'    => __('Pin Sidebar', 'dynamix'), 
				'subtitle'     => __('Pin the Sidebar to the edge of the site.', 'dynamix'),
				'options' => array(
					'normal' => esc_html__('Normal', 'dynamix'),
					'pinned' => esc_html__('Pinned', 'dynamix'),
				),
				'default'  => 'normal',
				'required' => array( 
					array('pagelayout','equals',array( 'layout_two','layout_four' ) ), 
				)		
			),	
			array(
				'id'       => 'pagesticksidebar',
				'type'     => 'switch',
				'title'    => __('Sticky Sidebar', 'dynamix'), 
				'subtitle'     => __('Make the Sidebar Sticky when scrolling down the page.', 'dynamix'),
				'default'  => 'false',	
			),					
            array(
                'id'       => 'sidebars_num',
                'type'     => 'text',
                'title'    => __( 'Number of Widget Areas', 'dynamix' ),
                'subtitle' => __( 'Set the number of Widget Areas ( Sidebars ).', 'dynamix' ),
                'default'  => '2',
            ),			
			array(
				'id'       => 'widget_tag',
				'type'     => 'select',
				'title'    => __('Widget Title HTML Tag', 'dynamix'), 
				'subtitle' => __('Choose what HTML is used to display the Widget Titles.', 'dynamix'),
				'options'  => array(
					'p' => esc_html__('p', 'dynamix'),
					'h3' => esc_html__('h3', 'dynamix'),
					'h4' => esc_html__('h4', 'dynamix'),
					'h5' => esc_html__('h5', 'dynamix'),
					'h6' => esc_html__('h6', 'dynamix'),
				),
				'default'  => 'p',
			),					
            array(
                'id'       => 'search_placeholder',
                'type'     => 'text',
                'title'    => __( 'Search Placeholder', 'dynamix' ),
                'subtitle' => __( 'Set the placeholder text for search fields. Default is: Search .', 'dynamix' ),
                'default'  => 'Search',
            ),	
			array(
				'id'   => 'info_layout_advanced',
				'type' => 'info',
				'title' => __('Advanced Layout', 'dynamix')
			),			
			/*array(
				'id' => 'content_width',
				'type' => 'text',
				'title' => __('Maximum Content Width', 'dynamix'),
				'subtitle' => __('Set the maximum content width for posts / pages. Enter any valid CSS unit, e.g. 900px.', 'dynamix'),
				"default" => '100%',
			),	*/	
			array(
				'id' => 'sidebar_width',
				'type' => 'text',
				'title' => __('Sidebar Width', 'dynamix'),
				'subtitle' => __('Set the Sidebar width. Enter any valid CSS unit, e.g. 25%.', 'dynamix'),
				"default" => '33%',
			),	
			array(
				'id' => 'dual_sidebar_width',
				'type' => 'text',
				'title' => __('Dual Sidebar Width', 'dynamix'),
				'subtitle' => __('Set the Sidebar width for Dual Sidebars. Enter any valid CSS unit, e.g. 25%.', 'dynamix'),
				"default" => '25%',
			),
			array(
				'id'             => 'content_padding',
				'type'           => 'spacing',
				'title' 		 => __('Content Area Padding', 'dynamix'),
				//'output'         => array('#content'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for the Content area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '30px', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '30px', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),		
			array(
				'id'             => 'sidebar_padding',
				'type'           => 'spacing',
				'title' 		 => __('Sidebar Padding', 'dynamix'),
				//'output'         => array('#content > .sidebar'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for Sidebar areas.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '30px', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '30px', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),	
			array(
				'id'             => 'vc_row_padding',
				'type'           => 'spacing',
				'title' 		 => __('Visual Composer Row Padding', 'dynamix'),
				'output'         => array('.entry > .wpb_row.row'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for the Content Rows.', 'dynamix'),
				'top' => true,
				'bottom' => true,
				'left' => false,
				'right' => false,
				'default'            => array(
					'padding-top'     => '30px', 
					'padding-bottom'  => '30px', 
					'units'          => 'px', 
				)
			),		
        )		
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __( 'Dock Bar', 'dynamix' ),
        'id'    => 'dockbar',
        'icon'  => 'fal fa-window-alt',
        'fields'     => array(
			array(
				'id'       => 'dockbar_position',
				'type'     => 'button_set',
				'title'    => __('Dock Bar Position', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding page option.', 'dynamix'),
				'options'  => array(
					'dock_layout_1' => esc_html__('Above Header', 'dynamix'),	
					'dock_layout_4' => esc_html__('Within Header', 'dynamix'),
				),
				'default' => 'dock_layout_4'		
			),	
			array(
				'id'       => 'dockbar_width',
				'type'     => 'button_set',
				'title'    => __('Dockbar Width', 'dynamix'), 
				'subtitle'     => __('Set the Width of the Dockbar.', 'dynamix'),
				'options' => array(
					'wide' => esc_html__('Site Width', 'dynamix'),
					'fullwidth' => esc_html__('Browser Width', 'dynamix'),
				),
				'required' => array( 
					array('dockbar_position','equals','dock_layout_1'), 
				),
				'default' => 'wide'	
			),		
			array(
				'id'             => 'dockbar_padding',
				'type'           => 'spacing',
				'title' 		 => __('Dockbar Padding', 'dynamix'),
				//'output'         => array('.dock-panel-wrap.skinset-dockbar'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for the Dockbar Area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '0', 
					'padding-right'   => '0', 
					'padding-bottom'  => '0', 
					'padding-left'    => '15px',
					'units'          => 'px', 
				)
			),		
			array(
				'id'       => 'dockicon_panels',
				'type'     => 'select',
				'title'    => __('Flyout Window Style', 'dynamix'), 
				'subtitle' => __('Choose the style of the Dock Flyout Window.', 'dynamix'),
				'options'  => array(
					'dockpanel_type_1' => esc_html__('Pointer', 'dynamix'),
					'dockpanel_type_2' => esc_html__('Off-Canvas', 'dynamix'),
					'dockpanel_type_3' => esc_html__('Fullscreen', 'dynamix'),

				),
				'default'  => 'dockpanel_type_2',
			),	
			array(
				'id'   => 'info_search',
				'type' => 'info',
				'title' => __('Search Widget', 'dynamix')
			),			
			array(
				'id'       => 'dockicon_search',
				'type'     => 'button_set',
				'title'    => __('Search Widget Display', 'dynamix'), 
				'subtitle'     => __('Display Search Widget Icon in Dock Bar.', 'dynamix'),
				'options' => array(
					'inline' => esc_html__('Inline', 'dynamix'),
					'flyout' => esc_html__('Flyout Window', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),		
				'default'  => 'flyout',
			),
			array(
				'id' => 'dockicon_search_text',
				'type' => 'text',
				'title' => __('Icon Text', 'dynamix'),
				'subtitle' => __('Only available on Desktop', 'dynamix'),
				'required' => array( 
					array('dockicon_search','equals','flyout'), 
				)		
			),		
			array(
				'id'       => 'dockicon_search_mobile',
				'type'     => 'switch',
				'title'    => __('Mobile Icon', 'dynamix'), 
				'subtitle'     => __('Collapse Widget into an Icon on Mobile Devices.', 'dynamix'),	
				'default'  => true,
				'required' => array( 
					array('dockicon_search','equals','inline'), 
				)		
			),			
			array(
				'id'   => 'custom_widgets',
				'type' => 'info',
				'title' => __('Custom Dock Icons', 'dynamix')
			),			
			array(
				'id'         => 'dockicon_custom',
				'type'       => 'repeater',
				'title'      => __( 'Add Custom Dock Widgets', 'dynamix' ),
				'subtitle'   => __( '', 'dynamix' ),
				'desc'       => __( '', 'dynamix' ),
				'group_values' => true, // Group all fields below within the repeater ID
				'item_name' => 'Dock Widget', // Add a repeater block name to the Add and Delete buttons
				//'bind_title' => '', // Bind the repeater block title to this field ID
				//'static'     => 2, // Set the number of repeater blocks to be output
				'limit' => 6, // Limit the number of repeater blocks a user can create
				'sortable' => true, // Allow the users to sort the repeater blocks or not
				'fields'     => array(
					/*array(
						'id'=>'dockicon',
						'type' => 'icon_select', 
						//'required' => array('switch-fold','equals','0'),   
						'title' => __('Dock Icon', 'dynamix'),
						'default'     => 'fal fa-info-circle',
						//'options' => array(), // key/value pair, value is the title
						//'enqueue' => false, // Disable auto-enqueue of stylesheet if present in the panel
						//'enqueue_frontend' => false, // Disable auto-enqueue of stylesheet on the front-end
						'stylesheet' => get_template_directory_uri() . '/css/font-icons/fontawesome/css/fontawesome-all.min.css', // full path OR url to stylesheet
						'prefix' => 'fal', // If needed to initialize the icon
						'selector' => 'fa-', // How each icons begins for this given font
						'height' => 300 // Change the height of the container. defaults to 300px;
					),*/	
					array(
						'id' => 'dockicon',
						'type' => 'text',
						'title' => __('Dock Icon', 'dynamix'),
						'subtitle' => __('Choose an icon to trigger the Widget Area.', 'dynamix'),
						'desc' => __('Visit <a href="https://fontawesome.com/icons/" target="_blank">FontAwesome</a> and copy the icon class into this field.', 'dynamix'),
						'required' => array( 
							array('dockicon_search','equals','flyout'), 
						),
						'default' => 'fal fa-info-circle'
					),			
					array(
						'id'       => 'dock_widget',
						'type'     => 'select',
						'title'    => __('Select Widget Area', 'dynamix'), 
						'subtitle' => __('Select which widget area to use for this Dock Icon.', 'dynamix'),
						'data' => 'sidebars',
						'default' => 'sidebar1'
					),	
					array(
						'id'       => 'dockicon_panel',
						'type'     => 'button_set',
						'title'    => __('Dock Widget Format', 'dynamix'), 
						'subtitle'     => __('Choose to display the Information Dock Widget as inline or within a Flyout Window.', 'dynamix'),
						'options' => array(
							'inline' => esc_html__('Inline', 'dynamix'),
							'flyout' => esc_html__('Flyout Window', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
						'default'  => 'flyout',
					),			
					array(
						'id' => 'dockicon_text',
						'type' => 'text',
						'title' => __('Icon Text', 'dynamix'),
						'subtitle' => __('Only available for Flyout Window on Desktop', 'dynamix'),
						'required' => array( 
							array('dockicon_panel','equals','flyout'), 
						)		
					),		
					array(
						'id'       => 'dockicon_panel_mobile',
						'type'     => 'switch',
						'title'    => __('Mobile Icon for Inline Format', 'dynamix'), 
						'subtitle'     => __('Collapse Inline Widget into an Icon on Mobile Devices.', 'dynamix'),	
						'default'  => true,
						'required' => array( 
							array('dockicon_panel','equals','inline'), 
						)		
					),		
				)
			)	
        )		
    ) );	

    Redux::setSection( $opt_name, array(
        'title' => __( 'Header', 'dynamix' ),
        'id'    => 'header',
        'icon'  => 'fal fa-window-maximize',
        'fields'     => array(
			array(
				'id'       => 'header_layout',
				'type'     => 'button_set',
				'title'    => __('Header Position', 'dynamix'), 
				'subtitle'     => __('Set the Position of the Header.', 'dynamix'),
				'options' => array(
					'top' => esc_html__('Top', 'dynamix'),
					'left' => esc_html__('Left', 'dynamix'),
				),
				'default'  => 'top',
			),	
			array(
				'id'       => 'header_style',
				'type'     => 'image_select',
				'title'    => __('Header Style', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding post option.', 'dynamix'),
				'options'  => array(
					'inline'      => array(
						'alt'   => 'Inline', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/header-inline.png'
					),
					'inline_middle_logo'      => array(
						'alt'   => 'Inline Middle Logo', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/header-inline-middle-logo.png'
					),		
					'stacked'      => array(
						'alt'   => 'Stacked', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/header-stacked.png'
					),					
					'middle'      => array(
						'alt'   => '3 Column Middle', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/header-middle.png'
					),
				),
				'default' => 'inline',
				'required' => array( 
					array('header_layout','equals','top'), 
				)			
			),	
			array(
				'id'       => 'header_style_left',
				'type'     => 'image_select',
				'title'    => __('Header Format', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding post option.', 'dynamix'),
				'options'  => array(
					'logo_dock_menu'      => array(
						'alt'   => 'Logo Dock Menu', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/header-left-logo-dock-menu.png'
					),
					'logo_menu_dock'      => array(
						'alt'   => 'Logo Menu Dock', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/header-left-logo-menu-dock.png'
					),		
				),
				'default' => 'logo_dock_menu',
				'required' => array( 
					array('header_layout','equals','left'), 
				)			
			),		
			array(
				'id'       => 'header_left_align',
				'type'     => 'button_set',
				'title'    => __('Text Align', 'dynamix'), 
				'options' => array(
					'left' => esc_html__('Left', 'dynamix'),
					'center' => esc_html__('Center', 'dynamix'),
					'right' => esc_html__('Right', 'dynamix'),
				),
				'default'  => 'left',
				'required' => array( 
					array('header_layout','equals',array( 'left' ) ), 
				)			
			),		
			array(
				'id'       => 'header_vertical_alignment',
				'type'     => 'button_set',
				'title'    => __('Vertical Alignment', 'dynamix'), 
				'subtitle'     => __('Set the Vertical Alignment of the Header Contents.', 'dynamix'),
				'options' => array(
					'middle' => esc_html__('Middle', 'dynamix'),
					'top' => esc_html__('Top', 'dynamix'),
					'bottom' => esc_html__('Bottom', 'dynamix'),
				),
				'default' => 'middle',
				'required' => array( 
					array('header_style','equals', array( 'inline','inline_middle_logo' ) ),
				)			
			),						
			array(
				'id'       => 'branding_alignment_inline',
				'type'     => 'button_set',
				'title'    => __('Branding Alignment', 'dynamix'), 
				'subtitle'     => __('Set the Logo Alignment.', 'dynamix'),
				'options' => array(
					'left' => esc_html__('Left', 'dynamix'),
					'right' => esc_html__('Right', 'dynamix'),
				),
				'default'  => 'left',
				'required' => array( 
					array('header_style','equals','inline'), 
				)			
			),		
			array(
				'id'       => 'menu_alignment_inline',
				'type'     => 'button_set',
				'title'    => __('Menu Alignment', 'dynamix'), 
				'subtitle'     => __('Set the Menu Alignment.', 'dynamix'),
				'options' => array(
					'left' => esc_html__('Left', 'dynamix'),
					'right' => esc_html__('Right', 'dynamix'),
				),
				'default'  => 'right',
				'required' => array( 
					array('header_style','equals','inline'), 
				)			
			),		
			array(
				'id'       => 'branding_alignment_stacked',
				'type'     => 'button_set',
				'title'    => __('Branding Alignment', 'dynamix'), 
				'subtitle'     => __('Set the Logo Alignment.', 'dynamix'),
				'options' => array(
					'left' => esc_html__('Left', 'dynamix'),
					'center' => esc_html__('Center', 'dynamix'),
					'right' => esc_html__('Right', 'dynamix'),
				),
				'default'  => 'left',
				'required' => array( 
					array('header_style','equals','stacked'), 
				)			
			),		
			array(
				'id'       => 'menu_alignment_stacked',
				'type'     => 'button_set',
				'title'    => __('Menu Alignment', 'dynamix'), 
				'subtitle'     => __('Set the Menu Alignment.', 'dynamix'),
				'options' => array(
					'left' => esc_html__('Left', 'dynamix'),
					'center' => esc_html__('Center', 'dynamix'),
					'right' => esc_html__('Right', 'dynamix'),
				),
				'default'  => 'right',
				'required' => array( 
					array('header_style','equals','stacked'), 
				)			
			),			
			array(
				'id'       => 'header_width',
				'type'     => 'button_set',
				'title'    => __('Header Width', 'dynamix'), 
				'subtitle'     => __('Set the Width of the Header.', 'dynamix'),
				'options' => array(
					'wide' => esc_html__('Site Width', 'dynamix'),
					'fullwidth' => esc_html__('Browser Width', 'dynamix'),
				),
				'default'  => 'wide',
				'required' => array( 
					array('header_layout','equals','top'), 
				)			
			),
			array(
				'id' => 'header_width_value',
				'type' => 'text',
				'title' => __('Header Width', 'dynamix'),
				'subtitle' => __('Set the Header Width. Enter any valid CSS unit, e.g. 200px.', 'dynamix'),
				"default" => '280px',
				'required' => array( 
					array('header_layout','!=','top'), 
				)		
			),			
			array(
				'id'             => 'header_padding',
				'type'           => 'spacing',
				'title' 		 => __('Header Padding', 'dynamix'),
				//'output'         => array('#header .inner-wrap, #header .menu-wrap.wide'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for the Header Area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '0', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '0', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),			
			array(
				'id' => 'header_height',
				'type' => 'text',
				'title' => __('Header Height', 'dynamix'),
				'subtitle' => __('Set the Header Height. Enter any valid CSS unit, e.g. 200px.', 'dynamix'),
				"default" => '',
			),	
			array(
				'id'       => 'header_float',
				'type'     => 'button_set',
				'title'    => __('Floating Header', 'dynamix'), 
				'options' => array(
					'header_float_disabled' => esc_html__('Disable', 'dynamix'),
					'header_float' => esc_html__('Float', 'dynamix'),
					'header_float transparent' => esc_html__('Float + Transparent', 'dynamix'),
				),
				'default'  => 'header_float_disabled',
				'required' => array( 
					array('header_layout','equals',array( 'top' ) ), 
				)			
			),		
        )		
    ) );		


    Redux::setSection( $opt_name, array(
        'title' => __( 'Sticky Header', 'dynamix' ),
        'id'    => 'sticky_header',
		'subsection'       => true,
        'fields'     => array(
			array(
				'id'       => 'sticky_menu',
				'type'     => 'switch',
				'title'    => __('Sticky Header', 'dynamix'), 
				'subtitle'     => __('Set the Header to stick to the top, when scrolling down the page.', 'dynamix'),
				'default'  => true,
			),			
			array(
				'id'       => 'sticky_menu_type',
				'type'     => 'button_set',
				'title'    => __('Sticky Header Mode', 'dynamix'), 
				'subtitle'     => __('Set the menu to display Inline or as an Icon in the Dock Bar.', 'dynamix'),
				'options' => array(
					'sticky_menu_logo' => esc_html__('Menu + Logo', 'dynamix'),
					'sticky_menu' => esc_html__('Menu', 'dynamix'),
				),
				'default'  => 'sticky_menu_logo',
				'required' => array( 
					array('sticky_menu','equals','1'), 
				)		
			),	
			array(
				'id'   => 'sticky_headings_menu',
				'type' => 'info',
				'title' => __('Menu', 'dynamix'),
				'required' => array( 
					array('sticky_menu','equals','1'), 
				)		
			),			
			array(
				'id'             => 'sticky_menu_items_margin',
				'type'           => 'spacing',
				'title' 		 => __('Menu Item Margin', 'dynamix'),
				'output'         => array('#header.stuck #acoda-tabs ul.menu > li > a'),
				'mode'           => 'margin',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'false',
				'subtitle'       => __('Set the Margin for Menu Items.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'margin-top'     => '0', 
					'margin-right'   => '7px', 
					'margin-bottom'  => '0', 
					'margin-left'    => '7px',
					'units'          => 'px', 
				),
				'required' => array( 
					array('sticky_menu','equals','1'), 
				)		
			),		
			array(
				'id'             => 'sticky_menu_items_padding',
				'type'           => 'spacing',
				'title' 		 => __('Menu Item Padding', 'dynamix'),
				'output'         => array('#header.stuck #acoda-tabs ul.menu > li > a'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for Menu Items.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '15px', 
					'padding-right'   => '15px', 
					'padding-bottom'  => '15px', 
					'padding-left'    => '15px',
					'units'          => 'px', 
				),
				'required' => array( 
					array('sticky_menu','equals','1'), 
				)		
			),		
			array(
				'id' => 'sticky_menu_font_size',
				'type' => 'text',
				'title' => __('Sticky Menu Font Size', 'dynamix'),
				'subtitle' => __('Set the Sticky Menu Font Size. Enter any valid CSS unit, e.g. 12px.', 'dynamix'),
				"default" => '',
				'required' => array( 
					array('sticky_menu','equals','1'),  
				)		
			),		
			array(
				'id'   => 'sticky_headings_logo',
				'type' => 'info',
				'title' => __('Logo', 'dynamix'),
				'required' => array( 
					array('sticky_menu_type','equals','sticky_menu_logo'), 
				)			
			),	
			array(
				'id'             => 'sticky_logo_margin',
				'type'           => 'spacing',
				'title' 		 => __('Logo Margin', 'dynamix'),
				'output'         => array('#header.stuck #header-logo'),
				'mode'           => 'margin',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'false',
				'subtitle'       => __('Set the Margin for the Logo.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'margin-top'     => '30px', 
					'margin-right'   => '0', 
					'margin-bottom'  => '30px', 
					'margin-left'    => '0',
					'units'          => 'px', 
				),
				'required' => array( 
					array('sticky_menu_type','equals','sticky_menu_logo'), 
				)			
			),		
			array(
				'id' => 'sticky_logo_height',
				'type' => 'text',
				'title' => __('Sticky Logo Height', 'dynamix'),
				'subtitle' => __('Set the Sticky Header Logo Height. Enter any valid CSS unit, e.g. 70px.', 'dynamix'),
				"default" => '',
				'required' => array( 
					array('sticky_menu_type','equals','sticky_menu_logo'), 
				)		
			),		
        )
    ) );	


    Redux::setSection( $opt_name, array(
        'title' => __( 'Logo', 'dynamix' ),
        'id'    => 'logo',
        'icon'  => 'fal fa-leaf',
        'fields'     => array(
			array(
				'id'       => 'branding_display',
				'type'     => 'switch',
				'title'    => __('Display Logo', 'dynamix'), 
				'subtitle'     => __('Display Logo in Header.', 'dynamix'),
				'default'  => true,
			),			
			array(
				'id'       => 'branding_url',
				'type'     => 'media', 
				'url'      => true,
				'title'    => __('Logo', 'dynamix'),
				'subtitle' => __('Upload your logo here.', 'dynamix'),
			),			
			array(
				'id'       => 'branding_2x',
				'type'     => 'media', 
				'url'      => true,
				'title'    => __('Retina Logo', 'dynamix'),
				'subtitle' => __('Upload a retina logo here, it should be 2x the size of the normal logo above.', 'dynamix'),
			),				
			array(
				'id'             => 'logo_margin',
				'type'           => 'spacing',
				'title' 		 => __('Logo Margin', 'dynamix'),
				//'output'         => array('#container #header-logo'),
				'mode'           => 'margin',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'false',
				'subtitle'       => __('Set the Margin for the Logo.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'margin-top'     => '30px', 
					'margin-right'   => '0', 
					'margin-bottom'  => '30px', 
					'margin-left'    => '0',
					'units'          => 'px', 
				)
			),			
			array(
				'id'       => 'header_tagline',
				'type'     => 'switch',
				'title'    => __('Display Tagline', 'dynamix'), 
				'subtitle'     => __('Display Tagline under Logo. Set the Tagline via Settings > General > Tagline.', 'dynamix'),
				'default'  => true,
			),				
			array(
				'id'   => 'logo_headings_mobile',
				'type' => 'info',
				'title' => __('Mobile Logo', 'dynamix')
			),				
			array(
				'id'       => 'mobile_logo',
				'type'     => 'media', 
				'url'      => true,
				'title'    => __('Mobile Logo', 'dynamix'),
				'subtitle' => __('Upload a logo to be displayed on Mobile & Tablet devices.', 'dynamix'),
			),
			array(
				'id'       => 'mobile_logo_2x',
				'type'     => 'media', 
				'url'      => true,
				'title'    => __('Retina Mobile Logo', 'dynamix'),
				'subtitle' => __('Upload a logo to be displayed on Mobile & Tablet devices.', 'dynamix'),
				'required' => array( 
					array('mobile_logo','!=',''), 
				)		
			),	
			array(
				'id'       => 'mobile_logo_position',
				'type'     => 'button_set',
				'title'    => __('Mobile Logo Position', 'dynamix'), 
				'subtitle'     => __('Set the Mobile logo to display within the Header or the Dock Bar, inline with the icons.', 'dynamix'),
				'options' => array(
					'header' => esc_html__('Header', 'dynamix'),
					'dockbar' => esc_html__('Dock Bar', 'dynamix'),
				),
				'default'  => 'header',	
			),		
			array(
				'id'   => 'info_header_transparent_logo',
				'type' => 'info',
				'title' => __('Transparent Floating Header', 'dynamix')
			),		
			array(
				'id'       => 'branding_url_transparent',
				'type'     => 'media', 
				'url'      => true,
				'title'    => __('Logo For Transparent Floating Header', 'dynamix'),
				'subtitle' => __('Set a logo for when the Transparent Floating Header option is enabled.', 'dynamix'),
			),	
			array(
				'id'       => 'branding_url_transparent_2x',
				'type'     => 'media', 
				'url'      => true,
				'title'    => __('Retina Logo For Transparent Floating Header', 'dynamix'),
				'subtitle' => __('Upload a retina logo here, it should be 2x the size of the normal logo above.', 'dynamix'),
			),			
        )
    ) );	

    Redux::setSection( $opt_name, array(
        'title' => __( 'Menu', 'dynamix' ),
        'id'    => 'menu',
        'icon'  => 'fal fa-bars',
        'fields'     => array(			
			array(
				'id'       => 'menu_position',
				'type'     => 'button_set',
				'title'    => __('Menu Position', 'dynamix'), 
				'subtitle'     => __('Set the menu to display Inline or as an Icon in the Dock Bar.', 'dynamix'),
				'options' => array(
					'inline' => esc_html__('Inline', 'dynamix'),
					'dockbar' => esc_html__('Dock Bar Widget', 'dynamix'),
				),
				'default'  => 'inline',
			),	
			array(
				'id'             => 'menu_margin',
				'type'           => 'spacing',
				'title' 		 => __('Menu Margin', 'dynamix'),
				//'output'         => array('#acoda-tabs'),
				'mode'           => 'margin',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'false',
				'subtitle'       => __('Set the Margin for the Menu.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'margin-top'     => '30px', 
					'margin-right'   => '0', 
					'margin-bottom'  => '30px', 
					'margin-left'    => '0',
					'units'          => 'px', 
				)
			),		
			array(
				'id'   => 'menu_headings_items',
				'type' => 'info',
				'title' => __('Menu Items', 'dynamix')
			),		
			array(
				'id'             => 'menu_items_margin',
				'type'           => 'spacing',
				'title' 		 => __('Menu Item Margin', 'dynamix'),
				'output'         => array('#header #acoda-tabs ul.menu > li > a'),
				'mode'           => 'margin',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'false',
				'subtitle'       => __('Set the Margin for Menu Items.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'margin-top'     => '0', 
					'margin-right'   => '7px', 
					'margin-bottom'  => '0', 
					'margin-left'    => '7px',
					'units'          => 'px', 
				)
			),		
			array(
				'id'             => 'menu_items_padding',
				'type'           => 'spacing',
				'title' 		 => __('Menu Item Padding', 'dynamix'),
				'output'         => array('#header #acoda-tabs ul.menu > li > a'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for Menu Items.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '15px', 
					'padding-right'   => '15px', 
					'padding-bottom'  => '15px', 
					'padding-left'    => '15px',
					'units'          => 'px', 
				)
			),																																					
        )
    ) );	

    Redux::setSection( $opt_name, array(
        'title' => __( 'Title Area', 'dynamix' ),
        'id'    => 'title_bar',
        'icon'  => 'fal fa-h1',
        'fields'     => array(			
			array(
				'id'       => 'title_layout',
				'type'     => 'image_select',
				'title'    => __('Title & Breadcrumbs Alignment', 'dynamix'), 
				'subtitle'     => __('Set the Page Title Alignment.', 'dynamix'),
				'options'  => array(
					'layout_1'      => array(
						'alt'   => '', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/title-left.png'
					),
					'layout_3'      => array(
						'alt'   => '', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/title-center.png'
					),					
					'layout_2'      => array(
						'alt'   => '', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/title-right.png'
					),
				),
				'default'  => 'layout_1',
			),		
			array(
				'id'       => 'breadcrumb',
				'type'     => 'switch',
				'title'    => __('Breadcrumbs Display', 'dynamix'), 
				'subtitle'     => __('Choose to display Breadcrumbs. This option has a dependency on the corresponding page option.', 'dynamix'),
				'default'  => true,
			),		
			array(
				'id'             => 'subheader_padding',
				'type'           => 'spacing',
				'title' 		 => __('Title Area Padding', 'dynamix'),
				'output'         => array('.intro-wrap .intro-text'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for Title Area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '30px', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '30px', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),	
			array(
				'id' => 'subheader_height',
				'type' => 'text',
				'title' => __('Title Area Height', 'dynamix'),
				'subtitle' => __('Set the Title Area Height. Enter any valid CSS unit, e.g. 200px.', 'dynamix'),
				"default" => '',
			),			
        )
    ) );			

    Redux::setSection( $opt_name, array(
        'title' => __( 'Footer', 'dynamix' ),
        'id'    => 'footer',
        'icon'  => 'fal fa-window-maximize fa-rotate-180',
        'fields'     => array(
			array(
				'id'       => 'mainfooter',
				'type'     => 'switch',
				'title'    => __('Footer Display', 'dynamix'), 
				'subtitle'     => __('Choose to Show or Hide the Footer.', 'dynamix'),
				'default'  => true,
			),	
			array(
				'id'       => 'footer_width',
				'type'     => 'button_set',
				'title'    => __('Footer Width', 'dynamix'), 
				'subtitle'     => __('Set the Width of the Footer.', 'dynamix'),
				'options' => array(
					'wide' => esc_html__('Site Width', 'dynamix'),
					'fullwidth' => esc_html__('Browser Width', 'dynamix'),
				),
				'default'  => 'wide',
			),		
			array(
				'id'             => 'footer_padding',
				'type'           => 'spacing',
				'title' 		 => __('Footer Padding', 'dynamix'),
				//'output'         => array('#footer-wrap'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for the Footer Area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '30px', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '30px', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),		
			array(
				'id'       => 'footer_columns_num',
				'type'     => 'select',
				'title'    => __('Footer Columns', 'dynamix'), 
				'subtitle' => __('Choose the number of Footer Columns. See Appearance > Widgets for adding content to these columns.', 'dynamix'),
				'options'  => array(
					'1' => esc_html__('One Column', 'dynamix'),
					'2' => esc_html__('Two Column', 'dynamix'),
					'3' => esc_html__('Three Column', 'dynamix'),
					'4' => esc_html__('Four Column', 'dynamix'),
				),
				'default'  => '4',
			),
			array(
				'id'             => 'footer_column_padding',
				'type'           => 'spacing',
				'title' 		 => __('Column Padding', 'dynamix'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for the Footer Area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '0px', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '0px', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),			
			array(
				'id'       => 'footer_text_align',
				'type'     => 'select',
				'title'    => __('Footer Text Align', 'dynamix'), 
				'subtitle' => __('Choose the number of Footer Columns. See Appearance > Widgets for adding content to these columns.', 'dynamix'),
				'options'  => array(
					'left' => esc_html__('Left', 'dynamix'),
					'center' => esc_html__('Center', 'dynamix'),
					'justify' => esc_html__('Justify', 'dynamix'),
					'right' => esc_html__('Right', 'dynamix'),
				),
				'default'  => 'left',
			),			
			array(
				'id'   => 'info_lowerfooter',
				'type' => 'info',
				'title' => __('Lower Footer', 'dynamix')
			),				
			array(
				'id'       => 'lowerfooter',
				'type'     => 'switch',
				'title'    => __('Lower Footer Display', 'dynamix'), 
				'subtitle'     => __('Choose to Show or Hide the Lower Footer.', 'dynamix'),
				'default'  => true,
			),						
			array(
				'id'               => 'lowfooterleft',
				'type'             => 'editor',
				'title'            => __('Lower Footer Left Column', 'dynamix'), 
				'subtitle'         => __('Add content to the Lower Footer Left Column.', 'dynamix'),
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
			),
			array(
				'id'               => 'lowfooterright',
				'type'             => 'editor',
				'title'            => __('Lower Footer Right Column', 'dynamix'), 
				'subtitle'         => __('Add content to the Lower Footer Right Column.', 'dynamix'),
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
			),					
			
																										
        )		
    ) );			


    Redux::setSection( $opt_name, array(
        'title' => __( 'Blog', 'dynamix' ),
        'id'    => 'blog',
        'icon'  => 'fal fa-newspaper',
        'fields'     => array(
			array(
				'id'       => 'arhpostcontent',
				'type'     => 'button_set',
				'title'    => __('Blog Content Display', 'dynamix'), 
				'subtitle'     => __('Choose what to display for the post content on Blog pages.', 'dynamix'),
				'options' => array(
					'excerpt' => esc_html__('Excerpt', 'dynamix'),
					'full_post' => esc_html__('Full Post', 'dynamix'),
					'title' => esc_html__('Title Only', 'dynamix'),
				),
				'default'  => 'excerpt',
			),
			array(
				'id' => 'blog_excerpt',
				'type' => 'text',
				'title' => __('Excerpt', 'dynamix'),
				'subtitle' => __('Set the excerpt value for Blog posts.', 'dynamix'),
				"default" => '240',	
				'required' => array( 
					array('arhpostcontent','equals',array( 'excerpt' ) ), 
				)	
			),
			array(
				'id'       => 'blogheader',
				'type'     => 'switch',
				'title'    => __('Blog Header', 'dynamix'), 
				'subtitle'     => __('Enables a Grid Header of the top posts on Blog Templates pages & Category Pages.', 'dynamix'),
				'default'  => false,		
			),			
			array(
				'id'       => 'bloglayout',
				'type'     => 'image_select',
				'title'    => __('Default Page Layout', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding post option.', 'dynamix'),
				'options'  => array(
					'layout_one'      => array(
						'alt'   => '1 Column', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/1col.png'
					),
					'layout_two'      => array(
						'alt'   => '2 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/2cl.png'
					),
					'layout_three'      => array(
						'alt'   => '3 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cl.png'
					),					
					'layout_four'      => array(
						'alt'   => '2 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/2cr.png'
					),
					'layout_five'      => array(
						'alt'  => '3 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/3cr.png'
					),					
					'layout_six'      => array(
						'alt'   => '3 Column Middle', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cm.png'
					),
				),
				'default' => 'layout_one'		
			),
			array(
				'id' => 'max_blog_width',
				'type' => 'text',
				'title' => __('Maximum Blog Width', 'dynamix'),
				'subtitle' => __('Set the maximum Blog Content width. Default is the "Site Width" value.', 'dynamix'),
				"default" => '',
				'required' => array( 
					array('bloglayout','equals',array( 'layout_one' ) ), 
				)			
			),		
			array(
				'id'       => 'blogpinsidebar',
				'type'     => 'button_set',
				'title'    => __('Pin Sidebar', 'dynamix'), 
				'subtitle'     => __('Pin the Sidebar to the edge of the site.', 'dynamix'),
				'options' => array(
					'normal' => esc_html__('Normal', 'dynamix'),
					'pinned' => esc_html__('Pinned', 'dynamix'),
				),
				'default'  => 'normal',
				'required' => array( 
					array('bloglayout','equals',array( 'layout_two','layout_four' ) ), 
				)		
			),	
			array(
				'id'       => 'blogsticksidebar',
				'type'     => 'switch',
				'title'    => __('Sticky Sidebar', 'dynamix'), 
				'subtitle'     => __('Make the Sidebar Sticky when scrolling down the page.', 'dynamix'),
				'default'  => false,		
			),			
			array(
				'id'       => 'blogcolone',
				'type'     => 'select',
				'title'    => __('Column One Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column One.', 'dynamix'),
				'data' => 'sidebars',
				'default' => 'sidebar1'
			),	
			array(
				'id'       => 'blogcoltwo',
				'type'     => 'select',
				'title'    => __('Column Two Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column Two.', 'dynamix'),
				'data' => 'sidebars',
				'default' => 'sidebar1'
			),						
			array(
				'id'       => 'arhpostdisplay',
				'type'     => 'select',
				'title'    => __('Display Format', 'dynamix'), 
				'subtitle' => __('Choose the Posts Display Format.', 'dynamix'),
				'options'  => array(
					'normal' => esc_html__('Stacked', 'dynamix'),
					'grid' => esc_html__('Grid', 'dynamix'),
					'masonrygrid' => esc_html__('Masonry Grid', 'dynamix'),
				),
				'default'  => 'normal',
			),	
			array(
				'id'       => 'arhpostcolumns',
				'type'     => 'select',
				'title'    => __('Grid Columns', 'dynamix'), 
				'subtitle' => __('Choose the number of Grid Columns.', 'dynamix'),
				'options' => array (
					'2' => esc_html__('Two', 'dynamix'),
					'3' => esc_html__('Three', 'dynamix'),
					'4' => esc_html__('Four', 'dynamix'),
					'5' => esc_html__('Five', 'dynamix'),
					'6' => esc_html__('Six', 'dynamix'),
				),
				'default'  => '2',
				'required' => array( 
					array('arhpostdisplay','!=','normal'), 
				)					
			),				
			/*array(
				'id'       => 'post_layout_style',
				'type'     => 'select',
				'title'    => __('Boxed Post Style', 'dynamix'), 
				'subtitle' => __('Choose the Posts Display Format.', 'dynamix'),
				'options' => array(
					'boxed' => esc_html__('Single & Archive', 'dynamix'),
					'boxed_single' => esc_html__('Single', 'dynamix'),
					'boxed_archive' => esc_html__('Archive', 'dynamix'),
					'unboxed' => esc_html__('Disabled', 'dynamix'),
				),
				'default'  => 'unboxed',
			),	*/
			array(
				'id'       => 'blog_search',
				'type'     => 'select',
				'title'    => __('Display Search Bar', 'dynamix'), 
				'subtitle' => __('Display a Search Bar on Blog Pages.', 'dynamix'),
				'options' => array(
					'disabled' => esc_html__('Disabled', 'dynamix'),
					'search' => esc_html__('Search Bar', 'dynamix'),
					'search_filter' => esc_html__('Search Filter', 'dynamix'),
					'search_filter_highlight' => esc_html__('Search Filter + Highlight', 'dynamix'),
				),
				'default'  => 'disabled',
			),				
			array(
				'id'       => 'blog_pagination',
				'type'     => 'select',
				'title'    => __('Pagination Type', 'dynamix'), 
				'subtitle' => __('Choose the pagination type for blog posts.', 'dynamix'),
				'options' => array(
					'click_load' => esc_html__('Ajax Click Load', 'dynamix'),
					'scroll_load' => esc_html__('Ajax Scroll Load', 'dynamix'),
					'page_numbers' => esc_html__('Page Numbers', 'dynamix'),
				),
				'default'  => 'page_numbers',
			),		
			array(
				'id'       => 'blog_title',
				'type'     => 'switch',
				'title'    => __('Display Blog Index Title', 'dynamix'), 
				'subtitle'     => __('If "Your latest posts" are set to the home page ( Settings > Reading ), you can choose whether to display the Site title or not.', 'dynamix'),
				'default'  => true,
			),				
			array(
				'id'   => 'featured_image',
				'type' => 'info',
				'title' => __('Featured Images', 'dynamix')
			),				
			array(
				'id'       => 'blogpostimage',
				'type'     => 'select',
				'title'    => __('Display Featured Images', 'dynamix'), 
				'subtitle' => __('Choose where to display Featured Images. This option has a dependency on the corresponding post option.', 'dynamix'),
				'options' => array (
					'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
					'archive' => esc_html__('Archive', 'dynamix'),
					'single' => esc_html__('Single', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => 'singlearchive',
			),		
			array(
				'id'       => 'title_tag',
				'type'     => 'select',
				'title'    => __('Post Title HTML Tag', 'dynamix'), 
				'subtitle' => __('Select the HTML tag for Blog Post Titles on Category pages.', 'dynamix'),
				'options' => array (
					'h2' => esc_html__('H2', 'dynamix'),
					'h3' => esc_html__('H3', 'dynamix'),
					'h4' => esc_html__('H4', 'dynamix'),
					'h5' => esc_html__('H5', 'dynamix'),
					'h6' => esc_html__('H6', 'dynamix'),
					'strong' => esc_html__('Bold', 'dynamix'),
					'div' => esc_html__('DIV', 'dynamix'),
				),
				'default'  => 'h2',
			),		
			/*array(
				'id'       => 'posttitle_overlayimage',
				'type'     => 'switch',
				'title'    => __('Overlay Title on Featured Image', 'dynamix'), 
				'subtitle'     => __('Display the title and Metadata overlaying the Featured Image.', 'dynamix'),
				'default'  => false,
				'required' => array( 
					array('posttitle_position','=','content'), 
				)			
			),	*/									
			array(
				'id'       => 'related_posts',
				'type'     => 'switch',
				'title'    => __('Display Related Posts', 'dynamix'), 
				'subtitle'     => __('Display related posts at the bottom of Single Posts.', 'dynamix'),
				'default'  => true,
			),				
			array(
				'id'   => 'blogimages_info',
				'type' => 'info',
				'title' => __('Blog Page Images', 'dynamix')
			),	
			array(
				'id'       => 'archive_img_align',
				'type'     => 'button_set',
				'title'    => __('Image Align', 'dynamix'), 
				'options' => array(
						'left' => esc_html__('Left', 'dynamix'),
						'center' => esc_html__('Center', 'dynamix'),
						'right' => esc_html__('Right', 'dynamix')
					),
				'default'  => 'left',
			),							
			array(
				'id'       => 'arhimgeffect',
				'type'     => 'select',
				'title'    => __('Image Effect', 'dynamix'), 
				'options' => array (
					'none' => esc_html__('None', 'dynamix'),
					'frame' => esc_html__('Frame', 'dynamix'),
					'blackwhite' =>  esc_html__('Black & White', 'dynamix'),
					'frameblackwhite' => esc_html__('Frame + Black & White', 'dynamix'),
				),
				'default'  => 'none',
			),					
			array(
				'id' => 'archive_img_size',
				'type' => 'text',
				'title' => __('Image Size', 'dynamix'),
				'description' => __('Enter image size. e.g. "thumbnail", "medium", "large", "full". Alternatively enter image size in pixels: 200x100 (Width x Height).', 'dynamix'),
				"default" => 'medium',
			),																																																
        )		
    ) );			

    Redux::setSection( $opt_name, array(
        'title' => __( 'Metadata', 'dynamix' ),
        'id'    => 'blog-metadata',
		'subsection'       => true,
        'fields'     => array(			
			array(
				'id'       => 'meta_align',
				'type'     => 'button_set',
				'title'    => __('Alignment', 'dynamix'), 
				'options' => array(
					'left' => esc_html__('Left', 'dynamix'),
					'center' => esc_html__('Center', 'dynamix'),
					'right' => esc_html__('Right', 'dynamix'),
				),
				'default'  => 'left',
		
			),					
			array(
				'id' => 'meta_date_format_archive',
				'type' => 'text',
				'title' => __('Archive Date Format', 'dynamix'),
				'subtitle' => __('See WordPress <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Date Formats</a> for reference.', 'dynamix'),
				'default' => 'F j, Y'
			),	
			array(
				'id' => 'meta_date_format_single',
				'type' => 'text',
				'title' => __('Single Post Date Format', 'dynamix'),
				'subtitle' => __('See WordPress <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Date Formats</a> for reference.', 'dynamix'),
				'default' => 'F j, Y'
			),		
			array(
				'id'       => 'meta_date_position',
				'type'     => 'button_set',
				'title'    => __('Date Position', 'dynamix'), 
				'subtitle' => __('Choose where to display the date.', 'dynamix'),
				'options' => array(
					'metadata' => esc_html__('Metadata Area', 'dynamix'),
					'title_below' => esc_html__('Below Title', 'dynamix'),
					//'title' => esc_html__('Within Title', 'dynamix'),
				),
				'default'  => 'metadata',
			),	
			array(
				'id'       => 'meta_date',
				'type'     => 'button_set',
				'title'    => __('Display Date', 'dynamix'), 
				'options' => array(
					'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
					'single' => esc_html__('Single', 'dynamix'),
					'archive' => esc_html__('Archive', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => 'singlearchive',
			),	
			array(
				'id'       => 'meta_author',
				'type'     => 'button_set',
				'title'    => __('Display Author', 'dynamix'), 
				'options' => array(
					'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
					'single' => esc_html__('Single', 'dynamix'),
					'archive' => esc_html__('Archive', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => 'singlearchive',
			),	
			array(
				'id'       => 'meta_categories',
				'type'     => 'button_set',
				'title'    => __('Display Categories', 'dynamix'), 
				'options' => array(
					'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
					'single' => esc_html__('Single', 'dynamix'),
					'archive' => esc_html__('Archive', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => 'singlearchive',
			),	
			array(
				'id'       => 'meta_tags',
				'type'     => 'button_set',
				'title'    => __('Display Tags', 'dynamix'), 
				'options' => array(
					'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
					'single' => esc_html__('Single', 'dynamix'),
					'archive' => esc_html__('Archive', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => 'singlearchive',
			),	
			array(
				'id'       => 'meta_comments',
				'type'     => 'button_set',
				'title'    => __('Display Comments', 'dynamix'), 
				'options' => array(
					'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
					'single' => esc_html__('Single', 'dynamix'),
					'archive' => esc_html__('Archive', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => 'singlearchive',
			),	
        )		
    ) );		

    Redux::setSection( $opt_name, array(
        'title' => __( 'Single Posts', 'dynamix' ),
        'id'    => 'blog-singleposts',
		'subsection'       => true,
        'fields'     => array(	
			array(
				'id'       => 'posttitle_position',
				'type'     => 'button_set',
				'title'    => __('Single Post Title Position', 'dynamix'), 
				'subtitle' => __('Choose where to display the Title on Single Posts.', 'dynamix'),
				'options' => array(
					'content' => esc_html__('Content', 'dynamix'),
					'header' => esc_html__('Header', 'dynamix'),
				),
				'default'  => 'content',
			),	
			array(
				'id'       => 'posttitle_align',
				'type'     => 'switch',
				'title'    => __('Center Align Title', 'dynamix'), 
				'default'  => false,
				'required' => array( 
					array('posttitle_position','equals',array( 'content' ) ), 
				)			
			),		
			array(
				'id'       => 'postlayout',
				'type'     => 'image_select',
				'title'    => __('Default Post Layout', 'dynamix'), 
				'subtitle' => __('This option inherits on the Blog Page Layout by default.', 'dynamix'),
				'options'  => array(
					'layout_one'      => array(
						'alt'   => '1 Column', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/1col.png'
					),
					'layout_two'      => array(
						'alt'   => '2 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/2cl.png'
					),
					'layout_three'      => array(
						'alt'   => '3 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cl.png'
					),					
					'layout_four'      => array(
						'alt'   => '2 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/2cr.png'
					),
					'layout_five'      => array(
						'alt'  => '3 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/3cr.png'
					),					
					'layout_six'      => array(
						'alt'   => '3 Column Middle', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cm.png'
					),
				),
				'default' => 'layout_one'		
			),	
			array(
				'id' => 'max_post_width',
				'type' => 'text',
				'title' => __('Maximum Post Width', 'dynamix'),
				'subtitle' => __('Set the maximum Post Content width. Default is the "Site Width" value.', 'dynamix'),
				"default" => '',
				'required' => array( 
					array('postlayout','equals',array( 'layout_one' ) ), 
				)			
			),			
			array(
				'id'       => 'postpinsidebar',
				'type'     => 'button_set',
				'title'    => __('Pin Sidebar', 'dynamix'), 
				'subtitle'     => __('Pin the Sidebar to the edge of the site.', 'dynamix'),
				'options' => array(
					'normal' => esc_html__('Normal', 'dynamix'),
					'pinned' => esc_html__('Pinned', 'dynamix'),
				),
				'default'  => 'normal',
				'required' => array( 
					array('postlayout','equals',array( 'layout_two','layout_four' ) ), 
				)		
			),	
			array(
				'id'       => 'poststicksidebar',
				'type'     => 'switch',
				'title'    => __('Sticky Sidebar', 'dynamix'), 
				'subtitle'     => __('Make the Sidebar Sticky when scrolling down the page.', 'dynamix'),
				'default'  => 'false',		
			),			
			array(
				'id'       => 'postcolone',
				'type'     => 'select',
				'title'    => __('Column One Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column One.', 'dynamix'),
				'data' => 'sidebars',
				'default' => 'sidebar1'
			),	
			array(
				'id'       => 'postcoltwo',
				'type'     => 'select',
				'title'    => __('Column Two Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column Two.', 'dynamix'),
				'data' => 'sidebars',
				'default' => 'sidebar1'
			),			
			array(
				'id'   => 'singlepostimages_info',
				'type' => 'info',
				'title' => __('Featured Image', 'dynamix')
			),				
			array(
				'id'       => 'post_lightbox',
				'type'     => 'switch',
				'title'    => __('Image Lightbox', 'dynamix'), 
				'default'  => true,
			),			
			array(
				'id'       => 'postimgeffect',
				'type'     => 'select',
				'title'    => __('Image Effect', 'dynamix'), 
				'options' => array (
					'none' => esc_html__('None', 'dynamix'),
					'frame' => esc_html__('Frame', 'dynamix'),
					'blackwhite' =>  esc_html__('Black & White', 'dynamix'),
					'frameblackwhite' => esc_html__('Frame + Black & White', 'dynamix'),
				),
				'default'  => 'none',
			),					
			array(
				'id' => 'post_img_size',
				'type' => 'text',
				'title' => __('Image Size', 'dynamix'),
				'description' => __('Enter image size. e.g. "thumbnail", "medium", "large", "full". Alternatively enter image size in pixels: 200x100 (Width x Height).', 'dynamix'),
				"default" => 'full',
			),			
        )		
    ) );	
		

    Redux::setSection( $opt_name, array(
        'title' => __( 'Portfolio', 'dynamix' ),
        'id'    => 'portfolio',
        'icon'  => 'fal fa-newspaper',
        'fields'     => array(	
			array(
				'id'       => 'portlayout',
				'type'     => 'image_select',
				'title'    => __('Default Portfolio Post Layout', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding post option.', 'dynamix'),
				'options'  => array(
					'layout_one'      => array(
						'alt'   => '1 Column', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/1col.png'
					),
					'layout_two'      => array(
						'alt'   => '2 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/2cl.png'
					),
					'layout_three'      => array(
						'alt'   => '3 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cl.png'
					),					
					'layout_four'      => array(
						'alt'   => '2 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/2cr.png'
					),
					'layout_five'      => array(
						'alt'  => '3 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/3cr.png'
					),					
					'layout_six'      => array(
						'alt'   => '3 Column Middle', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cm.png'
					),
				),
				'default' => 'layout_one'		
			),	
			array(
				'id'       => 'portcoltwo',
				'type'     => 'select',
				'title'    => __('Column One Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column One.', 'dynamix'),
				'data' => 'sidebars'
			),	
			array(
				'id'       => 'portcoltwo',
				'type'     => 'select',
				'title'    => __('Column Two Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column Two.', 'dynamix'),
				'data' => 'sidebars'
			),						
			array(
				'id'       => 'portpostdisplay',
				'type'     => 'select',
				'title'    => __('Display Format', 'dynamix'), 
				'subtitle' => __('Choose the Posts Display Format.', 'dynamix'),
				'options'  => array(
					'normal' => esc_html__('Stacked', 'dynamix'),
					'grid' => esc_html__('Grid', 'dynamix'),
					'masonrygrid' => esc_html__('Masonry Grid', 'dynamix'),
				),
				'default'  => 'masonrygrid',
			),	
			array(
				'id'       => 'portpostcolumns',
				'type'     => 'select',
				'title'    => __('Grid Columns', 'dynamix'), 
				'subtitle' => __('Choose the number of Grid Columns.', 'dynamix'),
				'options' => array (
					'2' => esc_html__('Two', 'dynamix'),
					'3' => esc_html__('Three', 'dynamix'),
					'4' => esc_html__('Four', 'dynamix'),
					'5' => esc_html__('Five', 'dynamix'),
					'6' => esc_html__('Six', 'dynamix'),
				),
				'default'  => '2',
				'required' => array( 
					array('portpostdisplay','!=','normal'), 
				)					
			),				
			/*array(
				'id'       => 'portfolio_layout_style',
				'type'     => 'select',
				'title'    => __('Boxed Post Style', 'dynamix'), 
				'subtitle' => __('Choose the Posts Display Format.', 'dynamix'),
				'options' => array(
					'boxed' => esc_html__('Single & Archive', 'dynamix'),
					'boxed_single' => esc_html__('Single', 'dynamix'),
					'boxed_archive' => esc_html__('Archive', 'dynamix'),
					'unboxed' => esc_html__('Disabled', 'dynamix'),
				),
				'default'  => 'unboxed',
			),*/
			array(
				'id'       => 'portfoliopage',
				'type'     => 'select',
				'title'    => __('Parent Portfolio Page', 'dynamix'), 
				'subtitle' => __('Choose the Parent Portfolio Page.', 'dynamix'),
				'data' => 'pages'
			),			
			array(
				'id'       => 'portfoliopagelink',
				'type'     => 'switch',
				'title'    => __('Display Portfolio Page Link', 'dynamix'), 
				'subtitle'     => __('Display a Portfolio Page Link at the bottom of Single Portfolio Posts.', 'dynamix'),
				'default'  => true,
			),					
			array(
				'id'       => 'portfolio_search',
				'type'     => 'select',
				'title'    => __('Display Search Bar', 'dynamix'), 
				'subtitle' => __('Display a Search Bar on Portfolio Pages.', 'dynamix'),
				'options' => array(
					'disabled' => esc_html__('Disabled', 'dynamix'),
					'search' => esc_html__('Search Bar', 'dynamix'),
					'search_filter' => esc_html__('Search Filter', 'dynamix'),
					'search_filter_highlight' => esc_html__('Search Filter + Highlight', 'dynamix'),
				),
				'default'  => 'disabled',
			),				
			array(
				'id'       => 'portfolio_pagination',
				'type'     => 'select',
				'title'    => __('Pagination Type', 'dynamix'), 
				'subtitle' => __('Choose the pagination type for portfolio posts.', 'dynamix'),
				'options' => array(
					'click_load' => esc_html__('Ajax Click Load', 'dynamix'),
					'scroll_load' => esc_html__('Ajax Scroll Load', 'dynamix'),
					'page_numbers' => esc_html__('Page Numbers', 'dynamix'),
				),
				'default'  => 'page_numbers',
			),		
			
			array(
				'id'   => 'featured_image',
				'type' => 'info',
				'title' => __('Featured Images', 'dynamix')
			),				
			array(
				'id'       => 'portpostimage',
				'type'     => 'select',
				'title'    => __('Display Featured Images', 'dynamix'), 
				'subtitle' => __('Choose where to display Featured Images. This option has a dependency on the corresponding post option.', 'dynamix'),
				'options' => array (
					'' => esc_html__('Single & Archive', 'dynamix'),
					'archive' => esc_html__('Archive', 'dynamix'),
					'single' => esc_html__('Single', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => '',
			),		
	
			array(
				'id'   => 'portfolioarchiveimages_info',
				'type' => 'info',
				'title' => __('Portfolio Archive Images', 'dynamix')
			),	
			array(
				'id'       => 'portfolio_img_align',
				'type'     => 'button_set',
				'title'    => __('Portfolio Image Align', 'dynamix'), 
				'options' => array(
						'left' => esc_html__('Left', 'dynamix'),
						'center' => esc_html__('Center', 'dynamix'),
						'right' => esc_html__('Right', 'dynamix')
					),
				'default'  => 'left',
			),										
			array(
				'id' => 'portfolio_img_size',
				'type' => 'text',
				'title' => __('Image Size', 'dynamix'),
				'description' => __('Enter image size. e.g. "thumbnail", "medium", "large", "full". Alternatively enter image size in pixels: 200x100 (Width x Height).', 'dynamix'),
				"default" => 'large',
			),				
			array(
				'id'   => 'singleportfolioimages_info',
				'type' => 'info',
				'title' => __('Single Portfolio Images', 'dynamix')
			),				
			array(
				'id'       => 'portfolio_post_lightbox',
				'type'     => 'switch',
				'title'    => __('Image Lightbox', 'dynamix'), 
				'default'  => true,
			),								
			array(
				'id' => 'port_single_img_size',
				'type' => 'text',
				'title' => __('Image Size', 'dynamix'),
				'description' => __('Enter image size. e.g. "thumbnail", "medium", "large", "full". Alternatively enter image size in pixels: 200x100 (Width x Height).', 'dynamix'),
				"default" => 'full',
			),																																													
        )		
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __( 'Lightbox', 'dynamix' ),
        'id'    => 'lightbox',
        'icon'  => 'fal fa-search-plus',
        'fields'     => array(		
			array(
				'id'       => 'lightbox',
				'type'     => 'switch',
				'title'    => __('Enable Lightbox', 'dynamix'), 
				'subtitle'     => __('Enable or Disable the iLightbox script.', 'dynamix'),
				'default'  => true,
			),			
			array(
				'id'       => 'lightbox_path',
				'type'     => 'button_set',
				'title'    => __('Layout', 'dynamix'), 
				'subtitle'     => __('Choose between a Horizontal or Vertical layout.', 'dynamix'),
				'options' => array(
					'horizontal' => esc_html__('Horizontal', 'dynamix'),
					'vertical' => esc_html__('Vertical', 'dynamix'),
				),
				'default'  => 'horizontal',
			),
			array(
				'id'       => 'lightbox_skin',
				'type'     => 'select',
				'title'    => __('Skin', 'dynamix'), 
				'subtitle'     => __('Select the Lightbox skin.', 'dynamix'),
				'options' => array(
					'flat-dark' => esc_html__('Flat Dark', 'dynamix'),
					'dark' => esc_html__('Dark', 'dynamix'),
					'light' => esc_html__('Light', 'dynamix'),
					'mac' => esc_html__('Mac', 'dynamix'),
					'metro-black' => esc_html__('Metro Black', 'dynamix'),
					'metro-white' => esc_html__('Metro White', 'dynamix'),
					'parade' => esc_html__('Parade', 'dynamix'),
					'smooth' => esc_html__('Smooth', 'dynamix'),
				),
				'default'  => 'flat-dark',
			),		
			array(
				'id' => 'lightbox_opacity',
				'type' => 'slider',
				'title' => __('Background Opacity', 'dynamix'),
				'subtitle' => __('Set the background Opacity.', 'dynamix'),
				"default" => .75,
				"min" => 0,
				"step" => .01,
				"max" => 1,
				'resolution' => 0.01,
				'display_value' => 'text',
			),		
			array(
				'id'       => 'lightbox_infinite',
				'type'     => 'switch',
				'title'    => __('Infinite Scroll', 'dynamix'), 
				'subtitle'     => __('Enable Infinite Scroll between images in the Lightbox.', 'dynamix'),
				'default'  => true,
			),	
			array(
				'id'       => 'lightbox_slideshow',
				'type'     => 'switch',
				'title'    => __('Slideshow', 'dynamix'), 
				'subtitle'     => __('Enable Slideshow button.', 'dynamix'),
				'default'  => false,
			),	
			array(
				'id'       => 'lightbox_arrows',
				'type'     => 'switch',
				'title'    => __('Arrows', 'dynamix'), 
				'subtitle'     => __('Display navigation arrows.', 'dynamix'),
				'default'  => true,
			),	
			array(
				'id'       => 'lightbox_thumbnail',
				'type'     => 'switch',
				'title'    => __('Thumbnails', 'dynamix'), 
				'subtitle'     => __('Display Thumbnail navigation.', 'dynamix'),
				'default'  => true,
			),	
			array(
				'id' => 'lightbox_classes',
				'type' => 'text',
				'title' => __('CSS Classes ', 'dynamix'),
				'subtitle' => __('Add comma separated CSS Classes to enable Lightbox.', 'dynamix'),
			),		
        )
    ) );	
	
	// bbPress Options

	if ( class_exists( 'bbPress' ) ) 
	{
		 
  	Redux::setSection( $opt_name, array(
        'title' => __( 'bbPress', 'dynamix' ),
        'id'    => 'bbpress',
        'icon'  => 'fal fa-file-alt',
        'fields'     => array(	
			array(
				'id'       => 'buddylayout',
				'type'     => 'image_select',
				'title'    => __('Default Product Post Layout', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding post option.', 'dynamix'),
				'options'  => array(
					'layout_one'      => array(
						'alt'   => '1 Column', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/1col.png'
					),
					'layout_two'      => array(
						'alt'   => '2 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/2cl.png'
					),
					'layout_three'      => array(
						'alt'   => '3 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cl.png'
					),					
					'layout_four'      => array(
						'alt'   => '2 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/2cr.png'
					),
					'layout_five'      => array(
						'alt'  => '3 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/3cr.png'
					),					
					'layout_six'      => array(
						'alt'   => '3 Column Middle', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cm.png'
					),
				),
				'default' => 'layout_one'		
			),	
			array(
				'id'       => 'bbppinsidebar',
				'type'     => 'button_set',
				'title'    => __('Pin Sidebar', 'dynamix'), 
				'subtitle'     => __('Pin the Sidebar to the edge of the site.', 'dynamix'),
				'options' => array(
					'normal' => esc_html__('Normal', 'dynamix'),
					'pinned' => esc_html__('Pinned', 'dynamix'),
				),
				'default'  => 'normal',
				'required' => array( 
					array('buddylayout','equals',array( 'layout_two','layout_four' ) ), 
				)		
			),		
			array(
				'id'       => 'buddycolone',
				'type'     => 'select',
				'title'    => __('Column One Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column One.', 'dynamix'),
				'data' => 'sidebars'
			),	
			array(
				'id'       => 'buddycoltwo',
				'type'     => 'select',
				'title'    => __('Column Two Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column Two.', 'dynamix'),
				'data' => 'sidebars'
			),										
        )		
    ) );
			
	}	 
		
	
	// WooCommerce Options		
	
	if (class_exists( 'woocommerce' ) )
	{ 
	
    Redux::setSection( $opt_name, array(
        'title' => __( 'WooCommerce', 'dynamix' ),
        'id'    => 'woocommerce',
        'icon'  => 'fal fa-shopping-cart',
        'fields'     => array(	
			array(
				'id'       => 'woocomtitle_position',
				'type'     => 'button_set',
				'title'    => __('Title & Breadcrumb Position', 'dynamix'), 
				'subtitle' => __('Choose where to display the Title on Single Products.', 'dynamix'),
				'options' => array(
					'content' => esc_html__('Content', 'dynamix'),
					'header' => esc_html__('Header', 'dynamix'),
				),
				'default'  => 'content',
			),		
			array(
				'id'       => 'woocomlayout',
				'type'     => 'image_select',
				'title'    => __('Default Product Post Layout', 'dynamix'), 
				'subtitle' => __('This option has a dependency on the corresponding post option.', 'dynamix'),
				'options'  => array(
					'layout_one'      => array(
						'alt'   => '1 Column', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/1col.png'
					),
					'layout_two'      => array(
						'alt'   => '2 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/2cl.png'
					),
					'layout_three'      => array(
						'alt'   => '3 Column Left', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cl.png'
					),					
					'layout_four'      => array(
						'alt'   => '2 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/2cr.png'
					),
					'layout_five'      => array(
						'alt'  => '3 Column Right', 
						'img'  => get_template_directory_uri() . '/lib/admin/assets/images/3cr.png'
					),					
					'layout_six'      => array(
						'alt'   => '3 Column Middle', 
						'img'   => get_template_directory_uri() . '/lib/admin/assets/images/3cm.png'
					),
				),
				'default' => 'layout_one'		
			),	
			array(
				'id'       => 'woopinsidebar',
				'type'     => 'button_set',
				'title'    => __('Pin Sidebar', 'dynamix'), 
				'subtitle'     => __('Pin the Sidebar to the edge of the site.', 'dynamix'),
				'options' => array(
					'normal' => esc_html__('Normal', 'dynamix'),
					'pinned' => esc_html__('Pinned', 'dynamix'),
				),
				'default'  => 'normal',
				'required' => array( 
					array('woocomlayout','equals',array( 'layout_two','layout_four' ) ), 
				)		
			),			
			array(
				'id'       => 'woocomcolone',
				'type'     => 'select',
				'title'    => __('Column One Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column One.', 'dynamix'),
				'data' => 'sidebars'
			),	
			array(
				'id'       => 'woocomcoltwo',
				'type'     => 'select',
				'title'    => __('Column Two Sidebar', 'dynamix'), 
				'subtitle' => __('Select which widget area to use for Column Two.', 'dynamix'),
				'data' => 'sidebars'
			),	
			array(
				'id'       => 'woocommerce_cart',
				'type'     => 'switch',
				'title'    => __('Display Cart Icon', 'dynamix'), 
				'subtitle'     => __('Display Cart Icon in Dock Bar.', 'dynamix'),
				'default'  => true,
			),	
			array(
				'id'       => 'woocomsearch',
				'type'     => 'switch',
				'title'    => __('Search Products Only', 'dynamix'), 
				'subtitle'     => __('Change the default search function to search for products only.', 'dynamix'),
				'default'  => false,
			),						
			array(
				'id'       => 'share_product',
				'type'     => 'switch',
				'title'    => __('Display Share Icons', 'dynamix'), 
				'subtitle'     => __('Add Share Icons to the bottom of Products.', 'dynamix'),
				'default'  => false,
			),	
			array(
				'id'   => 'info_layout_advanced',
				'type' => 'info',
				'title' => __('Single Product Advanced Layout', 'dynamix')
			),			
			array(
				'id'             => 'woocom_content_padding',
				'type'           => 'spacing',
				'title' 		 => __('Content Area Padding', 'dynamix'),
				//'output'         => array('#content'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for the Content area.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '30px', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '30px', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),	
			array(
				'id'             => 'woocom_sidebar_padding',
				'type'           => 'spacing',
				'title' 		 => __('Sidebar Padding', 'dynamix'),
				//'output'         => array('#content > .sidebar'),
				'mode'           => 'padding',
				'units'          => array('em', 'rem', 'px', '%'),
				'units_extended' => 'true',
				'display_units'	=> 'true',
				'subtitle'       => __('Set the Padding for Sidebar areas.', 'dynamix'),
				'desc' 		 => __('', 'dynamix'),
				'default'            => array(
					'padding-top'     => '30px', 
					'padding-right'   => '30px', 
					'padding-bottom'  => '30px', 
					'padding-left'    => '30px',
					'units'          => 'px', 
				)
			),			
        )		
    ) );
	
	}
	
    Redux::setSection( $opt_name, array(
        'title' => __( 'Social Media', 'dynamix' ),
        'id'    => 'socialmedia',
        'icon'  => 'fal fa-share-alt',
        'fields'     => array(	
			array(
				'id'       => 'share_post',
				'type'     => 'button_set',
				'title'    => __('Post Social Icons', 'dynamix'), 
				'subtitle'     => __('Add Social Icons to the bottom of Posts.', 'dynamix'),
				'options' => array(
					'bottom' => esc_html__('Bottom', 'dynamix'),
					'top' => esc_html__('Top', 'dynamix'),
					'both' => esc_html__('Both', 'dynamix'),
					'disable' => esc_html__('Disable', 'dynamix'),
				),
				'default'  => 'bottom',
			),		
			array(
				'id'       => 'display_socialicons',
				'type'     => 'switch',
				'title'    => __('Dock Bar Social Icons', 'dynamix'), 
				'subtitle'     => __('Add Social Icons to the Dock Bar.', 'dynamix'),
				'default'  => false,
			),
			array(
				'id'       => 'socialicons_share',
				'type'     => 'switch',
				'title'    => __('Share Icon', 'dynamix'), 
				'subtitle'     => __('Enabling this option will contain all social icons selected within one "Share Icon".', 'dynamix'),
				'default'  => false,
				'required' => array( 
					array('display_socialicons','equals',true ), 
				)			
			),				
			/*array(
				'id'       => 'share_post_portfolio',
				'type'     => 'switch',
				'title'    => __('Portfolio Social Icons', 'dynamix'), 
				'subtitle'     => __('Add Social Icons to the bottom of Portfolio Posts.', 'dynamix'),
				'default'  => true,
			),*/		
			array(
				'id'        => 'socialicons',
				'type'      => 'social_profiles',
				'title'     => 'Social Profiles',
				'subtitle'  => 'Click an icon to activate it, drag and drop to change the icon order.',
			),			
												
        )		
    ) );	

    Redux::setSection( $opt_name, array(
        'title' => __( 'Preloader', 'dynamix' ),
        'id'    => 'proloading',
        'icon'  => 'fal fa-spinner',
        'fields'     => array(	
			array(
				'id'       => 'preloader',
				'type'     => 'switch',
				'title'    => __('Use Preloader', 'dynamix'), 
				'subtitle'     => __('Enabling this option to display a loading animation.', 'dynamix'),
				'default'  => true,
			),													
        )		
    ) );	



    Redux::setSection( $opt_name, array(
        'title' => __( 'Advanced', 'dynamix' ),
        'id'    => 'custom_js',
        'icon'  => 'fal fa-cogs',
        'fields'     => array(	
			array(
				'id'               => 'custom_css',
				'type'             => 'ace_editor',
				'title'            => __('Custom CSS', 'dynamix'), 
				'subtitle'         => __('Add Custom CSS here.', 'dynamix'),
				'mode'			   => 'css',
				'theme'			   => 'chrome',
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
			),
			array(
				'id'               => 'mobile_css',
				'type'             => 'ace_editor',
				'title'            => __('Mobile CSS', 'dynamix'), 
				'subtitle'         => __('Add Mobile CSS here.', 'dynamix'),
				'mode'			   => 'css',
				'theme'			   => 'chrome',
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
			),			
			/*array(
				'id'               => 'custom_js',
				'type'             => 'ace_editor',
				'title'            => __('Tracking Code', 'dynamix'), 
				'subtitle'         => __('Add tracking code here, place within &lt;script&gt; tags.', 'dynamix'),
				'mode'			   => 'html',
				'theme'			   => 'chrome',
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
			),
			array(
				'id'               => 'before_head',
				'type'             => 'ace_editor',
				'title'            => __('Code Before &lt;/head&gt;.', 'dynamix'), 
				'subtitle'         => __('Add Javascript before the &lt;/head&gt; section.', 'dynamix'),
				'mode'			   => 'html',
				'theme'			   => 'chrome',
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
			),
			array(
				'id'               => 'before_body',
				'type'             => 'ace_editor',
				'title'            => __('Code Before &lt;/body&gt;.', 'dynamix'), 
				'subtitle'         => __('Add Javascript before the &lt;/body&gt; section.', 'dynamix'),
				'mode'			   => 'html',
				'theme'			   => 'chrome',
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
			),	*/																	
        )		
    ) );			


    /*
     * <--- END SECTIONS
     */





	function reset_metabox_values() {

		//if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'reset_metabox_values' ) ) return;

		// Reference the Redux global variable
		$dynamix_options = get_option('dynamix_options');
		


		// A list of fields that I want to keep untouched
		/*$blacklist = array(
			'audio_mp3',
			'audio_ogg',
			'audio_wav',
			'gallery_images',
			'video_mp4',
			'video_webm',
			'video_ogv',
		);*/
		
		
		
		$wpb_all_query = new WP_Query(
			array( 
				'posts_per_page'=>-1,
				'post_type' => array('post','page')
			)
		); 
 
		if ( $wpb_all_query->have_posts() ) : 
 
			while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); 
		
				$post_metadata = get_post_meta( get_the_ID() );

				foreach ( $post_metadata as $key => $value ) {

					/* Only delete the metadata if the key matchs any name inside the
					   Redux global variable. This way we prevent the removal of private
					   metadata (starting by underscores) and third-party metadata (many
					   plugins store their values in the post meta) */
		
					if ( ! array_key_exists( $key, $dynamix_options ) ) continue;
					//if ( in_array( $key, $blacklist ) ) continue;
					delete_post_meta( get_the_ID(), $key );
				}		
    
     		endwhile;  
		
			wp_reset_postdata(); 
		
		endif;

		//die();
	}

	if( isset( $_GET['reset_meta'] ) && isset( $_GET['page'] ) )
	{
		if( $_GET['page'] == 'dynamix_options' && $_GET['reset_meta'] == 'yes' )
		{
			reset_metabox_values();
		}
	}

  require_once( get_template_directory() . '/lib/admin/plugins/importer/importer.php' );
