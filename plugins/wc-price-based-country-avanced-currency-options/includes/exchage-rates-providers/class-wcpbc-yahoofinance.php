<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_YahooFinance' ) ) :

/**
 *
 * @class WCPBC_FloatRates
 * @version	1.0.0
 */
class WCPBC_YahooFinance extends WCPBC_Exchange_Rates_Provider {	
	
	/**
	 * Exchange rates provider url (to display provider information).
	 *
	 * @var $provider_url
	 */
	public $provider_url = 'http://finance.yahoo.com/';
	
	/**
	 * Exchange rates provider url name.
	 *
	 * @var $name
	 */
	public $name = 'Yahoo Finance';
	
	/**
	 * Return API endpoint
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	protected function get_api_endpoint( $from_currency, $to_currency ){
		$pair = urlencode('"' . $from_currency . implode(', "' . $from_currency, $to_currency) . '"' );								
		return 'http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.xchange where pair in ('. $pair . ')&env=store://datatables.org/alltableswithkeys&format=json';
	}

	/**
	 * Return rates array from response
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	protected function get_rates_from_response( $response, $from_currency, $to_currency ){

		if ( isset( $response['response']['code'] ) && $response['response']['code'] == '200' ) {

			$rates = array();

			$data = json_decode( $response['body'] );						

			if ( is_array($data->query->results->rate) ) {
				$query_rates = $data->query->results->rate;
			} else {
				$query_rates = array( $data->query->results->rate );
			}
			
			foreach ($query_rates as $rate) {
				$currency = str_replace($from_currency, '', $rate->id);
				$rates[ $currency ] = $rate->Rate;
			}

		} else {
			return new WP_Error( 'fail', __( "Error getting data from Yahoo finance API", 'wc-price-based-country' ) );
		}	

		return $rates;
	}
	
}

endif;

return new WCPBC_YahooFinance();