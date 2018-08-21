<?php
/**
 * @package WordPress
 * @subpackage acoda  */ 
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<?php 
	echo '<meta name="viewport" content="initial-scale=1.0,width=device-width">';
	echo '<link rel="pingback" href="'. esc_url( get_bloginfo('pingback_url') ) .'" />';		
	
	wp_head(); 
	
	?>
           
</head>
<body <?php body_class(); ?>>

	<?php	
	
	// Get Post ID
	if( is_archive() )
	{
		$url = explode('?', 'http://'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );
		$post_id = ( isset( $_GET['page_id'] ) ? esc_attr( $_GET['page_id'] ) : url_to_postid( esc_url( $url[0] ) ) );			
	}
	else
	{
		$post_id = ( !empty( $post ) && ! is_search() ? $post->ID : '' );
	}
	
	$header_float 		= acoda_settings('header_float'); 	
	$site_layout 		= acoda_settings('site_layout');
	$body_width			= acoda_settings('body_width');
	$header_layout		= 'header_'. acoda_settings('header_layout') .' ';
	$anchorlink_nav	 	= acoda_settings('anchorlink_nav');	
	$acoda_layout 		= acoda_settings('page_layout');
	$acoda_sticky_menu 	= acoda_settings('sticky_menu');	
	$pinned_sidebar		= 'sidebar-'. acoda_settings('pinned_sidebar');

	
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
	
	do_action('acoda_before_primary_wrapper');

	echo "\n". '<div id="container" class="'. ( !empty( $site_layout ) ? 'layout-'. esc_attr( $site_layout ) : ''  ) .' page_'. esc_attr( $acoda_layout .' '. $header_float .' '. $pinned_sidebar .' '. ( !empty( $anchorlink_nav ) ? 'anchorlink-nav ' : '' ) . $header_layout ) . ( $acoda_sticky_menu != false && acoda_settings( 'header_layout' ) != 'disable' ? ' sticky-header' : '' ) .'">';
	

	do_action('acoda_before_site_wrap');

	
	echo "\n". '<div class="site-inwrap clearfix">';
	echo "\n". '<a id="top"></a>';

	
	do_action('acoda_before_main_wrap');

	
	echo "\n". '<div id="main-wrap" role="main">';
	echo "\n\t". '<div class="main-wrap skinset-main acoda-skin clearfix '. esc_attr( $header_float ) .'">';		

	do_action('acoda_before_content_wrap');
	
	echo "\n" . '<div class="content-wrap row '. esc_attr( $body_width ) .'">';