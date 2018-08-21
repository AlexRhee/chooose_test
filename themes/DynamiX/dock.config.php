<?php

	/* ------------------------------------
	:: CONFIGURE DOCK BAR
	------------------------------------*/  
	
	$post_id = ( !empty( $post ) && ! is_search() ? $post->ID : '' );
	
	$acoda_socialicons	= acoda_settings('display_socialicons');	
	$acoda_social_share	= acoda_settings('socialicons_share');	
	
	echo "\n". '<nav class="dock-panel-wrap '. esc_attr( $dockbar_position .' '. $dockicon_panels ) . ( $header_width == ' fullwidth' && $dockbar_position == 'dock_layout_1' ? ' fullwidth' : '' ) .' skinset-dockbar acoda-skin '. ( $dockbar_position == 'dock_layout_1' ? 'top_bar' : 'main_nav' ) .'">';

		$dock_icons = '';
		
		if( $dockicon_panels == 'dockpanel_type_2' && ( $dockbar_position == 'dock_layout_1' || $dockbar_position == 'dock_layout_1 dock_float' ) )
		{
			$dock_icons .= "\n". '<div class="dock-panels-background skinset-dockbar acoda-skin"></div>';	
		}
		
		// Dock Icons
		$dock_icons .= "\n". '<div class="dock-panel-inner row clearfix">';
		$dock_icons .= "\n". '<div class="dock-panels clearfix">';	
		
		if( $dockicon_panels == 'dockpanel_type_2' && ( $dockbar_position != 'dock_layout_1' && $dockbar_position != 'dock_layout_1 dock_float' ) )
		{
			$dock_icons .= "\n". '<div class="dock-panels-background skinset-dockbar acoda-skin"></div>';	
		}
					
		
		$dock_icons .= "\n\t". '<ul class="dock-panel clearfix">';

				
				$mobile_logo 	= acoda_settings('mobile_logo');
				$mobile_logo_2x = acoda_settings('mobile_logo_2x');
					
				if( acoda_settings('mobile_logo_position') == 'dockbar' )
				{
					$dock_icons .= "\n\t". '<li class="dock-tab dock-logo mobile">';
					
					$width = $height = '';
				
					$acoda_branding_url = $mobile_logo['url']; 
					
					$branding_data = acoda_attachment_by_url( $mobile_logo['url'] );
					
					if( !empty( $branding_data ) )
					{
						$width  = $branding_data[1];
						$height = $branding_data[2];
					}

					$dock_icons .= '<a href="'. esc_url( get_home_url() ) .'">';
					
					if( !empty( $acoda_branding_url ) )
					{
						$dock_icons .= '<img src="'. esc_url( $acoda_branding_url ) .'" class="'. ( !empty( $mobile_logo_2x['url'] ) ? 'branding-1x' : '' ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" alt="'. esc_attr( get_bloginfo('name') ) .'" />';
					
						// Retina  Logo
						if( !empty( $mobile_logo_2x['url'] ) )
						{
							$acoda_branding_url = $mobile_logo_2x['url']; 

							$branding_data = acoda_attachment_by_url( $acoda_branding_url );

							if( !empty( $branding_data ) )
							{						
								$width  = $branding_data[1] / 2;
								$height = $branding_data[2] / 2;
							}

							$dock_icons .= '<img src="'. esc_url( $acoda_branding_url ) .'" class="branding-2x" alt="'. esc_attr( get_bloginfo('name') ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" />';
						}						
					}
					else
					{
						$dock_icons .= '<span class="logo">'. get_bloginfo('name') .'</span>';
					}
	
					
					$dock_icons .= '</a>';
					
					$dock_icons .= "\n\t". '</li>';
				}
					
				// Custom Dock Widgets
				$dock_widgets = acoda_settings('dockicon_custom');

				if( !empty( $dock_widgets ) )
				{
					$widget_count = count( $dock_widgets['redux_repeater_data'] ) -1;

					for ($x = 0; $x <= $widget_count; $x++) 
					{
						$dock_widget			= $dock_widgets['dock_widget'][$x];
						$dockicon_panel 		= $dock_widgets['dockicon_panel'][$x];
						$dockicon_panel_mobile 	= $dock_widgets['dockicon_panel_mobile'][$x];

						if( $dockicon_panel == 'inline')
						{
							$dock_icons .= "\n\t". '<li class="dock-tab dock-custom-'. $x . ( $dockicon_panel_mobile == true ? ' desktop' : ' block' ) .'">';

							if( is_active_sidebar( $dock_widget ) )
							{
								$dock_icons .= "\n". '<ul>';

								ob_start();
								dynamic_sidebar( $dock_widget );
								$dock_icons .= ob_get_contents();
								ob_end_clean();

								$dock_icons .= "\n". '</ul>';
							}

							$dock_icons .= '</li>';							
						}		
					} 
				}


				if( acoda_settings('dockicon_search') == 'inline'  )
				{
					$dock_icons .= "\n\t". '<li class="dock-tab dock-search'. ( acoda_settings('dockicon_search_mobile') == true ? ' desktop' : ' block' ) .'">';
					
					$dock_icons .= acoda_dockicon_search();
	
					$dock_icons .= '</li>';
				}

				if( is_active_sidebar('infopanel') && acoda_settings('dockicon_infopanel') == 'inline'  )
				{
					$dock_icons .= "\n\t". '<li class="dock-tab dock-info'. ( acoda_settings('dockicon_infopanel_mobile') == true ? ' desktop' : ' block' ) .'">';
					$dock_icons .= "\n". '<ul>';
					
					ob_start();
					dynamic_sidebar('infopanel');
					$dock_icons .= ob_get_contents();
					ob_end_clean();
					
					$dock_icons .= "\n". '</ul>';
	
					$dock_icons .= '</li>';
				}	
							
				// Social Icons
				$mobile_social = $social_init = '';			

				if( $acoda_socialicons == true )
				{
					if( $acoda_social_share == false ) 
					{
						$social_init = 'no'; 
					}
					else 
					{
						$social_init = 'yes';
					}
					
					if( $social_init == "yes" )
					{
						$dock_icons .= "\n\t". '<li class="social-trigger dock-tab desktop">';
						$dock_icons .= '<a data-show-dock="social-wrap" class="dock-tab-trigger" href="#"><i class="fal fa-share-alt"></i></a>';
						$dock_icons .= '</li>';
					}
					else
					{
						ob_start();
						include( get_template_directory() .'/lib/inc/social-icons.php' );
						$dock_icons .= ob_get_clean();
					}
				}

				// WPML
				if ( class_exists('SitePress') || class_exists('google_language_translator') )
				{
				$dock_icons .= "\n\t". '<li class="language-trigger dock-tab desktop">';
				$dock_icons .= '<a data-show-dock="wpml" class="dock-tab-trigger" href="#"><i class="fal fa-flag"></i></a>';
				$dock_icons .= '</li>';
				}				 
		
				// WooCommerce Shopping Cart		
				if( class_exists('Woocommerce') && acoda_settings('woocommerce_cart') != false )
				{
				global $woocommerce; 
				$dock_icons .= "\n\t". '<li class="woo-trigger dock-tab">';
				$dock_icons .= '<a data-show-dock="shop-cart" class="dock-tab-trigger" href="#">';
		
				// Show count if more than 1
				$display = '';
				if( $woocommerce->cart->cart_contents_count >=1 )
				{
					$display = 'display';
				}
				
				$dock_icons .= '<span class="items-count '. esc_attr( $display ) .'">'. esc_html( $woocommerce->cart->cart_contents_count ) .'</span>'; 
				
				                     
				$dock_icons .= '<i class="fal fa-shopping-cart"></i>';
				$dock_icons .= '</a>';
				$dock_icons .= '</li>';
				}	

				// Custom Dock Widgets
				$dock_widgets = acoda_settings('dockicon_custom');

				if( !empty( $dock_widgets ) )
				{		
					$widget_count = count( $dock_widgets['redux_repeater_data'] ) -1;

					for ($x = 0; $x <= $widget_count; $x++) 
					{
						$dock_widget			= $dock_widgets['dock_widget'][$x];
						$dockicon				= $dock_widgets['dockicon'][$x];
						$dockicon_panel 		= $dock_widgets['dockicon_panel'][$x];
						$dockicon_panel_mobile 	= $dock_widgets['dockicon_panel_mobile'][$x];

						if( $dockicon_panel == 'flyout' || ( $dockicon_panel == 'inline' && $dockicon_panel_mobile == true ) )
						{
							$dock_icons .= "\n\t". '<li class="custom-trigger-'. $x .' dock-tab '. ( $dockicon_panel_mobile == true && $dockicon_panel == 'inline' ? ' mobile' : '' ) .'">';
							$dock_icons .= '<a data-show-dock="dock-custom-'. $x .'" class="dock-tab-trigger" href="#"><i class="'. $dockicon .'"></i>'. ( !empty( $dock_widgets['dockicon_text'][$x] ) ? ' <span class="dock-trigger-text">'. $dock_widgets['dockicon_text'][$x] .'</span> ' : ''  ) .'</a>';
							$dock_icons .= '</li>';							
						}		
					} 
				}

				// Search
				if( acoda_settings('dockicon_search') == 'flyout' || ( acoda_settings('dockicon_search') == 'inline' && acoda_settings('dockicon_search_mobile') == true ) )
				{   
				$dock_icons .= "\n\t". '<li class="search-trigger dock-tab '. ( acoda_settings('dockicon_search_text') != '' ? ' dock-text' : ''  ) . ( acoda_settings('dockicon_search_mobile') == true && acoda_settings('dockicon_search') == 'inline' ? ' mobile' : '' ) .'">';
				$dock_icons .= '<a data-show-dock="searchform" class="dock-tab-trigger" href="#"><i class="fal fa-search"></i>'. ( acoda_settings('dockicon_search_text') != '' ? ' <span class="dock-trigger-text">'. acoda_settings('dockicon_search_text') .'</span> ' : ''  ) .'</a>';
				$dock_icons .= '</li>';
				} 						

				// Menu
				if(  has_nav_menu( 'mobilenav' ) || has_nav_menu( 'mainnav' ) )
				{   
					$dock_icons .= "\n\t". '<li class="dock-menu-trigger dock-tab'. ( acoda_settings('menu_position') == 'dockbar' ? '' : ' mobile' ) .'">';
					
					if( $dockbar_position == 'dock_layout_1' || $dockbar_position == 'dock_layout_4' || $dockbar_position == 'dock_layout_1 dock_float'  )
					{
						if( acoda_settings('dockicon_menu_text') != '' )
						{
							$dock_icons .= '<a data-show-dock="dock-menu" class="dock-tab-trigger text" href="#"><span class="dock-icon-text">'. esc_html( acoda_settings('dockicon_menu_text') ) .'</span></a>';
						}		
										
						$dock_icons .= '<a data-show-dock="dock-menu" class="dock-tab-trigger" href="#"><i class="'. ( acoda_settings( 'dockicon_menu_icon' ) != '' ? esc_attr( acoda_settings( 'dockicon_menu_icon' ) ) : 'fal fa-bars' ) .'"></i></a>';
					}
					else
					{
						$dock_icons .= '<a data-show-dock="dock-menu" class="dock-tab-trigger" href="#"><i class="'. ( acoda_settings( 'dockicon_menu_icon' ) != '' ? esc_attr( acoda_settings( 'dockicon_menu_icon' ) ) : 'fal fa-bars' ) .'"></i></a>';	
						
						if( acoda_settings('dockicon_menu_text') != '' )
						{
							$dock_icons .= '<a data-show-dock="dock-menu" class="dock-tab-trigger text" href="#"><span class="dock-icon-text">'. esc_html( acoda_settings('dockicon_menu_text') ) .'</span></a>';
						}							
					}
				
					$dock_icons .= '</li>';
				} 	
				
		$dock_icons .= "\n\t". '</ul>';


		// WPML
		if ( class_exists('SitePress') || class_exists('google_language_translator') )
		{
		$dock_icons .= "\n\t". '<div class="dock-tab-wrapper wpml">';
		$dock_icons .= "\n\t\t". '<span class="pointer"></span>';
		$dock_icons .= "\n\t\t". '<div class="background-wrap skinset-dockpanel acoda-skin">';
		$dock_icons .= "\n\t\t". '<div class="infodock-innerwrap clearfix">';		
		$dock_icons .= "\n\t\t". '<ul>';
		$dock_icons .= "\n\t\t". '<li>';
		
		if( class_exists('SitePress') )
		{
			ob_start();
			do_action('icl_language_selector');
			$dock_icons .= ob_get_clean();
		}
		elseif( class_exists('google_language_translator') )
		{
			$dock_icons .= do_shortcode('[google-translator]');
		}
		
		$dock_icons .= "\n\t\t". '</li>';
		$dock_icons .= "\n\t\t". '</ul>';		
		$dock_icons .= "\n\t\t". '</div>'; 
		$dock_icons .= "\n\t\t". '</div>'; 
		$dock_icons .= "\n\t". '</div>';			
		}
		
		// Social Icons
		if( $social_init == "yes" || $mobile_social == "mobile-social" )
		{
		$dock_icons .= "\n\t". '<div class="dock-tab-wrapper social-wrap">';
		$dock_icons .= "\n\t\t". '<span class="pointer"></span>';
		$dock_icons .= "\n\t\t". '<div class="background-wrap skinset-dockpanel acoda-skin">';
		$dock_icons .= "\n\t\t". '<div class="infodock-innerwrap clearfix">';
		$dock_icons .= "\n\t\t". '<ul class="clearfix">';
		
		ob_start();
		include( get_template_directory() .'/lib/inc/social-icons.php' );
		$dock_icons .= ob_get_clean();
		
		$dock_icons .= "\n\t\t". '</ul>';
		$dock_icons .= "\n\t\t". '</div>'; 
		$dock_icons .= "\n\t\t". '</div>'; 
		$dock_icons .= "\n\t". '</div>';			
		}
		
		
		// Dock Menu
		
		$dock_icons .= "\n\t". '<div class="dock-tab-wrapper dock-menu">';
		$dock_icons .= "\n\t\t". '<span class="pointer"></span>';
		$dock_icons .= "\n\t\t". '<nav class="background-wrap skinset-dockpanel dock-menu-tabs acoda-skin">';
		$dock_icons .= "\n\t\t". '<div class="infodock-innerwrap clearfix">' . "\n";
			
			if( acoda_settings('menu_position') == 'dockbar' || ! has_nav_menu( 'mobilenav' ) )
			{						
				if( $menu_slug != 'disable' && $selected_menu !='none' ) :
																
					$dock_icons .= wp_nav_menu( array(
						'echo' => false,
						'container' => 'ul',
						'menu_class' => 'dock_menu '. ( acoda_settings('menu_position') == 'dockbar' ? 'main' : '' ) .' clearfix'. ( ! has_nav_menu( 'mobilenav' ) ? ' mobile' : '' ),
						'menu_id' => '',
						'theme_location' => 'mainnav',
						'menu' => $menu_slug
					));
									
				endif;	
			}

			if ( has_nav_menu( 'mobilenav' ) )
			{			
				$dock_icons .= wp_nav_menu( array(
					'echo' => false,
					'container' => 'ul',
					'menu_class' => 'dock_menu mobile clearfix', 
					'theme_location' => 'mobilenav',

				));					
			}			

			if( is_active_sidebar('dockedmenupanel') )
			{
				$dock_icons .= "\n". '<ul>';
				
				ob_start();
				dynamic_sidebar('dockedmenupanel');
				$dock_icons .= ob_get_contents();
				ob_end_clean();	
				
				$dock_icons .= "\n". '</ul>';				
			}
						
		$dock_icons .= "\n\t\t". '</div>'; 
		$dock_icons .= "\n\t\t". '</nav>'; 
		$dock_icons .= "\n\t". '</div>';				
		


		// Woocommerce 
		if( class_exists('Woocommerce') && acoda_settings('woocommerce_cart') != false )
		{
		global $woocommerce;
		
		$dock_icons .= "\n\t". '<div class="dock-tab-wrapper shop-cart">';
		$dock_icons .= "\n\t\t". '<span class="pointer"></span>';
		$dock_icons .= "\n\t\t". '<div class="background-wrap skinset-dockpanel acoda-skin">';
		$dock_icons .= "\n\t\t". '<div class="infodock-innerwrap clearfix">';		
		
		$cart_widget = '';
		
		ob_start();	
		the_widget( 'acoda_WC_Widget_Cart' );
		$cart_widget = ob_get_clean();
		
		$dock_icons .= $cart_widget;
		$dock_icons .= "\n\t\t". '</div>';
		$dock_icons .= "\n\t\t". '</div>';
		$dock_icons .= "\n\t". '</div>';		
		}

		// Custom Dock Widgets
		$dock_widgets = acoda_settings('dockicon_custom');

		if( !empty( $dock_widgets) )
		{	
			$widget_count = count( $dock_widgets['redux_repeater_data'] ) -1;

			for ($x = 0; $x <= $widget_count; $x++) 
			{
				$dock_widget			= $dock_widgets['dock_widget'][$x];
				$dockicon_panel 		= $dock_widgets['dockicon_panel'][$x];
				$dockicon_panel_mobile 	= $dock_widgets['dockicon_panel_mobile'][$x];

				if( $dockicon_panel == 'flyout' || ( $dockicon_panel == 'inline' && $dockicon_panel_mobile == true ) )
				{
					$dock_icons .= "\n\t". '<div class="dock-tab-wrapper '. ( $dockicon_panel == 'flyout' ? 'static' : '' ) .' dock-custom-'. $x .'">';
					$dock_icons .= "\n\t\t". '<span class="pointer"></span>';
					$dock_icons .= "\n\t\t". '<div class="background-wrap skinset-dockpanel acoda-skin">';
					$dock_icons .= "\n\t\t". '<div class="infodock-innerwrap clearfix">';				

					if( is_active_sidebar( $dock_widget ) )
					{
						$dock_icons .= "\n". '<ul>';
						ob_start();
						dynamic_sidebar( $dock_widget );
						$dock_icons .= ob_get_contents();
						ob_end_clean();

						$dock_icons .= "\n". '</ul>';
					}

					$dock_icons .= "\n\t\t". '</div>';
					$dock_icons .= "\n\t\t". '</div>';
					$dock_icons .= "\n\t". '</div>';							
				}		
			} 
		}

		// Search Form
		if( acoda_settings('dockicon_search') == 'flyout' || ( acoda_settings('dockicon_search') == 'inline' && acoda_settings('dockicon_search_mobile') == true ) )
		{
			$dock_icons .= "\n\t". '<div class="dock-tab-wrapper '. ( acoda_settings( 'dockicon_search' ) == 'flyout' ? 'static' : '' ) .' searchform">';
			$dock_icons .= "\n\t\t". '<span class="pointer"></span>';
			$dock_icons .= "\n\t\t". '<div class="background-wrap skinset-dockpanel acoda-skin">';
			$dock_icons .= "\n\t\t". '<div class="infodock-innerwrap clearfix">';
			
			$widget_tag			= ( !empty( $dynamix_options['widget_tag'] ) ) ? $dynamix_options['widget_tag'] : 'h4';
			$dock_icons .= '<'.$widget_tag.' class="widget-title-wrap heading-font"><span class="widget-title">'. esc_html__('Search','dynamix') .'</span></'.$widget_tag.'>';			

			$dock_icons .= acoda_dockicon_search();
			
			$dock_icons .= "\n\t\t". '</div>';
			$dock_icons .= "\n\t\t". '</div>';
			$dock_icons .= "\n\t". '</div>';			
		}
		
		

		$dock_icons .= "\n". '</div>';
		$dock_icons .= "\n". '</div>';

		echo $dock_icons;
	
	echo "\n". '</nav>'; 


	// Header Info Panel
	/*$dock_icons = '';
	
	if( is_active_sidebar('infopanel') && acoda_settings('dockicon_infopanel') == 'inline' && ( $dockbar_position == 'dock_layout_2' || $dockbar_position == 'dock_layout_2 dock_float' || $dockbar_position == 'dock_layout_3' || $dockbar_position == 'dock_layout_3 dock_float'  ) )
	{
		$dock_icons .= "\n". '<div class="dock-panel-wrap infopanel-dock dock_layout_1 '. esc_attr( $dockicon_panels ) .' skinset-dockbar acoda-skin top_bar">';
		$dock_icons .= "\n". '<div class="dock-panel-inner row clearfix">';
		
		$dock_icons .= acoda_dockicon_info();

		$dock_icons .= "\n". '</div>';
		$dock_icons .= "\n". '</div>';
		
		echo $dock_icons; 	
	}*/	