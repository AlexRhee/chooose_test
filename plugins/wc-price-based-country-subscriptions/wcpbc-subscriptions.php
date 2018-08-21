<?php

/*
 Plugin Name: WooCommerce Subscriptions bridge for Price Based on Country
 Description: Provides the much-needed bridge between WooCommerce Subscriptions and Price Based on Country.
 Author: Oscar Gare
 Version: 1.1.2
 Author URI: google.com/+OscarGarciaArenas
 License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_Subscriptions' ) ) :

/**
 * Main WC Product Price Based Country Class
 *
 * @class WCPBC_Subscriptions
 * @version	1.1.2
 */
class WCPBC_Subscriptions {

	/**
	 * Hook actions and filters
	 *
	 * @since 1.0
	 */
	public static function init() {				
	
		add_filter( 'wc_price_based_country_price_meta_keys', array( __CLASS__ , 'price_meta_keys' ) );
		add_filter( 'wc_price_based_country_parent_product_types', array( __CLASS__ , 'parent_product_types' ) );
		
		add_action( 'wc_price_based_country_frontend_princing_init', array( __CLASS__ , 'frontend_init' ) );
		
		add_action( 'wc_price_based_country_admin_init', array( __CLASS__ , 'admin_includes' ) );

		add_action( 'wc_price_based_country_before_product_options_pricing', array( __CLASS__ , 'product_options_pricing' ), 10, 2 );
		add_action( 'wc_price_based_country_before_product_variable_options_pricing', array( __CLASS__ , 'product_variable_options_pricing' ), 10, 4 );		
		
		add_action( 'woocommerce_process_product_meta_subscription', array( 'WCPBC_Admin_Product_Data', 'process_product_simple_countries_prices' ), 10 ) ;						
		add_action( 'wc_price_based_country_process_product_meta_subscription', array( __CLASS__ , 'process_product_meta_subscription' ), 10, 5 ) ;											
		add_action( 'wc_price_based_country_process_product_meta_variable-subscription', array( __CLASS__ , 'process_product_meta_subscription' ), 10, 5 ) ;											
		add_action( 'wc_price_based_country_quick_or_bulk_edit_save_subscription', array( __CLASS__ , 'quick_or_bulk_edit_save_subscription' ), 10, 3 );
		
		add_action( 'woocommerce_bulk_edit_variations', array( __CLASS__, 'bulk_edit_variations' ), 25, 4 );
		
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_admin_script' ) );	
		
		register_activation_hook( __FILE__, array( __CLASS__, 'install' ) );
		
	}

	/**
	 * Install
	 */
	public static function install() {
		
		delete_transient('wc_report_subscription_events_by_date');
		delete_transient('wc_report_upcoming_recurring_revenue');				

		WCPBC_Install::sync_exchange_rate_prices();
	}
	

	/**
	 * Add product subscriptions price meta keys
	 *
	 * @return array
	 */
	public static function price_meta_keys( $meta_keys ) {
		array_push( $meta_keys, '_subscription_price', '_subscription_sign_up_fee' );
		return $meta_keys;
	}
	
	/**
	 * Add variable subscriptions product type
	 *
	 * @return array
	 */
	public static function parent_product_types( $types ) {
		array_push( $types, 'variable-subscription' );
		return $types;
	}
	
	/**
	 * Frontend init hooks
	 *
	 * @since 1.0
	 */
	public static function frontend_init() {		
		add_filter( 'woocommerce_product_class', array( __CLASS__ , 'overwrite_subscription_classes' ), 20, 4 );		
	}

	/**
	 * Overwrite WC_Product_Subscription class
	 *
	 * @since 1.0
	 */
	public static function overwrite_subscription_classes( $classname, $product_type, $post_type, $product_id ) {		
		
		if ( $classname === 'WC_Product_Subscription' ) {

			require_once( 'includes/class-wcpbc-product-subscription.php' );

			$classname = 'WCPBC_Product_Subscription';

		} elseif ( $classname == 'WC_Product_Variable_Subscription' ) {

			require_once( 'includes/class-wcpbc-product-variable-subscription.php' );			

			$classname = 'WCPBC_Product_Variable_Subscription';
		}

		return $classname;
	}

