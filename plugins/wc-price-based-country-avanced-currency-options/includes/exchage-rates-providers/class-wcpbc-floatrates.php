<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_FloatRates' ) ) :

/**
 *
 * @class WCPBC_FloatRates
 * @version	1.0.0
 */
class WCPBC_FloatRates extends WCPBC_Exchange_Rates_Provider {	
	
	/**
	 * Exchange rates provider url (to display provider information).
	 *
	 * @var $provider_url
	 */
	public $provider_url = 'http://www.floatrates.com/';
	
	/**
	 * Exchange rates provider url name.
	 *
	 * @var $name
	 */
	public $name = 'FloatRates';
	
	/**
	 * Return API endpoint
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	protected function get_api_endpoint( $from_currency, $to_currency ){
		return 'http://www.floatrates.com/daily/' . strtolower( $from_currency ) .'.json';
	}

	/**
	 * Return rates array from response
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	protected function get_rates_from_response( $response, $from_currency, $to_currency ){
		$rates = array();

		$data = json_decode( $response['body'] );				
			
		foreach ( $to_currency as $currency ) {
			$currency_prop = strtolower($currency);
			
			if ( isset( $data->$currency_prop ) ) {
				$rates[$currency] = $data->$currency_prop->rate;
			} else {
				$rates[$currency] = 1;
			}				
		}

		return $rates;
	}
	
}

endif;

return new WCPBC_FloatRates();