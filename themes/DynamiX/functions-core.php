<?php

	/* ------------------------------------
	::	acoda Core Functions
	------------------------------------ */	

	// acoda Global Variables
	if ( ! function_exists( 'acoda_settings' ) ) 
	{
		function acoda_settings( $option ) 
		{
			global $dynamix_options;

			$url = explode('?', 'http://'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );

			$post_id = ( isset($_GET['page_id'] ) ? esc_attr( $_GET['page_id'] ) : url_to_postid( esc_url( $url[0] ) ) );

			$setting = '';

			if( $option == 'page_layout' )
			{	
				if( !is_page() || ( is_search() || is_404() ) || ( is_home() && ! is_page() ) )
				{
					$setting = $dynamix_options['bloglayout']; 
				}
				
				if( is_single() )
				{
					$setting = $dynamix_options['postlayout'];
				}

				// Portfolio
				if( get_post_type() == 'portfolio' )
				{
					$setting = $dynamix_options['portlayout']; 
				}

				// If is singular but no layout config, use default.
				if( is_page() )
				{
					$setting = $dynamix_options['pagelayout']; 
				}


				// WooCommerce
				if( class_exists( 'woocommerce' ) )
				{
					if( is_woocommerce() )
					{
						$setting = $dynamix_options['woocomlayout']; 			
					}
				}	

				// bbPress
				if( class_exists( 'bbPress' ) )
				{
					if ( is_bbpress() ) 
					{
						$setting = $dynamix_options['buddylayout']; 
					}
				}

				return $setting;	
			}
			else if( $option == 'pinned_sidebar')
			{
				$pinned_sidebar = 'normal';
				$acoda_layout = acoda_settings('page_layout');
					
				if( $acoda_layout == 'layout_two' || $acoda_layout == 'layout_four' )
				{				
					if( !is_page() || ( is_search() || is_404() ) || ( is_home() && ! is_page() ) )
					{
						$setting = $dynamix_options['blogpinsidebar']; 
					}

					if( is_single() )
					{
						$setting = $dynamix_options['postpinsidebar'];
					}					

					// Portfolio
					if( get_post_type() == 'portfolio' )
					{
						$setting = $dynamix_options['portpinsidebar']; 
					}

					// If is singular but no layout config, use default.
					if( is_page() )
					{
						$setting = $dynamix_options['pagepinsidebar']; 
					}

					// WooCommerce
					if( class_exists( 'woocommerce' ) )
					{
						if( is_woocommerce() )
						{
							$setting = $dynamix_options['woopinsidebar']; 			
						}
					}	

					// bbPress
					if( class_exists( 'bbPress' ) )
					{
						if ( is_bbpress() ) 
						{
							$setting = $dynamix_options['bbppinsidebar']; 
						}
					}
				}

				return $setting;			
			}
			else if( $option == 'sticky_sidebar')
			{
				$acoda_layout = acoda_settings('page_layout');
					
				if( $acoda_layout == 'layout_two' || $acoda_layout == 'layout_four' )
				{
					if( !is_page() )
					{
						$setting = $dynamix_options['blogsticksidebar']; 
					}
					
					if( is_single() )
					{
						$setting = $dynamix_options['poststicksidebar']; 
					}					

					// If is singular but no layout config, use default.
					if( is_page() )
					{
						$setting = $dynamix_options['pagesticksidebar']; 
					}
				}

				return $setting;				
			}
			else if( $option == 'sidebar_one')
			{
				if( !is_page() || ( is_search() || is_404() ) || ( is_home() && ! is_page() ) )
				{
					$setting = ( !empty( $dynamix_options['blogcolone'] ) ? $dynamix_options['blogcolone'] : 'sidebar1' );
				}

				if( is_single() )
				{
					$setting = ( !empty( $dynamix_options['postcolone'] ) ? $dynamix_options['postcolone'] : 'sidebar1' );
				}
				
				
				// Portfolio
				if( get_post_type() == 'portfolio' )
				{
					$setting = ( !empty( $dynamix_options['portcolone'] ) ? $dynamix_options['portcolone'] : 'sidebar1' );
				}

				// If is singular but no layout config, use default.
				if( is_page() )
				{
					$setting = ( !empty( $dynamix_options['sidebarone'] ) ? $dynamix_options['sidebarone'] : 'sidebar1' );
				}				

				if( class_exists( 'woocommerce' ) )
				{
					if( is_woocommerce() )
					{
						$setting = ( !empty( $dynamix_options['woocomcolone'] ) ? $dynamix_options['woocomcolone'] : 'sidebar1' );
					}
				}	

				if( class_exists( 'bbPress' ) )
				{
					if ( is_bbpress() ) 
					{
						$setting = ( !empty( $dynamix_options['buddycolone'] ) ? $dynamix_options['buddycolone'] : 'sidebar1' );
					}
				}				
						
				if( empty( $setting ) )
				{
					$setting = 'sidebar1';
				}

				return $setting;			
			}	
			else if( $option == 'sidebar_two')
			{
				if( !is_page() || ( is_search() || is_404() ) || ( is_home() && ! is_page() ) )
				{
					$setting = ( !empty( $dynamix_options['blogcoltwo'] ) ? $dynamix_options['blogcoltwo'] : 'sidebar2' );
				}

				if( is_single() )
				{
					$setting = ( !empty( $dynamix_options['postcoltwo'] ) ? $dynamix_options['postcoltwo'] : 'sidebar2' );	
				}				

				// Portfolio
				if( get_post_type() == 'portfolio' )
				{
					$setting = ( !empty( $dynamix_options['portcoltwo'] ) ? $dynamix_options['portcoltwo'] : 'sidebar2' );	
				}

				// If is singular but no layout config, use default.
				if( is_page() )
				{
					$setting = ( !empty( $dynamix_options['sidebartwo'] ) ? $dynamix_options['sidebartwo'] : 'sidebar2' );
				}				

				if( class_exists( 'woocommerce' ) )
				{
					if( is_woocommerce() )
					{
						$setting = ( !empty( $dynamix_options['woocomcoltwo'] ) ? $dynamix_options['woocomcoltwo'] : 'sidebar2' );
					}
				}	

				if( class_exists( 'bbPress' ) )
				{
					if ( is_bbpress() ) 
					{
						$setting = ( !empty( $dynamix_options['buddycoltwo'] ) ? $dynamix_options['buddycoltwo'] : 'sidebar2' );
					}
				}				
						
				if( empty( $setting ) )
				{
					$setting = 'sidebar2';
				}

				return $setting;			
			}	
			else if( $option == 'skin')
			{
				$skin = get_option( 'acoda_dynamix_skin' );
				
				$setting = ( !empty( $dynamix_options['theme_skin'] ) ? $dynamix_options['theme_skin'] : ( !empty( $skin ) ? $skin : 'Classic' ) );
				
				return $setting;			
			}				
			else
			{
				$setting = ( !empty( $dynamix_options[$option] ) ?  $dynamix_options[$option] : '');
				
				return $setting;
			}
					
					
				
		}	
	}

	if ( ! function_exists( 'acoda_create_skin' ) ) 
	{	
		function acoda_create_skin()
		{
			// Skin
			$skin = get_option( 'acoda_dynamix_skin' );

			$acoda_skin = ( !empty( $dynamix_options['theme_skin'] ) ? 'dynamix_'. $dynamix_options['theme_skin'] : ( !empty( $skin ) ? 'dynamix_'. $skin : 'dynamix_Classic' ) );	

			$skin_data = get_option( $acoda_skin );

			$custom_css = '';
			
			// Content Link 
			if( !empty( $skin_data['body_content_link_underline_color']['rgba'] ) )
			{
				$underline_color = $skin_data['body_content_link_underline_color']['rgba'];
				
				//$custom_css .= '.skinset-background .entry p > a,.skinset-background .entry p span > a,.skinset-background .entry h1 > a,.skinset-background .entry h2 > a,.skinset-background .entry h3 > a,.skinset-background .entry h4 > a,.skinset-background .entry h5 > a,.skinset-background .entry h6 > a,.skinset-background .entry li > a  {background-image: linear-gradient('. $underline_color .', '. $underline_color .');background-size: 1px 0.13em;background-repeat: repeat-x;background-position: 0% 100%;}';
				$custom_css .= '.skinset-background .entry p > a,.skinset-background .entry p span > a {box-shadow: 0 1px 0 '. $underline_color .';}';				
			}			
			
			// Widget Title
			
			if( !empty( $skin_data['sidebar_widget_title_color']['rgba'] ) )
			{
				$custom_css .= '
				.skinset-sidebar .apb-title,
				.skinset-sidebar .widget-title { 
				 padding: 8px 10px;
    			 display: inline-block; 
				 }
				';
			}
			

			// Footer Widget Title
			
			if( !empty( $skin_data['footer_widget_title_color']['rgba'] ) )
			{
				$custom_css .= '
				.skinset-footer .apb-title,
				.skinset-footer .widget-title { 
				 padding: 8px 10px;
    			 display: inline-block; 
				 }
				';
			}			
			
			if( !empty( $skin_data['sidebar_widget_title_border_color']['rgba'] ) )
			{
				$custom_css .= '
				.skinset-sidebar .widget-title-wrap { border-width:0 0 2px;border-style:solid;}
				';
			}		
			
			if( !empty( $skin_data['menu_item_border']['border-style'] ) )
			{
				$custom_css .= '
				#acoda_dropmenu > li > a { 
					border-left: '. $skin_data['menu_item_border']['border-left'] .';
					border-right: '. $skin_data['menu_item_border']['border-right'] .';
					border-top: '. $skin_data['menu_item_border']['border-top'] .';
					border-bottom: '. $skin_data['menu_item_border']['border-bottom'] .';
					border-style: '. $skin_data['menu_item_border']['border-style'] .';
					border-color: transparent;
				}';				
			}

			// Header Image
			$header_featured_image = ( !empty (  $skin_data['header_image_featured'] ) ? $skin_data['header_image_featured'] : false  );
			
			// Header Background
			if( $header_featured_image == true && has_post_thumbnail() && ( is_single() || is_page() ) ) 
			{
				$custom_css .= '#header-wrap {background-size:cover;background-image: url('. get_the_post_thumbnail_url() .');}';
			}
			else if( !empty( $skin_data['header_image']['url'] ) )
			{
				$custom_css .= '#header-wrap {background-size:cover;background-image: url('. $skin_data['header_image']['url'] .');}';
			}
			
			// Header Position
			if( !empty( $skin_data['header_image_position'] ) )
			{
				$custom_css .= '#header-wrap {background-position: '. $skin_data['header_image_position'] .';}';
			}			
			
			// Header Position
			if( !empty( $skin_data['header_image_repeat'] ) )
			{
				$custom_css .= '#header-wrap {background-repeat: '. $skin_data['header_image_repeat'] .';}';
			}				


			// Subheader
			$subheader_featured_image = ( !empty (  $skin_data['subheader_image_featured'] ) ? $skin_data['subheader_image_featured'] : false  );
			
			// Header Background
			if( $subheader_featured_image == true && has_post_thumbnail() && ( is_single() || is_page() ) ) 
			{
				$custom_css .= '.intro-wrap {background-image: url('. get_the_post_thumbnail_url() .');}';
			}
			else if( !empty( $skin_data['subheader_image']['url'] ) )
			{
				$custom_css .= '.intro-wrap {background-image: url('. $skin_data['subheader_image']['url'] .');}';
			}
			
			// Header Position
			if( !empty( $skin_data['subheader_image_position'] ) )
			{
				$custom_css .= '.intro-wrap {background-position: '. $skin_data['subheader_image_position'] .';}';
			}			
			
			// Header Position
			if( !empty( $skin_data['subheader_image_repeat'] ) )
			{
				$custom_css .= '.intro-wrap {background-repeat: '. $skin_data['subheader_image_repeat'] .';}';
			}	
			
			// Footer Image
			if( !empty( $skin_data['footer_image']['url'] ) )
			{
				$custom_css .= '#footer-wrap {background-size:cover;background-image: url('. $skin_data['footer_image']['url'] .');}';
			}
			
			// Header Position
			if( !empty( $skin_data['footer_image_position'] ) )
			{
				$custom_css .= '#footer-wrap {background-position: '. $skin_data['footer_image_position'] .';}';
			}			
			
			// Header Position
			if( !empty( $skin_data['footer_image_repeat'] ) )
			{
				$custom_css .= '#footer-wrap {background-repeat: '. $skin_data['footer_image_repeat'] .';}';
			}	
			

			if( !empty( $skin_data['main_image']['url'] ) )
			{
				$custom_css .= '.skinset-main {background-image: url('. $skin_data['main_image']['url'] .');}';
			}			
				
			// Main Position
			if( !empty( $skin_data['main_image_position'] ) )
			{
				$custom_css .= '.skinset-main {background-position: '. $skin_data['main_image_position'] .';}';
			}			
			
			// Main Repeat 
			if( !empty( $skin_data['main_image_repeat'] ) )
			{
				$custom_css .= '.skinset-main {background-repeat: '. $skin_data['main_image_repeat'] .';}';
			}		
			
			// Main Size 
			if( !empty( $skin_data['main_image_size'] ) )
			{
				$custom_css .= '.skinset-main {background-size: '. $skin_data['main_image_size'] .';}';
			}				
			
			
			// Background
			if( !empty( $skin_data['background_image']['url'] ) )
			{
				$custom_css .= '.skinset-background {background-image: url('. $skin_data['background_image']['url'] .');}';
			}			
				
			// Background Position
			if( !empty( $skin_data['background_image_position'] ) )
			{
				$custom_css .= '.skinset-background {background-position: '. $skin_data['background_image_position'] .';}';
			}			
			
			// Background Repeat 
			if( !empty( $skin_data['background_image_repeat'] ) )
			{
				$custom_css .= '.skinset-background {background-repeat: '. $skin_data['background_image_repeat'] .';}';
			}	
			
			// Background Size 
			if( !empty( $skin_data['background_image_size'] ) )
			{
				$custom_css .= '.skinset-background {background-size: '. $skin_data['background_image_size'] .';}';
			}				

			// Minify CSS
			$custom_css = str_replace( array("\r", "\n", "\t" ), '', $custom_css );

			wp_enqueue_style( 'acoda-skin',	get_template_directory_uri() . '/dynamic-style.css', false, null );
			wp_add_inline_style( 'acoda-skin', $custom_css );

		}
	}
	
	add_action('wp_head', 'acoda_create_skin');
	

	// Custom Dynamic CSS
	if ( ! function_exists( 'acoda_dynamic_css' ) ) 
	{
		function acoda_dynamic_css()
		{
			global $post,
					$dynamix_options;
			$custom_css = $header_logo = $tabs = $subheader = '';

			$post_id = ( !empty( $post ) && ! is_search() ? $post->ID : '' );

	
			// Subheader Height
			if( acoda_settings('subheader_height') != '' )
			{
				$subheader_height = acoda_settings('subheader_height');

				$vh = strpos( $subheader_height, 'vh' );

				if( $vh === false )
				{
					$subheader = 'height:0;min-height:'. str_replace( 'px', '', $subheader_height ) .'px;';
				}
				else
				{
					$subheader = 'height:0;min-height:'. $subheader_height;
				}
			} 

			$sticky_menu = ( !empty( $dynamix_options['sticky_menu'] ) ? $dynamix_options['sticky_menu'] : true );
			
			// Content Padding
			if( !empty( $dynamix_options['content_padding'] ) )
			{
				$custom_css .= '
				#container #content {
					padding-top:'. $dynamix_options['content_padding']['padding-top'] .';
					padding-bottom:'. $dynamix_options['content_padding']['padding-bottom'] .';
				}';					
			}			

			if( $sticky_menu != false )
			{
				$custom_css .= '	
				@media only screen and (max-width: 64.063em) {
			
					
					#header.stuck {
					 z-index:1000;
					 position:fixed;
					}
					
					.sticky_menu #header.stuck #header-logo,
					#header.stuck .dock-panel li {
					 display:none;
					}
					
					#header.stuck .dock-panel li.dock-menu-trigger {
					 display:inline-block;
					}

					#header.stuck > .inner-wrap {
					 min-height:0 !important;
					}
					
					#header.stuck .dock-panel-wrap {
					 padding: 0rem 0.9375rem;
					}


					#header-wrap.layout_3 #header.stuck #acoda-tabs,
					#header-wrap.layout_3 #header.stuck #header-logo {
					 margin-left:0;
					 margin-right:0;	
					 display:inherit;
					 clear:none;
					}

					#header.stuck #header-logo #logo .description {display:none;}
				}';
			}

			if( !empty( $subheader ) )
			{ 
				$custom_css .= '
				@media only screen and (min-width: 64.063em) {
					.intro-wrap .intro-wrap-inner .intro-text,
					.intro-wrap.layout_3 .intro-wrap-inner {'. $subheader .'}
				}';
				/*$custom_css .= '
					.intro-wrap .intro-wrap-inner .intro-text,
					.intro-wrap.layout_3 .intro-wrap-inner {'. $subheader .'}';		*/		
			}	


			if( !empty( $header_logo ) )
			{ 
				$custom_css .= '
				@media only screen and (min-width: 64.063em) {
					#container #header-logo {'. $header_logo .'}
				}';
			}	

			if( !empty( $tabs ) )
			{ 
				$custom_css .= '
				@media only screen and (min-width: 64.063em) {
					#container #acoda-tabs > ul > li,
					#header-wrap .dock-panel-wrap.main_nav ul.dock-panel li,
					#acoda-tabs .dock-panel li.dock-tab.dock-info	{'. $tabs .'}
				}';
			}				

			if( acoda_settings( 'footer_text_align' ) != 'left' )
			{
				$custom_css .= '
					#footer .columns {
						text-align: '.  acoda_settings( 'footer_text_align' ) .';
					}
				';
			}			
			

			if( acoda_settings( 'custom_css' ) )
			{
				$custom_css .= acoda_settings( 'custom_css' );
			}

			// Dock Panel Layout
			if( acoda_settings('dockicon_panels') == 'dockpanel_type_2' )
			{
				
				
				$custom_css .= '	
				
					.dock-panel-wrap .dock-tab-wrapper span.pointer {display:none;}
				
					@media only screen and (min-width: 64.063em) {	

						body.dock-active #container {
							transform: translateX(400px);
						}	
						
						.dock-panel-wrap.dockpanel_type_2.skinset-dockbar.acoda-skin .dock-tab-wrapper {
							max-width:400px;
						}
						
						.dock-panel-wrap.dockpanel_type_2 .dock-tab-wrapper .background-wrap {
						 vertical-align:top;
						 padding-top:30px;
						}						

					}

				';
			}			
			
			// Dock Panel Layout
			if( acoda_settings('dockicon_panels') == 'dockpanel_type_3' )
			{
				
				$custom_css .= '	

					.dock-panel-wrap.dockpanel_type_3.skinset-dockbar.acoda-skin .dock-tab-wrapper .background-wrap {
						display:table-cell;
						vertical-align:middle;
						text-align:center;
						border:none;
					}	

					@media only screen and (min-width: 64.063em) {	


						.dock-panel-wrap.dockpanel_type_3.skinset-dockbar.acoda-skin .dock-tab-wrapper {
							opacity:0;
						}
										

						body.dock-active #container {
							transform: translateX(0);
						}	

						.dock-panel-wrap.dockpanel_type_3.skinset-dockbar.acoda-skin .dock-tab-wrapper .background-wrap .infodock-innerwrap {
							max-width:none;	
							margin: 0 auto;
							overflow:visible;
							display:inline-block;
						}

						.dock-panel-wrap.dockpanel_type_3.skinset-dockbar.acoda-skin .dock-tab-wrapper.searchform .background-wrap .infodock-innerwrap,
						.dock-panel-wrap.dockpanel_type_3.skinset-dockbar.acoda-skin .dock-tab-wrapper.infodock .background-wrap .infodock-innerwrap  {
							min-width:700px;	
						}
					}
				
				';
			}	
			
			$social_icons = ( acoda_settings('socialicons') != '' ? acoda_settings('socialicons') : '');
			
			if( !empty( $social_icons ) )
			{
				foreach( $social_icons as $social_icon => $value )
				{

					if( $value['enabled'] == true && ( !empty( $value['background'] ) || !empty( $value['color'] ) ) )
					{	
						$custom_css .= '.skinset-background .main-wrap .social-'. $value['id'] .' > a { ';

						if( !empty( $value['color'] ) )
						{
							$custom_css .= 'color:'. $value['color'] .';';
						}

						if( !empty( $value['background'] ) )
						{
							$custom_css .= 'background-color:'. $value['background'] .';';
						}						

						$custom_css .= ' }
						';

						$custom_css .= '.skinset-background .main-wrap .social-'. $value['id'] .' > a:hover { ';

						if( !empty( $value['color'] ) && !empty( $value['background'] ) )
						{
							$custom_css .= 'background-color:'. $value['color'] .';';
						}

						if( !empty( $value['background'] ) && !empty( $value['color'] ) )
						{
							$custom_css .= 'color:'. $value['background'] .';';
						}						

						$custom_css .= ' }
						';					
					}
				}
			}

			// Info Dock 
			if( acoda_settings( 'dockicon_infopanel' ) == 'inline' )
			{
				$custom_css .= '
					.dock-panel-wrap.dock_layout_1 .infodock.static ul li,
					.dock-panel-wrap.dock_layout_1 .infodock.static ul ul {
					 display:inline-block;
					 margin:0 30px 0 0;
					 padding:0;
					 width:100%;
					}

					.dock-panel-wrap.dock_layout_1 .infodock.static ul {margin:0;line-height:inherit;}
					.dock_layout_1 .dock-tab-wrapper.infodock.static {padding: 0.9375rem 0;line-height:32px;}

					.dock_layout_1 .dock-tab-wrapper.infodock.static .infodock-innerwrap {
					 background:none;
					 padding:0;	
					 box-shadow:none;
					 margin-right: 0;
					}

					.dock_layout_1 .dock-tab-wrapper.infodock.static .pointer {
					 display:none;
					}

					.dock_layout_1 .dock-tab-wrapper.infodock.static .acoda-skin {
					 background:none;
					 border:none;
					 box-shadow:none;
					 padding:0 0.9375em;
					 color:inherit;
					}

					.dock-panel-wrap.dock_layout_1 .dock-tab-wrapper.infodock.static {
					 position:relative;
					 visibility:visible;
					 opacity:1;
					 margin:0 !important;
					 -webkit-transform: none !important;
					 transform: none !important;	 
					 top:0 !important;
					 left:0 !important;
					 max-width:100%;
					 width:auto;
					 float:none;
					 z-index:103;
					 min-width:0;
					 box-shadow:none;
					}

					.dock-panel-wrap.dock_layout_1 .dock-tab-wrapper.infodock.static  .acoda_Editor_Widget p {
					 margin-bottom:0;
					 text-align:center;
					}
				';		
			}
	


			// * Start * Desktop Media Query
			$custom_css .= '
			@media only screen and (min-width: 64.063em) {
			';		
			
				// Header Height
				if( acoda_settings('header_height') != '' )
				{
					$header_height = acoda_settings('header_height');

					$vh = strpos( $header_height, 'vh' );

					if( $vh === false )
					{
						$custom_css .= '#header > .inner-wrap {height:0;min-height:'. str_replace( 'px', '', $header_height ) .'px;}';
					}
					else
					{
						$custom_css .= '#header > .inner-wrap {height:0;min-height:'. $header_height .';}';
					}
				} 		
			
			
				if( !empty( $dynamix_options['menu_items_margin']['margin-left']) )
				{
					$custom_css .= '					
						#acoda-tabs ul#acoda_dropmenu > li > ul.sub-menu {
						 margin-left:'. $dynamix_options['menu_items_margin']['margin-left'] .';
						}					
					';					
				}

				// Dock Panel Layout
				if( acoda_settings('dockicon_panels') == 'dockpanel_type_3' )
				{
					$custom_css .= '					
						.dock-panel-wrap .background-wrap {
						 border-width: 0 1px 0 1px;
						}					
					';
				}
			
				if( acoda_settings('title_layout') == 'layout_3' && acoda_settings('archive_img_align') == 'center' )
				{
					$custom_css .= '					
						.blog-content-wrap .entry-title {
						 text-align:center;
						}	
					';
				}
			
				if( acoda_settings('meta_align') == 'center' )
				{
					$custom_css .= '					
						.post-metadata-wrap {
						 display:inline-block;
						}	

						#container .post-metadata {
						 text-align:center;
						}	
					';
				}
			
				if( acoda_settings('meta_align') == 'right' )
				{
					$custom_css .= '					
						.post-metadata-wrap {
						 display:inline-block;
						}	

						.post-metadata {
						 text-align:right;
						}	
					';
				}			

				// Dock Bar
				$dockbar_position = ( acoda_settings('dockbar_position' ) != '' ? acoda_settings('dockbar_position' ) : 'dock_layout_1' );

				// Dock Bar Position if Menu is Dock Icon
				if( acoda_settings('menu_position') == 'dockbar' && acoda_settings('dockbar_position' ) == 'dock_layout_4' )
				{
					$dockbar_position = 'dock_layout_1';
				} 				

				if( $dockbar_position == 'dock_layout_1' || $dockbar_position == 'dock_layout_1 dock_float' )
				{
					$custom_css .= '
					
					.dock_layout_1 .dock-panel-wrap.main_nav {
					 display:none;
					}

					.dock_layout_1 ul.dock-panel {
					 text-align:right;
					 white-space:nowrap;
					}

					.dock_layout_1.animate-3d .dock-tab-wrapper {
					 -webkit-transform:rotateX(-100deg);
					 transform:rotateX(-100deg);  	
					}	

					.dock-panel-wrap.dock_layout_1.animate-3d .dock-tab-wrapper.show {
					 -webkit-transform:rotateX(0);
					 transform:rotateX(0);  	
					}		

					.dock-panel-wrap.dockpanel_type_2.dock_layout_1 .dock-tab-wrapper {
					  position:fixed;
					  left:0;
					  margin-left:0;
					  margin-top:-2px;
					  width:100%;
					  max-width:none;
					  opacity:0;
					 }

					.dock-panel-wrap.dockpanel_type_2.dock_layout_1 .infodock-innerwrap {margin:0 auto;}
					.dock-panel-wrap.dockpanel_type_2.dock_layout_1 #panelsearchform #drops {width:100%;}

					.dock_layout_1.dockpanel_type_2 .dock-menu-tabs .infodock-innerwrap > ul > li,
					nav.dock_layout_1.dockpanel_type_2 .infodock .infodock-innerwrap > ul > li.widget {
					 float:left;
					 width:25%;
					 clear:none;
					}

					.dock_layout_1 .dock-menu-tabs .infodock-innerwrap ul ul,
					.dock_layout_1 .dock-menu-tabs .infodock-innerwrap ul li {
					 margin-left:0;
					}	

					.dock_layout_1 .dock-menu-tabs li.menu-item-has-children > a:after {display:none;}	 	

					.dock_layout_1 .dock-tab-wrapper.infodock .acoda-skin a,
					.dock_layout_1 .dock-tab-wrapper.infodock .acoda-skin a:hover {color:inherit;}

					.dock_layout_1 .infodock.skinset-header {background:none;}					
					';
				}

				if( $dockbar_position == 'dock_layout_2' || $dockbar_position == 'dock_layout_2 dock_float' )
				{	
					if( $dockbar_position == 'dock_layout_2' )
					{	
						$custom_css .= '
						body.dock_layout_2 .vc_parallax .vc_parallax-inner {left:-61px;}
						body.dock_layout_2.icon-medium .vc_parallax .vc_parallax-inner {left:-69px;}
						body.dock_layout_2.icon-large .vc_parallax .vc_parallax-inner {left:-78px;}
						body.dock_layout_2.icon-xlarge .vc_parallax .vc_parallax-inner {left:-86px;}		

						body.dock_layout_2 .page_animate_2 nav.anchorlink-nav, 
						body.dock_layout_2 .page_animate_4 nav.anchorlink-nav,	
						body.dock_layout_2 .row.stretch_content,
						body.dock_layout_2 .row-shape-wrap,
						body.dock_layout_2 #header.stuck,
						body.dock_layout_2 {padding-left:61px;}


						body.dock_layout_2.icon-medium .row.stretch_content,
						body.dock_layout_2.icon-medium .row-shape-wrap,
						body.dock_layout_2.icon-medium  #header.stuck,
						body.dock_layout_2.icon-medium {padding-left:69px;}

						body.dock_layout_2.icon-large .row.stretch_content,
						body.dock_layout_2.icon-large .row-shape-wrap,
						body.dock_layout_2.icon-large  #header.stuck,
						body.dock_layout_2.icon-large {padding-left:78px;}			

						body.dock_layout_2.icon-xlarge .row-shape-wrap,
						body.dock_layout_2.icon-xlarge .row.stretch_content,
						body.dock_layout_2.icon-xlarge  #header.stuck,
						body.dock_layout_2.icon-xlarge {padding-left:86px;}
						';
					}

					if( acoda_settings('dockicon_panels') == 'dockpanel_type_3' )
					{	
						$custom_css .= '					
						nav.dock-panel-wrap.dockpanel_type_3.skinset-dockbar.acoda-skin .dock-tab-wrapper {
							right: auto !important;
							left: 0 !important;
						}
						';			
					}

					$custom_css .= '							

					.dock-panel-wrap.dock_layout_2.skinset-dockbar {
					 position:fixed;
					 height:100%;
					 width:auto;
					 -webkit-perspective: 1400px;
					 -moz-perspective: 1400px;
					 perspective: 1400px;	 
					 border-width: 0 1px 0 0;
					}

					body.admin-bar .dock-panel-wrap.dock_layout_2 {
					 height:calc(100% - 32px);
					}

					.dock-panel-wrap.dock_layout_2 li.dock-tab {display:block;}	

					.dock_layout_2 .dock-tab-wrapper {
					 margin-top:0;
					}

					nav.dock_layout_2 .dock-panels,
					nav.dock_layout_2 .background-wrap,
					nav.dock_layout_2 .dock-panel-inner,
					nav.dock_layout_2 .dock-tab-wrapper.mobile-menu {
					 height:100%;
					}

					nav.dock_layout_2 .dock-tab-wrapper.dock-menu,
					nav.dock_layout_2 .dock-tab-wrapper.infodock {min-width:600px;}				

					.dock-panel-wrap.dock_layout_2.animate-3d .dock-tab-wrapper.show {
					 -webkit-transform:rotateY(0);
					 transform:rotateY(0);  	
					}		

					.dock-panel-wrap.dockpanel_type_1.dock_layout_2.animate-slide .dock-tab-wrapper.show,
					.dock-panel-wrap.dockpanel_type_2.dock_layout_2.animate-slide .dock-tab-wrapper.show,
					.dock-panel-wrap.dockpanel_type_3.dock_layout_2.animate-slide .dock-tab-wrapper.show	 {
					 -webkit-transform:translateX(0) rotateX(0);
					 transform:translateX(0) rotateX(0);  	
					}	

					.dock-panel-wrap.dockpanel_type_2.dock_layout_2 .dock-tab-wrapper {height:100%;}		

					.dock_layout_2.animate-3d .dock-tab-wrapper {
					 -webkit-transform-origin:left top;
					 transform-origin:left top;	
					 -webkit-transform:rotateY(100deg);
					 transform:rotateY(100deg);  	
					}	

					.dock-panel-wrap.dock_layout_2 {
					 left:0;
					}

					.dock_layout_2 .dock-panel-wrap .dock-tab-wrapper span.pointer:before,
					.dock_layout_2 .dock-panel-wrap .dock-tab-wrapper span.pointer:after {
					 margin: 0 0 0 -17px;
					 border-bottom-color: transparent;
					 border-top-color: transparent;
					 border-left-color: transparent;
					}

					.dock_layout_2 .dock-panel-wrap .dock-tab-wrapper span.pointer:after {
					 border-right-color:rgba(0,0,0,0.1);
					 margin: -1px 0 0 -20px;
					}

					.dock-panel-wrap.dockpanel_type_2.dock_layout_2.animate-slide .dock-tab-wrapper,
					.dock-panel-wrap.dockpanel_type_3.dock_layout_2.animate-slide .dock-tab-wrapper {
					 -webkit-transform:translateX(-150%) rotateX(0);
					 transform:translateX(-150%) rotateX(0); 
					 opacity:1; 	
					}	

					.dock-panel-wrap.dockpanel_type_1.dock_layout_2.animate-slide .dock-tab-wrapper {
					 -webkit-transform:translateX(100%) rotateX(0);
					 transform:translateX(100%) rotateX(0);  	
					}		

					.dock_layout_2 li.dock-tab > a { margin: 0 0 0.4687em 0; }
					';
				}

				if( $dockbar_position == 'dock_layout_3' || $dockbar_position == 'dock_layout_3 dock_float' )
				{	
					if( $dockbar_position == 'dock_layout_3' )
					{	
						$custom_css .= '
						body.dock_layout_3 .vc_parallax .vc_parallax-inner {left:-61px;}
						body.dock_layout_3.icon-medium .vc_parallax .vc_parallax-inner {left:-69px;}
						body.dock_layout_3.icon-large .vc_parallax .vc_parallax-inner {left:-78px;}
						body.dock_layout_3.icon-xlarge .vc_parallax .vc_parallax-inner {left:-86px;}	

						body.dock_layout_3 .page_animate_2 nav.anchorlink-nav, 
						body.dock_layout_3 .page_animate_4 nav.anchorlink-nav,
						body.dock_layout_3 .row.stretch_content,		
						body.dock_layout_3 .row-shape-wrap,
						body.dock_layout_3 #header.stuck,
						body.dock_layout_3 {padding-right:61px;}

						body.dock_layout_3.icon-medium .page_animate_2 nav.anchorlink-nav, 
						body.dock_layout_3.icon-medium .page_animate_4 nav.anchorlink-nav,
						body.dock_layout_3.icon-medium .row.stretch_content,
						body.dock_layout_3.icon-medium .row-shape-wrap,
						body.dock_layout_3.icon-medium  #header.stuck,
						body.dock_layout_3.icon-medium {padding-right:69px;}

						body.dock_layout_3.icon-large .row.stretch_content,
						body.dock_layout_3.icon-large .row-shape-wrap,
						body.dock_layout_3.icon-large  #header.stuck,
						body.dock_layout_3.icon-large {padding-right:78px;}

						body.dock_layout_3.icon-xlarge .row.stretch_content,
						body.dock_layout_3.icon-xlarge .row-shape-wrap,
						body.dock_layout_3.icon-xlarge  #header.stuck,
						body.dock_layout_3.icon-xlarge {padding-right:86px;}						
						';
					}

					$custom_css .= '						

					.dock-panel-wrap.dock_layout_3.skinset-dockbar {
					 position:fixed;
					 height:100%;
					 width:auto;
					 -webkit-perspective: 1400px;
					 -moz-perspective: 1400px;
					 perspective: 1400px;	 
					 border-width: 0 0 0 1px;
					}			

					body.admin-bar .dock-panel-wrap.dock_layout_3 {
					 height:calc(100% - 32px);
					}					

					.dock-panel-wrap.dock_layout_3 li.dock-tab {display:block;}

					.dock_layout_3 div.autototop a { right:90px; }	

					.dock_layout_3 .dock-tab-wrapper {
					 margin-top:0;
					 text-align:right;
					}

					nav.dock_layout_3 .dock-panels,
					nav.dock_layout_3 .background-wrap,	
					nav.dock_layout_3 .dock-panel-inner,
					nav.dock_layout_3 .dock-tab-wrapper.mobile-menu {
					 height:100%;
					}

					nav.dock_layout_3 .dock-tab-wrapper.dock-menu,
					nav.dock_layout_3 .dock-tab-wrapper.infodock {min-width:600px;}						

					.dock-panel-wrap.dock_layout_3.animate-3d .dock-tab-wrapper.show {
					 -webkit-transform:rotateY(0);
					 transform:rotateY(0);  	
					}		

					.dock-panel-wrap.dockpanel_type_1.dock_layout_3.animate-slide .dock-tab-wrapper.show,
					.dock-panel-wrap.dockpanel_type_2.dock_layout_3.animate-slide .dock-tab-wrapper.show,
					.dock-panel-wrap.dockpanel_type_3.dock_layout_3.animate-slide .dock-tab-wrapper.show	 {
					 -webkit-transform:translateX(0) rotateX(0);
					 transform:translateX(0) rotateX(0);  	
					}	

					.dock-panel-wrap.dockpanel_type_2.dock_layout_3 .dock-tab-wrapper {height:100%;}		

					.dock-panel-wrap.dockpanel_type_1.dock_layout_3.animate-slide .dock-tab-wrapper {
					 -webkit-transform:translateX(-100%) rotateX(0);
					 transform:translateX(-100%) rotateX(0);  	
					}	

					.dock-panel-wrap.dock_layout_3 {
					 right:0;
					}

					.dock_layout_3 .dock-panel-wrap .dock-tab-wrapper span.pointer:before,
					.dock_layout_3 .dock-panel-wrap .dock-tab-wrapper span.pointer:after {
					 margin: 0 -18px 0 -1px;
					 border-bottom-color: transparent;
					 border-top-color: transparent;
					 border-right-color: transparent;
					}

					.dock_layout_3 .dock-panel-wrap .dock-tab-wrapper span.pointer:after {
					 border-left-color:rgba(0,0,0,0.1);
					 margin: -1px 0 0 0;
					}	

					.dock-panel-wrap.dockpanel_type_2.dock_layout_3.animate-slide .dock-tab-wrapper,
					.dock-panel-wrap.dockpanel_type_3.dock_layout_3.animate-slide .dock-tab-wrapper {
					 -webkit-transform:translateX(150%) rotateX(0);
					 transform:translateX(150%) rotateX(0);  	
					 opacity:1;
					}

					.dock_layout_3.animate-3d .dock-tab-wrapper {
					 -webkit-transform-origin:right top;
					 transform-origin:right top;	
					 -webkit-transform:rotateY(-100deg);
					 transform:rotateY(-100deg);  	
					}	

					.dock-panel-wrap.dockpanel_type_2.dock_layout_3 .dock-tab-wrapper {right:0;}
					.dock_layout_3 li.dock-tab > a { margin: 0 0 0.4687em 0; }
					';
				}		

				// Info Dock 
				if( acoda_settings( 'dockicon_infopanel' ) == 'inline' )
				{
					$custom_css .= '

					.dock-panel-wrap.dock_layout_1 .infodock.static ul li,
					.dock-panel-wrap.dock_layout_1 .infodock.static ul ul {
					 width:auto !important;
					}

					.dock-panel-wrap.dock_layout_1 .infodock.static ul li:last-child {
					 margin-right:0;	
					}

					.dock-panel-wrap.dock_layout_1 .dock-tab-wrapper.infodock.static {
					 float:right;
					}';		
				}
			
				$header_layout	= acoda_settings('header_layout');
			
				if( $header_layout == 'left' )
				{
					$header_width_value = ( !empty( $dynamix_options['header_width_value'] ) ? $dynamix_options['header_width_value'] : '280px' );
					
					$custom_css .= '	
					.header_left .site-inwrap {margin-left:'. $header_width_value .';}
					.header_left #header-wrap {width:'. $header_width_value .';position:absolute;height:100%;}
					.header_left #header-wrap .header-wrap-inner,
					.header_left #header-wrap #header {height:100%;}
					';
				}
			
				// Dock Bar Width
				$dockbar_width	= acoda_settings('dockbar_width');
			
				if( $dockbar_width == 'fullwidth' )
				{	
					$custom_css .= '	
					.dock-panel-wrap.dock_layout_1 .dock-panel-inner {max-width:100%;}
					';
				}			
		

				// Menu Layout				
				$header_style = ( !empty( $dynamix_options['header_style'] ) ? $dynamix_options['header_style'] : 'inline' );
			
				if( $header_style == 'inline' )
				{
					$branding_alignment			= ( !empty( $dynamix_options['branding_alignment_inline'] ) ? $dynamix_options['branding_alignment_inline'] : 'left' );
					$menu_alignment				= ( !empty( $dynamix_options['menu_alignment_inline'] ) 	? $dynamix_options['menu_alignment_inline'] 	: 'right' );	
					$header_vertical_alignment	= ( !empty( $dynamix_options['header_vertical_alignment'] ) ? $dynamix_options['header_vertical_alignment'] : 'middle' );	

					if(  $menu_alignment == 'right' && $branding_alignment == 'right' )
					{
						$custom_css .= '							
							.header_top #header .inner-wrap {
							 display:table;
							 width:100%;
							 text-align:right;
							}
						';						
					}
					else
					{
						$custom_css .= '							
							.layout_top #header .inner-wrap {
							 display:table;
							 width:100%;
							}
						';						
					}
					
					if( $menu_alignment == 'left' && $branding_alignment == 'left' || $menu_alignment == 'right' && $branding_alignment == 'right' )
					{
						$custom_css .= '
							.header_top #header .cell-wrap {
							 display:inline-block;
							 vertical-align:'. $header_vertical_alignment .';
							}	
						';						
					}
					else
					{
						$custom_css .= '
							.header_top #header .cell-wrap {
							 display:table-cell;
							 vertical-align:'. $header_vertical_alignment .';
							}	
						';
					}
					
					if( $menu_alignment == 'left' )
					{
						$custom_css .= '							
						.header_top #header-wrap #acoda-tabs {
						 float:left;
						}';
					}		

					if( $menu_alignment == 'center' )
					{
						$custom_css .= '		
						#header-wrap #acoda-tabs {
						 float:none;
						 clear:both;
						 display:table;
						 margin-left:auto;
						 margin-right:auto;
						}';
					}		

					if( $branding_alignment == 'right' )
					{
						$custom_css .= '							
						.header_top #header-wrap #header-logo {
						 float:right;
						 text-align:right;
						}';
					}						
				}
				else if( $header_style == 'inline_middle_logo' )
				{	
					$header_vertical_alignment	= ( !empty( $dynamix_options['header_vertical_alignment'] ) ? $dynamix_options['header_vertical_alignment'] : 'middle' );	

				
					$custom_css .= '							
						.header_top #header .inner-wrap {
						 display:table;
						 width:100%;
						 text-align:left;
						}
					';
					
					if(  $dynamix_options['branding_display'] == false )
					{
						$custom_css .= '
							.header_top #header .cell-wrap {
							 display:table-cell;
							 vertical-align:'. $header_vertical_alignment .';
							 width:50%;
							}	
						';						
					}
					else
					{
						$custom_css .= '
							.header_top #header .cell-wrap {
							 display:table-cell;
							 vertical-align:'. $header_vertical_alignment .';
							 width:33.3%;
							}	
						';						
					}
			

		
					$custom_css .= '							
					.header_top #header-wrap #acoda-tabs {
					 float:left;
					}';
					
					$custom_css .= '							
					.header_top #header-wrap #header-logo {
					 float:none;
					 text-align:center;
					}';					
							
					$custom_css .= '							
					.dock-panel-wrap.dock_layout_4 {
					 float:right;
					 text-align:right;
					}';
						
				}			
				else if( $header_style == 'stacked' )
				{
					$branding_alignment	= ( !empty( $dynamix_options['branding_alignment_stacked'] ) ? $dynamix_options['branding_alignment_stacked'] : 'left' );
					$menu_alignment		= ( !empty( $dynamix_options['menu_alignment_stacked'] )	 ? $dynamix_options['menu_alignment_stacked']	  : 'right' );		

					$custom_css .= '	
					 .header_top #acoda-tabs .menu-inner {
					 display:table;
					 width:100%;
					}
					';
					
					if( $menu_alignment == 'left' )
					{
						$custom_css .= '							
						.header_top #header-wrap #acoda-tabs {
						 float:none;
						}

						.header_top #header-wrap #acoda-tabs #acoda_dropmenu {
						 float:left;
						}
						 ';
					}	
					else if( $menu_alignment == 'right' )
					{
						$custom_css .= '							
						.header_top #header-wrap #acoda-tabs {
						 float:none;
						}

						.header_top #header-wrap #acoda-tabs #acoda_dropmenu {
						 float:right;
						}			
						';
					}		
					else if( $menu_alignment == 'center' )
					{
						$custom_css .= '		
						.header_top #header-wrap #acoda-tabs {
						 float:none;
						}
						
						#header-wrap #acoda-tabs .menu-wrap {
						 float:none;
						 clear:both;
						 display:table;
						 margin-left:auto;
						 margin-right:auto;
						}';
					}	

					if( $branding_alignment == 'right' )
					{
						$custom_css .= '							
						.header_top #header-wrap #header-logo {
						 float:right;
						 text-align:right;
						}';
					}
					else if( $branding_alignment == 'center' )
					{
						$custom_css .= '							
						.header_top #header-wrap #header-logo {
						 float:none;
						 text-align:center;
						}';						
					}
					
				}
				else if( $header_style == 'middle' )
				{
					$custom_css .= '							
						.header_top #header-wrap .inner-wrap {
						 display:table;
						 width:100%;
						}

						.header_top #header-wrap .cell-wrap {
						 display:table-cell;
						 vertical-align:middle;
						}
					';					
					
					$custom_css .= '		
					.header_top #header-wrap #acoda-tabs {
					 float:none;
					}
					
					.header_top #header-wrap.middle #acoda-tabs ul#acoda_dropmenu > li {
						float: none;
						display: table-cell;
						vertical-align: middle;
					}			
						
					#header-wrap #acoda-tabs .menu-wrap {
					 float:none;
					 clear:both;
					 display:table;
					 margin-left:auto;
					 margin-right:auto;
					}';					
				}			

				$sticky_menu = ( !empty( $dynamix_options['sticky_menu'] ) ? $dynamix_options['sticky_menu'] : true );
			

				if( $sticky_menu != false )
				{
					$custom_css .= '		
					#header.stuck {
					 left:0; 
					 top:0;
					 z-index:1000;
					 position:fixed;
					 height:auto;
					 box-shadow: 0 0 20px rgba(0,0,0,0.05);
					 transform: translateY(-100%);
					}
					
					#header-wrap #header.stuck .inner-wrap {
					 padding-top:0;
					 padding-bottom:0;
					}
					
					#header.stuck.animate {
					 transition: transform 300ms ease-out 200ms;
					 transform: translateY(0);
					}					
					
					#header.stuck > .inner-wrap {
					 min-height:0 !important;
					}

					.sticky_menu #header.stuck #header-logo {
					 display:none;
					}

					#header.stuck #acoda-tabs > ul {font-size:1rem;}			

					.layout-boxed #header.stuck {max-width:100%;}

					body.admin-bar #header.stuck {margin-top:32px !important;}

					#header-wrap.layout_3 #header.stuck #acoda-tabs,
					#header-wrap.layout_3 #header.stuck #header-logo {
					 margin-left:0;
					 margin-right:0;	
					 display:inherit;
					 clear:none;
					}

					#header.stuck #header-logo #logo .description {display:none;}
					';
				}

			
				if( acoda_settings( 'sticky_sidebar' ) != false )
				{
					$custom_css .= '		
					.acoda-sidebar .sidebar.stuck  {
					 position:fixed !important;
					 height:100% !important;
					 overflow:auto;
					 width: inherit;
					 top:0;
					 padding-bottom:30px !important;
					 margin-bottom:0;
					}
					
					body.admin-bar .acoda-sidebar .sidebar.stuck {margin-top:32px !important;}
					';
				}			
			
				$sticky_logo_height = ( !empty( $dynamix_options['sticky_logo_height'] ) ? $dynamix_options['sticky_logo_height'] : '' );
			
				if( !empty( $sticky_logo_height ) )
				{
					$custom_css .= '
					#header.stuck #header-logo img {
					 width: auto;
					 height:'. $sticky_logo_height .';
					}

					#header.stuck #header-logo img {
					 vertical-align:middle;
					}		
					';
				}
				
				$sticky_menu_font_size = ( !empty( $dynamix_options['sticky_menu_font_size'] ) ? $dynamix_options['sticky_menu_font_size'] : '' );
			
				if( !empty( $sticky_menu_font_size ) )
				{
					$custom_css .= '
					#header.stuck #header-logo .logo,
					#header.stuck #header-logo .logo a,
					#header.stuck #acoda-tabs #acoda_dropmenu a {
					 font-size:'. $sticky_menu_font_size .';
					}		
					';
				}		
								

				// Maximum Site Width
				if( !empty( $dynamix_options['max_site_width'] ) )
				{
					$max_width = ( preg_match("/^-?[1-9][0-9]*$/D", $dynamix_options['max_site_width'] ) ? $dynamix_options['max_site_width'] . 'px' :  $dynamix_options['max_site_width'] );

					$custom_css .= '
					div#header.wide .inner-wrap,
					div#header.wide .menu-wrap,
					div#container.layout-boxed,
					.intro-wrap.wide .intro-text,
					.compose-mode div.acoda-page-animate .row.vc_row-parent > .vc_container-block,
					.acoda-page-animate .row.vc_row-parent > .row-content-wrap > div.row-inner-wrap,
					#container.layout-boxed div.dynamic-frame.row,
					#container .intro-wrap-inner,
					.lowerfooter,
					div.row {
						max-width:'. $max_width .';
					}';
				}
			
				if( !empty( $dynamix_options['max_page_width'] ) && acoda_settings( 'pagelayout' ) == 'layout_one' )
				{
					$max_width = ( preg_match("/^-?[1-9][0-9]*$/D", $dynamix_options['max_page_width'] ) ? $dynamix_options['max_page_width'] . 'px' :  $dynamix_options['max_page_width'] );

					$custom_css .= '
					body.page #content {
						max-width:'. $max_width .';
						margin: 0 auto;
					}';
				}	
			
				if( !empty( $dynamix_options['max_blog_width'] ) && acoda_settings( 'bloglayout' ) == 'layout_one' )
				{
					$max_width = ( preg_match("/^-?[1-9][0-9]*$/D", $dynamix_options['max_blog_width'] ) ? $dynamix_options['max_blog_width'] . 'px' :  $dynamix_options['max_blog_width'] );

					$custom_css .= '
					body.archive #content,
					body.page-template-blog #content,
					body.blog #content {
						max-width:'. $max_width .';
						margin: 0 auto;
					}';
				}
			
				if( !empty( $dynamix_options['max_post_width'] ) && acoda_settings( 'postlayout' ) == 'layout_one' )
				{
					$max_width = ( preg_match("/^-?[1-9][0-9]*$/D", $dynamix_options['max_post_width'] ) ? $dynamix_options['max_post_width'] . 'px' :  $dynamix_options['max_post_width'] );

					$custom_css .= '
					body.single-post #content {
						max-width:'. $max_width .';
						margin: 0 auto;
					}';
				}			
			
			

				if( !empty( $dynamix_options['site_margin'] ) )
				{
					$custom_css .= '
					#container.layout-boxed,
					#container.layout-wide {
						margin-top:'. $dynamix_options['site_margin']['margin-top'] .';
						margin-right:'. $dynamix_options['site_margin']['margin-right'] .';
						margin-bottom:'. $dynamix_options['site_margin']['margin-bottom'] .';
						margin-left:'. $dynamix_options['site_margin']['margin-left'] .';
					}';
				}	

				if( !empty( $dynamix_options['content_padding'] ) )
				{
					$custom_css .= '
					#container #content {
						padding-right:'. $dynamix_options['content_padding']['padding-right'] .';
						padding-left:'. $dynamix_options['content_padding']['padding-left'] .';
					}';
					
					$custom_css .= '
					.blog_header_wrap {
						padding-top:'. $dynamix_options['content_padding']['padding-top'] .';
						padding-right:'. $dynamix_options['content_padding']['padding-right'] .';
						padding-left:'. $dynamix_options['content_padding']['padding-left'] .';						
					}';					
				}	
			
			

				if( !empty( $dynamix_options['sidebar_padding'] ) )
				{
					$custom_css .= '
					.acoda-sidebar .sidebar {
						padding-top:'. $dynamix_options['sidebar_padding']['padding-top'] .';
						padding-right:'. $dynamix_options['sidebar_padding']['padding-right'] .';
						padding-bottom:'. $dynamix_options['sidebar_padding']['padding-bottom'] .';
						padding-left:'. $dynamix_options['sidebar_padding']['padding-left'] .';
					}';
				}
			
				if ( class_exists( 'woocommerce' ) )
				{			
					if( !empty( $dynamix_options['woocom_content_padding'] ) )
					{
						$custom_css .= '
						.woocommerce-page.single #container #content {
							padding-top:'. $dynamix_options['woocom_content_padding']['padding-top'] .';
							padding-right:'. $dynamix_options['woocom_content_padding']['padding-right'] .';
							padding-bottom:'. $dynamix_options['woocom_content_padding']['padding-bottom'] .';
							padding-left:'. $dynamix_options['woocom_content_padding']['padding-left'] .';
						}';
					}	



					if( !empty( $dynamix_options['woocom_sidebar_padding'] ) )
					{
						$custom_css .= '
						.woocommerce-page.single .acoda-sidebar .sidebar {
							padding-top:'. $dynamix_options['woocom_sidebar_padding']['padding-top'] .';
							padding-right:'. $dynamix_options['woocom_sidebar_padding']['padding-right'] .';
							padding-bottom:'. $dynamix_options['woocom_sidebar_padding']['padding-bottom'] .';
							padding-left:'. $dynamix_options['woocom_sidebar_padding']['padding-left'] .';
						}';
					}	
				}
			
			
				if( !empty( $dynamix_options['logo_margin'] ) )
				{
					$custom_css .= '
					#container #header-logo {
						margin-top:'. $dynamix_options['logo_margin']['margin-top'] .';
						margin-right:'. $dynamix_options['logo_margin']['margin-right'] .';
						margin-bottom:'. $dynamix_options['logo_margin']['margin-bottom'] .';
						margin-left:'. $dynamix_options['logo_margin']['margin-left'] .';
					}';
				}				

				if( !empty( $dynamix_options['header_padding'] ) )
				{
					$custom_css .= '
					#header-wrap #header .inner-wrap, 
					#header .menu-wrap.wide {
						padding-top:'. $dynamix_options['header_padding']['padding-top'] .';
						padding-right:'. $dynamix_options['header_padding']['padding-right'] .';
						padding-bottom:'. $dynamix_options['header_padding']['padding-bottom'] .';
						padding-left:'. $dynamix_options['header_padding']['padding-left'] .';
					}';
				}
			
				if( !empty( $dynamix_options['dockbar_padding'] ) )
				{
					$custom_css .= '
					#container .dock-panel-wrap.skinset-dockbar {
						padding-top:'. $dynamix_options['dockbar_padding']['padding-top'] .';
						padding-right:'. $dynamix_options['dockbar_padding']['padding-right'] .';
						padding-bottom:'. $dynamix_options['dockbar_padding']['padding-bottom'] .';
						padding-left:'. $dynamix_options['dockbar_padding']['padding-left'] .';
					}';
				}			

				if( !empty( $dynamix_options['footer_padding'] ) )
				{
					$custom_css .= '
					#container #footer-wrap #footer {
						padding-top:'. $dynamix_options['footer_padding']['padding-top'] .';
						padding-right:'. $dynamix_options['footer_padding']['padding-right'] .';
						padding-bottom:'. $dynamix_options['footer_padding']['padding-bottom'] .';
						padding-left:'. $dynamix_options['footer_padding']['padding-left'] .';
					}';
				}	
			
				if( !empty( $dynamix_options['footer_column_padding'] ) )
				{
					$custom_css .= '
					#container #footer-wrap #footer .block.columns {
						padding-top:'. $dynamix_options['footer_column_padding']['padding-top'] .';
						padding-right:'. $dynamix_options['footer_column_padding']['padding-right'] .';
						padding-bottom:'. $dynamix_options['footer_column_padding']['padding-bottom'] .';
						padding-left:'. $dynamix_options['footer_column_padding']['padding-left'] .';
					}
					
					#container #footer-wrap #footer > .content {
						margin: 0 -'.$dynamix_options['footer_column_padding']['padding-right'].';
					}
					
					
					#container #footer-wrap .lowerfooter {
						padding-left: '.$dynamix_options['footer_padding']['padding-left'].';
						padding-right: '.$dynamix_options['footer_padding']['padding-right'].';
					}';
				}				
			
			

				/*if( !empty( $dynamix_options['subheader_padding'] ) )
				{
					$custom_css .= '
					.intro-wrap .intro-text {
						padding-top:'. $dynamix_options['subheader_padding']['padding-top'] .';
						padding-right:'. $dynamix_options['subheader_padding']['padding-right'] .';
						padding-bottom:'. $dynamix_options['subheader_padding']['padding-bottom'] .';
						padding-left:'. $dynamix_options['subheader_padding']['padding-left'] .';
					}';
				}	*/					
				
				if( !empty( $dynamix_options['menu_margin'] ) )
				{
					$custom_css .= '
					.inline #acoda-tabs,
					.stacked #acoda-tabs #acoda_dropmenu {
						margin-top:'. $dynamix_options['menu_margin']['margin-top'] .';
						margin-right:'. $dynamix_options['menu_margin']['margin-right'] .';
						margin-bottom:'. $dynamix_options['menu_margin']['margin-bottom'] .';
						margin-left:'. $dynamix_options['menu_margin']['margin-left'] .';
					}';
				}				
			

				/*if( !empty( $dynamix_options['content_width'] ) )
				{
					$content_max_width = ( preg_match("/^-?[1-9][0-9]*$/D", $dynamix_options['content_width'] ) ? $dynamix_options['content_width'] . 'px' :  $dynamix_options['content_width'] );

					$custom_css .= '
					#content > .post,
					#content > .comments-wrapper {
						max-width:'. $content_max_width .';
						margin:0 auto;
					}';
				}*/
			
			
				
				if ( acoda_settings('posttitle_align') == true && acoda_settings('posttitle_position') == 'content' && is_single() )
				{
					$custom_css .= '
						.single-post .post-metadata,
						.single-post .entry-title {
							text-align:center;
						}';						
				}
				
				$header_left_align = ( acoda_settings('header_left_align') != '' ? acoda_settings('header_left_align') : 'left' );
			
				if( acoda_settings('header_layout') == 'left' )
				{
					$custom_css .= '
						#container #header-logo,
						#container ul.dock-panel,
						#container #acoda-tabs,
						#container li.dock-tab {
							text-align:'. $header_left_align .';
						}
						
						#container .layout_left .dock-panel li.dock-tab.dock-text {width:100%;}';			
				}

				if( $dynamix_options['sidebar_width'] != '' )
				{			
					$sidebar_width = ( preg_match("/^-?[1-9][0-9]*$/D", $dynamix_options['sidebar_width'] ) ? $dynamix_options['sidebar_width'] . 'px' :  $dynamix_options['sidebar_width'] );		

					$custom_css .= '
					#container #content.layout_two,
					#container #content.layout_three,
					#container #content.layout_four,
					#container #content.layout_five,
					#container #content.layout_six {
						width: calc( 100% - '. $sidebar_width .' );
					}

					#container .acoda-sidebar.layout_two,
					#container .acoda-sidebar.layout_three,
					#container .acoda-sidebar.layout_four,
					#container .acoda-sidebar.layout_five,
					#container .acoda-sidebar.layout_six {
						width: '. $sidebar_width .';
					}';					
				}			

				if( $dynamix_options['dual_sidebar_width'] != '' )
				{			
					$sidebar_width = ( preg_match("/^-?[1-9][0-9]*$/D", $dynamix_options['dual_sidebar_width'] ) ? $dynamix_options['dual_sidebar_width'] . 'px' :  $dynamix_options['dual_sidebar_width'] );		

					$custom_css .= '
					#container #content.layout_three,
					#container #content.layout_five,
					#container #content.layout_six {
						width: calc( 100% - '. $sidebar_width .' - '. $sidebar_width .' );

					}

					#container #content.layout_six {				
						margin-left: '. $sidebar_width .';
					}

					#container .acoda-sidebar.layout_three,
					#container .acoda-sidebar.layout_five,
					#container .acoda-sidebar.layout_six {
						width: '. $sidebar_width .';
					}	

					#container .acoda-sidebar.layout_six.side_one {
						margin-left: calc( '. $sidebar_width .' - 100% );
					}';	

				}			






			// * End * Desktop Media Query
			$custom_css .= '
			}';

			if( acoda_settings('preloader') == true  )
			{
				$custom_css .= '		
				.preloader-wrapper {
					display: inline-block;
					position: fixed;
					width: 50px;
					height: 50px;
					top:50%;
					left:50%;
					margin:-25px 0 0 -25px;
				}

				.preloader-wrapper.active {
					-webkit-animation: container-rotate 1568ms linear infinite;
					animation: container-rotate 1568ms linear infinite
				}

				@-webkit-keyframes container-rotate {
					to {
						-webkit-transform: rotate(360deg)
					}
				}

				@keyframes container-rotate {
					to {
						-webkit-transform: rotate(360deg);
						transform: rotate(360deg)
					}
				}

				.spinner-layer {
					position: absolute;
					width: 100%;
					height: 100%;
					opacity: 0;
				}

				.active .spinner-layer {
					opacity: 1;
					-webkit-animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
					animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both
				}

				@-webkit-keyframes fill-unfill-rotate {
					12.5% {
						-webkit-transform: rotate(135deg)
					}
					25% {
						-webkit-transform: rotate(270deg)
					}
					37.5% {
						-webkit-transform: rotate(405deg)
					}
					50% {
						-webkit-transform: rotate(540deg)
					}
					62.5% {
						-webkit-transform: rotate(675deg)
					}
					75% {
						-webkit-transform: rotate(810deg)
					}
					87.5% {
						-webkit-transform: rotate(945deg)
					}
					to {
						-webkit-transform: rotate(1080deg)
					}
				}

				@keyframes fill-unfill-rotate {
					12.5% {
						-webkit-transform: rotate(135deg);
						transform: rotate(135deg)
					}
					25% {
						-webkit-transform: rotate(270deg);
						transform: rotate(270deg)
					}
					37.5% {
						-webkit-transform: rotate(405deg);
						transform: rotate(405deg)
					}
					50% {
						-webkit-transform: rotate(540deg);
						transform: rotate(540deg)
					}
					62.5% {
						-webkit-transform: rotate(675deg);
						transform: rotate(675deg)
					}
					75% {
						-webkit-transform: rotate(810deg);
						transform: rotate(810deg)
					}
					87.5% {
						-webkit-transform: rotate(945deg);
						transform: rotate(945deg)
					}
					to {
						-webkit-transform: rotate(1080deg);
						transform: rotate(1080deg)
					}
				}

				.gap-patch {
					position: absolute;
					top: 0;
					left: 45%;
					width: 10%;
					height: 100%;
					overflow: hidden;
					border-color: inherit
				}

				.gap-patch .circle {
					width: 1000%;
					left: -450%
				}

				.circle-clipper {
					display: inline-block;
					position: relative;
					width: 50%;
					height: 100%;
					overflow: hidden;
					border-color: inherit;
				}

				.circle-clipper .circle {
					width: 200%;
					height: 100%;
					border-width: 5px;
					border-style: solid;
					border-color: inherit;
					border-bottom-color: transparent !important;
					border-radius: 50%;
					-webkit-animation: none;
					animation: none;
					position: absolute;
					top: 0;
					right: 0;
					bottom: 0;
				}

				.circle-clipper.left .circle {
					left: 0;
					border-right-color: transparent !important;
					-webkit-transform: rotate(129deg);
					transform: rotate(129deg)
				}

				.circle-clipper.right .circle {
					left: -100%;
					border-left-color: transparent !important;
					-webkit-transform: rotate(-129deg);
					transform: rotate(-129deg)
				}

				.active .circle-clipper.left .circle {
					-webkit-animation: left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
					animation: left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both
				}

				.active .circle-clipper.right .circle {
					-webkit-animation: right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
					animation: right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both
				}

				@-webkit-keyframes left-spin {
					from {
						-webkit-transform: rotate(130deg)
					}
					50% {
						-webkit-transform: rotate(-5deg)
					}
					to {
						-webkit-transform: rotate(130deg)
					}
				}

				@keyframes left-spin {
					from {
						-webkit-transform: rotate(130deg);
						transform: rotate(130deg)
					}
					50% {
						-webkit-transform: rotate(-5deg);
						transform: rotate(-5deg)
					}
					to {
						-webkit-transform: rotate(130deg);
						transform: rotate(130deg)
					}
				}

				@-webkit-keyframes right-spin {
					from {
						-webkit-transform: rotate(-130deg)
					}
					50% {
						-webkit-transform: rotate(5deg)
					}
					to {
						-webkit-transform: rotate(-130deg)
					}
				}

				@keyframes right-spin {
					from {
						-webkit-transform: rotate(-130deg);
						transform: rotate(-130deg)
					}
					50% {
						-webkit-transform: rotate(5deg);
						transform: rotate(5deg)
					}
					to {
						-webkit-transform: rotate(-130deg);
						transform: rotate(-130deg)
					}
				}

				body.loaded .preloader-wrapper {
					-webkit-animation: container-rotate 1568ms linear infinite, fade-out 200ms cubic-bezier(0.4, 0, 0.2, 1) normal forwards;
					animation: container-rotate 1568ms linear infinite, fade-out 200ms cubic-bezier(0.4, 0, 0.2, 1) normal forwards;
				}

				@-webkit-keyframes fade-out {
					from {
						opacity: 1
					}
					to {
						opacity: 0
					}
				}

				@keyframes fade-out {
					from {
						opacity: 1
					}
					to {
						opacity: 0
					}
				}';			
			}

			if( acoda_settings( 'mobile_css' ) )
			{
				$custom_css .= '@media only screen and (max-width: 1024px) {'. acoda_settings( 'mobile_css' ) . '}';
			}		
			// Minify CSS
			$custom_css = str_replace( array("\r", "\n", "\t" ), '', $custom_css );



			wp_enqueue_style( 'acoda-dynamic',	get_template_directory_uri() . '/dynamic-style.css', false, null );
			wp_add_inline_style( 'acoda-dynamic', $custom_css );	
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'acoda_dynamic_css' );


	if ( ! function_exists( 'acoda_class_names' ) ) 
	{
		function acoda_class_names( $classes ) 
		{
			// add 'class-name' to the $classes array
			$classes[] = 'skinset-background acoda-skin';

			// Dock Bar Position
			$dockbar_position 	= ( acoda_settings('dockbar_position' ) != '' ? acoda_settings('dockbar_position' ) : 'dock_layout_4' );
			$dockicon_panels 	= ( acoda_settings('dockicon_panels' )  != '' ? acoda_settings('dockicon_panels' )  : 'dockpanel_type_1' );
			
			$classes[] = $dockbar_position;	
			$classes[] = $dockicon_panels;	
			
			if( acoda_settings('preloader' ) == false )
			{
				$classes[] = 'loaded';
			}

			// return the $classes array
			return $classes;
		}
	}
		
	add_filter( 'body_class', 'acoda_class_names' );

	if ( ! function_exists( 'acoda_menu') )
	{
		function acoda_menu()
		{
			global $dynamix_options;

	
			$dockicon_panels 	= acoda_settings('dockicon_panels');
			$menu_slug 			= acoda_settings('menu');							
			$selected_menu 		= ( empty( $menu_slug ) && !has_nav_menu( 'mainnav' ) ? 'none' : '' );
			$acoda_skin 		= acoda_settings('skin');	
			$header_width		= ( !empty( $dynamix_options['header_width'] ) ? $dynamix_options['header_width'] : 'wide' );		
			$header_style		= ( !empty( $dynamix_options['header_style'] ) ? $dynamix_options['header_style']  : 'style_1' );
			$dockbar_position 	= ( acoda_settings('dockbar_position' ) != '' ? acoda_settings('dockbar_position' ) : 'dock_layout_4' );	
			$header_layout		= ( !empty( $dynamix_options['header_layout'] ) ? $dynamix_options['header_layout']  : 'top' );
			$displaymenu		= acoda_settings('displaymenu');
			$header_style_left	= acoda_settings('header_style_left');
			
			if( $displaymenu == false )
			{
				$menu_slug = 'disable';
			}
			
			if( acoda_settings( 'menu_position' ) != 'dockbar' )
			{   
				echo "\n". '<div class="cell-wrap">';
				
				if( $dockbar_position == 'dock_layout_4' && $header_style != 'inline_middle_logo' && $header_layout == 'left' && $header_style_left != 'logo_menu_dock' )
				{
					require_once get_template_directory() .'/dock.config.php';
				}					
				
				echo "\n\t". '<nav id="acoda-tabs" class="skinset-menu acoda-skin" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">';
					echo "\n". '<div class="menu-wrap '. ( $header_style == 'stacked' && $header_width == 'wide' ? 'wide' : '' ) .' clearfix">'; 	

					if( $header_style == 'stacked' )
					{
						echo "\n". '<div class="menu-inner">';
					}

					if(  $menu_slug != 'disable' && $selected_menu !='none' ) :

					$walker = new acoda_walker;

					wp_nav_menu( array(
						'echo' => true,
						'container' => 'ul',
						'menu_class' => 'menu clearfix',
						'menu_id' => 'acoda_dropmenu',
						'theme_location' => 'mainnav',
						'walker' => $walker,
						'menu' => $menu_slug
					));

					endif;						

				if( $dockbar_position == 'dock_layout_4' && $header_style != 'inline_middle_logo' && $header_layout != 'left' )
				{
					require_once get_template_directory() .'/dock.config.php';
				}			

				if( $header_style == 'stacked' )
				{								
					echo "\n\t". '</div>';
				}

				echo "\n\t". '</div>';
				echo "\n\t". '</nav><!-- /acoda-tabs -->';
				
				if( $header_layout == 'left' && $header_style_left == 'logo_menu_dock' )
				{
					require_once get_template_directory() .'/dock.config.php';
				}
				
				
				echo "\n\t". '</div>';
			}
			elseif( acoda_settings( 'menu_position' ) == 'dockbar' && $dockbar_position == 'dock_layout_4' )
			{
				echo "\n". '<div class="cell-wrap">';
				echo "\n\t". '<nav id="acoda-tabs" class="skinset-menu acoda-skin" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">';
				echo "\n". '<div class="menu-wrap '. ( $header_style == 'stacked' && $header_width == 'wide' ? 'wide' : '' ) .' clearfix">'; 

				if( $header_style == 'stacked' )
				{
					echo "\n". '<div class="menu-inner">';
				}

				if( $dockbar_position == 'dock_layout_4' && $header_style != 'inline_middle_logo' )
				{
					require_once get_template_directory() .'/dock.config.php';
				}								

				if( $header_style == 'stacked' )
				{								
					echo "\n\t". '</div>';
				}

				echo "\n\t". '</div>';
				echo "\n\t". '</nav><!-- /acoda-tabs -->';
				echo "\n\t". '</div>';
			}
		}
	}


	if ( ! function_exists( 'acoda_logo') )
	{
		function acoda_logo()
		{		
			global $dynamix_options;
			

			$acoda_skin 				= acoda_settings('skin');	
			$header_float 				= acoda_settings('header_float');
					
			$acoda_logo 				= ( !empty( $dynamix_options['branding_url']['url'] )	? $dynamix_options['branding_url']['url'] : '' );
			$acoda_logo_2x				= ( !empty( $dynamix_options['branding_2x']['url'] )	? $dynamix_options['branding_2x']['url']  : '' );
			
			//$acoda_skin_logo 			= ( !empty( $dynamix_options['branding_url']['url'] )	? $dynamix_options['branding_url']['url'] : '' );
			//$acoda_skin_logo_2x		= ( !empty( $dynamix_options['branding_2x']['url'] )	? $dynamix_options['branding_2x']['url']  : '' );			
			
			
			$mobile_logo 				= ( !empty( $dynamix_options['mobile_logo']['url'] )	? $dynamix_options['mobile_logo']['url'] : '' );
			$mobile_logo_2x 			= ( !empty( $dynamix_options['mobile_logo_2x']['url'] )	? $dynamix_options['mobile_logo_2x']['url'] : '' );			
			
			// Transparent Logo
			$acoda_logo_transparent		= ( !empty( $dynamix_options['branding_url_transparent']['url']  ) )		? $dynamix_options['branding_url_transparent']['url']  	: '';
			$acoda_logo_transparent_2x	= ( !empty( $dynamix_options['branding_url_transparent_2x']['url']  ) ) 	? $dynamix_options['branding_url_transparent_2x']['url']  : '';			
						
			
			if( $dynamix_options['branding_display'] == true ) : 

				echo "\n". '<div class="cell-wrap">';
				echo "\n\t". '<div id="header-logo" '. ( acoda_settings('mobile_logo_position') == 'dockbar' ? 'class="desktop"' : '' ) .'>';
				echo "\n\t". '<div id="logo">';

					if( $acoda_logo != '' ) : // Is Branding Image Set 

						// Logo
						$acoda_branding_url = ( !empty( $acoda_skin_logo ) ? $acoda_skin_logo : $acoda_logo ); 

						$width = $height = '';

						$branding_data = acoda_attachment_by_url( $acoda_branding_url );
						if( !empty( $branding_data ) )
						{
							$width  = $branding_data[1];
							$height = $branding_data[2];
						}
			
						if( $width == "0" || $height == "0" )
						{
							$width = $height = 'auto';
						}	
	

						echo '<a href="'. esc_url( get_home_url() ) .'">';

						echo '<img src="'. esc_url( $acoda_branding_url ) .'" class="'. ( !empty( $acoda_logo_2x ) ? 'branding-1x' : '' ) .' '. ( !empty( $mobile_logo ) ? 'desktop' : '' ) .' '. ( !empty( $acoda_logo_transparent ) && ( $header_float == 'header_float transparent' ) ? 'sticky' : '' ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" alt="'. esc_attr( get_bloginfo('name') ) .'" />';

						// Logo Retina
						if( !empty( $acoda_logo_2x ) )
						{
							$acoda_branding_url = $acoda_logo_2x; 

							$branding_data = acoda_attachment_by_url( $acoda_branding_url );
							$width  = $branding_data[1] / 2;
							$height = $branding_data[2] / 2;		
							
							
							$width = $height = '50%';
													

							echo '<img src="'. esc_url( $acoda_branding_url ) .'" class="branding-2x '. ( !empty( $mobile_logo_2x ) ? 'desktop' : '' ) .' '. ( !empty( $acoda_logo_transparent ) && ( $header_float == 'header_float transparent' ) ? 'sticky' : '' ) .'" alt="'. esc_attr( get_bloginfo('name') ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" />';
						}					

						// Logo Mobile
						if( !empty( $mobile_logo ) && acoda_settings('mobile_logo_position') == 'header' )
						{				
							$acoda_branding_url = $mobile_logo; 

							$branding_data = acoda_attachment_by_url( $acoda_branding_url );

							if( !empty( $branding_data ) )
							{
								$width  = $branding_data[1];
								$height = $branding_data[2];
							}									

							echo '<img src="'. esc_url( $acoda_branding_url ) .'" class="'. ( !empty( $mobile_logo_2x ) ? 'branding-1x' : '' ) .' mobile" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" alt="'. esc_attr( get_bloginfo('name') ) .'" />';
						}	

						// Logo Mobile Retina
						if( !empty( $mobile_logo_2x ) && acoda_settings('mobile_logo_position') == 'header' )
						{				
							$acoda_branding_url = $mobile_logo_2x; 

							$branding_data = acoda_attachment_by_url( $acoda_branding_url );

							$width  = $branding_data[1] / 2;
							$height = $branding_data[2] / 2;	
							
							$width = $height = '50%';

							echo '<img src="'. esc_url( $acoda_branding_url ) .'" class="branding-2x mobile" alt="'. esc_attr( get_bloginfo('name') ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" />';								
						}					



						// Logo Transparent Header 
						if( !empty( $acoda_logo_transparent ) && ( $header_float == 'header_float transparent' ) )
						{
							$acoda_branding_url = $acoda_logo_transparent;

							$branding_data = acoda_attachment_by_url( $acoda_branding_url );
							$width  = ( !empty( $branding_data[1] ) ? $branding_data[1] : '' );
							$height = ( !empty( $branding_data[2] ) ? $branding_data[2] : '' );				

							echo '<img src="'. esc_url( $acoda_branding_url ) .'" class="'. ( !empty( $acoda_logo_transparent_2x ) ? 'branding-1x' : '' ) .' transparent" alt="'. esc_attr( get_bloginfo('name') ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" />';
						}

						// Logo Transparent Header Retina  
						if( !empty( $acoda_logo_transparent_2x ) && ( $header_float == 'header_float transparent' ) )
						{
							$acoda_branding_url = $acoda_logo_transparent_2x; 

							$branding_data = acoda_attachment_by_url( $acoda_branding_url );
							$width  = $branding_data[1] / 2;
							$height = $branding_data[2] / 2;	
							
							$width = $height = '50%';

							echo '<img src="'. esc_url( $acoda_branding_url ) .'" class="branding-2x transparent" alt="'. esc_attr( get_bloginfo('name') ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" />';
						}					

						echo '</a>';

						if( get_bloginfo('description') != '' && acoda_settings('header_tagline') == true ) :
						   echo '<span class="description">'. esc_html( get_bloginfo('description') ) .'</span>'; 
						endif;           

					else:

						echo '<span class="logo"><a href="'. esc_url( get_home_url() ) .'">'. get_bloginfo('name') .'</a></span>';

						if( get_bloginfo('description') !='' && acoda_settings('header_tagline') == true )
						{
							echo '<span class="description">'. esc_html( get_bloginfo('description') ) .'</span>';		
						}

					endif; 

				echo "\n\t". '</div>';
				echo "\n\t". '</div><!-- /header-logo -->';
				echo "\n\t". '</div>';

			endif;		
		}
	}

	if ( ! function_exists( 'acoda_header' ) ) 
	{
		function acoda_header()
		{		
			global 	$post,
					$dynamix_options;
			
			$skin = get_option( 'acoda_dynamix_skin' );
			$acoda_skin = ( !empty( $dynamix_options['theme_skin'] ) ? 'dynamix_'. $dynamix_options['theme_skin'] : ( !empty( $skin ) ? 'dynamix_'. $skin : 'dynamix_Classic' ) );	
			$skin_data = get_option( $acoda_skin );			
					

			// Get Post ID
			if( is_archive() )
			{
				$url = explode('?', 'http://'. esc_url( $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) );
				$post_id = ( isset($_GET['page_id'] ) ? esc_attr( $_GET['page_id'] ) : url_to_postid( esc_url( $url[0] ) ) );				
			}
			else
			{
				$post_id = ( !empty( $post ) && ! is_search() ? $post->ID : '' );
			}
			

			$dockicon_panels 			= acoda_settings('dockicon_panels');
			$menu_slug 					= acoda_settings('menu');							
			$selected_menu 				= ( empty( $menu_slug ) && !has_nav_menu( 'mainnav' ) ? 'none' : '' );
			$acoda_header_display 		= acoda_settings('header_layout');
			$acoda_skin 				= acoda_settings('skin');	
			$get_skin_data 				= get_option( ACODA_THEME_PREFIX .'_'. $acoda_skin );
			$header_width				= ( !empty( $dynamix_options['header_width'] ) ? $dynamix_options['header_width'] : 'wide' );	
			$header_float 				= acoda_settings('header_float');		
			
			$header_layout 				= 'layout_'. acoda_settings('header_layout');	
			$header_style				= ( !empty( $dynamix_options['header_style'] ) ? $dynamix_options['header_style']  : 'inline' );
			$sticky_menu_type			= ( !empty( $dynamix_options['sticky_menu_type'] ) ? $dynamix_options['sticky_menu_type']  : '' );
			$header_featured_image 		= ( !empty (  $skin_data['header_image_featured'] ) ? $skin_data['header_image_featured'] : false  );
			$header_parallax			= ( !empty (  $skin_data['header_parallax'] ) ? $skin_data['header_parallax'] : false  );
			
			
			// Do not float archive pages
			if( is_archive() || is_search() )
			{
				$header_float = 'header_float_disabled';	
			}
			elseif ( class_exists( 'woocommerce' ) )
			{
				if( is_woocommerce() )
				{
					$header_float = 'header_float_disabled';	
				}
			}	


			// Dock Bar Position
			$dockbar_position 		= ( acoda_settings('dockbar_position' ) != '' ? acoda_settings('dockbar_position' ) : 'dock_layout_4' );			

			// If not dock_layout_1 or dock_layout_1 dock_float
			if( $acoda_header_display != 'disable' && ( $header_float == 'header_float' || $header_float == 'header_float transparent' || $header_float == 'header_float transparent_default_font' ) && ( $dockbar_position == 'dock_layout_1' || $dockbar_position == 'dock_layout_1 dock_float' )  )
			{
				echo "\n". '<div class="header-float-wrap '. esc_attr( $header_float ) .' clearfix">';
			}	

			if( $dockbar_position != 'dock_layout_4' )
			{
				require_once get_template_directory() .'/dock.config.php';
			}

			// If not dock_layout_1 or dock_layout_1 dock_float
			if( $acoda_header_display != 'disable' && ( $header_float == 'header_float' || $header_float == 'header_float transparent' || $header_float == 'header_float transparent_default_font' ) && ( $dockbar_position != 'dock_layout_1' && $dockbar_position != 'dock_layout_1 dock_float' )  )
			{
				echo "\n". '<div class="header-float-wrap '. esc_attr( $header_float ) .' clearfix">';
			}

			if( $acoda_header_display != 'disable' )
			{
				$parallax_image = '';
				
				if( $header_featured_image == true && has_post_thumbnail() && ( is_single() || is_page() ) ) 
				{
					$parallax_image = get_the_post_thumbnail_url();
				}
				else if( !empty( $skin_data['header_image']['url'] ) )
				{
					$parallax_image = $skin_data['header_image']['url'];
				}				
				
				
				if( $header_parallax == true && !empty( $parallax_image ) )
				{
					wp_enqueue_script( 'acoda-parallax', get_template_directory_uri().'/js/parallax-background.min.js', false, array('jquery'), true );
					$parallax_classes[] = 'acoda-parallax';
					$parallax_attributes[] = 'data-parallax-direction="down" data-parallax-bg-image="' . esc_attr( $parallax_image ) . '"';			
				}
				
				echo "\n". '<header id="header-wrap" class="'. esc_attr( $header_float .' '. $dockbar_position .' '. $header_style .' '. $header_layout .' '. $sticky_menu_type ) .' clearfix skinset-header  acoda-skin">';

				echo "\n". '<div class="header-parallax '. ( !empty( $parallax_classes ) ? esc_attr( trim( implode( ' ', array_filter( $parallax_classes ) ) ) ) : '' ) .'" '. ( !empty( $parallax_attributes ) ? implode( ' ', $parallax_attributes ) : '' ) .'></div>';
				echo "\n". '<div class="header-wrap-inner">';	
				
					echo "\n". '<div id="header" class="row '. esc_attr( $header_width ) .'">';
				
					// Inline
					if( $header_style == 'inline' )
					{
						echo "\n". '<div class="inner-wrap clearfix">'; 
						
						if( acoda_settings('branding_alignment_inline') == 'left' )
						{
							acoda_logo();
							acoda_menu();
						}
						else if( acoda_settings('branding_alignment_inline') == 'right' )
						{
							acoda_menu();	
							acoda_logo();
						}
						
						echo "\n". '</div><!-- /inner-wrap -->'; 
					}
				
					// Inline
					if( $header_style == 'inline_middle_logo' )
					{
						echo "\n". '<div class="inner-wrap clearfix">'; 
						
						acoda_menu();
						acoda_logo();
							
		
						if( $dockbar_position == 'dock_layout_4' )
						{
							echo "\n". '<div class="cell-wrap">';
							require_once get_template_directory() .'/dock.config.php';
							echo "\n". '</div>';
						}						
						
						echo "\n". '</div><!-- /inner-wrap -->'; 
					}				
				
					// Stacked Style
					if( $header_style == 'stacked' )
					{
						echo "\n". '<div class="inner-wrap clearfix">';		
						acoda_logo();
						echo "\n". '</div><!-- /inner-wrap -->'; 
						acoda_menu();	
					}
				
					// Middle Style
					if( $header_style == 'middle' )
					{
						echo "\n". '<div class="inner-wrap clearfix">'; 
						
							acoda_logo();
							acoda_menu();
						
						echo "\n". '</div><!-- /inner-wrap -->'; 
					}			

				echo "\n". '</div><!-- /header -->';
				
				if( is_active_sidebar('headerpanel') && acoda_settings('header_layout') == 'top' )
				{
					acoda_header_ad();
				}				

				if( acoda_settings('header_layout') == 'top' )
				{
					if( class_exists( 'woocommerce' ) )
					{
						if( is_product() && acoda_settings('woocomtitle_position') == 'header' )
						{
							acoda_sub_header();			
						}
						else if( ! is_product() )
						{
							acoda_sub_header();
						}
					}	
					else
					{
						acoda_sub_header();	
					}
				}				
				
				echo "\n". '</div><!-- /header-inner-wrap -->';
				echo "\n". '</header><!-- /header-wrap -->';
			}

			if( $acoda_header_display != 'disable' && ( $header_float == 'header_float' || $header_float == 'header_float transparent' || $header_float == 'header_float transparent_default_font' ) )
			{
				echo "\n". '</div>';
			}						
		}
	}
	
	

	if( acoda_settings('header_layout') == 'top' )
	{
		add_action('acoda_before_main_wrap', 'acoda_header');
	}
	else
	{
		add_action('acoda_before_main_wrap', 'acoda_header_ad');
		add_action('acoda_before_main_wrap', 'acoda_sub_header');
		add_action('acoda_before_site_wrap', 'acoda_header');
	}

	if ( ! function_exists('acoda_header_ad') )
	{
		function acoda_header_ad()
		{
				if( is_active_sidebar('headerpanel') )
				{
					$header_widget_width = acoda_settings('header_widget_width');
					$header_widget_align = acoda_settings('header_widget_align');

					echo '<div class="headerpanel-widget-wrap skinset-ad">';
					echo "\n". '<ul class="headerpanel-widgets'. ( $header_widget_width != '' ? ' '. esc_attr( $header_widget_width ) : '' ) . ( $header_widget_align != '' ? ' '. esc_attr( $header_widget_align ) : '' ) .'">';
					dynamic_sidebar('headerpanel');	
					echo "\n". '</ul>';
					echo '</div>';
				}			
		}
	}


	if ( ! function_exists( 'acoda_sub_header' ) ) 
	{
		function acoda_sub_header()
		{		
			global	$post, 
					$dynamix_options;
			
			$skin = get_option( 'acoda_dynamix_skin' );
			$acoda_skin = ( !empty( $dynamix_options['theme_skin'] ) ? 'dynamix_'. $dynamix_options['theme_skin'] : ( !empty( $skin ) ? 'dynamix_'. $skin : 'dynamix_Classic' ) );	
			$skin_data = get_option( $acoda_skin );					

			$acoda_displaytitle	= acoda_settings('displaytitle');
			$acoda_pagetitle	= acoda_settings('pagetitle');
			$acoda_pagesubtitle	= acoda_settings('pagesubtitle');		
			$header_width		= ( !empty( $dynamix_options['header_width'] ) ? $dynamix_options['header_width'] : 'wide' );	
			$subheader_featured_image 	= ( !empty (  $skin_data['subheader_image_featured'] ) ? $skin_data['subheader_image_featured'] : false  );
			$subheader_parallax			= ( !empty (  $skin_data['subheader_parallax'] ) ? $skin_data['subheader_parallax'] : false  );			

			$acoda_breadcrumbs 	= ( $dynamix_options['breadcrumb'] == false ? 'disable' : '' );	
			$posttitle_position	= ( !empty( $dynamix_options['posttitle_position'] ) ? $dynamix_options['posttitle_position'] : 'content' );

			$title_layout		= acoda_settings('title_layout');	

			if( is_single() && $posttitle_position == 'content' )
			{
				$acoda_displaytitle = false;
			}		

			if( is_front_page() ) 
			{
				$acoda_breadcrumbs = 'disable'; 

				if( ! is_page() )
				{
					$acoda_pagesubtitle = ( acoda_settings( 'blog_title' ) != false ? get_bloginfo('description') : '' );
				}
			}

			$post_id = ( isset( $post ) ? $post->ID : '' );
			
			$parallax_image = '';

			if( $subheader_featured_image == true && has_post_thumbnail() && ( is_single() || is_page() ) ) 
			{
				$parallax_image = get_the_post_thumbnail_url();
			}
			else if( !empty( $skin_data['subheader_image']['url'] ) )
			{
				$parallax_image = $skin_data['subheader_image']['url'];
			}				


			if( $subheader_parallax == true && !empty( $parallax_image ) )
			{
				wp_enqueue_script( 'acoda-parallax', get_template_directory_uri().'/js/parallax-background.min.js', false, array('jquery'), true );
				$parallax_classes[] = 'acoda-parallax';
				$parallax_attributes[] = 'data-parallax-direction="down" data-parallax-bg-image="' . esc_attr( $parallax_image ) . '"';			
			}			
			

			// Sub Header Display			
			$acoda_disable_subtabs = ( $acoda_breadcrumbs == 'disable' && $acoda_displaytitle == false ? 'yes' : '' );

			if( ( $acoda_disable_subtabs != 'yes' && ! is_home() ) || !empty( $acoda_pagesubtitle ) || ( is_home() && acoda_settings( 'blog_title' ) != false ) || ( $acoda_displaytitle != false && is_page() ) || is_archive() )
			{
				echo "\n" . '<div class="intro-wrap skinset-sub_header '. ( !empty( $title_layout  ) ? esc_attr( $title_layout ) : '' ) .' '. esc_attr( $header_width ) .' '. ( !empty( $parallax_classes ) ? esc_attr( trim( implode( ' ', array_filter( $parallax_classes ) ) ) ) : '' ) .' acoda-skin clearfix" '. ( !empty( $parallax_attributes ) ? implode( ' ', $parallax_attributes ) : '' ) .'>';
				echo "\n\t" . '<div class="overlay"></div>';
				echo "\n\t" . '<div class="intro-wrap-inner">';
				echo "\n\t\t" . '<div class="intro-text '. ( $acoda_displaytitle == false ? 'left-align' : '' ) .'">';

				$title_output = '';

				// Post Date
				$meta_date_format 	= ( acoda_settings( 'meta_date_format_single' ) != '' ? acoda_settings( 'meta_date_format_single' ) : 'd F Y' );
				$meta_date 			= 	acoda_settings('meta_date');
				
				
				$meta_date = ( $meta_date != 'archive' && $meta_date != 'disable' ? 'display' : 'disable' );
					


				if( ( !empty( $acoda_pagesubtitle ) && !empty( $acoda_pagetitle ) || $acoda_displaytitle != false && ( is_page() || is_single() ) ) || ( $dynamix_options['meta_date_position'] != 'metadata' && is_single() && $meta_date == 'display' ) || ( is_home() && acoda_settings( 'blog_title' ) != false ) )
				{
					$title_output .= "\n\t\t\t" . '<div class="post-titles"><!-- post-titles -->';

					if( !empty($acoda_pagetitle) )
					{
						if( $acoda_displaytitle != false )
						{
							$title_output .= "\n\t\t\t\t" . '<h1>'. esc_html( $acoda_pagetitle ) .'</h1>';
						}
					}
					elseif( is_home() && acoda_settings( 'blog_title' ) != false )
					{
						$title_output .= "\n\t\t\t\t" . '<h1>'. esc_html( get_bloginfo( 'name' ) ) .'</h1>';
					}
					else
					{
						if( $acoda_displaytitle != false )
						{
							$title_output .= "\n\t\t\t\t" . '<h1>'. get_the_title() .'</h1>';
						}
					}		

					if( !empty( $acoda_pagesubtitle ) && ( ( is_single() && $meta_date == 'display' &&  get_post_type( $post_id ) == 'post' )  || ( is_page() ) ) )
					{
						$title_output .= "\n\t\t\t\t" . '<h2>' . esc_html( $acoda_pagesubtitle ) .'</h2>';
					}				
					
					
					if( $dynamix_options['meta_date_position'] == 'title_below' && is_single() && $meta_date == 'display' )
					{
						$title_output .= "\n\t\t\t\t" . '<div class="title-date"><span class="date">'. get_the_time( $meta_date_format ) .'</span></div>';
					}

					$title_output .= "\n\t\t\t" . '</div><!-- /post-titles -->';
				}
				elseif( is_search() )
				{
					$title_output .= "\n\t\t\t" . '<div class="post-titles"><!-- post-titles -->';
					$title_output .= '<h1>';				
					$title_output .= sprintf(  esc_html__( 'Search results for &#39; %s &#39;', 'dynamix' ), get_search_query() );	
					$title_output .= '</h1>';		
					$title_output .= "\n\t\t\t" . '</div><!-- /post-titles -->';					
				}
				elseif( is_404() )
				{
					$title_output .= "\n\t\t\t" . '<div class="post-titles"><!-- post-titles -->';
					$title_output .= '<h1>';				
					$title_output .= sprintf(  esc_html__( 'Oops!', 'dynamix' ), get_search_query() );	
					$title_output .= '</h1>';		
					$title_output .= "\n\t\t\t" . '</div><!-- /post-titles -->';					
				}			
				elseif( is_archive() )
				{
					$title_output .= "\n\t\t\t" . '<div class="post-titles"><!-- post-titles -->';
					$title_output .= '<h1 class="archive-title">';

					$title_output .= get_the_archive_title();

					$title_output .= '</h1>';		

					$title_output .= "\n\t\t\t" . '</div><!-- /post-titles -->';			
				}
				elseif( function_exists( 'is_shop' ) )			
				{
					if( is_shop() )
					{
						$shop_page_id = wc_get_page_id( 'shop' ); 
						$page_title = get_the_title( $shop_page_id ); 
						$title_output .= "\n\t\t\t" . '<div class="post-titles"><!-- post-titles -->';
						$title_output .= "\n\t\t\t\t" . '<h1>'. esc_html( $page_title ) .'</h1>';	
						$title_output .= "\n\t\t\t" . '</div><!-- /post-titles -->';	
					}
					else
					{
						$title_output .= "\n\t\t\t" . '<div class="post-titles"><!-- post-titles -->';
						$title_output .= '<h1 class="archive-title">';

						$title_output .= get_the_archive_title();

						$title_output .= '</h1>';		

						$title_output .= "\n\t\t\t" . '</div><!-- /post-titles -->';							
					}
				}				

				// Check Title Layout
				if( $title_layout != 'layout_2' )
				{
					echo $title_output;
				}

				// Breadcrumbs
				if( $acoda_breadcrumbs != 'disable' ) 
				{
					echo "\n\t\t\t" . '<div id="sub-tabs">';

						if(class_exists('bbPress') && is_bbpress())
						{
							echo "\n" . '<div class="breadcrumb clearfix" itemprop="breadcrumb">';
								bbp_breadcrumb();
							echo "\n" . '</div>';
						}
						else
						{ 				   
							// Woocommerce Breadcrumb
							if ( function_exists( 'woocommerce_breadcrumb' ) )
							{ 
								woocommerce_breadcrumb('delimiter=<span class="subbreak"><i class="fal fa-angle-right"></i></span>&wrap_before=<div class="breadcrumb">&wrap_after=</div>');
							}
							else
							{
								echo "\n" . '<ul class="clearfix">'. acoda_breadcrumbs() .'</ul>';
							} 
						}

					echo "\n\t\t\t" . '</div>';
				}			  

				if( $title_layout == 'layout_2' )
				{
					echo $title_output;
				}			

				echo "\n\t\t" . '</div>';
				echo "\n\t" . '</div>';
				echo "\n" . '</div>';	
			}			
		}
	}
	
	//add_action('acoda_before_content_wrap', 'acoda_sub_header');


	if ( ! function_exists( 'acoda_footer' ) ) 
	{
		function acoda_footer()
		{
			$acoda_disablefooter = acoda_settings('disablefooter');

			if( $acoda_disablefooter != 'yes' && acoda_settings('mainfooter') != false ) : 

				echo "\n". '<footer id="footer-wrap" class="skinset-footer acoda-skin clearfix">';
				echo "\n". '<div class="overlay"></div>';
				echo "\n". '<div id="footer" class="clearfix row" itemscope="itemscope" itemtype="http://schema.org/WPFooter">';
				echo "\n". '<div class="content row">';

				$get_footer_num = ( acoda_settings('footer_columns_num') !='' ) ? acoda_settings('footer_columns_num') : '4'; // If not set, default to 4 columns

				$i = 1;

				while( $i <= $get_footer_num )
				{ 
					echo '<div class="block columns large-'. 12 / esc_attr( $get_footer_num ) .' '. ( $i == $get_footer_num ? 'last' : '' ) .'">';
					echo '<ul>';

					dynamic_sidebar( 'footer'.$i ); 

					echo '</ul>';
					echo '</div>';

					$i++;	
				}

				echo "\n". '</div><!-- / row -->';
				echo "\n". '</div><!-- / footer -->';


				// Check for enabled lower footer
				if( acoda_settings('lowerfooter') != false )
				{
					$allowed_tags = wp_kses_allowed_html();

					$lower_left  = ( acoda_settings('lowfooterleft') !='' )  ? acoda_settings('lowfooterleft')  : '&copy; '. date("Y") .' '. get_option("blogname");
					$lower_right = ( acoda_settings('lowfooterright') !='' ) ? acoda_settings('lowfooterright') : '';


					echo "\n". '<div class="lowerfooter-wrap row clearfix">';
					echo "\n". '<div class="lowerfooter columns large-12 clearfix">';  
					echo "\n". '<div class="lowfooterleft">'. wp_kses_post( do_shortcode( $lower_left ), $allowed_tags ) .'</div>';
					echo "\n". '<div class="lowfooterright">'. wp_kses_post( do_shortcode( $lower_right ), $allowed_tags ) .'</div>';
					echo "\n". '</div><!-- / lowerfooter -->';
					echo "\n". '</div><!-- / lowerfooter-wrap -->';
				} 

				echo "\n". '<div class="footer-filler"></div>';       
				echo "\n". '</footer><!-- / footer-wrap -->';

			endif; // disable footer 			
		}
	}
	
	add_action('acoda_after_content_wrap', 'acoda_footer');
	

	
	
	

	
	// Post Title
	if ( ! function_exists( 'acoda_post_title' ) ) 
	{
		function acoda_post_title()
		{
			global	$post,
					$dynamix_options;

			$meta_date_format		= ( acoda_settings( 'meta_date_format_archive' ) != '' ? acoda_settings( 'meta_date_format_archive' ) : 'd M' );
			$posttitle_position		= ( acoda_settings( 'posttitle_position' ) != '' ? acoda_settings( 'posttitle_position' ) : 'content' );
			
		
			// POST OPTIONS
			$acoda_disablegallink	= ( get_post_meta( $post->ID, 'post_link', true ) != '' ? get_post_meta( $post->ID, 'post_link', true ) : true );
			$post_link				= ( get_post_meta( $post->ID, 'post_altlink', true ) != '' ? get_post_meta( $post->ID, 'post_altlink', true ) : get_permalink() );
			$acoda_displaytitle		= ( get_post_meta( $post->ID, 'displaytitle', true ) != '' ? get_post_meta( $post->ID, 'displaytitle', true ) : true );
			$acoda_postsubtitle 	= ( get_post_meta( $post->ID, 'pagesubtitle', true ) != '' ? get_post_meta( $post->ID, 'pagesubtitle', true ) : '' );
			$acoda_posttitle 		= ( get_post_meta( $post->ID, 'pagetitle', true ) != '' ? get_post_meta( $post->ID, 'pagetitle', true ) : '' );
			$acoda_title_tag 		= ( acoda_settings( 'title_tag' ) != '' ? acoda_settings( 'title_tag' ) : 'h2' );

			
			if( is_search() )
			{
				$acoda_displaytitle = 'display';	
			}

			// Post Title
			if( $acoda_posttitle )
			{  	
				if( $acoda_displaytitle != false )
				{ 
					if( !is_single() )
					{ 
						if( $acoda_disablegallink == false )
						{
							echo '<'. $acoda_title_tag .' class="entry-title">'. ( $dynamix_options['meta_date_position'] != 'metadata' && acoda_settings( 'meta_date' ) != 'disable' && ! is_search() ? '<span class="date">'. get_the_time( $meta_date_format ) .'</span> ' : '' ) . esc_html( $acoda_posttitle ) . ( !empty( $acoda_postsubtitle ) ? '<span class="colon">:</span> <span class="sub-title">'. esc_html( $acoda_postsubtitle ) .'</span>' : '' ) .'</'. $acoda_title_tag .'>';					
						}
						else
						{
							echo '<'. $acoda_title_tag .' class="entry-title"><a href="'. esc_url( $post_link ) .'" rel="bookmark">'. ( $dynamix_options['meta_date_position'] != 'metadata' && acoda_settings( 'meta_date' ) != 'disable' && ! is_search() ? '<span class="date">'. get_the_time( $meta_date_format ) .'</span> ' : '' ) . esc_html( $acoda_posttitle ) . ( !empty( $acoda_postsubtitle ) ? '<span class="colon">:</span> <span class="sub-title">'. esc_html( $acoda_postsubtitle ) .'</span>' : '' ) .'</a></'. $acoda_title_tag .'>';
						}
					}
					else if( $posttitle_position == 'content' && is_single() )
					{
						echo '<h1 class="entry-title" itemprop="headline">'. esc_html( $acoda_posttitle ) .'</h1>';

						if( !empty($acoda_pagesubtitle) )
						{
							echo '<h2>'. esc_html( $acoda_pagesubtitle ) .'</h2>';
						}	
					}				
				}	 
			}
			else
			{  
				if( $acoda_displaytitle != false )
				{ 
					if( !is_single() )
					{
						if( $acoda_disablegallink == false )
						{				
							echo '<'. $acoda_title_tag .' class="entry-title">'. ( $dynamix_options['meta_date_position'] != 'metadata' && acoda_settings( 'meta_date' ) != 'disable' && ! is_search() ? '<span class="date">'. get_the_time( $meta_date_format ) .'</span> ' : '' ) . get_the_title() . ( !empty( $acoda_postsubtitle ) ? '<span class="colon">:</span> <span class="sub-title">'. esc_html( $acoda_postsubtitle ) .'</span>' : '' ) .'</'. $acoda_title_tag .'>';	
						}
						else
						{
							echo '<'. $acoda_title_tag .' class="entry-title"><a href="'. esc_url( $post_link ) .'" rel="bookmark">'. ( $dynamix_options['meta_date_position'] != 'metadata' && acoda_settings( 'meta_date' ) != 'disable' && ! is_search() ? '<span class="date">'. get_the_time( $meta_date_format ) .'</span> ' : '' ) . get_the_title() . ( !empty( $acoda_postsubtitle ) ? '<span class="colon">:</span> <span class="sub-title">'. esc_html( $acoda_postsubtitle ) .'</span>' : '' ) .'</a></'. $acoda_title_tag .'>';						
						}
					}     
					else if( $posttitle_position == 'content' && is_single() )
					{
						echo '<h1 class="entry-title" itemprop="headline">'. get_the_title() .'</h1>';
					}				 	
				} 
			} 				
		}
	}
	
	// Blog Content
	if ( ! function_exists( 'acoda_post_content' ) ) 
	{
		function acoda_post_content()
		{
			global $post;

			$acoda_blogcontent = acoda_settings("arhpostcontent"); // Post Content
			$format = get_post_format();
			$acoda_max_characters = acoda_settings("blog_excerpt");

			if( is_single() || $acoda_blogcontent == 'full_post' ) :

				$content = get_the_content();

				$acoda_description = apply_filters( 'the_content', $content);

			elseif (  $acoda_blogcontent == '' || $acoda_blogcontent == 'excerpt' ) : 

				if ( empty($post->post_excerpt) )
				{
					$content = get_the_content();

					if( $format == 'gallery' )
					{
						//$content = acoda_switch_gallery($content , 'body' );
					}

					if( is_search() )
					{
						$acoda_description  = '<p>'. acoda_max_character_excerpt( $acoda_max_characters,  get_the_excerpt() ) .'</p>';
						//$acoda_description .= '<p>'. acoda_readmore() .'</p>';	
					}
					else
					{
						$content = apply_filters( 'the_content', $content);
						$acoda_description  = '<p>'. acoda_max_character_excerpt( $acoda_max_characters,  get_the_excerpt() ) .'</p>';
						//$acoda_description .= '<p>'. acoda_readmore() .'</p>';	
					}
				}
				else
				{
					$acoda_description  = '<p>'. get_the_excerpt() .'</p>'; 
					//$acoda_description .= '<p>'. acoda_readmore() .'</p>';	

				}

				$allowed_tags = wp_kses_allowed_html();

				$acoda_description = wp_kses_post( $acoda_description, $allowed_tags );

			else : 

				$acoda_description = '';

			endif; 		

			echo $acoda_description;
		}
	}
	
	if ( ! function_exists( 'acoda_post_image' ) ) 
	{
		function acoda_post_image( $img_size = '' )
		{
			global	$post;

			$acoda_postlayout			= acoda_settings('arhpostdisplay');
			$acoda_archive_img_align	= acoda_settings('archive_img_align');
			$acoda_archive_img_size		= ( !empty( $img_size ) ? $img_size : acoda_settings('archive_img_size') );
			$acoda_archive_img_effect	= acoda_settings('archive_img_effect');

			if( is_single() )
			{ 
				if( get_post_type( $post->ID ) != 'portfolio' )
				{
					// image size
					$acoda_img_size = ( acoda_settings('post_img_size') != '' ) ? acoda_settings('post_img_size') : 'large' ; 

					// image align
					$acoda_img_align = 'center'; 
				}
				else
				{
					// image size
					$acoda_img_size = ( acoda_settings('port_single_img_size') != '' ) ? acoda_settings('port_single_img_size') : 'large' ; 

					// image align
					$acoda_img_align = 'center'; 			
				}
			}
			elseif( ! is_single() )
			{
				if( get_post_type( $post->ID ) != 'portfolio'	 )
				{		
					// image size
					$acoda_img_size	= ( !empty( $acoda_archive_img_size ) ? $acoda_archive_img_size : ( acoda_settings('archive_img_size') != '' ? acoda_settings('archive_img_size') : 'large' ) ); 

					// image align
					$acoda_img_align	= ( !empty( $acoda_archive_img_align ) ? $acoda_archive_img_align : ( acoda_settings('archive_img_align') != '' ? acoda_settings('archive_img_align') : 'center' ) ); 	
				}
				else
				{
					// image size
					$acoda_img_size	= ( !empty( $acoda_archive_img_size ) ? $acoda_archive_img_size : ( acoda_settings('portfolio_img_size') != '' ? acoda_settings('portfolio_img_size') : 'large' ) ); 

					// image align
					$acoda_img_align	= ( !empty( $acoda_archive_img_align ) ? $acoda_archive_img_align : ( acoda_settings('portfolio_img_align') != '' ? acoda_settings('portfolio_img_align') : 'center' ) ); 				
				}
			}		


			$postcount = 0;

			// Image Effect + Lightbox
			$acoda_showlightbox = '';

			if( is_single() ) 
			{
				$acoda_imageeffect = acoda_settings('postimgeffect'); 

				if( get_post_type( $post->ID ) != 'portfolio' )
				{	
					if( acoda_settings('post_lightbox') == true )
					{
						$acoda_showlightbox = 'enable'; 
					}
				}
				else
				{
					if( acoda_settings('portfolio_post_lightbox') == true )
					{
						$acoda_showlightbox = 'enable'; 
					}			
				}
			}
			elseif( ! is_single() )
			{
				$acoda_imageeffect = ( !empty( $acoda_archive_img_effect ) ? $acoda_archive_img_effect : acoda_settings('arhimgeffect') ); // image effect	
			}
			
			// Post link
			$acoda_displayblogimage	= acoda_settings( 'blogpostimage' );
			
			$acoda_disablegallink	= ( get_post_meta( $post->ID, 'post_link', true ) != '' ? get_post_meta( $post->ID, 'post_link', true ) : true );
			$acoda_permalink		= ( get_post_meta( $post->ID, 'post_altlink', true ) != '' ? get_post_meta( $post->ID, 'post_altlink', true ) : get_permalink() );
			
			
			$acoda_img_id 			= get_post_thumbnail_id( $post->ID );	

			if( is_single() )
			{
				$acoda_disablegallink = false;
				
				if( get_post_type( $post->ID ) != 'portfolio' )
				{
					if( $acoda_displayblogimage != 'archive' && $acoda_displayblogimage != 'disable' && ( acoda_settings('blogpostimage') == '' || $acoda_displayblogimage == 'single' ||  $acoda_displayblogimage == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}
				}
				else
				{
					if( acoda_settings('portpostimage') != 'archive' && acoda_settings('portpostimage') != 'disable' && ( acoda_settings('portpostimage') == '' || acoda_settings('portpostimage') == 'single' ||  acoda_settings('portpostimage') == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}			
				}
			}
			elseif( !is_single() )
			{
				if( get_post_type( $post->ID ) != 'portfolio' )
				{	
					if( $acoda_displayblogimage != 'single' && $acoda_displayblogimage != 'disable' && ( $acoda_displayblogimage == 'archive' ||  $acoda_displayblogimage == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}
				}
				else
				{	
					if( acoda_settings('portpostimage') != 'single' && acoda_settings('portpostimage') != 'disable' && ( acoda_settings('portpostimage') == '' || acoda_settings('portpostimage') == 'archive' ||  acoda_settings('portpostimage') == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}						
				}
			}			

			

			if( !empty( $acoda_img_id ) && $acoda_displayblogimage == 'display' ) 
			{
				if( ( is_single() && empty( $acoda_showlightbox ) ) || $acoda_disablegallink == false )
				{
					$acoda_permalink = '';
				}				

				echo '<div class="blog-media-wrap '. esc_attr( $acoda_img_align ) .'">';

				$atts = array(
					'img_size' => $acoda_img_size,
					'image' => $acoda_img_id,
					'style' => $acoda_imageeffect,
					'alignment' => $acoda_img_align,
					'lightbox' => $acoda_showlightbox,
					'link' => $acoda_permalink,
					'img_link_target' => "_self",
					'el_class' => "blog_image"
				);

				echo acoda_featured_image( $atts );
	
				echo '</div>';
			} 	
		}
	}
	
	if ( ! function_exists( 'acoda_post_media' ) ) 
	{
		function acoda_post_media()
		{
			global	$post;

			$acoda_postlayout			= acoda_settings('arhpostdisplay');
			$acoda_archive_img_align	= acoda_settings('archive_img_align');
			$acoda_archive_img_size		= acoda_settings('archive_img_size');
			$acoda_archive_img_effect	= acoda_settings('archive_img_effect');


			if( is_single() )
			{ 
				if( get_post_type( $post->ID ) != 'portfolio' )
				{
					// image size
					$acoda_img_size = ( acoda_settings('post_img_size') != '' ) ? acoda_settings('post_img_size') : 'large' ; 

					// image align
					$acoda_img_align = 'center'; 
				}
				else
				{
					// image size
					$acoda_img_size = ( acoda_settings('port_single_img_size') != '' ) ? acoda_settings('port_single_img_size') : 'large' ; 

					// image align
					$acoda_img_align = 'center'; 			
				}
			}
			elseif( ! is_single() )
			{
				if( get_post_type( $post->ID ) != 'portfolio'	 )
				{		
					// image size
					$acoda_img_size		= ( !empty( $acoda_archive_img_size ) ? $acoda_archive_img_size : 'large' ); 

					// image align
					$acoda_img_align	= ( !empty( $acoda_archive_img_align ) ? $acoda_archive_img_align :  'center' ); 	
				}
				else
				{
					// image size
					$acoda_img_size		= ( acoda_settings('portfolio_img_size') != ''  ? acoda_settings('portfolio_img_size') : 'large'  ); 

					// image align
					$acoda_img_align	= ( acoda_settings('portfolio_img_align') != '' ? acoda_settings('portfolio_img_align') : 'center' ); 				
				}
			}		


			// Image Effect + Lightbox
			$acoda_showlightbox = '';

			if( is_single() ) 
			{
				$acoda_imageeffect = acoda_settings('postimgeffect'); 

				if( get_post_type( $post->ID ) != 'portfolio' )
				{	
					if( acoda_settings('post_lightbox') == true )
					{
						$acoda_showlightbox = 'enable'; 
					}
				}
				else
				{
					if( acoda_settings('portfolio_post_lightbox') == true )
					{
						$acoda_showlightbox = 'enable'; 
					}			
				}
			}
			elseif( ! is_single() )
			{
				$acoda_imageeffect = ( !empty( $acoda_archive_img_effect ) ? $acoda_archive_img_effect : acoda_settings('arhimgeffect') ); // image effect		
			}		


			
			$acoda_disablegallink	= ( get_post_meta( $post->ID, 'post_link', true ) != '' ? get_post_meta( $post->ID, 'post_link', true ) : true );
			$acoda_permalink		= ( get_post_meta( $post->ID, 'post_altlink', true ) != '' ? get_post_meta( $post->ID, 'post_altlink', true ) : get_permalink() );			
			$acoda_movieurl 		= ( get_post_meta( $post->ID, 'media_url', true ) != '' ? get_post_meta( $post->ID, 'media_url', true ) : '' );	
			$acoda_videotype 		= ( get_post_meta( $post->ID, 'media_display', true ) != '' ? get_post_meta( $post->ID, 'media_display', true ) : 'oembed' );
			
			$acoda_displayblogimage	= acoda_settings( 'blogpostimage' );
			
			
			$ratio 				 	= 'normal';
			$acoda_videoautoplay	= '1';

			$acoda_videoautoplay = ( !empty( $acoda_videoautoplay ) ? 1 : 0 );


			if( is_single() )
			{
				if( get_post_type( $post->ID ) != 'portfolio' )
				{
					if( $acoda_displayblogimage != 'archive' && $acoda_displayblogimage != 'disable' && ( acoda_settings('blogpostimage') == '' || $acoda_displayblogimage == 'single' ||  $acoda_displayblogimage == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}
				}
				else
				{
					if( $acoda_displayblogimage != 'archive' && $acoda_displayblogimage != 'disable' && ( acoda_settings('portpostimage') == '' || $acoda_displayblogimage == 'single' ||  $acoda_displayblogimage == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}			
				}
			}
			elseif( !is_single() )
			{
				if( get_post_type( $post->ID ) != 'portfolio' )
				{	
					if( $acoda_displayblogimage != 'single' && $acoda_displayblogimage != 'disable' && ( $acoda_displayblogimage == 'archive' ||  $acoda_displayblogimage == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}
				}
				else
				{
					if( $acoda_displayblogimage != 'single' && $acoda_displayblogimage != 'disable' && ( acoda_settings('portpostimage') == '' || $acoda_displayblogimage == 'archive' ||  $acoda_displayblogimage == 'singlearchive' ) )
					{
						$acoda_displayblogimage = 'display';
					}			
				}
			}						



			if( !empty( $acoda_img_id ) && $acoda_displayblogimage == 'display' && !empty( $acoda_showlightbox ) && $acoda_videotype == 'lightbox' )
			{	
				echo '<div class="blog-media-wrap '. esc_attr( $acoda_img_align ) .'">';

				$atts = array(
					'img_size' => $acoda_img_size,
					'image' => $acoda_img_id,
					'style' => $acoda_imageeffect,
					'alignment' => $acoda_img_align,
					'lightbox' => $acoda_showlightbox,
					'link' => $acoda_permalink,
					'media_url' => $acoda_movieurl,
					'img_link_target' => "_self",
					'el_class' => "blog_image"
				);

				echo acoda_post_image( $atts );

				echo '</div>';
			} 				
			else if( !empty( $acoda_movieurl ) && $acoda_displayblogimage == 'display' && !empty( $acoda_videotype ) )
			{		
				$style = '';
				$image_types_array = array("thumbnail", "medium", "large", "full");

				$image_types = implode('|', $image_types_array);

				if( preg_match( '/('. $image_types .')/i', $acoda_img_size ) )
				{
					$style = ' style="width:'. get_option( $acoda_img_size.'_size_w' ) .'px;max-width:100%;"';
				}
				else
				{			
					$img_width = explode( 'x', $acoda_img_size );

					$style = ' style="width:'. $img_width[0] .'px;max-width:100%;"';
				}

				echo '<div class="blog-media-wrap '. esc_attr( $acoda_img_align ) .'" '. $style .'>';

				$acoda_videotype = 'oembed'; // fallback if set to lightbox and no image is set

				$atts = array(
					'type' => $acoda_videotype,
					'link' => $acoda_movieurl,
					'style' => $acoda_imageeffect,
					'alignment' => $acoda_img_align,
					'autoplay' => $acoda_videoautoplay,
					'ratio' => $ratio,
				);

				echo acoda_featured_media( $atts );					

				echo '</div>';
			}		
		}
	}
	
	if ( ! function_exists( 'acoda_post_metadata' ) ) 
	{
		function acoda_post_metadata()
		{
			global	$post,
					$dynamix_options;

			$acoda_postlayout	= acoda_settings('arhpostdisplay');

			$acoda_arhpostpostmeta = '';

			$meta_date		 = acoda_settings('meta_date');	
			$meta_author	 = acoda_settings('meta_author');		
			$meta_categories = acoda_settings('meta_categories');
			$meta_tags 		 = acoda_settings('meta_tags');	
			$meta_comments	 = acoda_settings('meta_comments');	

			

			if( is_single() )
			{ 	
				// Meta Date		
				$meta_date = ( $meta_date != 'archive' && $meta_date != 'disable' && $dynamix_options['meta_date_position'] == 'metadata' ? 'display' : 'disable' );
		
				// Meta Author
				$meta_author = ( $meta_author != 'archive' && $meta_author != 'disable' ? 'display' : 'disable' );	
		
				// Meta Categories
				$meta_categories = ( $meta_categories != 'archive' && $meta_categories != 'disable' ? 'display' : 'disable' );	
		
				// Meta Tags		
				$meta_tags = ( $meta_tags != 'archive' && $meta_tags != 'disable' ? 'display' : 'disable' );				
		
				// Meta comments		
				$meta_comments = ( $meta_comments != 'archive' && $meta_comments != 'disable' ? 'display' : 'disable' );					
				
				
				if(  $meta_categories != 'disable' || $meta_tags != 'disable' || $meta_comments != 'disable' || $meta_date != 'disable' )
				{
					$acoda_arhpostpostmeta = 'display';
				}
			}
			elseif( !is_single() )
			{	
				// Meta Date		
				$meta_date = ( $meta_date != 'single' && $meta_date != 'disable' ? 'display' : 'disable' );
		
				// Meta Author
				$meta_author = ( $meta_author != 'single' && $meta_author != 'disable' ? 'display' : 'disable' );	
		
				// Meta Categories
				$meta_categories = ( $meta_categories != 'single' && $meta_categories != 'disable' ? 'display' : 'disable' );	
		
				// Meta Tags		
				$meta_tags = ( $meta_tags != 'single' && $meta_tags != 'disable' ? 'display' : 'disable' );				
		
				// Meta comments		
				$meta_comments = ( $meta_comments != 'single' && $meta_comments != 'disable' ? 'display' : 'disable' );				
				
				if( $meta_date != 'disable' || $meta_categories != 'disable' || $meta_tags == 'disable' || $meta_comments != 'disable' )
				{
					$acoda_arhpostpostmeta = 'display';
				}
			}		

			if( get_post_type( $post ) == 'portfolio' ) 
			{
				$acoda_arhpostpostmeta = 'disable';
			}				

			
			// If image is aligned left / right, display post metadata below
			if( $acoda_arhpostpostmeta == 'display' )
			{
				if( is_single() && acoda_settings('meta_date_format_single') != '' ) 
				{
					$meta_date_format = ( acoda_settings( 'meta_date_format_single' ) != '' ? acoda_settings( 'meta_date_format_single' ) : ( acoda_settings( 'meta_date_format_archive' ) != '' ? acoda_settings( 'meta_date_format_archive' ) : 'd M y' ) );
				}
				else
				{
					$meta_date_format = ( acoda_settings( 'meta_date_format_archive' ) != '' ? acoda_settings( 'meta_date_format_archive' ) : 'd M y' );
				}

				
				echo "\n". '<div class="post-metadata">'; 
				echo "\n". '<ul class="post-metadata-wrap">'; 

				if( $meta_author != 'disable' ) 
				{ 
					echo "\n". '<li class="meta-author">';
					//echo "\n". ( is_single() ? '<span class="icon">'. get_avatar( get_the_author_meta( 'ID' ), '30') .'</span>' : '' );
					echo "\n". '<span class="author-name">';
					echo "\n". '<span class="vcard author" itemprop="name">';
					echo "\n". '<span class="fn" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author">';        
					echo "\n". ( is_single() ? __( 'By', 'dynamix' ) : '' ) . ' <a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'">'. get_the_author_meta( 'display_name' ) .'</a>';
					echo "\n". '</span>';
					echo "\n". '</span>';
					echo "\n". '</span>';
					echo "\n". '</li>';
				}	


				if( $meta_date != 'disable' && $dynamix_options['meta_date_position'] == 'metadata' )
				{
					$date_stamp = get_post_time('Y-m-d H:i:s');
					
					echo "\n". '<li class="meta-date">';
					echo "\n". '<span class="date-day updated"><time datetime="'. esc_attr( $date_stamp ) .'">'. get_the_time( $meta_date_format ) .'</time></span>';
					echo "\n". '</li>';
				}


				if( $meta_categories != 'disable' ) 
				{         
					echo "\n". '<li class="meta-category">';
					echo "\n". '<span class="category-list">';
					the_category(' , ');
					echo "\n". '</span>';
					echo "\n". '</li>';	
				}

				if( get_the_tags() !='' && $meta_tags != 'disable' )
				{
					echo "\n". '<li class="tags-title">';
					echo "\n". '<span class="tags-list">';
					the_tags('',' , ');
					echo "\n". '</span>';
					echo "\n". '</li>';
				} 					

				if( comments_open() && $meta_comments != 'disable' )
				{
					echo "\n". '<li class="comments-list">';
				
					comments_popup_link( 
						'<span class="icon"><i class="fal fa-comment"></i></span> '. __( '0', 'dynamix' ), 
						'<span class="icon"><i class="fal fa-comment"></i></span> '. __( '1', 'dynamix' ), 
						'<span class="icon"><i class="fal fa-comments"></i></span> '. __( '%', 'dynamix' )
					);
					
					echo "\n". '</li>';
				}			

				echo "\n". '</ul>';			
				echo "\n". '</div>';
			}		
			
			// Share Post
			$share_post = ( acoda_settings("share_post") == 'top' || acoda_settings("share_post") == 'both' ? 'enable' : '' );

			if( $share_post == 'enable' && is_single() )
			{
				echo "\n". '<div class="post-metadata">';
				echo acoda_share_post();
				echo "\n". '</div>';
			}				
		}
	}
	
	if ( ! function_exists( 'acoda_post_footer' ) ) 
	{
		function acoda_post_footer()
		{
			global	$post,
					$dynamix_options;
			
			echo '<footer>';
			echo '<section class="large-12 columns">';		
			
				// If a user has filled out their description and this is a multi-author blog, show a bio on their entries
				if ( get_the_author_meta( 'user_description' ) ) :

					echo '<div class="author-info-wrap row clearfix">';
					echo '<aside id="author-avatar" class="aligncenter">';
					echo get_avatar( get_the_author_meta( 'user_email' ), '150' );
					echo '</aside><!-- #author-avatar -->';		
					echo '<div class="author-info columns large-6">';		
					echo '<section id="author-description" class="clearfix">';
					echo '<h4>';
					echo '<a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'" rel="author">';
					printf( esc_html__( '%s', 'dynamix' ), get_the_author() );
					echo '</a>';
					echo '</h4>';
					echo '<span class="vcard author">';
					echo '<span class="fn">';
					echo '<p>'. get_the_author_meta( 'description' ) .'</p>';
					echo '</span>';
					echo '</span>';
					echo '</section><!-- #author-description -->';
					echo '</div>';
					echo '</div>';

				endif;				

				// Share Post
				$share_post = ( acoda_settings("share_post") == 'bottom' || acoda_settings("share_post") == 'both' ? 'enable' : '' );
			
				if( $share_post == 'enable' && is_single() )
				{
					echo '<div class="blog-social-icons">';
					//echo '<div class="heading-font">'. esc_html__('Share This','dynamix') .'</div>';					
					echo acoda_share_post();
					echo '</div>';
				}

				// related posts
				$tags = wp_get_post_tags($post->ID);

				if( !empty($tags) ) 
				{ 
					$tag_ids = array();
					foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

					$args = array(
						'tag__in' => $tag_ids,
						'post__not_in' => array( $post->ID ),
						'posts_per_page' => 6, // Number of related posts that will be shown.
						'ignore_sticky_posts' => 1,
						'orderby'=>'rand' // Randomize the posts
					);

					// Related Posts
					$related_posts = $dynamix_options['related_posts'];

					$related_query = new wp_query( $args );	

					if( $related_query->found_posts > 0 && $related_posts == true )
					{
						echo "\n". '<div id="related_posts" class="row">';
						echo "\n". '<section class="columns large-12">';


						if( $related_query->have_posts() ) 
						{
							echo '<div class="heading-font">'.esc_html__('Related Posts','dynamix').'</div>';
							echo "\n". '<ul class="clearfix">';

							while( $related_query->have_posts() )
							{
								$related_query->the_post();
								
								$category = get_the_category();

								$category_id	= $category[0]->cat_ID;
								$category_link 	= get_category_link( $category_id );								
								$category_name 	= $category[0]->cat_name;

								echo "\n". '<li class="columns large-4">';
								echo "\n". '<div class="related_post_wrap clearfix">';
								echo "\n". '<div class="related-post-img">';
								echo "\n". '<a href="'. esc_url( get_the_permalink() ) .'" rel="bookmark" title="'. esc_attr( get_the_title() ) .'">';
								the_post_thumbnail(  'medium' , 'related-posts' );
								echo "\n". '</a>';     
								echo "\n". '<div class="related-post-cat"><a href="'. esc_url( $category_link ) .'">'. esc_attr( $category_name ) .'</a></div>';
								echo "\n". '</div>';  
								echo "\n". '<h4><a href="'. esc_url( get_the_permalink() ) .'" class="recent-posts-title" rel="bookmark" title="'. esc_attr( get_the_title() ) .'">'. get_the_title() .'</a></h4>';
								echo "\n". '</div>';
								echo "\n". '</li>';
							}

							echo "\n". '</ul>';
						} 

						echo "\n". '</section>';
						echo "\n". '</div>';
					}
				}

				echo '<div class="nextprevious_posts clearfix">';

					next_post_link('<span class="alignright">%link &rarr;</span>'); 

					if(  get_post_type() == 'portfolio' &&  acoda_settings('portfoliopagelink') != false )
					{
						if( acoda_settings('portfoliopage' ) != '' )
						{
							$url 	= get_permalink( acoda_settings('portfoliopage' ) );
							$title 	= get_the_title( acoda_settings('portfoliopage' ) );
						}
						else
						{
							$url 	= get_post_type_archive_link( 'portfolio' );	
							$title 	= '';
						}

						echo '<span class="portfolio-link"><a title="'. esc_attr( $title ) .'" href="'. esc_url( $url ) .'"><i class="fas fa-th"></i></a></span>';
					}		

					previous_post_link('<span class="alignleft">&larr; %link</span>');
				echo '</div>';			

			echo '</section>';
			echo '</footer>';		
		}
	}
	


	if ( ! function_exists( 'acoda_dockicon_search' ) ) 
	{
		function acoda_dockicon_search()
		{
			$dock_icons = '';
			$dock_icons .= "\n\t\t". '<form method="get" id="panelsearchform" class="disabled" action="'. esc_url( home_url( '/' ) ) .'">';
			$dock_icons .= "\n\t\t". '<input type="text" placeholder="'.  acoda_settings('search_placeholder') .'"  name="s" id="drops" />';

			if( acoda_settings('woocomsearch') == true )
			{
				$dock_icons .= "\n\t\t". '<input type="hidden" name="post_type" value="product">';
			}

			$dock_icons .= "\n\t\t". '<i class="fal fa-search" id="panelsearchsubmit"></i>';
			$dock_icons .= "\n\t\t". '</form>';

			return $dock_icons;
		}	
	}
	
	// Auto-excerpt 
	if ( ! function_exists( 'acoda_max_character_excerpt' ) ) 
	{
		function acoda_max_character_excerpt( $charlength, $excerpt )
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

			return $output;
		}	
	}
	

	// Acoda Share Posts
	if( ! function_exists('acoda_share_post') )
	{
		function acoda_share_post()
		{
			$output = '';
			$output .= '<div class="acoda_share_post display ">';
			$output .= '<ul>';
			$output .= '<li class="facebook"><a href="http://www.facebook.com/sharer.php?u='. esc_url( get_the_permalink() ) .'&amp;t='. esc_html( get_the_title() ) .'&amp;popup=yes" target="_blank" rel="nofollow"><i class="fab fa-facebook-f"></i><span class="text">'. esc_html__('Share on Facebook','dynamix') .'</span></a></li>';
			$output .= '<li class="twitter"><a href="http://twitter.com/share?text='. esc_html( get_the_title() ) .'&amp;url='. esc_url( get_the_permalink() ) .'&amp;popup=yes"  class="lightbox" target="_blank" rel="nofollow"><i class="fab fa-twitter"></i><span class="text">'. esc_html__('Share on Twitter','dynamix') .'</span></a></li>';
			$output .= '<li class="google"><a href="https://plus.google.com/share?url='. esc_html( get_the_permalink() ) .'&amp;popup=yes" rel="nofollow"><i class="fab fa-google-plus-g"></i></a></li>';	
			$output .= '<li class="pinterest"><a href="http://pinterest.com/pin/create/link/?url='. esc_html( get_the_permalink() ) .'" rel="nofollow"><i class="fab fa-pinterest-p"></i></a></li>';	
			$output .= '</ul>';
			$output .= '</div>';
		
			return $output;
		}
	}

	// Add Attach Media Fields
	if ( ! function_exists( 'acoda_attach_media_fields' ) ) 
	{
		function acoda_attach_media_fields( $form_fields, $post ) {

			$form_fields['media-tags'] = array(
				'label' => esc_html__( 'Tags', 'dynamix' ),
				'input' => 'text',
				'helps' => esc_html__( 'Comma Separated Tags.', 'dynamix' ),
				'value' => get_post_meta( $post->ID, '_'. ACODA_THEME_PREFIX .'_media-tags', true ),
			);	

			$form_fields['gallery-link-url'] = array(
				'label' => esc_html__( 'Link URL', 'dynamix' ),
				'input' => 'text',
				'value' => get_post_meta( $post->ID, '_'. ACODA_THEME_PREFIX .'_gallery-link-url', true ),
			);

			$form_fields['gallery-video-url'] = array(
				'label' => esc_html__( 'Media URL', 'dynamix' ),
				'input' => 'text',
				'value' => get_post_meta( $post->ID, '_'. ACODA_THEME_PREFIX .'_gallery-video-url', true ),
			);

			// select options: you could code these manually or get it from a database
			$embed_options = array(
				"" => "No Embed",
				"oembed" => "oEmbed",
				"youtube" => "YouTube",
			);

			// get the current value of our custom field
			$current_embed_value = get_post_meta($post->ID, '_'. ACODA_THEME_PREFIX .'_media-embed', true);

			// build the html for our select box
			$media_embed_Html = "<select name='attachments[". esc_attr($post->ID) ."][media-embed]' id='attachments-". esc_attr($post->ID) ."-media-embed'>";

			foreach($embed_options as $value => $text){

				// if this value is the current_value we'll mark it selected
				$selected = ($current_embed_value == $value) ? ' selected ' : '';

				// escape value	for single quotes so they won't break the html
				$value = addcslashes( $value, "'");

				$media_embed_Html .= "<option value='". esc_attr( $value ) ."' ". esc_attr($selected) .">{$text}</option>";
			}
			$media_embed_Html .= "</select>";

			// add our custom select box to the form_fields
			$form_fields["media-embed"]["label"] = esc_html__("Media Embed", 'dynamix');
			$form_fields["media-embed"]["input"] = "html";
			$form_fields["media-embed"]["html"]  = $media_embed_Html;	

			// select options: you could code these manually or get it from a database
			$ratio_options = array(
				"" => "16:9",
				"four_by_three" => "4:3",
				"normal" => "1:1",
			);

			// get the current value of our custom field
			$current_ratio_value = get_post_meta($post->ID, '_'. ACODA_THEME_PREFIX .'_media-ratio', true);

			// build the html for our select box
			$media_ratio_Html = "<select name='attachments[". esc_attr($post->ID) ."][media-ratio]' id='attachments-". esc_attr($post->ID) ."-media-ratio'>";

			foreach($ratio_options as $value => $text){

				// if this value is the current_value we'll mark it selected
				$selected = ($current_ratio_value == $value) ? ' selected ' : '';

				// escape value	for single quotes so they won't break the html
				$value = addcslashes( $value, "'");

				$media_ratio_Html .= "<option value='". esc_attr( $value ) ."' ". esc_attr($selected) .">{$text}</option>";
			}
			$media_ratio_Html .= "</select>";

			// add our custom select box to the form_fields
			$form_fields["media-ratio"]["label"] = esc_html__("Media Ratio", 'dynamix');
			$form_fields["media-ratio"]["input"] = "html";
			$form_fields["media-ratio"]["html"]  = $media_ratio_Html;				


			$form_fields['gallery-slide-timeout'] = array(
				'label' => esc_html__( 'Timeout ( s )', 'dynamix' ),
				'input' => 'text',
				'value' => get_post_meta( $post->ID, '_'. ACODA_THEME_PREFIX .'_gallery-slide-timeout', true ),
			);	

			$form_fields['gallery-slide-classes'] = array(
				'label' => esc_html__( 'CSS Classes', 'dynamix' ),
				'input' => 'text',
				'value' => get_post_meta( $post->ID, '_'. ACODA_THEME_PREFIX .'_gallery-slide-classes', true ),
			);				

			return $form_fields;
		}
	}
	
	
	add_filter( 'attachment_fields_to_edit', 'acoda_attach_media_fields', 10, 2 );		

	if ( ! function_exists( 'acoda_media_fields_save' ) ) 
	{
		function acoda_media_fields_save( $post, $attachment ) {

			if( isset( $attachment['media-tags'] ) )
			{
				update_post_meta( $post['ID'], '_'. ACODA_THEME_PREFIX .'_media-tags', $attachment['media-tags'] );
			}
			if( isset( $attachment['gallery-link-url'] ) )
			{
				update_post_meta( $post['ID'], '_'. ACODA_THEME_PREFIX .'_gallery-link-url', $attachment['gallery-link-url'] );
			}
			if( isset( $attachment['gallery-video-url'] ) )
			{
				update_post_meta( $post['ID'], '_'. ACODA_THEME_PREFIX .'_gallery-video-url', $attachment['gallery-video-url'] );		
			}
			if( isset( $attachment['media-embed'] ) )
			{
				update_post_meta( $post['ID'], '_'. ACODA_THEME_PREFIX .'_media-embed', $attachment['media-embed'] );		
			}	
			if( isset( $attachment['media-ratio'] ) )
			{
				update_post_meta( $post['ID'], '_'. ACODA_THEME_PREFIX .'_media-ratio', $attachment['media-ratio'] );		
			}				
			if( isset( $attachment['gallery-slide-timeout'] ) )
			{
				update_post_meta( $post['ID'], '_'. ACODA_THEME_PREFIX .'_gallery-slide-timeout', $attachment['gallery-slide-timeout'] );		
			}
			if( isset( $attachment['gallery-slide-classes'] ) )
			{
				update_post_meta( $post['ID'], '_'. ACODA_THEME_PREFIX .'_gallery-slide-classes', $attachment['gallery-slide-classes'] );							
			}
			return $post;
		}
	}
	
	add_filter( 'attachment_fields_to_save', 'acoda_media_fields_save', 10, 2 );
	

	if ( ! function_exists( 'acoda_get_embed' ) ) 
	{
		function acoda_get_embed( $height, $width, $media_url )
		{
			global $wp_embed;
			$embed = $wp_embed->run_shortcode( '[embed '. $height .' '. $width .' ]'. esc_url( $media_url ) .'[/embed]' );	// height & width escaped below
			return $embed;
		}
	}
	
	// Post Media
	if ( ! function_exists( 'acoda_featured_media' ) ) 
	{
		function acoda_featured_media( $atts )
		{
			extract( $atts );

			$acoda_videotype = $type;
			$acoda_movieurl = $link;
			$acoda_videoautoplay = $autoplay;
			$output = '';

			include(get_template_directory() .'/lib/inc/classes/video-class.php');		

			return $output;
		}
	}

	// Post Image
	if ( ! function_exists( 'acoda_featured_image' ) ) 
	{
		function acoda_featured_image( $atts )
		{
			extract( $atts );

			$img_id = preg_replace( '/[^\d]/', '', $image );

			// Full Image URL
			$img_full_src = wp_get_attachment_image_src( $img_id, 'full');
			$img_full_src = $img_full_src[0];				

			if( function_exists( 'wpb_getImageBySize' ) )
			{
				$img = wpb_getImageBySize( array(
					'attach_id' => $img_id,
					'thumb_size' => $img_size,
					'class' => 'vc_single_image-img'
				) );
			}
			else
			{
				$img_resize = wp_get_attachment_image_src( $img_id, $img_size );
				$img['thumbnail'] = '<img src="'. esc_url( $img_resize[0] ) .'" />';
			}

			// Lightbox
			$link_output = '';

			if( $lightbox == "enable" || !empty( $link ) )
			{							
				// Split Icon Space
				$split = '';

				if( $lightbox == "enable" && !empty( $link ) ) $split = 'split';

				// Set Link + Lightbox
				if( $lightbox == "enable" )
				{ 
					$lightbox_type = $lightbox_url = '';

					if( !empty($media_url) )
					{
						$lightbox_url = $media_url;
						$lightbox_type = 'fal fa-play';
					}
					else
					{
						$lightbox_url = $img_full_src;
						$lightbox_type = 'fal fa-expand';
					}

					$link_output .= '<a href="'. esc_url( $lightbox_url ) .'" class="lightbox action-icons lightbox-icon '. esc_attr( $split ) .'"><i class="'. esc_attr( $lightbox_type ) .'"></i></a>';
				}

				if( !empty( $link ) )
				{ 
					$link_output .= '<a href="'. esc_url( $link ) .'" class="action-icons link-icon '. esc_attr( $split ) .'" target="'. esc_attr( $img_link_target ) .'" ><i class="fal fa-plus"></i></a>';
				}
			}			

			$output = '';
			$output .= '<div class="wpb_single_image wpb_content_element vc_align_' . esc_attr( $alignment ) . ' blog_image">';
			$output .= '<div class="wpb_wrapper vc_single_image-wrapper '. esc_attr( $style ) . '">';

			$output .= '<div class="container">';
			$output .= '<div class="gridimg-wrap">';
			$output .= '<div class="img">';		

			$output .= $img['thumbnail'];

			if( !empty( $lightbox ) || !empty( $link ) )
			{
				$output .= $link_output;
			}	

			$output .= '</div>';
			$output .= '</div>'; 
			$output .= '</div>';

			$output .= '</div>'; 
			$output .= '</div>'; 

			return $output;
		}
	}

	

	// Get Post Category Function
	if ( ! function_exists( 'acoda_data_source' ) ) 
	{
		function acoda_data_source($data_type, $type = '')
		{
			$arr = array();

			if( $data_type == 'data-2' ) // Post Categories
			{
				$arr = get_categories();
			}
			elseif( $data_type == 'data-2-formats' ) // Post Formats
			{
				$post_formats = get_theme_support( 'post-formats' );
				$arr = $post_formats[0];
				array_unshift($arr, "Select Filter");
			}
			/*elseif( $data_type == 'data-4' ) // Slide Sets
			{
				$args = array(
					'numberposts' => -1,
					'post_type' => 'slide-sets',
					'post_status' => 'publish'
				);

				$arr = get_posts ( $args );
			}	*/	

			// Set the options array
			if( is_array( $arr ) )
			{
				foreach ( $arr as $val )
				{		
					if( $data_type == 'data-2' )
					{
						if( $type == 'shortcode' )
						{
							$options_array[htmlspecialchars($val->cat_name)] = $val->cat_name;
						}
						else
						{
							$options_array[htmlspecialchars($val->term_id)] = $val->cat_name;
						}
					}		
					elseif( $data_type == 'data-2-formats' )
					{
						if( $type == 'shortcode' )
						{	
							if( $val == 'Select Filter' )
							{
								$options_array[htmlspecialchars($val)] = '';
							}
							else
							{
								$options_array[htmlspecialchars($val)] = $val;
							}
						}
						elseif( $type == 'blog' )
						{	
							if( $val != 'Select Filter' )
							{
								$options_array[htmlspecialchars($val)] = $val;
							}
						}					
						else
						{				
							if( $val == 'Select Filter' )
							{
								$options_array[] = array(
									'name' => $val,
									'value' => ''
								);					
							}
							else
							{
								$options_array[] = array(
									'name' => $val,
									'value' => $val
								);
							}
						}
					}						
					elseif( $data_type == 'data-4' )
					{
						if( $type == 'shortcode' )
						{				
							$options_array[htmlspecialchars($val->post_title)] = $val->post_title;
						}
						else
						{
							$options_array[htmlspecialchars($val->ID)] = $val->post_title;
						}					
					}					
					else
					{
						$options_array[htmlspecialchars($val->name)] = $val->name;
					}
				}
			}

			if( empty($options_array) ) $options_array[''] = 'No Data Found';

			return $options_array;
		}
	}


	if ( ! function_exists( 'acoda_social_icon_data' ) ) 
	{
		// Social Icons Data
		function acoda_social_icon_data( $socialicon )
		{
			if( $socialicon == 'digg' )
			{
				return 'http://www.digg.com/submit?phase=2&amp;url=[get_permalink]&amp;title=[get_the_title]';
			}
			else if( $socialicon == 'facebook' || $socialicon == 'facebook-square' )
			{
				return 'http://www.facebook.com/sharer.php?u=[get_permalink]&amp;t=[get_the_title]&amp;popup=yes';
			}
			else if( $socialicon == 'linkedin' || $socialicon == 'linkedin-square' )
			{
				return 'http://www.linkedin.com/shareArticle?mini=true&url=[get_permalink]&title=[get_the_title]&source=[get_blogurl]';
			}	
			else if( $socialicon == 'pinterest' || $socialicon == 'pinterest-square' )
			{
				return 'http://pinterest.com/pin/create/link/?url=[get_permalink]';
			}				
			else if( $socialicon == 'delicious' )
			{
				return 'http://del.icio.us/post?url=[get_permalink]&amp;title=[get_the_title]';
			}
			else if( $socialicon == 'reddit' || $socialicon == 'reddit-square' )
			{
				return 'http://www.reddit.com/submit?url=[get_permalink]';
			}
			else if( $socialicon == 'stumbleupon' || $socialicon == 'stumbleupon-circle' )
			{
				return 'http://www.stumbleupon.com/submit?url=[get_permalink]&amp;title=[get_the_title]';
			}	
			else if( $socialicon == 'twitter' || $socialicon == 'twitter-square' )
			{
				return 'http://twitter.com/share?text=[get_the_title]&amp;url=[get_permalink]&amp;popup=yes';
			}	
			else if( $socialicon == 'google-plus' || $socialicon == 'google-plus-square' )
			{
				return 'https://plus.google.com/share?url=[get_permalink]&amp;popup=yes';
			}
			else if( $socialicon == 'vk' )
			{
				return 'http://vk.com/share.php?url=[get_permalink]&amp;popup=yes';
			}	
			else if( $socialicon == 'xing' || $socialicon == 'xing-square' )
			{
				return 'https://www.xing.com/spi/shares/new?url=[get_permalink]&amp;popup=yes';
			}	
			else
			{
				return '';	
			}
		}
	}

	/* ------------------------------------
	:: POST FIRST IMAGE DETECTION
	------------------------------------ */

	if ( ! function_exists( 'acoda_catch_image' ) ) 
	{	
		function acoda_catch_image()
		{ 
			if( acoda_settings('firstimage_detect') == 'enable' )
			{
				global $post, $posts;
				$first_img = $short_img = $shrtmatches = $matches = '';
				ob_start();
				ob_end_clean();
				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
				$shrtoutput = preg_match_all('/imageeffect.+url=[\'"]([^\'"]+)[\'"].*/i', $post->post_content, $shrtmatches); // Check shortcode image

				$short_img = ( !empty( $shrtmatches [1] [0] ) ) ? $shrtmatches [1] [0] : '';
				$first_img = ( !empty( $matches [1] [0] ) ) ? $matches [1] [0] : '';

				if( $short_img )
				{
					return $short_img;
				} 
				else
				{
					return $first_img;  
				}
			}
			else
			{
				return;	
			}
		}	
	}

	/* ------------------------------------
	:: GET ATTACHMENT BY URL
	------------------------------------ */	

	if ( ! function_exists( 'acoda_attachment_by_url' ) ) 
	{	
		function acoda_attachment_by_url( $attachment_url )
		{ 
			global $wpdb;
			$attachment_id = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment_url )); 
			
			$attachment = '';
			
			if( !empty( $attachment_id ) )
			{
				$attachment = wp_get_attachment_image_src( $attachment_id[0], 'full' );
			}
			
        	return $attachment; 
		}	
	}



	/* ------------------------------------
	:: GET ATTACHMENT IMAGE / RESIZE
	------------------------------------ */	

	if ( ! function_exists( 'acoda_getImageBySize' ) ) 
	{
		function acoda_getImageBySize( $params = array( 'post_id' => NULL, 'attach_id' => NULL, 'thumb_size' => 'thumbnail', 'class' => '' ) )
		{
			if ( ( ! isset( $params['attach_id'] ) || $params['attach_id'] == NULL ) && ( ! isset( $params['post_id'] ) || $params['post_id'] == NULL ) ) return;
			$post_id = isset( $params['post_id'] ) ? $params['post_id'] : 0;

			$attach_id = ( !empty( $post_id ) ? get_post_thumbnail_id( $post_id ) : $params['attach_id'] );

			$thumb_size = $params['thumb_size'];
			$thumb_class = ( isset( $params['class'] ) && $params['class'] != '' ) ? $params['class'] . ' ' : '';

			global $_wp_additional_image_sizes;

			$thumbnail = $height = $width = $max_width = $max_height = $src = '';

			if ( is_string( $thumb_size ) && ( ( ! empty( $_wp_additional_image_sizes[$thumb_size] ) && is_array( $_wp_additional_image_sizes[$thumb_size] ) ) || in_array( $thumb_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) )
			{
				global $_wp_additional_image_sizes;

				$sizes = array();
				$get_intermediate_image_sizes = get_intermediate_image_sizes();

				// Create the full array with sizes and crop info
				foreach( $get_intermediate_image_sizes as $_size )
				{
					if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) )
					{
						$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
						$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
						$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
					}
					elseif( isset( $_wp_additional_image_sizes[ $_size ] ) )
					{
						$sizes[ $_size ] = array( 
							'width' => $_wp_additional_image_sizes[ $_size ]['width'],
							'height' => $_wp_additional_image_sizes[ $_size ]['height'],
							'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
						);
					}
				}

				if( $attach_id != 'no_image' )
				{			
					$img_url_array	= wp_get_attachment_image_src( $attach_id, $thumb_size );			
					$img_url 		= $img_url_array[0];
					$img_full_src 	= wp_get_attachment_image_src( $attach_id, 'full' );
					$alt 			= trim( strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );


					$width 	= $img_url_array[1];
					$height	= $img_url_array[2];
					$src	= $img_url_array[0];
					
					$srcset = wp_get_attachment_image_srcset( $attach_id, $thumb_size );

					$thumbnail = '<img src="'. esc_url( $src ) .'" srcset="'. esc_attr( $srcset ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'" alt="'. esc_attr( $alt ) .'" />';	
				}			
				else
				{
					$img_url = get_template_directory_uri() .'/images/no_image.jpg';
					$img_full_src = get_template_directory_uri() .'/images/no_image.jpg';	
					$alt = esc_html__('No Image','dynamix');	

					$src = $img_url;

					$thumbnail = '<img src="'. esc_url( $img_url ) .'"  width="'. esc_attr( $sizes[$thumb_size]['width'] ) .'" height="'. esc_attr( $sizes[$thumb_size]['height'] ) .'" alt="'. esc_attr( $alt ) .'" />';	
				}
			} 
			elseif ( $attach_id )
			{
				if ( is_string( $thumb_size ) )
				{
					preg_match_all( '/\d+/', $thumb_size, $thumb_matches );
					if ( isset( $thumb_matches[0] ) )
					{
						$thumb_size = array();
						if ( count( $thumb_matches[0] ) > 1 ) 
						{
							$thumb_size[] = $thumb_matches[0][0]; // width
							$thumb_size[] = $thumb_matches[0][1]; // height
						} 
						elseif ( count( $thumb_matches[0] ) > 0 && count( $thumb_matches[0] ) < 2 )
						{
							$thumb_size[] = $thumb_matches[0][0]; // width
							$thumb_size[] = $thumb_matches[0][0]; // height
						}
						else
						{
							$thumb_size = false;
						}
					}			
				}

				if( $thumb_size != false )
				{
					$max_width	 = $thumb_size[0];
					$max_height = $thumb_size[1];
				}

				if ( is_array( $thumb_size ) ) 
				{

					// Resize image to custom size
					if( $attach_id == 'no_image' )
					{
						$img_url	= $img_full_src[0] = get_template_directory_uri() .'/images/no_image.jpg';
						$p_img		= wpb_resize( null, $img_url, $thumb_size[0], $thumb_size[1], true );
						$alt 		= esc_html__('No Image','dynamix');
					}
					else
					{
						$p_img = wpb_resize( $attach_id, null, $thumb_size[0], $thumb_size[1], true );

						$img_full_src 	= wp_get_attachment_image_src( $attach_id, 'full' );

						$alt = trim( strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );

						if ( empty( $alt ) )
						{
							$attachment = get_post( $attach_id );
							$alt = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
						}
						if ( empty( $alt ) )
						{
							$alt = trim( strip_tags( $attachment->post_title ) ); // Finally, use the title
						}					
					}


					if ( $p_img )
					{
						$img_class = '';

						$width = $p_img['width'];
						$height = $p_img['height'];
						$src = $p_img['url'];
						

						$srcset = wp_get_attachment_image_srcset( $attach_id, $thumb_size );
					

						$thumbnail = '<img class="' . esc_attr( $thumb_class ) . '" src="' . esc_url( $p_img['url'] ) . '" srcset="'. esc_attr( $srcset ) .'" width="' . esc_attr( $p_img['width'] ) . '" height="' . esc_attr( $p_img['height'] ) . '" alt="' . esc_attr( $alt ) . '" />';
					}
				}
			}

			return array( 'thumbnail' => $thumbnail, 'src' => $src, 'img_full_src' => $img_full_src[0], 'width' => $width, 'height' => $height, 'max_width' => $max_width, 'max_height' => $max_height );

		}		
	}

	/* ------------------------------------
	:: GET ATTACHMENT DATA
	------------------------------------ */	
	
	if ( ! function_exists( 'acoda_attachment_data' ) ) 
	{
		function acoda_attachment_data( $attachment_id )
		{		
			$attachment = get_post( $attachment_id );
			
			if( !empty( $attachment ) )
			{	
				return array(
					'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
					'caption' => $attachment->post_excerpt,
					'description' => $attachment->post_content,
					'href' => get_permalink( $attachment->ID ),
					'src' => $attachment->guid,
					'title' => $attachment->post_title
				);
			}
		}	
	}


	/* ------------------------------------
	:: POST FORMAT GALLERY
	------------------------------------ */	

	if ( ! function_exists( 'acoda_switch_gallery' ) ) 
	{
		function acoda_switch_gallery( $content, $position )
		{
			//search for the first av gallery or gallery shortcode
			preg_match("!\[(?:postgallery)?gallery.+?\]!", $content, $match_gallery);

			if( !empty($match_gallery) )
			{
				$gallery = $match_gallery[0];

				if(strpos( $gallery, 'postgallery' ) === false && strpos( $gallery, "ids" ) !== false )
				{
					$gallery = str_replace("gallery", 'postgallery_image id="stage_'. esc_attr( get_the_id() ) .'" timeout="10"  content_type="image" img_size="large" lightbox="yes" navigation="enabled" data_source="data-9" ', $gallery);
					$gallery = str_replace("ids", 'images_attach', $gallery);

					$convert = true;
				}

				if( $position == 'header' )
				{
					$content = $gallery;
				}
				else
				{
					$content = str_replace($match_gallery[0], '' , $content);	
				}
			}
			elseif( empty($match_gallery) && $position == 'header' )
			{
				$content = '';
			}

			return $content;
		}
	}

	if ( ! function_exists( 'acoda_getTaxonomies' ) ) 
	{
		function acoda_getTaxonomies() {
			$taxonomy_exclude = (array)apply_filters( 'get_categories_taxonomy', 'category');
			$taxonomy_exclude[] =  'post_tag';
			$taxonomies = array();

			foreach(get_taxonomies() as $taxonomy)
			{
				if(!in_array($taxonomy, $taxonomy_exclude)) $taxonomies[] = $taxonomy;
			}
			return $taxonomies;
		}
	}

	/* ------------------------------------
	:: AJAX DATA
	------------------------------------ */	

	if ( ! function_exists( 'acoda_ajaxdata' ) ) 
	{
		function acoda_ajaxdata()
		{
		   global $dynamix_options,
				  $post;
			
		   $data_contents = $data_source = $type = '';


			$type 			= ( !empty( $_POST['type'] ) ? $_POST['type'] : '' );
			$data_source 	= ( !empty( $_POST['source'] ) ? $_POST['source'] : '' );
			$query 			= ( !empty( $_POST['query'] ) ? $_POST['query'] : '' );
			$data_offset 	= ( !empty( $_POST['data_offset'] ) ? $_POST['data_offset'] : '' );
			$load_value 	= ( !empty( $_POST['load_value'] ) ? $_POST['load_value'] : '' );
			$postlayout 	= ( !empty( $_POST['postlayout'] ) ? $_POST['postlayout'] : '' );
			$grid_columns 	= ( !empty( $_POST['grid_columns'] ) ? $_POST['grid_columns'] : '' );
			$config 		= ( !empty( $_POST['attributes'] ) ? $_POST['attributes'] : '' );
			$attributes 	= explode('|', $config);

			foreach( $attributes as $attribute )
			{
				if( !empty( $attribute ) )
				{
					list($key, $value) = explode(":", $attribute);
					$config_attributes[$key] = $value;
				}
			}

			$acoda_postlayout			= acoda_settings('arhpostdisplay');
			$acoda_archive_img_align	= acoda_settings('archive_img_align');
			$acoda_archive_img_size		= acoda_settings('archive_img_size');
			$acoda_archive_img_effect	= acoda_settings('archive_img_effect');		
			

			// Configuration Options
			$acoda_gridcolumns 		 = $grid_columns;
			$acoda_slidercolumns 	 = $load_value;
			$acoda_groupgridcontent  = ( !empty( $config_attributes['content'] ) ? $config_attributes['content'] : '' );	
			$img_size 				 = ( !empty( $config_attributes['img_size'] ) ? $config_attributes['img_size'] : '' );			
			$acoda_lightbox 		 = ( !empty( $config_attributes['lightbox'] ) ? $config_attributes['lightbox'] : '' );	
			$acoda_imageeffect 		 = ( !empty( $config_attributes['imageeffect'] ) ? $config_attributes['imageeffect'] : '' );
			$hover_effect 			 = ( !empty( $config_attributes['hover_effect'] ) ? $config_attributes['hover_effect'] : '' );		
			$img_align				 = ( !empty( $config_attributes['imagealign'] ) ? $config_attributes['imagealign'] : '' );
			$title_size				 = ( !empty( $config_attributes['title_size'] ) ? $config_attributes['title_size'] : '' );
			$acoda_shortcode_id		 = ( !empty( $config_attributes['gallery_id'] ) ? $config_attributes['gallery_id'] : '' );
			$product_price			 = ( !empty( $config_attributes['product_price'] ) ? $config_attributes['product_price'] : '' );



			if( $data_source == 'blog' || $data_source == 'date' || $data_source == 'author' || $data_source == 'tag' || $data_source == 'search' )
			{
				global	$acoda_archive_img_size,
						$acoda_archive_img_effect,
						$acoda_archive_img_align;	

				$acoda_archive_img_effect = $acoda_imageeffect;
				$acoda_archive_img_size = $img_size;
				$acoda_archive_img_align = $img_align;	

				if( !empty( $query ) && $data_source == 'blog' )
				{
					$args = array( 'post_type' => 'post', 'cat' => $query, 'offset' => $data_offset, 'posts_per_page' => get_option('posts_per_page') );			
				}
				elseif( !empty( $query ) && $data_source == 'search' )
				{
					$args = array( 's' => $query, 'offset' => $data_offset, 'posts_per_page' => get_option('posts_per_page') );
				}
				elseif( !empty( $query ) && $data_source == 'author' )
				{
					$args = array( 'post_type' => 'post', 'author' => $query, 'offset' => $data_offset, 'posts_per_page' => get_option('posts_per_page') );
				}	
				elseif( !empty( $query ) && $data_source == 'date' )
				{
					$attributes = explode( '|', $query );

					foreach( $attributes as $attribute )
					{
						list($key, $value) = explode(":", $attribute);
						$date_query[$key] = $value;
					}

					$args = array('post_type' => 'post', 'date_query' => $date_query, 'offset' => $data_offset, 'posts_per_page' => get_option('posts_per_page') );
				}	
				elseif( !empty( $query ) && $data_source == 'tag' )
				{							
					$args = array( 'post_type' => 'post', 'tag_id' => $query, 'offset' => $data_offset, 'posts_per_page' => get_option('posts_per_page') );
				}									
				else
				{
					$categories = get_terms( 'category' );				

					foreach( $categories as $category )
					{
					  $query .= $category->term_id .',';
					}

					$query = rtrim( $query , ',' );
					$args = array(  'post_type' => 'post', 'offset' => $data_offset, 'posts_per_page' => get_option('posts_per_page'), 'ignore_sticky_posts' => false, 'post_status' => 'publish' );
				}
				
				Redux::init( 'dynamix_options' );

				$category_posts = new WP_Query($args);

				if( $category_posts->have_posts() ) : 
					while($category_posts->have_posts()) : $category_posts->the_post();
				
						$do_not_duplicate = $post->ID; //This is the magic line

						$data_contents .= '<div class="columns large-'. ( $postlayout == 'grid' ? esc_attr( 12 / $grid_columns .' grid_layout' ) : 12 )  .' acoda-animate-in '.  esc_attr( $data_source ). ' panel ">';

						ob_start();

						// Post Featured Image
						acoda_post_image( $acoda_archive_img_size );	

						echo '<div class="blog-content-wrap">';
					
						// Post Title
						acoda_post_title();		

						// Post Metadata 
						acoda_post_metadata();		

						// Post Content		
						acoda_post_content();				

						echo '</div>';			
				
						$data_contents .= ob_get_contents();
						ob_end_clean();

						$data_contents .= '</div>';

					endwhile;
				endif;         
			}

			if( $data_source == 'data-4' )
			{
				$slide_sets = explode( ",", $query );

				foreach ( $slide_sets as $slide_set )
				{ 		
					$name = get_page_by_title( $slide_set, 'OBJECT', "slide-sets" );
					$slide_id = $name->ID;
					$slide_name = $slide_set;		

					$sorted_slidesets[$slide_name] = $slide_id;
				}

				ksort( $sorted_slidesets );
				$slide_sets 		= $sorted_slidesets;
				$slide_set_array 	= array();
				$postcount 		= 0;

				foreach( $slide_sets as $slide_set )
				{		
					$slide_xml = get_post_meta( $slide_set, 'slide_manager_xml', true );
					$slide_data = new DOMDocument();
					$slide_data->loadXML( $slide_xml );
					$slide_set = $slide_data->documentElement;

					foreach( $slide_set->childNodes as $slide )
					{						
						// Get Attached / Post Image Data
						$img = acoda_getImageBySize( array( 'attach_id' => acoda_find_xml_value( $slide, 'image' ), 'thumb_size' => $img_size ) );

						// Get Image Meta Data Attachment ID
						$attachment_meta = acoda_attachment_data( acoda_find_xml_value( $slide, 'image' ) );

						$slide_set_array[$slidecount]['img']				= $img;
						$slide_set_array[$slidecount]['img_url'] 		= ( !empty( $img['src'] ) ? $img['src'] : acoda_find_xml_value( $slide, 'image_url' ) );
						$slide_set_array[$slidecount]['media_url'] 		= acoda_find_xml_value( $slide, 'media_url' );
						$slide_set_array[$slidecount]['embed_type'] 	= acoda_find_xml_value( $slide, 'embed_type' );
						$slide_set_array[$slidecount]['autoplay'] 		= acoda_find_xml_value( $slide, 'autoplay' );
						$slide_set_array[$slidecount]['title'] 			= ( acoda_find_xml_value( $slide, 'title' ) !='' ) ? acoda_find_xml_value( $slide, 'title' ) : $attachment_meta['title'];
						$slide_set_array[$slidecount]['description']	= ( acoda_find_xml_value( $slide, 'description' ) !='' ) ? acoda_find_xml_value( $slide, 'description' ) : $attachment_meta['description'];
						$slide_set_array[$slidecount]['link_url']		= acoda_find_xml_value( $slide, 'link_url' );
						$slide_set_array[$slidecount]['css_classes']	= acoda_find_xml_value( $slide, 'css_classes' );
						$slide_set_array[$slidecount]['readmore_link']	= acoda_find_xml_value( $slide, 'readmore_link' );
						$slide_set_array[$slidecount]['timeout'] 		= acoda_find_xml_value( $slide, 'timeout' );
						$slide_set_array[$slidecount]['filter_tags'] 	= acoda_find_xml_value( $slide, 'filter_tags' ); 

						$slidecount++;
					}
				}

				$slide_set_array = array_slice( $slide_set_array, $data_offset, $load_value );			

				foreach( $slide_set_array as $slide_set )
				{
					$acoda_disablegallink=
					$acoda_movieurl=
					$acoda_previewimgurl=
					$acoda_cssclasses=
					$acoda_altlink=
					$acoda_videotype=
					$acoda_videoautoplay=
					$acoda_posttitle=
					$acoda_description=
					$acoda_slidetimeout=
					$img = '';

					$img 						= $slide_set['img'];
					$acoda_previewimgurl		= $slide_set['img_url'];
					$acoda_movieurl 			= $slide_set['media_url'];
					$acoda_videotype 			= $slide_set['embed_type'];
					$acoda_videoautoplay 		= $slide_set['autoplay'];		
					$acoda_posttitle 			= $slide_set['title'];
					$acoda_description 		= $slide_set['description'];
					$acoda_altlink 			= $slide_set['link_url'];
					$acoda_cssclasses 			= $slide_set['css_classes'];
					$acoda_slidetimeout 		= $slide_set['timeout'];
					$tags_array		 		= $slide_set['filter_tags']; 

					$acoda_disablegallink	= ( empty( $acoda_altlink ) ? 'yes' : '');
					$acoda_videoautoplay 		= ( $acoda_videoautoplay == 'on' ) ? '1' : '0';

					// Assign unique video ID
					$video_id = $postcount + $data_id;			

					$postcount++;
					$data_id++;

					$output 			= '';
					$acoda_show_slider= $type;

					if(	$acoda_show_slider == 'stageslider' || $acoda_show_slider == 'carousel' )
					{
						require( get_template_directory() .'/lib/inc/stage-gallery-frame.php' ); // STAGE
					}
					elseif( $acoda_show_slider == 'gridgallery' )
					{
						require( get_template_directory() .'/lib/inc/grid-gallery-frame.php' ); // GRID
					}
					elseif( $acoda_show_slider == 'groupslider' )
					{
						require( get_template_directory() .'/lib/inc/group-gallery-frame.php' ); // GROUP SLIDER
					}

					$data_contents .= $output;					
				}
			}	

			if( $data_source == 'data-9' )
			{	
				$images_ids = empty( $query ) ? array() : explode( ',', trim( $query ) );

				$count = count( $images_ids );
				$postcount = 0;

				$images_ids = array_slice( $images_ids, $data_offset, $load_value );

				// Slide Set ID Array Check
				foreach( $images_ids as $img_id )
				{
					$acoda_disablegallink=
					$acoda_movieurl=
					$acoda_previewimgurl=
					$acoda_cssclasses=
					$acoda_altlink=
					$acoda_videotype=
					$acoda_videoautoplay=
					$acoda_posttitle=
					$acoda_description=
					$acoda_slidetimeout = 
					$img = 
					$img_full_src =
					$ratio = '';

					// Get Attached / Post Image Data
					$img = acoda_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size ) );

					// Get Image Meta Data Attachment ID
					$attachment_meta = acoda_attachment_data( $img_id, 'image' );

					$acoda_movieurl			= get_post_meta( $img_id, 'gallery-video-url', true );
					$acoda_posttitle		= $attachment_meta['title'];
					$acoda_description		= $attachment_meta['description'];		
					$acoda_altlink			= get_post_meta( $img_id, 'gallery-link-url', true );
					$acoda_disablegallink 	= ( empty( $acoda_altlink ) ) ? 'yes' : '';
					$acoda_slidetimeout		= get_post_meta( $img_id, 'gallery-slide-timeout', true );
					$acoda_cssclasses		= get_post_meta( $img_id, 'gallery-slide-classes', true );
					$tags_array				= get_post_meta( $img_id, 'media-tags', true );		
					$acoda_videotype		= get_post_meta( $img_id, 'media-embed', true );	
					$ratio					= get_post_meta( $img_id, 'media-ratio', true );		

					// Assign unique video ID
					$video_id = $img_id + $data_id;	

					$postcount++;	

					/* ------------------------------------
					:: GET SLIDER FRAME
					------------------------------------ */			

					$output = '';

					$acoda_show_slider = $type;

					if(	$acoda_show_slider == 'stageslider' || $acoda_show_slider == 'carousel' )
					{
						require( get_template_directory() .'/lib/inc/stage-gallery-frame.php' ); // STAGE
					}
					elseif( $acoda_show_slider == 'gridgallery' )
					{
						require( get_template_directory() .'/lib/inc/grid-gallery-frame.php' ); // GRID
					}
					elseif( $acoda_show_slider == 'groupslider' )
					{
						require( get_template_directory() .'/lib/inc/group-gallery-frame.php' ); // GROUP SLIDER
					}	

					$data_contents .= $output;	

				}			
			}				

			if( $data_source == 'data-10' )
			{		
				$data = $taxonomy_tags 	= array();
				$values_pairs 				= preg_split('/\|/', $query);
				$postcount 				= 0;

				foreach($values_pairs as $pair) 
				{
					if(!empty($pair)) 
					{
						list($key, $value) = preg_split('/\:/', $pair);

						if( $key == 'categories' ) 
						{
							$key = 'cat';
							$filter_cats = $value;
						}
						if( $key == 'tags' ) 
						{
							$key = 'tag__in';
							$filter_tags = $value;
							$value = explode( ',' , $value );
						}	
						if( $key == 'tax_query' ) 
						{
							$tax = explode( ',' , $value );
							$terms = get_terms(acoda_getTaxonomies(), array('include' => array_map('abs', $tax )));		
							$tax_data = $tax_arrays = array();

							$value = array( 
								'relation' => 'OR'
							);

							foreach ( $terms as $term )
							{
								$tax_data[$term->taxonomy]['terms'][] = $term->term_id;
							}

							foreach ( $tax_data as $tax => $term )
							{
								$tax_array = array(
									'taxonomy' => $tax,
									'field' => 'id',
									'terms' => $term['terms'],
									'operator' => 'IN'
								);

								array_push( $value, $tax_array );
								array_push( $taxonomy_tags, $tax_array );			
							}						
						}	
						if( $key == 'post_type' ) 
						{
							$post_type = $value;
							$value = explode( ',' , $value );
						}												
						if( $key == 'order_by' ) $key = 'orderby';
						if( $key == 'size' ) $key = 'posts_per_page';

						$data[$key] = $value;
					}
				}	

				$data['offset'] = $data_offset;
				$data['posts_per_page'] = $load_value;

				$featured_query = new WP_Query($data);

				$post_count = $featured_query->post_count; // Check how many posts in query.

				while ( $featured_query->have_posts() ) : $featured_query->the_post();

					/* ------------------------------------
					:: GET INDIVIDUAL SLIDE DATA
					------------------------------------ */

					$image = acoda_catch_image(); // Check for images within post

					$img = array();
					$post_id = $featured_query->post->ID;

					// check what image to use, custom, featured, image within post. 
					if( empty( $acoda_previewimgurl ) )
					{  
						$img_id = get_post_thumbnail_id( $post_id );
						if ( !empty($img_id) )
						{	
							// Get Attached / Post Image Data
							$img = acoda_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size ) );
						} 
						else
						{
							$img = acoda_getImageBySize( array( 'attach_id' => 'no_image', 'thumb_size' => $img_size ) );
						}
					}	

					$acoda_movieurl 		= acoda_settings( 'media_url' );	
					$acoda_disablegallink	= acoda_settings( 'post_link' );
					$acoda_displaytitle		= acoda_settings( 'displaytitle' );
					$acoda_postsubtitle 	= acoda_settings( 'pagesubtitle' );	
					$acoda_videotype 		= acoda_settings( 'media_display' );
					$ratio 				 	= 'normal';
					$acoda_videoautoplay	= '1';		
					$acoda_altlink			= ( acoda_settings( 'post_altlink' ) !='' )	? acoda_settings( 'post_altlink' ) : get_permalink();
					$acoda_pagetitle		= ( acoda_settings( 'pagetitle' ) !='' )	? acoda_settings( 'pagetitle' ) : the_title('', '', false);

			

					$acoda_max_characters = 240;

					if ( empty($post->post_excerpt) )
					{

						if( !function_exists('the_advanced_excerpt') )
						{
							$acoda_description = acoda_max_character_excerpt( $acoda_max_characters,  get_the_excerpt() );
						}
						else
						{
							$acoda_description = the_advanced_excerpt('length='.$acoda_galleryexcerpt.'&ellipsis=',true);
						}
					} 
					else
					{
						$acoda_description = get_the_excerpt(); 
					}					


					$acoda_videoautoplay = ( empty( $acoda_videoautoplay ) ) ? '0' : '1';

					$postcount++;


					/* ------------------------------------
					:: FILTER CATEGORIES
					------------------------------------ */		

					$categories = ''; 

					if( !empty( $taxonomy_tags ) )
					{				
						foreach( $taxonomy_tags as $tax_id )
						{			
							$terms = $tax_id['terms'];
							$term_slug = '';


							$term_name = '';
							$term_name = wp_get_post_terms( get_the_ID(), $tax_id['taxonomy'] );

							if( !empty( $term_name ) )
							{
								foreach( $term_name as $term )
								{
									$term_slug = $term->name;

									$categories .= str_replace( ' ', '', $term_slug ) . $acoda_shortcode_id .' ';
									$categories = preg_replace( "/&#?[a-z0-9]+;/i", '', $categories );			
								}
							}

						}	
					}				


					// Product Price
					if( !empty( $product_price ) && class_exists( 'woocommerce' ) )
					{
						$_product = wc_get_product( get_the_ID() );
						$acoda_product_price = get_woocommerce_currency_symbol() . $_product->get_regular_price();
					}			

					// Post Author
					if( !empty( $post_author ) )
					{
						$author_id			= get_post_field( 'post_author', get_the_ID() );
						$author_name		= get_the_author_meta( 'display_name', $author_id );
						$author_url			= get_author_posts_url( $author_id );
						$acoda_post_author 	= '<a href="'. $author_url .'" class="post_author metadata">'. get_avatar( $author, 40 ). '<span>' . esc_html__('By ','dynamix') . $author_name .'</span></a>';
					}	

					// Post Date
					if( !empty( $post_date ) )
					{
						$meta_date_format = ( acoda_settings( 'meta_date_format_single' ) != '' ? acoda_settings( 'meta_date_format_single' ) : 'd F Y' );
						$acoda_post_date  =  '<span class="date metadata">'. get_the_time( $meta_date_format ) .'</span>';
					}						


					/* ------------------------------------
					:: GET SLIDER FRAME
					------------------------------------ */			

					$output = '';

					$acoda_show_slider = $type;

					if(	$acoda_show_slider == 'stageslider' || $acoda_show_slider == 'carousel' )
					{
						require( get_template_directory() .'/lib/inc/stage-gallery-frame.php' ); // STAGE
					}
					elseif( $acoda_show_slider == 'gridgallery' )
					{
						require( get_template_directory() .'/lib/inc/grid-gallery-frame.php' ); // GRID
					}
					elseif( $acoda_show_slider == 'groupslider' )
					{
						require( get_template_directory() .'/lib/inc/group-gallery-frame.php' ); // GROUP SLIDER
					}						

					$data_contents .= $output;		

				endwhile;	
			}
			
			wp_reset_postdata();

		   die($data_contents);
		}	
	}
	
	add_action( 'wp_ajax_nopriv_acoda_ajaxdata', 'acoda_ajaxdata' );
	add_action( 'wp_ajax_acoda_ajaxdata', 'acoda_ajaxdata' );	

	/* ------------------------------------
	:: FRIENDLY PAGE TITLE
	------------------------------------ */

	if ( ! function_exists( 'acoda_wp_title' ) ) 
	{
		function acoda_wp_title( $title, $sep ) {
			global $paged, $page;

			if ( is_feed() )
				return $title;

			// Add the site name.
			$title .= get_bloginfo( 'name' );

			// Add the site description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				$title = "$title $sep $site_description";

			// Add a page number if necessary.
			if ( $paged >= 2 || $page >= 2 )
				$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'dynamix' ), max( $paged, $page ) );

			return $title;
		}
	}

	add_filter( 'wp_title', 'acoda_wp_title', 10, 2 );

	/* ------------------------------------
	:: CATEGORY TITLE
	------------------------------------ */

	if ( ! function_exists( 'acoda_category_title' ) ) 
	{
		function acoda_category_title( $title )
		{
			if( is_category() ) 
			{
				$title = single_cat_title( '', false );
			}

			return $title;		
		}
	}

	add_filter( 'get_the_archive_title', 'acoda_category_title');
	
	/* ------------------------------------
	:: MENU DROPDOWN ICON
	------------------------------------ */	

	if ( ! function_exists( 'acoda_set_dropdown' ) ) 
	{
		function acoda_set_dropdown( $sorted_menu_items, $args )
		{
			$last_top = 0;
			foreach ( $sorted_menu_items as $key => $obj )
			{
				// it is a top lv item?
				if ( 0 == $obj->menu_item_parent )
				{
					// set the key of the parent
					$last_top = $key;
				}
				else
				{
					$sorted_menu_items[$last_top]->classes['dropdown'] = 'hasdropmenu';
				}
			}

			return $sorted_menu_items;
		}
	}

	add_filter( 'wp_nav_menu_objects', 'acoda_set_dropdown', 10, 2 );

	class acoda_walker extends Walker_Nav_Menu {
			
		function start_lvl( &$output, $depth=0,  $args=array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu skinset-submenu acoda-skin\">\n";
		}
	
		
		function start_el( &$output, $item, $depth=0, $args=array(), $current_object_id=0 ) {
			global $wp_query;
	
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
			$class_names = $value = '';
	
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
	
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="' . esc_attr( $class_names ) . '"';	

			$output .= $indent . '<li ' . $value . $class_names .'>';		
		
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= '<span class="menutitle">'.$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after.'</span>';
			$item_output .= '</a>';	
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	} 


	if ( ! function_exists( 'acoda_replace_chars' ) ) 
	{
		function acoda_replace_chars($string) {
			$transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');

			return strtr( $string, $transliterationTable );	
		}	
	}


	/* ------------------------------------
	:: ADMIN.CSS + ACTIVATION
	------------------------------------ */
	
	
	if ( ! function_exists( 'acoda_theme_activate' ) ) 
	{	
		function acoda_theme_activate() 
		{
			if( current_user_can('edit_theme_options') )
			{
				header( 'Location: '.admin_url().'themes.php?page=dynamix_options');
			}
		}	
	}

	add_action('after_switch_theme', 'acoda_theme_activate');


	
	
	// Percent to Pixels Value
	if ( ! function_exists( 'acoda_percent_to_pixels' ) ) 
	{	
		function acoda_percent_to_pixels( $percent, $value = 1220 ) 
		{
			return intval( ( intval( $percent ) * $value ) / 100 );
		}
	}

	if ( ! function_exists( 'acoda_ems_to_pixels' ) ) 
	{	
		function acoda_ems_to_pixels( $ems, $value ) 
		{
			$ems = filter_var( $ems, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

			return intval( $ems * $value );
		}	
	}