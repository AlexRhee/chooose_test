<?php
/**
 * acoda Shopping Cart Widget
 *
 * Displays shopping cart widget
 *
 * @author 	acoda
 * @category 	Widgets
 * @package 	WooCommerce/Widgets
 * @version 	2.0.1
 * @extends 	WC_Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class acoda_WC_Widget_Cart extends WC_Widget_Cart {

	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? esc_html__( 'Shopping Cart', 'dynamix' ) : $instance['title'], $instance, $this->id_base );
		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;
		
		$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );

		echo $before_widget;

		if ( $title ) {
			echo '<h3 class="dock-title">'. esc_html( $title ) .'</h3>';
		}
		
		if ( $hide_if_empty )
		{
			echo '<div class="hide_cart_widget_if_empty">';
		}		
		
	
		
		// Insert cart widget placeholder - code in woocommerce.js will update this on page load
		echo '<div class="widget_shopping_cart_content"></div>';

		if ( $hide_if_empty )
		{
			echo '</div>';
		}
		
		if( WC()->cart->is_empty() )
		{
			echo '<a href="'. $shop_page_url .'">'. esc_html__( 'View Shop', 'dynamix' ) .'</a>';
		}
		
		
		echo $after_widget;
	}
}
