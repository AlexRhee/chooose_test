<?php
/*
 Plugin Name: WooCommerce Price Based on Country Advanced Currency Options
 Description: Supercharge Price Based on Country with extra currency options
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

if ( ! class_exists( 'WCPBC_Avanced_Currency_Options' ) ) :

/**
 *
 * @class WCPBC_Avanced_Currency_Options
 * @version	1.1.2
 */
class WCPBC_Avanced_Currency_Options {
	
	/**
	 * @var string
	 */
	public static $version = '1.1.2';

	/**
	 * Exchange provides.
	 *
	 * @var array
	 */
	private static $exchange_rates_providers = array();
	
	/**
	 * Get the plugin url.
	 * @return string
	 */
	public static function plugin_url() {		
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	
	public static function plugin_path(){
		return plugin_dir_path( __FILE__ );
	}

	/**
	 * Init plugin, Hook actions and filters
	 *
	 * @since 1.0
	 */
	public static function init() {								
		
		include_once( 'includes/class-wcpbc-exchange-rates-provider.php' );			
		include_once( 'includes/class-wcpbc-aco-integrations.php');
		include_once( 'includes/class-wcpbc-aco-frontend.php' ); 

		add_action( 'wc_price_based_country_admin_init', array( __CLASS__ , 'admin_includes' ) );		
		add_action( 'widgets_init', array( __CLASS__, 'register_widgets'), 20 );		
		add_action( 'woocommerce_scheduled_sales', array( __CLASS__, 'update_exchange_rates'), 5 );

		register_activation_hook( __FILE__, array( __CLASS__, 'install' ) );
	}		
	

	/**
	 * Admin includes	 	
	 */
	public static function admin_includes() {
		include_once( 'includes/admin/class-wcpbc-aco-admin.php' ); 
	}		

	/**
	 * Register Widgets
	 *	 
	 */
	 public static function register_widgets(){	 	
	 	include_once( 'includes/class-wcpbc-widget-currency-switcher.php' );	
	 	register_widget( 'WCPBC_Widget_Currency_Switcher' );
	 }

	 
	/**
	 * Get exchange rates getters.
	 *
	 * @return array
	 */
	public static function get_exchange_rates_providers() {	
		
		if ( empty( self::$exchange_rates_providers ) ) {			
			
			$exchange_rates_providers = array();				
			
			$exchange_rates_providers['yahoofinance'] = include('includes/exchage-rates-providers/class-wcpbc-yahoofinance.php');
			$exchange_rates_providers['floatrates'] = include('includes/exchage-rates-providers/class-wcpbc-floatrates.php');
			$exchange_rates_providers['fixerio'] = include('includes/exchage-rates-providers/class-wcpbc-fixerio.php');
			
			self::$exchange_rates_providers = apply_filters( 'pbc_aco_get_exchange_providers', $exchange_rates_providers );
		}		
		
		return self::$exchange_rates_providers; 
	}
	
	/**
	 * Update exchange rates
	 *
	 * @return void
	 */
	public static function update_exchange_rates() {
		$regions = get_option( 'wc_price_based_country_regions', array() );			

		foreach ($regions as $key => $region) {
			if ( isset( $region['auto_exchange_rate'] ) &&  $region['auto_exchange_rate'] == 'yes' && ( $rate = self::get_exchange_rate_from_api( $region['currency'] ) ) ) {				
				$regions[$key]['exchange_rate']= $rate;
			}
		}

		update_option( 'wc_price_based_country_regions', $regions );			
		update_option( 'wc_price_based_country_timestamp', time() );		
	}		
	
	/**
	 * Retrun a exchange rate	 
	 *
	 * @param $to_currency string Curreny code
	 * @return number
	 */	
	public static function get_exchange_rate_from_api( $to_currency ) {		
		$exchange_rate = false;

		$api_providers = self::get_exchange_rates_providers();
		$exchange_rate_api = get_option( 'wc_price_based_country_exchange_rate_api', 'yahoofinance' );

		if ( $exchange_rate_api && isset( $api_providers[$exchange_rate_api] ) ) {

			$from_currency = get_option( 'woocommerce_currency');

			if ( $to_currency === $from_currency ) {
				$exchange_rate = 1;
			} else {

				$rates = $api_providers[$exchange_rate_api]->get_exchange_rates( $from_currency, $to_currency );

				if ( ! is_wp_error( $rates ) ) {
					$exchange_rate = floatval( $rates[$to_currency] );

				} else {				
					$logger     = new WC_Logger();		
					$logger->add( 'wc_price_based_country', sprintf( 'Unable to update exchange rate from API: %s', $rates->get_error_message() ) );						
				}	
			}
			
		}

		return $exchange_rate;
	}		

	/**
	 * Update exchange rates
	 *
	 * @since 1.1
	 * @return void
	 */
	public static function install() {
		$currency_format = get_option( 'wc_price_based_currency_format', false );
		if ( ! $currency_format ) {
			$currency_pos = get_option( 'woocommerce_currency_pos' );
			$format = '[symbol][price]';

			switch ( $currency_pos ) {
				case 'left' :
					$format = '[symbol][price]';
				break;
				case 'right' :
					$format = '[price][symbol]';
				break;
				case 'left_space' :
					$format = '[symbol]&nbsp;[price]';
				break;
				case 'right_space' :
					$format = '[price]&nbsp;[symbol]';
				break;
			}

			update_option( 'wc_price_based_currency_format', $format );
		}
	}

}

endif;

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
		&& ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) );
	}
}

/**
 * WooCommerce PBC inactive notice. 
 *
 * @since  1.0.0
 */
function wcpbc_pbc_inactive_notice() {
	if ( current_user_can( 'activate_plugins' ) ) {
		echo '<div id="message" class="error"><p>';
		printf( __( '%1$sWooCommerce Price Based Country Avanced Currency Options is inactive%2$s. %3$sWooCommerce Price Based Country plugin %4$s must be active for work. Please %5$sinstall and activate WooCommerce Price Based Country &raquo;%6$s', 'wc-price-based-country' ), '<strong>', '</strong>', '<a href="https://wordpress.org/plugins/woocommerce-product-price-based-on-countries/">', '</a>', '<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">', '</a>' );
		echo '</p></div>';
	}
}	

/*
 * Initialize
 */
if ( is_woocommerce_pbc_active() ) {
	WCPBC_Avanced_Currency_Options::init();
} else {
	add_action( 'admin_notices', 'wcpbc_pbc_inactive_notice' );
}

