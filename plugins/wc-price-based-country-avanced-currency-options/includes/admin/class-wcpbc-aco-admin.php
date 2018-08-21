<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_ACO_Admin' ) ) :

/**
 *
 * @class WCPBC_ACO_Admin
 * @version	1.0.4
 */
class WCPBC_ACO_Admin {
	
	/**
	 * Hook actions and filters
	 *
	 * @since 1.0
	 */
	public static function init() {
		add_filter( 'woocommerce_general_settings', array( __CLASS__ , 'currency_format_settings' ) );	
		add_filter( 'wc_price_based_country_default_region_data', array( __CLASS__ , 'default_region_data' )  );
		add_filter( 'wc_price_based_country_settings', array( __CLASS__ , 'exchange_provider_settings' ) );		
		add_filter( 'wc_price_based_country_table_region_column_currency', array( __CLASS__ , 'exchange_rate_column_description' ), 10, 3 );
		add_action( 'wc_price_based_country_before_region_data_save', array( __CLASS__ , 'update_exchange_rate_from_api' ) );
		add_action( 'wc_price_based_country_admin_region_fields', array( __CLASS__ , 'region_currency_options' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_admin_script' ) );	
	}
	
	/**
	 * Add currency format setting.
	 *
	 * @return array
	 */
	public static function currency_format_settings( $settings ) {

		$general_settings = array();
		
		foreach ( $settings as $setting ) {
			if ( $setting['id'] === 'woocommerce_currency_pos' ) {
				
				$general_settings[] = array(			
					'title' 	=> __( 'Currency Format', 'wc-price-based-country' ),										
					'id'      	=> 'wc_price_based_currency_format',
					'desc'		=> sprintf( __( 'Preview: %s', 'wc-price-based-country'), '<code id="wc_price_based_currency_format_preview"></code>'),
					'desc_tip'	=> __( 'Enter the currency format. Supports the following placeholders: [code] = currency code, [symbol] = currency symbol, [price] = product price.', 'wc-price-based-country'),					
					'css'      	=> 'min-width:350px;',
					'default'  	=> '[symbol][price]',
					'type' 		=> 'text'
				);
			}

			$general_settings[] = $setting;
		}

		return $general_settings;
	}	 
	
	/**
	 * Add currency options to default region data
	 *
	 * @param  string $key
	 * @return array
	 */
	public static function default_region_data( $data ) {

		$data['auto_exchange_rate'] = 'no';		
		$data['currency_format'] 	= '';
		$data['price_thousand_sep'] = get_option( 'woocommerce_price_thousand_sep' );
		$data['price_decimal_sep'] 	= get_option( 'woocommerce_price_decimal_sep' );
		$data['price_num_decimals'] = get_option( 'woocommerce_price_num_decimals' );		
		
		return $data;
	}


	/**
	 * Add exchange rates api providers settings.
	 *
	 * @return array
	 */
	public static function exchange_provider_settings( $settings ) {
		 
		$options = array();
		foreach ( WCPBC_Avanced_Currency_Options::get_exchange_rates_providers() as $id => $provider ) {
			$options[$id] = $provider->name;
		}
		
		$pbc_settings = array();
		foreach ($settings as $setting ) {
			
			if ( $setting['type'] ==='sectionend' && $setting['id'] ==='general_options' ) {
				$pbc_settings[] = array(
					'title'    => __( 'Exchange rate API', 'wc-price-based-country' ),
					'desc'     => __( 'This controls which API provider will be used to exchange rates auto-updates.' ),
					'id'       => 'wc_price_based_country_exchange_rate_api',
					'default'  => current(array_keys($options)),
					'type'     => 'select',
					'class'    => 'wc-enhanced-select',				
					'desc_tip' =>  true,
					'options'  => $options			
				);
			}

			$pbc_settings[] = $setting;
		}
		
		return $pbc_settings;
	}
	
	/**
	 * Add auto update exchange rate description to region table currency column
	 *
	 * @return string
	 */
	public static function exchange_rate_column_description( $output, $region, $default_region_key ) {
		$description = '';

		if ( isset( $region['auto_exchange_rate'] ) &&  $region['auto_exchange_rate'] == 'yes') {
			$description = ' (auto)';
		} elseif( $region['key'] !== $default_region_key ) {
			$description = ' (manual)';
		}
		
		return substr($output, 0, strlen($output)- 7 ) . $description . '</span>';		

	}

	/**
	 * Update exchange rate from api before save if user select auto updates
	 *
	 * @return void
	 */
	public static function update_exchange_rate_from_api( ) {		
		
		if ( isset( $_POST['auto_exchange_rate'] ) &&  isset( $_POST['exchange_rate'] ) && isset( $_POST['currency'] ) && $_POST['auto_exchange_rate'] === 'yes' ) {			
			$rate = WCPBC_Avanced_Currency_Options::get_exchange_rate_from_api( $_POST['currency'] );
			if ( $rate ) {
				$_POST['exchange_rate'] = $rate;
			} else {				
				WC_Admin_Settings::add_error( __( 'Errors on update exchange rate from API.', 'wc-price-based-country' ) );
			}
		}
		
	}	

	/**
	 * Add avanced currency options to admin region
	 *
	 * @return void
	 */
	public static function region_currency_options( $region ) {		
		include('views/html-region-currency-options.php');
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @return void
	 */	
	public static function load_admin_script( ) {	

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'wc-price-based-country-aco-admin', WCPBC_Avanced_Currency_Options::plugin_url() . 'assets/admin' . $suffix . '.js', array('jquery'), WCPBC_Avanced_Currency_Options::$version, true );		

	}
			
}

endif;

WCPBC_ACO_Admin::init();