	/**
	 * Admin includes
	 *
	 * @since 1.1.2
	 */
	public static function admin_includes() {		
		include_once('includes/class-wcpbc-subscription-reports.php');					
	}

	/**
	 * Output the subscription specific pricing fields on the "Edit Product" admin page.
	 *
	 * @since 1.0
	 */
	public static function product_options_pricing ( $id_prefix, $currency ) {

		echo '<div class="show_if_subscription">';

		// Subscription Price
		woocommerce_wp_text_input( array(
			'id'          => $id_prefix . '_subscription_price',
			'class'       => 'short wc_input_price wcpbc_subscription_price',
			// translators: %s is a currency symbol / code
			'label'       => sprintf( __( 'Subscription Price (%s)', 'woocommerce-subscriptions' ),  get_woocommerce_currency_symbol( $currency ) ),
			'placeholder' => _x( 'e.g. 5.90', 'example price', 'woocommerce-subscriptions' ),
			'type'        => 'text',
			'custom_attributes' => array(
					'step' => 'any',
					'min'  => '0',
			),
		) );		

		// Sign-up Fee
		woocommerce_wp_text_input( array(
			'id'          => $id_prefix . '_subscription_sign_up_fee',
			'class'       => 'short wc_input_price',
			// translators: %s is a currency symbol / code
			'label'       => sprintf( __( 'Sign-up Fee (%s)', 'woocommerce-subscriptions' ), get_woocommerce_currency_symbol( $currency ) ),
			'placeholder' => _x( 'e.g. 9.90', 'example price', 'woocommerce-subscriptions' ),
			'description' => __( 'Optionally include an amount to be charged at the outset of the subscription. The sign-up fee will be charged immediately, even if the product has a free trial or the payment dates are synced.', 'woocommerce-subscriptions' ),
			'desc_tip'    => true,
			'type'        => 'text',
			'custom_attributes' => array(
				'step' => 'any',
				'min'  => '0',
			),
		) );

		echo '</div>';

	}

	/**
	 * Output the subscription specific pricing fields on the "Edit Variable Product" admin page.
	 *
	 * @since 1.0
	 */
	public static function product_variable_options_pricing( $key, $currency, $loop, $variation) {

		$_variable_subscription_sign_up_fee = wc_format_localized_price( get_post_meta( $variation->ID, '_' . $key . '_subscription_sign_up_fee', true) );
		$_variable_subscription_price = wc_format_localized_price( get_post_meta( $variation->ID, '_' . $key . '_subscription_price', true) );

		?>

		<div class="show_if_variable-subscription">

			<p class="form-row form-row-first">
				<label><?php  printf( __( 'Sign-up Fee: (%s)', 'woocommerce-subscriptions' ) ,  get_woocommerce_currency_symbol( $currency ) ); ?></label>
				<input type="text" size="5" id="<?php echo '_' . $key . '_subscription_sign_up_fee_' . $loop; ?>" name="<?php echo '_' . $key . '_subscription_sign_up_fee[' . $loop. ']'; ?>" value="<?php echo esc_attr( $_variable_subscription_sign_up_fee ); ?>" class="wc_input_price" />
			</p>
			<p class="form-row form-row-last">
				<label><?php printf( __( 'Subscription Price (%s)', 'woocommerce-subscriptions' ) ,  get_woocommerce_currency_symbol( $currency ) ); ?></label>
				<input type="text" size="5" id="<?php echo '_' . $key . '_subscription_price_' . $loop; ?>" name="<?php echo '_' . $key . '_subscription_price[' . $loop. ']'; ?>" value="<?php if ( isset( $_variable_subscription_price ) ) echo esc_attr( $_variable_subscription_price ); ?>" class="wc_input_price wcpbc_subscription_price" />
			</p>

		</div>

		<?php
	}

