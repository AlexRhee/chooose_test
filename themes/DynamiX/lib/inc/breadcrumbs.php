<?php 

if ( ! function_exists( 'acoda_breadcrumbs' ) ) 
{
	function acoda_breadcrumbs() 
	{
	  $before = '<li><span class="subbreak"><i class="fal fa-angle-right"></i></span>';  
	  $current_before = '<li class="current_page_item"><span class="subbreak"><i class="fal fa-angle-right"></i></span><span class="text">';
	  $current_after = '</span></li>';
	  $after = '</li>';

	  if ( !is_home() && !is_front_page() || is_paged() ) {

		global $post;

		echo '<li class="home"><a rel="home" href="'. esc_url( home_url( '/' ) ) .'">'. esc_html__('Home', 'dynamix' ) . '</a></li>';

		if ( is_category() ) {
		  global $wp_query;
		  $cat_obj = $wp_query->get_queried_object();
		  $thisCat = $cat_obj->term_id;
		  $thisCat = get_category($thisCat);
		  $parentCat = get_category($thisCat->parent);
		  if ($thisCat->parent != 0) echo( $before. get_category_parents($parentCat, TRUE, '<span class="subbreak"><i class="fal fa-angle-right"></i></span>') . $after);

		  if($thisCat->parent != 0)
		  {
				echo '<li class="current_page_item"><span class="text">'. single_cat_title(  $prefix = '', $display = false  ) . $current_after;
		  }
		  else
		  {	
				echo '<li class="current_page_item"><span class="subbreak"><i class="fal fa-angle-right"></i></span><span class="text">'. single_cat_title(  $prefix = '', $display = false  ) . $current_after;
		  }


		} elseif ( is_day() ) {
		  echo $before . '<a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a> ' . $after;
		  echo $before . '<a href="' . esc_url( get_month_link(get_the_time('Y'),get_the_time('m')) ) . '">' . get_the_time('F') . '</a> ' . $after;
		  echo $current_before . get_the_time('d') . $current_after;

		} elseif ( is_month() ) {
		  echo $before . '<a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a> ' . $after;
		  echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
		  echo $current_before . get_the_time('Y') . $current_after;

		} elseif ( get_post_type() == 'portfolio' ) { // Post type name

			if( acoda_settings('portfoliopage' ) != '' )
			{
				$url 	= get_permalink( acoda_settings('portfoliopage' ) );
				$title 	= get_the_title( acoda_settings('portfoliopage' ) );

				//echo '<li><span class="subbreak">/</span> <a title="'. esc_attr( $title ) .'" href="'. esc_url( $url ) .'">'. esc_html( $title ) .'</a> </li>';
			}
			else
			{		
				echo get_the_term_list(get_the_ID() , 'portfolio_category', $before, '<span class="subbreak"><i class="fal fa-angle-right"></i></span>', $after ); // New taxonomy
			}

			if( !is_archive() )
			{
				echo $before;
				the_title();
				echo $after;
			}

		} elseif ( is_single() ) {
		  $cat = get_the_category(); if(isset($cat[0])) $cat = $cat[0];
		  $cat_parent = get_category_parents($cat, TRUE, '</li><li><span class="subbreak">/</span>');
		if( !is_object( $cat_parent ) ) {
		  $cat_parent = substr($cat_parent, 0, -40);

		  echo $before . $cat_parent;
		  //echo $current_before;
		  //the_title();
		  //echo $current_after;
		}

		} elseif ( is_page() && !$post->post_parent ) {
		  echo $current_before;
		  the_title();
		  echo $current_after;

		} elseif ( is_page() && $post->post_parent ) {
		  $parent_id  = $post->post_parent;
		  $breadcrumbs = array();
		  while ($parent_id) {
			$page = get_page($parent_id);
		   // $breadcrumbs[] = $before . '<a href="' . esc_url( get_permalink($page->ID) ) . '">' . get_the_title($page->ID) . '</a>' . $after;
			$parent_id  = $page->post_parent;
		  }
		  $breadcrumbs = array_reverse($breadcrumbs);
		  foreach ($breadcrumbs as $crumb) echo $crumb;
		  echo $current_before;
		  the_title();
		  echo $current_after;

		} elseif ( is_search() ) {

			echo $current_before . sprintf(  esc_html__( 'Search results for &#39; %s &#39;', 'dynamix' ), get_search_query() ) . $current_after;

		} elseif ( is_tag() ) {

			echo $current_before . sprintf(  esc_html__( 'Posts Tagged &#39; %s &#39;', 'dynamix' ), single_tag_title( $prefix = '', $display = false ) ) . $current_after;

		} elseif ( is_author() ) {
		  global $author;
		  $userdata = get_userdata($author);

		  echo $current_before . sprintf(  esc_html__( 'Articles posted by &#39; %s &#39;', 'dynamix' ), $userdata->display_name ) . $current_after;


		} elseif ( is_404() ) {

		  echo $current_before . sprintf( esc_html__( 'Error 404', 'dynamix' ) ) . $current_after;

		}

		if ( get_query_var('paged') ) {

		  echo $current_before . sprintf(  esc_html__( 'Page %s', 'dynamix' ), get_query_var('paged') ) . $current_after;

		}
	  }
	}
}