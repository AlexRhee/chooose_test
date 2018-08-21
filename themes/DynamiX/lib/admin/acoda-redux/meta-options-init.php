<?php

	/* Page / Post Options */

	if ( !function_exists( "redux_add_metaboxes" ) ):

		$opt_name = "dynamix_options";

		function redux_add_metaboxes()
		{
			
			$pageLayoutSection =  $pageSections = $postLayoutSection = $portfolioLayoutSection = $boxSections = $postSections = $metaboxes = $portfolioSection = $siteLayoutSection = array();

			$boxSections[] = array(
				'title' => __('Site Layout', 'dynamix'),
				'icon' => 'fal fa-browser',
				'fields' => array(  			
					array(
						'id'       => 'site_layout',
						'type'     => 'button_set',
						'title'    => __('Site Layout', 'dynamix'), 
						'subtitle'     => __('Choose between Wide or Boxed Layout.', 'dynamix'),
						'options' => array(
							'wide' => esc_html__('Wide', 'dynamix'),
							'boxed' => esc_html__('Boxed', 'dynamix'),
						),
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
					),				
				)
			);


			$pageLayoutSection[] = array(
				'title' => __('Page Layout', 'dynamix'),
				'icon' => 'fal fa-window-maximize fa-rotate-90',
				'fields' => array(  													
					array(
						'title'     => __( 'Page Layout', 'dynamix' ),
						'id'        => 'pagelayout',
						'type'      => 'image_select',		
						'customizer'=> array(),
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
						'default' => '',
					),
					array(
						'id' => 'max_page_width',
						'type' => 'text',
						'title' => __('Maximum Page Width', 'dynamix'),
						'subtitle' => __('Set the maximum Page Content width. Default is the "Site Width" value.', 'dynamix'),
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
						'default'  => '',
						'required' => array( 
							array('pagelayout','equals',array( 'layout_two','layout_four' ) ), 
						)		
					),	
					array(
						'id'       => 'pagesticksidebar',
						'type'     => 'switch',
						'title'    => __('Sticky Sidebar', 'dynamix'), 
						'subtitle'     => __('Make the Sidebar Sticky when scrolling down the page.', 'dynamix'),
						'default'  => '',	
					),		
					array(
						'id'       => 'sidebarone',
						'type'     => 'select',
						'title'    => __('Column One Sidebar', 'dynamix'), 
						'data' => 'sidebars',				
					),	
					array(
						'id'       => 'sidebartwo',
						'type'     => 'select',
						'title'    => __('Column Two Sidebar', 'dynamix'), 
						'data' => 'sidebars',					
					),		
					array(
						'id'   => 'singlepage_info',
						'type' => 'info',
						'title' => __('Single Page', 'dynamix')
					),	
					array(
						'id'       => 'anchorlink_nav',
						'type'     => 'switch',
						'title'    => __('Single Page Navigation', 'dynamix'), 
						'subtitle'     => __('Display navigation dots on the page.', 'dynamix'),
						'default'  => '',	
					),				
				)
			);

			$postLayoutSection[] = array(
				'title' => __('Post Layout', 'dynamix'),
				'icon' => 'fal fa-window-maximize fa-rotate-90',
				'fields' => array(  		
					array(
						'title'     => __( 'Post Layout', 'dynamix' ),
						'id'        => 'postlayout',
						'type'      => 'image_select',		
						'customizer'=> array(),
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
						'required' => array( 
							array('postlayout','equals',array( 'layout_two','layout_four' ) ), 
						)		
					),	
					array(
						'id'       => 'poststicksidebar',
						'type'     => 'switch',
						'title'    => __('Sticky Sidebar', 'dynamix'), 
						'subtitle'     => __('Make the Sidebar Sticky when scrolling down the page.', 'dynamix'),	
					),		
					array(
						'id'       => 'postcolone',
						'type'     => 'select',
						'title'    => __('Column One Sidebar', 'dynamix'), 
						'data' => 'sidebars',				
					),	
					array(
						'id'       => 'postcoltwo',
						'type'     => 'select',
						'title'    => __('Column Two Sidebar', 'dynamix'), 
						'data' => 'sidebars',					
					),		
					array(
						'id'       => 'related_posts',
						'type'     => 'switch',
						'title'    => __('Display Related Posts', 'dynamix'), 
						'subtitle'     => __('Display Related Posts for this Post.', 'dynamix'),
					),		
					array(
						'id'       => 'blogpostimage',
						'type'     => 'select',
						'title'    => __('Display Featured Image', 'dynamix'), 
						'subtitle' => __('Choose where to display the Featured Image.', 'dynamix'),
						'options' => array (
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),						
				)
			);	

			$portfolioLayoutSection[] = array(
				'title' => __('Post Layout', 'dynamix'),
				'icon' => 'fal fa-window-maximize fa-rotate-90',
				'fields' => array(  				
					array(
						'title'     => __( 'Post Layout', 'dynamix' ),
						'id'        => 'portlayout',
						'type'      => 'image_select',		
						'customizer'=> array(),
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
					),
					array(
						'id'       => 'portcolone',
						'type'     => 'select',
						'title'    => __('Column One Sidebar', 'dynamix'), 
						'data' => 'sidebars',				
					),	
					array(
						'id'       => 'portcoltwo',
						'type'     => 'select',
						'title'    => __('Column Two Sidebar', 'dynamix'), 
						'data' => 'sidebars',					
					),			
					array(
						'id'       => 'related_posts',
						'type'     => 'button_set',
						'title'    => __('Display Related Posts', 'dynamix'), 
						'subtitle'     => __('Display Related Posts for this Post.', 'dynamix'),
						'options' => array(
							1 => esc_html__('On', 'dynamix'),
							0 => esc_html__('Off', 'dynamix'),
						),
					),		
					array(
						'id'       => 'blogpostimage',
						'type'     => 'select',
						'title'    => __('Display Featured Image', 'dynamix'), 
						'subtitle' => __('Choose where to display the Featured Image.', 'dynamix'),
						'options' => array (
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),						
				)
			);	

			$boxSections[] = array(
				'title' => __('Header', 'dynamix'),
				'icon' => 'fal fa-window-maximize',
				'fields' => array(  
					array(
						'id'       => 'header_layout',
						'type'     => 'button_set',
						'title'    => __('Display Header', 'dynamix'), 
						'options' => array(
							'top' => esc_html__('Top', 'dynamix'),
							'left' => esc_html__('Left', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
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
						'required' => array( 
							array('header_layout','equals','top'), 
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
						'required' => array( 
							array('header_style','equals','inline'), 
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
						'required' => array( 
							array('header_layout','equals','top'), 
						)			
					),
					array(
						'id' => 'header_width_value',
						'type' => 'text',
						'title' => __('Header Width', 'dynamix'),
						'subtitle' => __('Set the Header Width. Enter any valid CSS unit, e.g. 200px.', 'dynamix'),
						'required' => array( 
							array('header_layout','!=','top'), 
						)		
					),		
					array(
						'id'       => 'sticky_menu',
						'type'     => 'switch',
						'title'    => __('Sticky Header', 'dynamix'), 
						'subtitle'     => __('Set the Header to stick to the top, when scrolling down the page.', 'dynamix'),
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
					),									                                  
				),
			);	

			$boxSections[] = array(
				'title' => __('Logo', 'dynamix'),
				'icon' => 'fal fa-leaf',
				'fields' => array(  
					array(
						'id'       => 'branding_display',
						'type'     => 'switch',
						'title'    => __('Display Logo', 'dynamix'), 
						'subtitle'     => __('Display Logo in Header.', 'dynamix'),
					),				
				),
			);	

			$boxSections[] = array(
				'title' => __('Menu', 'dynamix'),
				'icon' => 'fal fa-bars',
				'fields' => array(  
					array(
						'id'       => 'displaymenu',
						'type'     => 'switch',
						'title'    => __('Display Menu', 'dynamix'), 
						'default'  => true,
					),	
					array(
						'id'       => 'menu_position',
						'type'     => 'button_set',
						'title'    => __('Menu Position', 'dynamix'), 
						'subtitle'     => __('Set the menu to display Inline or as an Icon in the Dock Bar.', 'dynamix'),
						'options' => array(
							'inline' => esc_html__('Inline', 'dynamix'),
							'dockbar' => esc_html__('Dock Bar Widget', 'dynamix'),
						),
						'required' => array( 
							array('displaymenu','equals',true), 
						)					
					),				
					array(
						'id'       => 'menu',
						'type'     => 'select',
						'title'    => __('Menu', 'dynamix'), 
						'subtitle' => __('Select a menu for this page.', 'dynamix'),		
						'data' => 'menus',
						'required' => array( 
							array('displaymenu','equals',true), 
						)		
					),		

				),
			);	

			$boxSections[] = array(
				'title' => __('Title Area', 'dynamix'),
				'icon' => 'fal fa-h1',
				'fields' => array(  
					array(
						'id'       => 'displaytitle',
						'type'     => 'switch',
						'title'    => __('Display Title', 'dynamix'), 
						'default'  => true,
					),	       
					array(
						'id' => 'pagetitle',
						'type' => 'text',
						'title' => __('Alternative Title', 'dynamix'),
						'subtitle' => __('Enter an alternative title to override the page / post title.', 'dynamix'),
					),
					array(
						'id' => 'pagesubtitle',
						'type' => 'text',
						'title' => __('Sub Title', 'dynamix'),
						'subtitle' => __('Enter an sub title to appear below the main title.', 'dynamix'),
					),	
					array(
						'id'       => 'title_layout',
						'type'     => 'image_select',
						'title'    => __('Title & Breadcrumb Alignment', 'dynamix'), 
						'subtitle'     => __('Set the Page Title & Breadcrumb Alignment.', 'dynamix'),	
						'options'  => array(
							'layout_1'      => array(
								'alt'   => 'Inline', 
								'img'   => get_template_directory_uri() . '/lib/admin/assets/images/title-left.png'
							),
							'layout_3'      => array(
								'alt'   => 'Stacked', 
								'img'   => get_template_directory_uri() . '/lib/admin/assets/images/title-center.png'
							),					
							'layout_2'      => array(
								'alt'   => '3 Column Middle', 
								'img'   => get_template_directory_uri() . '/lib/admin/assets/images/title-right.png'
							),
						),
					),				
					array(
						'id'       => 'breadcrumb',
						'type'     => 'switch',
						'title'    => __('Breadcrumbs Display', 'dynamix'), 
						'subtitle'     => __('Choose to display Breadcrumbs on this Post.', 'dynamix'),
					),											                                  
				),
			);

			$boxSections[] = array(
				'title' => __('Footer', 'dynamix'),
				'icon' => 'fal fa-window-maximize fa-rotate-180',
				'fields' => array(  
					array(
						'id'       => 'mainfooter',
						'type'     => 'switch',
						'title'    => __('Footer Display', 'dynamix'), 
						'subtitle'     => __('Choose to Show or Hide the Footer.', 'dynamix'),
					),									                                  
				),
			);		

			$boxSections[] = array(
				'title' => __('Social', 'dynamix'),
				'icon' => 'fal fa-share-alt',
				'fields' => array(  
					array(
						'id'       => 'display_socialicons',
						'type'     => 'switch',
						'title'    => __('Display Social Icons', 'dynamix'), 
						'subtitle'     => __('Enabling this option will display the selected icons below.', 'dynamix'),
					),	
					array(
						'id'       => 'socialicons_share',
						'type'     => 'switch',
						'title'    => __('Share Icon', 'dynamix'), 
						'subtitle'     => __('Enabling this option will contain all social icons selected within one "Share Icon".', 'dynamix'),
					),							                                  
				),
			);	

			$skin_ids = explode(',', rtrim( get_option('skins_'. get_option('acoda_theme') .'_ids'), ',' ) );

			$skin_id_array = array();

			foreach( $skin_ids as $skin_id )
			{
				$skin_id_array[$skin_id] = $skin_id;
			}	

			$pageSections[] = array(
				'title' => __('Page Skin', 'dynamix'),
				'icon' => 'fal fa-paint-brush',
				'desc' => __('Choose an alternative Theme Skin for this page only.', 'dynamix'),
				'fields' => array(  
					array(
						'id'       => 'theme_skin',
						'type'     => 'select',
						'title'    => __('Page Skin', 'dynamix'), 
						'options'  => $skin_id_array
					),								                                  
				),
			);						

			$pageSections[] = array(
				'title' => __('Blog Template', 'dynamix'),
				'icon' => 'fal fa-newspaper',
				'fields' => array(  
					array(
						'id'       => 'blogheader',
						'type'     => 'switch',
						'title'    => __('Blog Header', 'dynamix'), 
						'subtitle'     => __('Enables a Grid Header of the top posts.', 'dynamix'),
						'default'  => false,		
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
					),		
					array(
						'id' => 'ajax_num_posts',
						'type' => 'text',
						'title' => __('Posts Per Load', 'dynamix'),
						'placeholder' => get_option('posts_per_page'),
						'subtitle' => __('Enter the number of posts to load per ajax request.', 'dynamix'),
					),	
					array(
						'id'       => 'blogcategories',
						'type'     => 'checkbox',
						'title'    => __('Select Categories', 'dynamix'), 
						'subtitle' => __('Select which categories to display on this page.', 'dynamix'),
						'data' => 'categories'
					),	
					array(
						'id'       => 'postformats',
						'type'     => 'checkbox',
						'title'    => __('Exclude Post Formats', 'dynamix'), 
						'subtitle' => __('Select which Post Formats to exclude on this page.', 'dynamix'),
						'options' => array(
							'aside' =>  esc_html__('Aside', 'dynamix'),
							'link' => esc_html__('Link', 'dynamix'),
							'status' => esc_html__('Status', 'dynamix'),
							'quote' => esc_html__('Quote', 'dynamix'),
							'image' => esc_html__('Image', 'dynamix'),
							'video' => esc_html__('Video', 'dynamix'),
							'audio' => esc_html__('Audio', 'dynamix'),
							'gallery' => esc_html__('Gallery', 'dynamix')
						)
					),
					array(
						'id'       => 'meta_align',
						'type'     => 'button_set',
						'title'    => __('Metadata Alignment', 'dynamix'), 
						'options' => array(
							'left' => esc_html__('Left', 'dynamix'),
							'center' => esc_html__('Center', 'dynamix'),
							'right' => esc_html__('Right', 'dynamix'),
						),
					),				
					array(
						'id'   => 'blogimages_info',
						'type' => 'info',
						'title' => __('Blog Page Images', 'dynamix')
					),	
					array(
						'id'       => 'archive_img_align',
						'type'     => 'button_set',
						'title'    => __('Image Alignment', 'dynamix'), 
						'options' => array(
							'left' => esc_html__('Left', 'dynamix'),
							'center' => esc_html__('Center', 'dynamix'),
							'right' => esc_html__('Right', 'dynamix')
						),
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
					),					
					array(
						'id' => 'archive_img_size',
						'type' => 'text',
						'title' => __('Image Size', 'dynamix'),
						'description' => __('Enter image size. e.g. "thumbnail", "medium", "large", "full". Alternatively enter image size in pixels: 200x100 (Width x Height).', 'dynamix'),
					),																					                                  
				),
			);	

			$postSections[] = array(
				'title' => __('Multimedia', 'dynamix'),
				'icon' => 'fal fa-film',
				'fields' => array(  
					array(
						'id'       => 'mediaurl',
						'type'     => 'text', 
						'title'    => __('Media URL', 'dynamix'),
					),	
					array(
						'id'       => 'media_display',
						'type'     => 'button_set',
						'title'    => __('Embed Type', 'dynamix'), 
						'subtitle' => __('Choose to display the Media file Embedded or within a Lightbox.', 'dynamix'),
						'options' => array(
							'oembed' => esc_html__('oEmbed', 'dynamix'),
							'lightbox' => esc_html__('Lightbox', 'dynamix'),
						),
						'default'  => 'oembed',		
					),										                                  
				),
			);	

			$postSections[] = array(
				'title' => __('Post Skin', 'dynamix'),
				'desc' => __('Choose an alternative Theme Skin for this post only.', 'dynamix'),
				'icon' => 'fal fa-paint-brush',
				'fields' => array(  
					array(
						'id'       => 'theme_skin',
						'type'     => 'select',
						'title'    => __('Post Skin', 'dynamix'), 
						'options'  => $skin_id_array
					),								                                  
				),
			);			

			$postSections[] = array(
				'title' => __('Metadata', 'dynamix'),
				'desc' => __('Choose how to display Metadata for this post.', 'dynamix'),
				'icon' => 'fal fa-calendar',
				'fields' => array(  	
					array(
						'id'       => 'meta_date',
						'type'     => 'select',
						'title'    => __('Display Date', 'dynamix'), 
						'options' => array(
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),	
					array(
						'id'       => 'meta_author',
						'type'     => 'select',
						'title'    => __('Display Author', 'dynamix'), 
						'options' => array(
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),	
					array(
						'id'       => 'meta_categories',
						'type'     => 'select',
						'title'    => __('Display Categories', 'dynamix'), 
						'options' => array(
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),	
					array(
						'id'       => 'meta_tags',
						'type'     => 'select',
						'title'    => __('Display Tags', 'dynamix'), 
						'options' => array(	
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),	
					array(
						'id'       => 'meta_like',
						'type'     => 'select',
						'title'    => __('Display Like', 'dynamix'), 
						'options' => array(
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),
					array(
						'id'       => 'meta_comments',
						'type'     => 'select',
						'title'    => __('Display Comments', 'dynamix'), 
						'options' => array(
							'singlearchive' => esc_html__('Single & Archive', 'dynamix'),
							'single' => esc_html__('Single', 'dynamix'),
							'archive' => esc_html__('Archive', 'dynamix'),
							'disable' => esc_html__('Disable', 'dynamix'),
						),
					),		
				),
			);		

			$postSections[] = array(
				'title' => __('Extras', 'dynamix'),
				'icon' => 'fal fa-sliders-v-square',
				'fields' => array(  
					array(
						'id'       => 'post_link',
						'type'     => 'switch',
						'title'    => __('Post Link', 'dynamix'), 
						'subtitle'     => __('Choose to enable / disable the post link.', 'dynamix'),
						'default'  => true,
					),			
					array(
						'id' => 'post_altlink',
						'type' => 'text',
						'title' => __('Alternative Link', 'dynamix'),
						'subtitle' => __('Choose to link the post to an alternative URL.', 'dynamix'),
						'required' => array( 
							array('post_link','equals',true), 
						)					
					),	
					array(
						'id' => 'css_classes',
						'type' => 'text',
						'title' => __('CSS Classes', 'dynamix'),
						'subtitle' => __('Apply CSS Classes to this Post.', 'dynamix'),				
					),														                                  
				),
			);		

			$portfolioSection[] = array(
				'fields' => array(  
					array(
						'id'       => 'portfoliopage',
						'type'     => 'select',
						'title'    => __('Parent Portfolio Page', 'dynamix'), 
						'subtitle' => __('Choose the Parent Portfolio Page.', 'dynamix'),
						'data' => 'pages'
					),														                                  
				),
			);	

			// Page Options
			$merge_pageSections = 	array_merge(
				//$siteLayoutSection,
				$pageLayoutSection,
				$boxSections,
				$pageSections
			);

			$metaboxes[] = array(
				'id' => 'page-options',
				'title' => __('Page Options', 'dynamix'),
				'post_types' => array('page'),
				//'page_template' => array('page-test.php'),
				//'post_format' => array('image'),
				'position' => 'normal', // normal, advanced, side
				'priority' => 'high', // high, core, default, low
				//'sidebar' => false, // enable/disable the sidebar in the normal/advanced positions
				'sections' => $merge_pageSections
			);

			// Portfolio Options
			$merge_portfolioSections = array_merge(
				//$siteLayoutSection,
				$portfolioLayoutSection,
				$boxSections,
				$postSections
			);		

			// Post Options
			$merge_postSections = 	array_merge(
				//$siteLayoutSection,
				$postLayoutSection,
				$boxSections,
				$postSections
			);	

			$metaboxes[] = array(
				'id' => 'post-options',
				'title' => __('Post Options', 'dynamix'),
				'post_types' => array('post'),
				//'page_template' => array('page-test.php'),
				//'post_format' => array('image'),
				'position' => 'normal', // normal, advanced, side
				'priority' => 'high', // high, core, default, low
				//'sidebar' => false, // enable/disable the sidebar in the normal/advanced positions
				'sections' => $merge_postSections
			);

			$metaboxes[] = array(
				'id' => 'portfolio-options',
				'title' => __('Portfolio Options', 'dynamix'),
				'post_types' => array('portfolio'),
				//'page_template' => array('page-test.php'),
				//'post_format' => array('image'),
				'position' => 'normal', // normal, advanced, side
				'priority' => 'high', // high, core, default, low
				//'sidebar' => false, // enable/disable the sidebar in the normal/advanced positions
				'sections' => $merge_portfolioSections
			);

			$metaboxes[] = array(
				'id' => 'portfolio-options-side',
				'title' => __('Portfolio Page', 'dynamix'),
				'post_types' => array('portfolio'),
				//'page_template' => array('page-test.php'),
				//'post_format' => array('image'),
				'position' => 'side', // normal, advanced, side
				'priority' => 'high', // high, core, default, low
				//'sidebar' => false, // enable/disable the sidebar in the normal/advanced positions
				'sections' => $portfolioSection
			);			


			return $metaboxes;
		}
		
	add_action('redux/metaboxes/'.$opt_name.'/boxes', 'redux_add_metaboxes');

	endif;