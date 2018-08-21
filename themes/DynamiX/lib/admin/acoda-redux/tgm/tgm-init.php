<?php

/**
 * TGM Init Class
 */
include_once ('class-tgm-plugin-activation.php');

function dynamix_options_register_required_plugins() {

	$plugins = array(

			array(
				'name'                  => 'Visual Composer', // The plugin name
				'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/js_composer.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '5.4.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),	
			array(
				'name'                  => 'ACODA Typewriter', // The plugin name
				'slug'                  => 'acoda-typewriter', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/acoda-typewriter.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'                  => 'ACODA Gigatools', // The plugin name
				'slug'                  => 'acoda-gigatools', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/acoda-gigatools.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),			
			array(
				'name'                  => 'ACODA Counters', // The plugin name
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
				'version'               => '4.1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'          => '', // If set, overrides default API URL and points to an external URL
			),			
			array(
				'name'                  => 'ACODA Pricing Tables', // The plugin name
				'slug'                  => 'ultimate-pricing-tables', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/plugins/ultimate-pricing-tables.zip', // The plugin source
				'required'              => false, // If false, the plugin is only 'recommended' instead of required
				'version'               => '1.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
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
				'version'               => '5.4.6.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
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
		'domain'       		=> 'dynamix',         	// Text domain - likely want to be the same as your theme.
		'default_path'      => '',                           // Default absolute path to pre-packaged plugins
		'menu'              => 'install-required-plugins',   // Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
	);

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'dynamix_options_register_required_plugins' );