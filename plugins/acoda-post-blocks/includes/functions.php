<?php

	function apb_max_character_excerpt( $charlength, $excerpt )
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
	
	function apb_ajaxdata()
	{
		global $is_widget;

		$query 		 = ( !empty( $_POST['query'] ) ? $_POST['query'] : '' );
		$filter	 	 = ( !empty( $_POST['filter'] ) ? $_POST['filter'] : '' );
		$layout		 = ( !empty( $_POST['type'] ) ? $_POST['type'] : '' );
		$attributes  = ( !empty( $_POST['attributes'] ) ? $_POST['attributes'] : '' );
		$ajax_action = ( !empty( $_POST['ajax_action'] ) ? $_POST['ajax_action'] : '' );

		$args = json_decode(stripslashes($query), true);
		$attributes = json_decode(stripslashes($attributes), true);
		

		if( $ajax_action == 'next' )
		{
			$offset 		= $args['offset'];
			$posts_per_page = $args['posts_per_page'];

			$args['offset'] = $post_offset = $offset + $posts_per_page;
		}

		if( $ajax_action == 'prev' )
		{
			$offset 		= $args['offset'];
			$posts_per_page = $args['posts_per_page'];

			if( $offset != 0 )
			{
				$args['offset'] = $post_offset = $offset - $posts_per_page;
			}
		}	
		
		if( $ajax_action == 'category' && !empty( $filter ) )
		{
			$args['category__in'] = array( $filter );
			$args['offset'] = 0;
		}			
		

		$apb_query = new WP_Query($args);
		
		$found_posts = $apb_query->found_posts;
		$post_count = $apb_query->post_count;

		// Define Vars
		//$layout = $attributes['layout'];
		$show_cats = $attributes['show_cats'];
		$title_tag = 'div';	
		$show_date = $attributes['show_date'];
		$date_format = $attributes['date_format'];
		$show_author = $attributes['show_author'];
		$show_comments = $attributes['show_comments'];
		$excerpt_length = $attributes['excerpt_length'];
		$show_readmore = $attributes['show_readmore'];

		$pagination_type = 'click_load';
		
		$output = '';
		
		$args = json_encode($args);
		
		switch ($layout) 
		{
			case "block_1":
				include 'includes/block_1.php';
				break;
			case "block_2":
				include 'includes/block_2.php';
				break;
			default:
				include 'includes/block_1.php';
		}	
		
		$results = array(
			 'output' => $output,
			 'query' => $args,
			 'found_posts' => $found_posts,
			 'post_count' => $post_count,
			 'post_offset' => $post_offset,
			 'posts_per_page' => $posts_per_page,
		);
		
		//echo $output;
		
		echo json_encode($results, true);
		
		die();

	}

	add_action( 'wp_ajax_nopriv_apb_ajaxdata', 'apb_ajaxdata' );
	add_action( 'wp_ajax_apb_ajaxdata', 'apb_ajaxdata' );