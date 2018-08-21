<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_Exchange_Rates_Provider' ) ) :

/**
 *
 * @class WCPBC_Exchange_Rates_Provider
 * @version	1.0.0
 */
abstract class WCPBC_Exchange_Rates_Provider {
	
	/**
	 * Exchange rates provider url (to display provider information).
	 *
	 * @var $provider_url
	 */
	protected $provider_url = '';
	
	/**
	 * Return API endpoint
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	abstract protected function get_api_endpoint( $from_currency, $to_currency );

	/**
	 * Return rates array from response
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	abstract protected function get_rates_from_response( $response, $from_currency, $to_currency );

	/**
	 * Return exchage rates array
	 *
	 * @param  string $from_currency
	 * @param  string/array $to_currency	 
	 * @return array
	 */
	public function get_exchange_rates( $from_currency, $to_currency ){

		$rates = array();
		
		if ( ! is_array ($to_currency ) ) {
			$to_currency = array( $to_currency );
		}

		$url = esc_url_raw( $this->get_api_endpoint( $from_currency, $to_currency ) );		

		$response = wp_safe_remote_get( $url );						

		if ( ! is_wp_error( $response ) ) { 									
			$rates = $this->get_rates_from_response( $response, $from_currency, $to_currency );
		} else {
			$rates = $response;
		}

		return $rates;
	}
	
	public function get_fields(){
		return array();
	}
	
	public static function save_settings() {
		
	}	
}

endif;