	/**
	 * Save country options pricing for subscription products
	 *
	 * @since 1.1
	 * @param int $post_id
	 * @param string $zone_prepended
	 * @param array $zone
	 * @param string $price_method
	 * @param int $loop
	 */
	public static function process_product_meta_subscription( $post_id, $zone_prepended, $zone, $price_method, $loop ) {
		
		if ( $price_method == 'exchange_rate') {			
			
			if ( $loop === FALSE ) {
				$_subscription_price 		= $_POST['_subscription_price'];
				$_subscription_sign_up_fee	= $_POST['_subscription_sign_up_fee'];
			}else {				
				$_subscription_price 		= $_POST['variable_subscription_price'][$loop];
				$_subscription_sign_up_fee	= $_POST['variable_subscription_sign_up_fee'][$loop];
			}
			
			$_subscription_price 		= ( $_subscription_price !== '' ? wc_format_decimal( $_subscription_price ) * $zone['exchange_rate'] : '' );
			$_subscription_sign_up_fee 	= ( $_subscription_sign_up_fee !== '' ? wc_format_decimal( $_subscription_sign_up_fee ) * $zone['exchange_rate'] : '' );

		} else {	
	
			if ( $loop !== FALSE ) {
				$_subscription_price 		= wc_format_decimal( $_POST[$zone_prepended . '_subscription_price'][$loop] );
				$_subscription_sign_up_fee 	= wc_format_decimal( $_POST[$zone_prepended . '_subscription_sign_up_fee'][$loop] );

			} else {
				$_subscription_price 		= wc_format_decimal( $_POST[$zone_prepended . '_subscription_price'] );
				$_subscription_sign_up_fee 	= wc_format_decimal( $_POST[$zone_prepended . '_subscription_sign_up_fee'] );
			}			
		}

		update_post_meta( $post_id, $zone_prepended . '_subscription_price', $_subscription_price );
		update_post_meta( $post_id, $zone_prepended . '_subscription_sign_up_fee', $_subscription_sign_up_fee );
	}		
	
	/**
	 * Quick or Bulk product edit.
	 */
	public static function quick_or_bulk_edit_save_subscription( $product, $zone_prepended, $zone ) {
		
		$_subscription_price 		= get_post_meta( $product->id, '_subscription_price', true);
		$_subscription_sign_up_fee	= get_post_meta( $product->id, '_subscription_sign_up_fee', true);
		
		$_subscription_price 		= ( $_subscription_price !== '' ? $_subscription_price * $zone['exchange_rate'] : '' );
		$_subscription_sign_up_fee 	= ( $_subscription_sign_up_fee !== '' ? $_subscription_sign_up_fee * $zone['exchange_rate'] : '' );
		
		update_post_meta( $product->id, $zone_prepended . '_subscription_price', $_subscription_price );
		update_post_meta( $product->id, $zone_prepended . '_subscription_sign_up_fee', $_subscription_sign_up_fee );		
	}
	
	/**
	 * Sync product variation prices with parent
	 */
	public static function variable_product_subscription_sync( $product_id, $children ) {

		foreach ( WCPBC()->get_regions() as $region_key => $region ) {
			
			// Main active prices
			$min_subscription_sign_up_fee = 0;
			
			foreach ( $children as $child_id ) {

				$child_price_method = get_post_meta( $child_id, '_' . $region_key . '_variable_price_method', true );

				if ( $child_price_method !== 'manual' ) {

					$child_price = get_post_meta( $child_id, '_subscription_sign_up_fee', true );					
					$child_price = ( !empty( $child_price ) && $region['exchange_rate'] ) ? ( $region['exchange_rate'] * $child_price ) : $child_price;							

				} else{

					$child_price = get_post_meta( $child_id, '_' . $region_key . '_variable_subscription_sign_up_fee', true );					
				}		

				// Skip non-priced variations
				if ( $child_price === '' ) {
					continue;
				}	

				// Find min sign_up_fee
				if ( $child_price < $min_subscription_sign_up_fee ) {
					$min_subscription_sign_up_fee = $child_price;					
				}			
			}

			// Store _subscription_sign_up_fee
			update_post_meta( $product_id, '_' . $region_key . '_subscription_sign_up_fee', $min_subscription_sign_up_fee );
		}
	}
	
