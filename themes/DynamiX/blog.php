<?php
/**
 * @package WordPress
 * @subpackage acoda
*/

/*
Template Name: Blog
*/ 	
	
	get_header();  

	$acoda_layout 			= acoda_settings('page_layout');
	$acoda_gridcols 		= acoda_settings('arhpostcolumns');
	$acoda_postlayout 		= acoda_settings('arhpostdisplay');
	$acoda_layout_style		= '';// acoda_settings('post_layout_style');
	$blog_search			= acoda_settings('blog_search');
	$posts_per_page 		= get_option('posts_per_page');
	$paginate	 			= acoda_settings('blog_pagination');
	$blogcategories			= acoda_settings('blogcategories');
	$postformats			= acoda_settings('postformats');
	$highlight 				= '';
	$blog_header 			= acoda_settings('blogheader');
	

	$acoda_blog_lightbox 		= acoda_settings('blog_lightbox');
	$acoda_archive_img_align	= acoda_settings('archive_img_align');
	$acoda_archive_img_size		= acoda_settings('archive_img_size');
	$acoda_archive_img_effect	= acoda_settings('archive_img_effect');
	
	
	
	$attributes = 'lightbox:'. $acoda_blog_lightbox . '|img_size:'. $acoda_archive_img_size. '|imageeffect:'. $acoda_archive_img_effect. '|imagealign:'. $acoda_archive_img_align;	
	
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
	
	if( $masonry == 'masonry' || $blog_search == 'search_filter'  ) 
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

	$cats = $cat_isnum = '';
		
	// Selected Blog Categories	
	if( !empty($blogcategories) )
	{ 
		// Get category ID Array	
		foreach ($blogcategories as $catlist)
		{ 
			$cats = $cats.",".$catlist;
		}

		if(empty($cats)) $cats='';
			
		$cats = lTrim($cats,',');
		$cat_isnum = str_replace(",","", $cats); // join cats to check if numeric			
	}		

		
				
	// backwards compatible with post id
	if (is_numeric ($cat_isnum))
	{ 
		$cat_type= "cat";
	}
	// if not numeric, use category name
	else
	{
		$cat_type= "category_name";
	}
			
	if( is_home() || is_front_page() )
	{
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
	}
	else
	{
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}

	$loop = new WP_Query ( array(
		'paged' => $paged
	) );
			
	// Filter Post Formats
	$filterformats	= '';
	$offset			= 0;
				
	if( !empty( $postformats ) )
	{
		foreach( $postformats as $format )
		{
			$filterformats[] = 'post-format-'. $format;
		}
	}

	if( $blog_header == true )
	{
		$offset = 5;

		add_action('pre_get_posts', 'acoda_query_offset', 1 );
		function acoda_query_offset(&$query) {

			//First, define your desired offset...
			$offset = 5;

			//Next, determine how many posts per page you want (we'll use WordPress's settings)
			$ppp = get_option('posts_per_page');

			//Next, detect and handle pagination...
			if ( $query->is_paged ) {

				//Manually determine page query offset (offset + current page (minus one) x posts per page)
				$page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );

				//Apply adjust page offset
				$query->set('offset', $page_offset );
			}
			else {

				//This is the first page. Just use the offset...
				$query->set('offset',$offset);
			}
		}	

	
		
		$args = array(
			$cat_type => $cats,
			'paged' => $paged,				
			'tax_query' => array(
				array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => $filterformats,
				'operator' => 'NOT IN'
				)
			),
			'posts_per_page'=> $posts_per_page,
			'offset'     =>  $offset
		);

		$loop = new WP_Query ( $args );

		$max_num_pages = ceil( ( $loop->found_posts - $offset ) / $posts_per_page );

		remove_action('pre_get_posts', 'acoda_query_offset',1 );			
	}
	else
	{
		$args = array(
			$cat_type => $cats,
			'paged' => $paged,				
			'tax_query' => array(
				array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => $filterformats,
				'operator' => 'NOT IN'
				)
			)
		);

		$loop = new WP_Query ( $args );

		$max_num_pages = $loop->max_num_pages;	
	}

	$post_count = $loop->found_posts;


	if( $blog_header == true )
	{	
		echo '<div class="blog_header_wrap">';
		
		echo do_shortcode( '[postgallery_grid data_source="data-10" content_type="titleoverlay_static" title_tag="h3" title_size="small" text_align="left" text_vertical_align="bottom" title_color="#ffffff" text_color="#ffffff" post_date="enable" img_size="1024×768" columns="4" masonry="masonry_style_2" overlay_color="rgba(0,0,0,0.15)" loop="size:5|order_by:date|post_type:post|categories:'. $cats .'"]' );
		
		echo '</div>';
	}
		
	echo "\n\t". '<div id="content" class="columns '. esc_attr( $columns .' '. $acoda_layout .' '. $acoda_layout_style ) .'">';

	if(have_posts()) : the_post(); 
				
		$content = get_the_content(); 
				
		if( $content != '' )
		{                           
			echo "\n\t". '<div class="entry columns large-12">';
			echo "\n\t". do_shortcode($content); // Check if there is content
			echo "\n\t". '</div><!-- /entry -->';             
		} 
				
	endif;

		
	echo "\n\t". '<div id="blog_container" class="acoda-ajax-container row '. ( $blog_search == 'search_filter' ? ' filter search' : '' ) . ( $masonry == 'masonry' ? ' '. esc_attr( $masonry ) : '' ) . ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' ? ' grid' : '' ) .'" data-source="blog" data-load-method="'. esc_attr( $paginate ) .'"  data-query="'. esc_attr( $cats ) .'" data-attributes="'. esc_attr( $attributes ) .'" data-ajaxurl="'. esc_url( admin_url( 'admin-ajax.php' ) ) .'" data-postlayout="'. ( $acoda_postlayout == 'grid' || $acoda_postlayout == 'masonrygrid' ? 'grid' : 'normal' ) .'" data-grid-columns="'. esc_attr( $acoda_gridcols ) .'">';

		if( $blog_search == 'search_filter' )
		{
			echo "\n\t". '<div class="splitter-wrap"><input type="text" class="search-filter" placeholder="'. esc_html__( 'Search Filter', 'dynamix' ) .'"></div>';
		}
		elseif( $blog_search	== 'search' )
		{
			echo "\n\t". '<div class="splitter-wrap"><form method="get" id="searchform" action="'. esc_url( home_url( '/' ) ) .'"><input type="text" class="search-blog" placeholder="'. esc_html__( 'Search', 'dynamix' ) .'" name="s" id="s"><input type="submit" id="searchsubmit" value="&#xf002;" /></form></div>';
		}		
		
		echo "\n\t". '<div class="row dynamic-frame blog '. esc_attr( $highlight ) .' clearfix" '. ( $paginate != 'page_numbers' ? 'data-offset="'. esc_attr( $posts_per_page + $offset ) .'" data-total="'. esc_attr( $post_count ) .'" data-load-value="'. esc_attr( $posts_per_page + $offset ) .'"' : '' ) .'>';

				$count = 1;
				
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
			
				 if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();

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
			
				else :

					echo '<section class="columns large-12">';
			
					if ( is_category() ) { // If this is a category archive
						printf("<h2 class='center'>". esc_html__("Sorry, but there aren't any posts in the %s category yet.", 'dynamix' ) ."</h2>", single_cat_title('',false));
					} else if ( is_date() ) { // If this is a date archive
						echo("<h2>". esc_html__( "Sorry, but there aren't any posts with this date.", 'dynamix' )  ."</h2>");
					} else if ( is_author() ) { // If this is a category archive
						$userdata = get_userdatabylogin(get_query_var('author_name'));
						printf("<h2 class='center'>". esc_html__("Sorry, but there aren't any posts by %s yet.", 'dynamix' ) ."</h2>", $userdata->display_name);
					} else {
						echo("<h2 class='center'>". esc_html__('No posts found.', 'dynamix' ) ."</h2>");
					}

					echo '</section>';
			
				endif;
			
			$postcount = 0; 

			
	echo "\n\t". '</div>';

	// Page Numbers Pagination	
	if( $paginate == 'page_numbers' )
	{
		echo '<nav class="navigation pagination" role="navigation">';
		echo '<h2 class="screen-reader-text">Posts navigation</h2>';
		
		echo paginate_links( array(
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'total'        => $max_num_pages,
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'format'       => '?paged=%#%',
			'show_all'     => false,
			'type'         => 'plain',
			'end_size'     => 2,
			'prev_next'    => true,
			'mid_size' => 10,
			'prev_text'	=> '&laquo;',
			'next_text'	=> '&raquo;',
			'add_args'     => false,
			'add_fragment' => '',
		) );	
		
		echo '</nav>';
	}

	wp_reset_postdata();

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
	
	wp_reset_query();
		
	get_sidebar();  
	get_footer();