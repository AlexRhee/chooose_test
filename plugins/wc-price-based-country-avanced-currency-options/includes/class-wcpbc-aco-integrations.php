<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_ACO_Integrations' ) ) :

/**
 * Integrations 
 *
 * Handle integrations between PBC and 3rd-Party plugins
 *
 * @class    WCPBC_ACO_Integrations
 * @version  1.1.1
 * @author   oscargare
 */
class WCPBC_ACO_Integrations {

	/**
	 * Add 3rd-Party plugins integrations
	 */
	public static function add_third_party_plugin_integrations(){
		if ( class_exists('Woocommerce_Price_Per_Word') ){
			//Price per word by Angell EYE
			add_filter( 'wc_price_args', array( __CLASS__ , 'price_per_word_price_args' ) );			
		}
	}

	/**
	 * Fix problem with num decimals
	 *
	 * @since 1.1.1
	 */
	public static function price_per_word_price_args( $args ) {
		if ( WCPBC()->customer && WCPBC()->customer->price_num_decimals <> '' && $args['decimals'] <> WCPBC()->customer->price_num_decimals ) {
			$args['decimals'] = WCPBC()->customer->price_num_decimals;
		}

		return $args;
	}
	
}
add_action( 'plugins_loaded', array( 'WCPBC_ACO_Integrations', 'add_third_party_plugin_integrations' ) );

endif;
