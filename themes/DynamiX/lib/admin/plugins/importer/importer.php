<?php
function acoda_options_import_demo()
{
	if ( current_user_can( 'manage_options' ) )
	{
		// Check AJAX Referer
		check_ajax_referer('_acoda_theme_options', '_ajax_nonce');
	
		if ( ! class_exists('WP_Import') )
		{
			if ( ! defined('WP_LOAD_IMPORTERS') ) : define('WP_LOAD_IMPORTERS', true); endif;
			$wp_import = get_template_directory() . '/lib/admin/plugins/importer/wordpress-importer.php';
			require_once($wp_import);
		}
	
		class acodaImport extends WP_Import {}
	
		// Instantiate prime-importer
		$wp_import = new acodaImport();
	
		// Load attachments
		$wp_import->fetch_attachments = true;

		// Get Demo Version
		if( ! isset( $_POST['demo_name'] ) || trim( $_POST['demo_name'] ) == '' )
		{
			$demo = 'classic';
		}
		else
		{
			$demo = $_POST['demo_name'];
		}		
		
		$theme_options = $xml_path = $widgets_data = $revslider_array = '';

		// Menu Name
		$skin_name = ucfirst( str_replace( '_', '', $demo ) );	
				
		//$menu_name = str_replace( '_', '-', $demo );
		$menu_name = 'acoda_menu';
				
		wp_delete_nav_menu( $menu_name );	
				
		// Home Name
		$home_name = 'Home';	
		
		switch( $demo )
		{
			case 'apparel':
	
				// XML Path

				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';
				
				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';

				// Rev Slider Dir
				

				//wp_delete_nav_menu( $menu_name .'-single' );						
	
			break;				
			case 'classic':
	
				// XML Path

				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';
				
				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				//$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';

				// Rev Slider Dir
				$revslider_array = array(  
					get_template_directory() . '/demos/'. $demo .'/plugins/revslider/dynamix_home.zip',  
				);		

				//wp_delete_nav_menu( $menu_name .'-single' );						
	
			break;
			case 'capture':
	
				// XML Path

				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';
				
				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';
	
			break;	
			case 'founder':
	
				// XML Path

				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';
				
				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';						
	
			break;				
			case 'horizon':
	
				// XML Path
				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';

				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';
				
				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';
				
				// Rev Slider Dir
				$revslider_array = array(  
					get_template_directory() . '/demos/'. $demo .'/plugins/revslider/news-slider.zip',  
				);					
					
			break;					
			case 'couture':
	
				// XML Path

				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';
				
				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';
	
			break;	
			case 'lakeside':
	
				// XML Path
				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';

				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';
				
				// Rev Slider Dir
				$revslider_array = array(  
					get_template_directory() . '/demos/'. $demo .'/plugins/revslider/slider-home.zip',  
				);					

			break;	

			case 'rising':
	
				// XML Path
				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';

				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';		
							
					
			break;	
			case 'techbyte':
	
				// XML Path
				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';

				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';		
					
					
			break;	
			case 'wanderlust':
	
				// XML Path
				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';

				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';		
					
					
			break;	
			case 'xesign':
	
				// XML Path
				$xml_path = get_template_directory() . '/demos/'. $demo .'/demo.xml';

				// Theme Options
				$theme_options = get_template_directory() . '/demos/'. $demo .'/theme_options.json';

				// Widget Data
				$widgets_data = get_template_directory() . '/demos/'. $demo .'/widget_data.json';		
					
					
			break;					
		}
				
		ob_start();
		$wp_import->import($xml_path);
		ob_end_clean();	
		

		update_option('preview_skin', $skin_name );
		update_option('acoda_dynamix_skin', $skin_name ); 	
		
		
		// Load menus
		$primary_nav = wp_get_nav_menu_object( $menu_name );
		
		$primary_nav_term_id = (int)$primary_nav->term_id;
		
		//Set the menu values
		$locations = get_theme_mod('nav_menu_locations');
		$locations['mainnav'] = $primary_nav_term_id; //$foo is term_id of menu
	
		set_theme_mod('nav_menu_locations', $locations);
	
		// Setup Reading Settings
		update_option('show_on_front', 'page');
		$home_page = get_page_by_title( $home_name );
		
		if( $home_page->post_type == 'page' ) update_option('page_on_front', $home_page->ID);

		// Import Theme Options
		if( !empty( $theme_options ) )
		{
			global $wp_filesystem;
			$encode_options = $wp_filesystem->get_contents( $theme_options );	
												
			$options = json_decode($encode_options, true);
	
			if( $options !== false )
			{
				$acoda_option = get_option( ACODA_THEME_PREFIX.'_options' );
				update_option( ACODA_THEME_PREFIX.'_options', $options );				
			}	
		}

		// Add data to widgets
		if( !empty( $widgets_data ) )
		{
			$widgets_json = $widgets_data; // widgets data file
			
			global $wp_filesystem;
			$widgets_json = $wp_filesystem->get_contents( $widgets_json );
			
			$widget_content = $widgets_json;
			$import_widgets = acoda_import_widget_data( $widget_content );
		}

		// Import Revslider
		if( class_exists('UniteFunctionsRev') && is_array( $revslider_array ) ) 
		{			 
			$slider_array = $revslider_array;
			$slider = new RevSlider();
			 
			foreach($slider_array as $filepath)
			{
				$slider->importSliderFromPost( true, true, $filepath );  
			}	
		}					
	
		wp_kses( _e( '<strong>Import Complete.</strong> The Demo content has been imported, <strong>please wait for page reload.</strong>', 'dynamix' ), wp_kses_allowed_html() );
		
	}
	
	echo 'Finished';
	
	die();
}