	/**
	 * Bulk edit variations via AJAX.
	 */
	public static function bulk_edit_variations( $bulk_action, $data, $product_id, $variations ) {	
		if ( in_array( $bulk_action, array( 'variable_subscription_sign_up_fee', 'variable_regular_price', 'variable_regular_price_increase', 'variable_regular_price_decrease' ) ) 
			&& ( ( isset( $_POST['product_type'] ) && 'variable-subscription' !== $_POST['product_type'] ) || WC_Subscriptions_Product::is_subscription( $product_id ) )
			)  {
			
			foreach ( WCPBC()->get_regions() as $zone_id => $zone_data ) {				
				$meta_prefix = '_' . $zone_id;				
				
				foreach ( $variations as $variation_id ) {
					$price_method = get_post_meta( $variation_id, $meta_prefix . '_price_method', true );
					if ( $price_method == 'exchange_rate' || ! $price_method ) {
							
							$_subscription_sign_up_fee = get_post_meta( $variation_id, '_subscription_sign_up_fee', true );
							$_subscription_price = get_post_meta( $variation_id, '_subscription_price', true );
							
							update_post_meta( $variation_id, $meta_prefix . '_subscription_sign_up_fee', $_subscription_sign_up_fee !== '' ? $_subscription_sign_up_fee * $zone_data['exchange_rate'] : '' );							
							update_post_meta( $variation_id, $meta_prefix . '_subscription_price', $_subscription_price !== '' ? $_subscription_price * $zone_data['exchange_rate'] : '' );							
					}
				}
			}
		}
	}
	
	/**
	 * Adds all necessary admin scripts.
	 *
	 * @since 1.0
	 */
	public static function load_admin_script( ) {	

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'wc-price-based-subscription-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin' . $suffix . '.js', array('jquery'), '1.1.0', true );		
	}	
}

endif; // ! class_exists( 'WCPBC_Subscriptions' )

/**
 * WooCommerce PBC Detection
 *
 * @since  1.0.0
 * @return boolean
 */
if ( ! function_exists( 'is_woocommerce_pbc_active' ) ) {
	function is_woocommerce_pbc_active() {
		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}
		
		return ( in_array( 'woocommerce-product-price-based-on-countries/woocommerce-product-price-based-on-countries.php', $active_plugins ) || array_key_exists( 'woocommerce-product-price-based-on-countries/woocommerce-product-price-based-on-countries.php', $active_plugins ) ) 
		&& ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) )
		&& ( in_array( 'woocommerce-subscriptions/woocommerce-subscriptions.php', $active_plugins ) || array_key_exists( 'woocommerce-subscriptions/woocommerce-subscriptions.php', $active_plugins ) );
	}
}

/**
 * WooCommerce PBC inactive notice. 
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'wcpbc_pbc_inactive_notice' ) ) {

	function wcpbc_pbc_inactive_notice() {
		if ( current_user_can( 'activate_plugins' ) ) {
			echo '<div id="message" class="error"><p>';
			printf( __( '%1$sWooCommerce Subscriptions bridge for Price Based Country is inactive%2$s. %3$sWooCommerce Price Based Country plugin%4$s and WooCommerce Subscription must be active for work.', 'wc-price-based-country' ), '<strong>', '</strong>', '<a href="https://wordpress.org/plugins/woocommerce-product-price-based-on-countries/">', '</a>' );
			echo '</p></div>';
		}
	}	
}

/*
 * Initialize
 */
if ( is_woocommerce_pbc_active() ) {
	WCPBC_Subscriptions::init();
} else {
	add_action( 'admin_notices', 'wcpbc_pbc_inactive_notice' );
}