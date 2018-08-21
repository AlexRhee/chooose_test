<?php
/**
 * @package WordPress
 * @subpackage acoda
*/

	get_header(); 

	$acoda_layout 			= acoda_settings('page_layout');
	$acoda_gridcols 		= acoda_settings('arhpostcolumns');
	$acoda_postlayout 		= acoda_settings('arhpostdisplay');
	$acoda_layout_style		= '';//acoda_settings('post_layout_style');
	$blog_search			= acoda_settings('blog_search');
	$posts_per_page 		= get_option('posts_per_page');
	$paginate	 			= acoda_settings('blog_pagination');
	$highlight 			= '';

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

	// Search Filter Highlight 
	if( $blog_search == 'search_filter_highlight' )
	{
		$blog_search	= 'search_filter';
		$highlight		= 'highlight';
		wp_enqueue_script( 'jquery-highlight', get_template_directory_uri() . '/js/jquery.highlight.js', array('jquery'), true );		
	}		
	
	$masonry = ( $acoda_postlayout == 'masonrygrid' ? 'masonry' : '' );
	
	if( $masonry == 'masonry' || $blog_search == 'search_filter' ) 
	{
		wp_enqueue_script('jquery-isotope', get_template_directory_uri().'/js/jquery.isotope.min.js', array('jquery'), true);
	}		

	$columns = 'large-8';
		
	$cats = '';	
		
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

	echo "\n\t". '<div id="blog_container" class="acoda-ajax-container row '. ( $blog_search == 'search_filter' ? ' filter search' : '' ) . ( $masonry == 'masonry' ? ' '. esc_attr( $masonry ) : '' ) . ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid'  ? ' grid' : '' ) .'" data-source="blog" data-load-method="'. esc_attr( $paginate ) .'"  data-query="'. esc_attr( $cats ) .'" data-ajaxurl="'. esc_url( admin_url( 'admin-ajax.php' ) ) .'" data-postlayout="'. ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' ? 'grid' : 'normal' ) .'" data-grid-columns="'. esc_attr( $acoda_gridcols ) .'">';
	
	if( $blog_search == 'search_filter' )
	{
		echo "\n\t". '<div class="splitter-wrap"><input type="text" class="search-filter" placeholder="'. esc_html__( 'Search Filter', 'dynamix' ) .'"></div>';
	}
	elseif( $blog_search	== 'search' )
	{
		echo "\n\t". '<div class="splitter-wrap"><form method="get" id="searchform" action="'. esc_url( home_url( '/' ) ) .'"><input type="text" class="search-blog" placeholder="'. esc_attr__( 'Search', 'dynamix' ) .'" name="s" id="s"><input type="submit" id="searchsubmit" value="&#xf002;" /></form></div>';
	}
	
	echo "\n\t". '<div class="row dynamic-frame blog '. esc_attr( $highlight ) .' clearfix" '. ( $paginate != 'page_numbers' ? 'data-offset="'. esc_attr( $posts_per_page ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $posts_per_page ) .'"' : '' ) .'>';			

	if( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' || $blog_search == 'search_filter' )
	{
		if( $masonry != 'masonry' )
		{
			$clear = $acoda_gridcols+1;
			$column_css = '
			.columns.grid_layout:nth-child('. $acoda_gridcols .'n+'. $clear .') {clear: both;}';
							
			wp_enqueue_style( 'acoda-grid-columns',	get_template_directory_uri() . '/dynamic-style.css', false, null );
			wp_add_inline_style( 'acoda-grid-columns', $column_css );	
		}



		if( $masonry == 'masonry' || $blog_search == 'search_filter' )
		{
			if( $acoda_postlayout == 'normal' )
			{
				echo '<div class="blog-sizer columns blog large-12"></div>';
			}
			else
			{
				echo '<div class="blog-sizer columns blog large-'. 12 / esc_attr( $acoda_gridcols ) .'"></div>';
			}
		}						
	}	

	if (have_posts()) :
	
		while (have_posts()) : the_post();

			echo '<div class="columns large-'. ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' ? 12 / esc_attr( $acoda_gridcols ) .' grid_layout' : 12 ) .' acoda-animate-in blog panel">';
					
				// Post Featured Image
				acoda_post_image();	

				echo '<div class="blog-content-wrap">';

				// Post Title
				acoda_post_title();		

				// Post Metadata 
				acoda_post_metadata();		

				// Post Content		
				acoda_post_content();				


				echo '</div>';	
								
			echo '</div>';		
						
		endwhile;
	
	else : ?>
        <section class="columns large-12">
            <?php if ( is_category() ) { // If this is a category archive
                printf("<h2 class='center'>".  esc_html__("Sorry, but there aren't any posts in the %s category yet.", 'dynamix' )."</h2>", single_cat_title('',false));
            } else if ( is_date() ) { // If this is a date archive
                echo("<h2>". esc_html__( "Sorry, but there aren't any posts with this date.", 'dynamix' ) ."</h2>");
            } else if ( is_author() ) { // If this is a category archive
                $userdata = get_userdatabylogin(get_query_var('author_name'));
                printf("<h2 class='center'>". esc_html__("Sorry, but there aren't any posts by %s yet.", 'dynamix' ) ."</h2>", $userdata->display_name);
            } else {
                echo("<h2 class='center'>". esc_html__('No posts found.', 'dynamix' ) ."</h2>");
            } ?>
            
        </section>
	<?php 
	
	endif;

	echo "\n\t". '</div>';

	// Page Numbers Pagination
	if( $paginate == 'page_numbers' )
	{
		the_posts_pagination( 
		array(   
			'mid_size' => 10,
			'prev_text'	=> '&laquo;',
			'next_text'	=> '&raquo;'
			)	
		);
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