add_action( 'wp_ajax_acoda_options_import_demo', 'acoda_options_import_demo' );

// Parsing Widgets Function
// Thanks to http://wordpress.org/plugins/widget-settings-importexport/
function acoda_import_widget_data( $widget_data ) {
	
	update_option( 'sidebars_widgets', array() );
	
	$json_data = $widget_data;
	$json_data = json_decode( $json_data, true );

	$sidebar_data = $json_data[0];
	$widget_data = $json_data[1];

	foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
		$widgets[ $widget_data_title ] = '';
		foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
			if( is_int( $widget_data_key ) ) {
				$widgets[$widget_data_title][$widget_data_key] = 'on';
			}
		}
	}
	unset($widgets[""]);

	foreach ( $sidebar_data as $title => $sidebar ) {
		$count = count( $sidebar );
		for ( $i = 0; $i < $count; $i++ ) {
			$widget = array( );
			$widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
			$widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
			if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
				unset( $sidebar_data[$title][$i] );
			}
		}
		$sidebar_data[$title] = array_values( $sidebar_data[$title] );
	}

	foreach ( $widgets as $widget_title => $widget_value ) {
		foreach ( $widget_value as $widget_key => $widget_value ) {
			$widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
		}
	}

	$sidebar_data = array( array_filter( $sidebar_data ), $widgets );

	acoda_parse_import_data( $sidebar_data );
}

function acoda_parse_import_data( $import_array ) {
	global $wp_registered_sidebars;
	$sidebars_data = $import_array[0];
	$widget_data = $import_array[1];
	$current_sidebars = get_option( 'sidebars_widgets' );
	$new_widgets = array( );

	foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

		foreach ( $import_widgets as $import_widget ) :
			//if the sidebar exists
			if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
				$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
				$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
				$current_widget_data = get_option( 'widget_' . $title );
				$new_widget_name = acoda_get_new_widget_name( $title, $index );
				$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

				if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
					while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
						$new_index++;
					}
				}
				$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
				if ( array_key_exists( $title, $new_widgets ) ) {
					$new_widgets[$title][$new_index] = $widget_data[$title][$index];
					$multiwidget = $new_widgets[$title]['_multiwidget'];
					unset( $new_widgets[$title]['_multiwidget'] );
					$new_widgets[$title]['_multiwidget'] = $multiwidget;
				} else {
					$current_widget_data[$new_index] = $widget_data[$title][$index];
					$current_multiwidget = isset($current_widget_data['_multiwidget']) ? $current_widget_data['_multiwidget'] : false;
					$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
					$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
					unset( $current_widget_data['_multiwidget'] );
					$current_widget_data['_multiwidget'] = $multiwidget;
					$new_widgets[$title] = $current_widget_data;
				}

			endif;
		endforeach;
	endforeach;

	if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
		update_option( 'sidebars_widgets', $current_sidebars );

		foreach ( $new_widgets as $title => $content )
			update_option( 'widget_' . $title, $content );

		return true;
	}

	return false;
}

function acoda_get_new_widget_name( $widget_name, $widget_index ) {
	$current_sidebars = get_option( 'sidebars_widgets' );
	$all_widget_array = array( );
	foreach ( $current_sidebars as $sidebar => $widgets ) {
		if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
			foreach ( $widgets as $widget ) {
				$all_widget_array[] = $widget;
			}
		}
	}
	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
		$widget_index++;
	}
	$new_widget_name = $widget_name . '-' . $widget_index;
	return $new_widget_name;
}