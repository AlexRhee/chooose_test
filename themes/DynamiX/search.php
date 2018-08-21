<?php 

	get_header(); 

	$acoda_layout 			= acoda_settings('page_layout');
	$acoda_gridcols 		= acoda_settings('arhpostcolumns');
	$acoda_postlayout 		= acoda_settings('arhpostdisplay');
	$acoda_layout_style		= acoda_settings('post_layout_style');
	$posts_per_page 		= get_option('posts_per_page');
	$paginate	 			= acoda_settings('blog_pagination');
	$query					= esc_attr( $_GET['s'] );
	$query_type 			= 'search'; 

	$post_count = $wp_query->found_posts;	

	if( $paginate == 'scroll_load' )
	{
		wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), true );
		wp_enqueue_script(	 'acoda-loadposts', get_template_directory_uri() . '/js/load-ajax.js', array( 'jquery' ), true );	
	}
	elseif( $paginate == 'click_load' )
	{
		wp_enqueue_script(	 'acoda-loadposts', get_template_directory_uri() . '/js/load-ajax.js', array( 'jquery' ), true );	
	}
	
	$masonry = ( $acoda_postlayout == 'masonrygrid' || $acoda_postlayout == 'masonrygrid_search' ? 'masonry' : '' );
	
	if( $masonry == 'masonry' ) 
	{
		wp_enqueue_script('jquery-isotope', get_template_directory_uri().'/js/jquery.isotope.min.js',false,array('jquery'),true);
	}	
	 

	$columns = 'large-8';
			
	if( 
	$acoda_layout == "layout_one" || 
	$acoda_layout == "layout_zero" )				: $columns = 'large-12';
	elseif( $acoda_layout == "layout_two" )		: $columns = 'large-8 last';
	elseif( $acoda_layout == "layout_three" ) 	: $columns = 'large-6 last';
	elseif( $acoda_layout == "layout_four" ) 	: $columns = 'large-8';
	elseif( $acoda_layout == "layout_five" )  	: $columns = 'large-6';
	elseif( $acoda_layout == "layout_six" )  	: $columns = 'large-6';
	endif;
		
	echo "\n\t". '<div id="content" class="columns '. esc_attr( $columns .' '. $acoda_layout .' '. $acoda_layout_style ) .'">'; 
		
	echo "\n\t". '<div id="blog_container" class="acoda-ajax-container '. ( $masonry == 'masonry' ? esc_attr( ' '. $masonry ) : '' ) . ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' ? ' grid' : '' ) .'" data-source="'. esc_attr( $query_type ) .'" data-load-method="'. esc_attr( $paginate ) .'"  data-query="'. esc_attr( $query ) .'" data-ajaxurl="'. esc_url( home_url( '/' ) ) .'wp-admin/admin-ajax.php" data-postlayout="'. ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' ? 'grid' : 'normal' ) .'" data-grid-columns="'. esc_attr( $acoda_gridcols ) .'">';
	
	if (have_posts()) : 
	
		echo "\n\t". '<div class="row dynamic-frame clearfix" '. ( $paginate != 'page_numbers' ? 'data-offset="'. esc_attr( $posts_per_page ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $posts_per_page )  .'"' : '' ) .'>';
		
			if( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' || $acoda_postlayout == 'masonrygrid_search' )
			{
				if( $masonry != 'masonry' )
				{
					$clear = $acoda_gridcols+1;
					$column_css = '
					.columns.grid_layout:nth-child('. $acoda_gridcols .'n+'. $clear .') {clear: both;}';
									
					wp_enqueue_style( 'acoda-grid-columns',	get_template_directory_uri() . '/style.css', false, null );
					wp_add_inline_style( 'acoda-grid-columns', $column_css );	
				}
		
				if( $masonry == 'masonry' )
				{
					echo '<div class="grid-sizer columns large-'. 12 / esc_attr( $acoda_gridcols ) .'"></div>';
				}						
			}					
	
			while (have_posts()) : the_post();
		
				echo '<div class="columns large-'. ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' || $acoda_postlayout == 'masonrygrid_search' ? 12 / esc_attr( $acoda_gridcols ) .' grid_layout' : 12 ) .' acoda-animate-in panel">';
							
					get_template_part( 'content', get_post_format());
										
				echo '</div>';		
								
			endwhile;
	
		echo "\n\t". '</div>';

	else :
	
		echo '<h3 class="aligncenter">'. esc_html__('Sorry, no posts found. Try a different search? ', 'dynamix' ) .'</h3>';     
		echo "\n\t". '<div class="splitter-wrap"><form method="get" id="searchform" action="'. esc_url( home_url( '/' ) ) .'"><input type="text" class="search-blog" placeholder="'. esc_attr__( 'Search', 'dynamix' ) .'" name="s" id="s"><button type="submit" id="searchsubmit"><i class="fal fa-search"></i></button></form></div>';
	
	endif;

	// Page Numbers Pagination	
	if( $paginate == 'page_numbers' )
	{
		$total_pages = $wp_query->max_num_pages;
						
		if ($total_pages > 1)
		{	
			$current_page = max(1, get_query_var('paged'));
						  
			echo '<div class="page_nav">';
						  
			echo paginate_links(array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => 'page/%#%',
				'current' => $current_page,
				'total' => $total_pages,
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;'
			));
					
			echo '</div>';
		}		
	}

	if( $paginate != 'page_numbers' )
	{
		echo "\n\t". '<div class="acoda-ajax-loading"></div>';
	}

	if( $paginate == 'click_load' && $post_count > $posts_per_page )
	{
		echo "\n\t". '<div class="button-wrap acoda-ajax-loaddata wpb_regularsize aligncenter"><div class="button link_color vc_btn_rounded inherit"><a>'. esc_html__('Load More', 'dynamix' ) .'</a></div></div>';
	}	
		
	echo "\n\t". '</div>';		

	echo "\n\t\t". '<div class="clear"></div>';
	echo "\n\t". '</div><!-- #content -->';

	get_sidebar(); 
	get_footer();		