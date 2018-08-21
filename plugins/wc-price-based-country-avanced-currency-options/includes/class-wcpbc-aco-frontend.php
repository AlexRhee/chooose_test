<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_ACO_Frontend' ) ) :

/**
 *
 * @class WCPBC_ACO_Frontend
 * @version	1.1.2
 */
class WCPBC_ACO_Frontend {
	
	/**
	 * @var array
	 */
	private static $zone_data = false;

	/**
	 * Init plugin, Hook actions and filters
	 *
	 * @since 1.0
	 */
	public static function init(){
		add_filter( 'woocommerce_email_order_items_args', array( __CLASS__ , 'email_order_zone_data' ) );					
		add_filter( 'woocommerce_price_format', array( __CLASS__ , 'get_price_format' ), 10, 2 );			
		add_filter( 'wc_price_args', array( __CLASS__ , 'set_currency_code' ), 5, 1 );			
		add_filter( 'option_woocommerce_price_thousand_sep', array( __CLASS__ , 'price_thousand_sep' ) );
		add_filter( 'option_woocommerce_price_decimal_sep', array( __CLASS__ , 'price_decimal_sep' ) );
		add_filter( 'option_woocommerce_price_num_decimals', array( __CLASS__ , 'price_num_decimals' ) );						
	}
	
	/**
	 * Return zone data 
	 *	 
	 */
	private static function get_zone_data_value( $key, $default = false ){
		$value = false;
		
		if ( self::$zone_data && isset( self::$zone_data[$key] ) ) {
			$value = self::$zone_data[$key];		
		} elseif ( WCPBC()->customer && WCPBC()->customer->$key ) {
			$value = WCPBC()->customer->$key;					
		}	
		
		if ( ! $value ) {
			$value = $default;
		}
		return $value;
	}

	/**
	 * Set zone data  for order items email
	 *	 
	 */
	public static function email_order_zone_data( $args ){
		self::$zone_data = false;
		
		if ( isset( $args['order'] ) && $order = $args['order'] ) {
			
			$address = $order->get_address( get_option('wc_price_based_country_based_on', 'billing') );			
			if ( ! $address['country'] ) {
				$address = $order->get_address( 'billing' );
			}			

			foreach ( WCPBC()->get_regions() as $key => $zone_data ) {				

				if ( in_array( $address['country'], $zone_data['countries'] ) ) {
					self::$zone_data = $zone_data;				
					break;
				}			
			}
		}

		return $args;

	}		

	/**
	 * Clear email zone data 
	 *	 
	 */
	public static function clear_email_order_zone_data( $content, $order ){	
		self::$zone_data = false;
		return $content;
	}
	
	/**
	 * Get the price format.
	 *	 
	 */
	public static function get_price_format( $format, $currency_pos ){		 		
		
		if ( $currency_format = self::get_zone_data_value( 'currency_format', get_option( 'wc_price_based_currency_format' ) ) ) {

			if (strpos( $currency_format, '[price]' ) === false ) {
				$currency_format .= '[price]';
			}
			
			$format = str_replace( array( '[symbol]', '[price]', ' ' ), array( '%1$s', '%2$s', '&nbsp;' ), $currency_format ) ;
		}		
		return $format; 
	}	 		

	/**
	 * Set currency code to price format
	 *	 
	 */
	public static function set_currency_code( $args ){		 		
		if ( $args['currency'] ) {
			$currency_code = $args['currency'];
		} else {
			$currency_code = get_woocommerce_currency();
		}
		
		$args['price_format'] = str_replace( '[code]', $currency_code, $args['price_format'] );

		return $args;
	}

	/**
	 * Return the thousand separator for prices.	 
	 */
	public static function price_thousand_sep( $thousand_sep ) {
		if ( $_price_thousand_sep = self::get_zone_data_value( 'price_thousand_sep' ) ) {
			$thousand_sep = $_price_thousand_sep;
		}

		return $thousand_sep;
	}

	/**
	 * Return the decimal separator for prices.	 
	 */
	public static function price_decimal_sep( $decimal_sep ) {
		if ( $_price_decimal_sep = self::get_zone_data_value( 'price_decimal_sep' ) ) {		
			$decimal_sep = $_price_decimal_sep;
		}

		return $decimal_sep;
	}

	/**
	 * Return the number of decimals for prices.	 
	 */
	public static function price_num_decimals( $num_decimals ) {
		if ( $_price_num_decimals = self::get_zone_data_value( 'price_num_decimals' ) ) {				
			$num_decimals = $_price_num_decimals;
		}

		return $num_decimals;
	}
}

endif;

WCPBC_ACO_Frontend::init();
